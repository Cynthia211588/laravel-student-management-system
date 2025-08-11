@include('layouts.header')

<div class="home-container">
    <div class="module-card" onclick="window.location.href='/students'">
        <div class="overlay">Students</div>
    </div>

    <div class="module-card" onclick="window.location.href='/courses'">
        <div class="overlay">Courses</div>
    </div>

    <div class="module-card" onclick="window.location.href='/exam-marks'">
        <div class="overlay">Exam Marks</div>
    </div>

    <div class="module-card" onclick="window.location.href='/reports'">
        <div class="overlay">Reports</div>
    </div>
</div>

@include('layouts.footer')


{{-- http://localhost:8000/reports/subjects --}}