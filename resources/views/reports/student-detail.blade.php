<div class="table-responsive">
    <table class="styled-table">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Mark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($student['subjects'] as $subject)
                <tr>
                    <td>{{ $subject['subject'] }}</td>
                    <td>{{ $subject['mark'] ?? '-' }}</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>Average</strong></td>
                <td><strong>{{ $student['average'] }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
