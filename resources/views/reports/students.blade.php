@include('layouts.header')

<div class="container">
    <h2>Average Marks by Student</h2>

    <!-- Chart -->
    <canvas id="studentChart" height="100" style="margin-bottom: 20px;"></canvas>

    <a href="{{ route('reports.export.students') }}" class="report-export">Export CSV</a>

    <div class="table-responsive">
        <table class="styled-table">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Average Mark</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($studentAverages as $student)
            <tr>
                <td>
                    <a href="#" data-toggle="modal" data-target="#reportModal-{{ $student['id'] }}">
                        {{ $student['student_id'] }}
                    </a>
                </td>
                <td>{{ $student['name'] }}</td>
                <td>
                    <strong class="{{ $student['average'] < 60 ? 'score-fail' : 'score-pass' }}">
                        {{ $student['average'] }}
                    </strong>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- 所有 Modal 放在 table 后面 --}}
@foreach ($studentAverages as $student)
    <div class="modal fade" id="reportModal-{{ $student['id'] }}" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel-{{ $student['id'] }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📋 Report for {{ $student['name'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('reports.student-detail', ['student' => $student])
                </div>
            </div>
        </div>
    </div>
@endforeach


    </div>
    <a href="{{ route('reports.index') }}" class="btn-back">Back</a>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const studentNames = {!! json_encode($studentAverages->pluck('name')) !!};
    const studentAverages = {!! json_encode($studentAverages->pluck('average')) !!};

    const ctx = document.getElementById('studentChart').getContext('2d');
    const studentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: studentNames,
            datasets: [{
                label: 'Average Marks',
                data: studentAverages,
                backgroundColor: '#2563eb',
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'nearest' }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            let label = this.getLabelForValue(value);
                            return label.length > 15 ? label.substring(0, 15) + '...' : label;
                        }
                    }
                },
                x: { beginAtZero: true, max: 100 }
            }
        }
    });
</script>

@include('layouts.footer')
