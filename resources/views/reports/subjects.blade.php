@include('layouts.header')

<div class="container">
    <h2>Average Marks by Subject</h2>

<canvas id="subjectChart" width=450 height="450" style="margin-bottom: 20px;display:block;margin:auto;"></canvas>

    <a href="{{ route('reports.export.subjects') }}" class="report-export">Export CSV</a>

    <div class="table-responsive">
    <table class="styled-table">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Average Mark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjectAverages as $subject)
                <tr>
                    <td>{{ $subject['name'] }}</td>
                    <td>
                        <strong class="{{ $subject['average'] < 60 ? 'score-fail' : 'score-pass' }}">
                            {{ $subject['average'] }}
                        </strong>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <a href="{{ route('reports.index') }}" class="btn-back">Back</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const subjectNames = {!! json_encode($subjectAverages->pluck('name')) !!};
    const subjectAverages = {!! json_encode($subjectAverages->pluck('average')) !!};

    const ctx2 = document.getElementById('subjectChart').getContext('2d');
    const subjectChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: subjectNames,
            datasets: [{
                data: subjectAverages,
                backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4']
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: { size: 12 }
                    }
                }
            }
        }
    });
</script>


@include('layouts.footer')
