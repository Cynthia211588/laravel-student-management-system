<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('course');

        //searching
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('student_id', 'like', '%' . $request->search . '%')
                    ->orWhereHas('course', function($q2) use ($request) {
                        $q2->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        // sorting
        $sort_by = $request->get('sort_by', 'id'); 
        $sort_order = $request->get('sort_order', 'asc'); 

        $students = $query->orderBy($sort_by, $sort_order)->get();
        $courses = Course::all();

        // autoincremeny of student id
        $latestStudent = Student::orderBy('id', 'desc')->first();
        $number = $latestStudent ? intval(substr($latestStudent->student_id, 2)) + 1 : 1;
        $nextStudentId = 'ST' . str_pad($number, 4, '0', STR_PAD_LEFT);

        return view('students.index', compact('students', 'courses', 'nextStudentId', 'sort_by', 'sort_order'));
    }

    public function create()
    {
        $courses = Course::all();

        // 自动生成 student_id
        $latestStudent = Student::orderBy('id', 'desc')->first();
        $number = $latestStudent ? intval(substr($latestStudent->student_id, 2)) + 1 : 1;
        $nextStudentId = 'ST' . str_pad($number, 4, '0', STR_PAD_LEFT);

        return view('students.create', compact('courses', 'nextStudentId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'dob' => 'required|date',
            'phone' => 'required',
            'course_id' => 'required|exists:courses,id',
            
        ]);

        $latestStudent = Student::orderBy('id', 'desc')->first();
        $number = $latestStudent ? intval(substr($latestStudent->student_id, 2)) + 1 : 1;
        $student_id = 'ST' . str_pad($number, 4, '0', STR_PAD_LEFT);

        Student::create([
            'student_id' => $student_id,
            'name' => $request->name,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'course_id' => $request->course_id
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }

    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_id' => 'required',
            'name' => 'required',
            'dob' => 'required|date',
            'phone' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        $student->update([
            'name' => $request->name,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'course_id' => $request->course_id
        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
