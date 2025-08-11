<?php


namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\ExamMark;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function studentReport()
    {
        $students = Student::with(['course.subjects', 'examMarks.subject'])->get();

        $studentAverages = $students->map(function ($student) {
            $courseSubjects = optional($student->course)->subjects ?? collect();

            $examMarks = $student->examMarks;

            $subjects = $courseSubjects->map(function ($subject) use ($examMarks) {
                // get the mark for this subject, if exists
                $markRecord = $examMarks->firstWhere(fn($mark) => optional($mark->subject)->id === $subject->id);

                return [
                    'subject' => $subject->name,
                    'mark' => $markRecord ? $markRecord->marks : '-',
                ];
            });

            $average = $examMarks->avg('marks') ?? 0;

            return [
                'id' => $student->id,
                'student_id' => $student->student_id,
                'name' => $student->name,
                'average' => round($average, 2),
                'course' => ['name' => optional($student->course)->name],
                'subjects' => $subjects->toArray(),
            ];
        });

        return view('reports.students', compact('studentAverages'));
    }

    public function studentDetail(Student $student)
    {
        $examMarks = $student->examMarks()->with('subject')->get();
        $average = $examMarks->avg('marks') ?? 0;

        return view('reports.student-detail', compact('student', 'examMarks', 'average'));
    }

    public function subjectReport()
    {
        $subjects = Subject::with('examMarks')->get();

        $subjectAverages = $subjects->map(function ($subject) {
            $average = $subject->examMarks->avg('marks') ?? 0;
            return [
                'name' => $subject->name,
                'average' => round($average, 2),
            ];
        });

        return view('reports.subjects', compact('subjectAverages'));
    }

    public function exportStudents()
    {
        $students = Student::with('examMarks')->get();

        $csv = "Student ID,Name,Average Marks\n";
        foreach ($students as $student) {
            $avg = round($student->examMarks->avg('marks') ?? 0, 2);
            $csv .= "{$student->id},{$student->name},{$avg}\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="student_report.csv"',
        ]);
    }

    public function exportSubjects()
    {
        $subjects = Subject::with('examMarks')->get();

        $csv = "Subject,Average Marks\n";
        foreach ($subjects as $subject) {
            $avg = round($subject->examMarks->avg('marks') ?? 0, 2);
            $csv .= "{$subject->name},{$avg}\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subject_report.csv"',
        ]);
    }
}
