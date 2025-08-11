<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('subjects')->orderBy('id', 'asc');

        // searching
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%');
            });
        }

        $courses = $query->get();
        $subjects = Subject::all();

        // auto generate course_id
        $latestCourse = Course::orderBy('id', 'desc')->first();
        $nextCourseId = $latestCourse ? 'CS' . str_pad(intval(substr($latestCourse->course_id, 2)) + 1, 4, '0', STR_PAD_LEFT) : 'CS0001';

        return view('courses.index', compact('courses', 'subjects', 'nextCourseId'));
    }



    // add course
    public function create()
    {
        //auto generate next course_id
        $latestCourse = Course::orderBy('id', 'desc')->first();

        if ($latestCourse) {
            $number = intval(substr($latestCourse->course_id, 2)) + 1;
        } else {
            $number = 1;
        }

        $nextCourseId = 'CS' . str_pad($number, 4, '0', STR_PAD_LEFT);

        $subjects = Subject::all();
        return view('courses.create', compact('subjects', 'nextCourseId'));
    }

    //save course
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'subjects' => 'required|array'
        ]);

        //auto generate next course_id
        $latestCourse = Course::orderBy('id', 'desc')->first();
        if ($latestCourse) {
            $number = intval(substr($latestCourse->course_id, 2)) + 1;
        } else {
            $number = 1;
        }

        $course_id = 'CS' . str_pad($number, 4, '0', STR_PAD_LEFT);

        //create course
        $course = Course::create([
            'course_id' => $course_id,
            'name' => $request->name
        ]);

        $subjectIds = [];
        foreach ($request->subjects as $value) {
            if (is_numeric($value)) {
                // 已存在的 subject
                $subjectIds[] = $value;
            } else {
                // 新建 subject
                $newSubject = Subject::create(['name' => $value]);
                $subjectIds[] = $newSubject->id;
            }
        }
        $course->subjects()->sync($subjectIds);

        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }

    //edit course
    public function edit(Course $course)
    {
        $subjects = Subject::all();
        $selectedSubjects = $course->subjects->pluck('id')->toArray();
        return view('courses.edit', compact('course', 'subjects', 'selectedSubjects'));
    }

    //update course
    public function update(Request $request, Course $course)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required',
            'subjects' => 'required|array'
        ]);

        // update course name
        $course->update([
            'name' => $request->name
        ]);

        // update subjects
        $subjectIds = [];
        foreach ($request->subjects as $value) {
            if (is_numeric($value)) {
                $subjectIds[] = $value;
            } else {
                $newSubject = Subject::create(['name' => $value]);
                
                $subjectIds[] = $newSubject->id;
            }
        }
        $course->subjects()->sync($subjectIds);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }

    //delete course
    public function destroy(Course $course)
    {
        $course->subjects()->detach(); 
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
