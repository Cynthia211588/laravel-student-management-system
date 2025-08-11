@include('layouts.header')

<div class="container">

    <h2 > Report Dashboard</h2>

    <form method="get" action="">
        <select class="select" onchange="location = this.value;">
            <option value="#">-- Select Report Type --</option>
            <option value="{{ route('reports.students') }}">Average Mark by Student</option>
            <option value="{{ route('reports.subjects') }}">Average Mark by Subject</option>
        </select>
    </form>

    <div style="margin-top: 40px; text-align:center;">
        <img src="/images/report.jpg" alt="Reports" style="max-width:500px; opacity:0.9; border-radius: 16px; box-shadow: 0 6px 12px rgba(0,0,0,0.1);">
    </div>

</div>

@include('layouts.footer')
