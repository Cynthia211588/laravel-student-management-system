<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExamMarkController;

Route::get('/', function () {
    return view('home');
});

Route::resource('courses', CourseController::class);
Route::resource('students', StudentController::class);
//Route::resource('exam-marks', ExamMarkController::class);
Route::get('exam-marks', [ExamMarkController::class, 'index'])->name('exam-marks.index');
Route::get('exam-marks/create', [ExamMarkController::class, 'create'])->name('exam-marks.create');
Route::post('exam-marks', [ExamMarkController::class, 'store'])->name('exam-marks.store');
Route::get('exam-marks/{student}/edit', [ExamMarkController::class, 'edit'])->name('exam-marks.edit');
Route::put('exam-marks/{student}/update', [ExamMarkController::class, 'update'])->name('exam-marks.update');
Route::delete('exam-marks/{exam_mark}', [ExamMarkController::class, 'destroy'])->name('exam-marks.destroy');
Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');


//report
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/students', [ReportController::class, 'studentReport'])->name('students');
    Route::get('/students/{student}', [ReportController::class, 'studentDetail'])->name('students.detail');
    Route::get('/subjects', [ReportController::class, 'subjectReport'])->name('subjects');

    // CSV Exports
    Route::get('/export/students', [ReportController::class, 'exportStudents'])->name('export.students');
    Route::get('/export/subjects', [ReportController::class, 'exportSubjects'])->name('export.subjects');
});

Route::get('/reports/students', [ReportController::class, 'studentReport'])->name('reports.students');

