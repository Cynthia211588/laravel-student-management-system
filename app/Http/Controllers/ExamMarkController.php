<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\ExamMark;
use Illuminate\Http\Request;

class ExamMarkController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with('subjects')->get();
        $students = Student::with('course.subjects')->get();

        $selectedStudent = null;
        $examMarks = collect();

        if ($request->student_id) {
            $selectedStudent = Student::with('course.subjects')->find($request->student_id);

        if ($selectedStudent) {
            $examMarks = ExamMark::where('student_id', $selectedStudent->id)
                                 ->get()
                                 ->keyBy('subject_id');
            }
        }

        return view('exam-marks.index', compact('students', 'courses', 'examMarks', 'selectedStudent'));
    }

    public function create(Request $request)
    {
        $student = null;
        $subject = null;

        if ($request->student_id && $request->course_id && $request->subject_id) {
            $student = Student::find($request->student_id);
            $subject = Course::find($request->course_id)
                     ?->subjects->firstWhere('id', $request->subject_id);
        }

        return view('exam-marks.create', compact('student', 'subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'marks' => 'required|array',
            'marks.*' => 'nullable|integer|min:0|max:100'
        ]);

        foreach ($request->marks as $subjectId => $mark) {
            if ($mark === null || $mark === '') {
                continue; // will jump to next iteration if mark is empty
            }

            ExamMark::updateOrCreate([
                'student_id' => $request->student_id,
                'subject_id' => $subjectId
            ], [
                'marks' => $mark
            ]);
        }

        return redirect()->route('exam-marks.index', ['student_id' => $request->student_id])
                        ->with('success', 'Exam marks saved successfully!');
    }

    public function edit(Request $request, Student $student)
    {
        $subjectId = $request->query('subject_id');

        // get all subjects for the student's course
        $allSubjects = $student->course->subjects ?? collect();

        $subjects = $subjectId 
            ? $allSubjects->where('id', $subjectId) 
            : $allSubjects;

        $examMarks = ExamMark::where('student_id', $student->id)
                    ->get()
                    ->keyBy('subject_id');

        return view('exam-marks.edit', compact('student', 'subjects', 'examMarks'));
    }


    public function update(Request $request, Student $student)
    {
        foreach ($request->marks as $subjectId => $markValue) {
                ExamMark::updateOrCreate(
                    ['student_id' => $student->id, 'subject_id' => $subjectId],
                    ['marks' => $markValue]
                );
        }
        
        $courseId = $request->query('course_id');
        $subjectId = $request->query('subject_id');

        return redirect()->route('exam-marks.index', [
            'student_id' => $student->id,
            'course_id' => $courseId, 
            'subject_id' => $subjectId
        ])->with('success', 'Marks updated!');
    }
    
    public function destroy(Request $request, ExamMark $examMark)
    {
        $examMark->delete();

        return redirect()->route(
            'exam-marks.index', ['student_id' => $request->student_id]
        )   
        ->with('success', 'Exam mark deleted successfully!');

    }
}
