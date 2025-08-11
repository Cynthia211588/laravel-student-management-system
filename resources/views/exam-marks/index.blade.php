@include('layouts.header')

<div class="container">
    <h2>Exam Marks Management</h2>

    {{-- Filter Section --}}
    <form method="GET" action="{{ route('exam-marks.index') }}">
    <div class="form-group">
        <label for="student_id">Select Student:</label>
        <select name="student_id" id="student_id" onchange="this.form.submit()" class="select" required>
            <option value="">-- Select Student --</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                    {{ $student->student_id }} - {{ $student->name }}
                </option>
            @endforeach
        </select>
    </div>
</form>


    @if(session('success'))
        <div class="success-box">{{ session('success') }}</div>
    @endif
   
    @if(!$selectedStudent)
        <div style="margin-top: 40px; text-align:center;">
            <img src="/images/exam.jpg" alt="Reports" style="max-width:500px; opacity:0.9; border-radius: 16px; box-shadow: 0 6px 12px rgba(0,0,0,0.1);">
        </div>
    @endif

    {{-- Messages --}}
    @if($selectedStudent)
    <h3>Exam Marks for {{ $selectedStudent->student_id }} - {{ $selectedStudent->name }}</h3>
    <div class="table-responsive">
    <table class="styled-table">
        <thead>
            <tr>
                <th>Course</th>
                <th>Subject</th>
                <th>Marks</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($selectedStudent->course->subjects as $subject)
                <tr>
                    <td>{{ $selectedStudent->course->name }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>
                        {{ $examMarks->has($subject->id) ? $examMarks[$subject->id]->marks : '-' }}
                    </td>
                    <td>
                        @if($examMarks->has($subject->id))

                        {{-- Include Edit Modal --}}
                        <button class="edit_button" data-toggle="modal" data-target="#editExamMarkModal-{{ $subject->id }}">Edit</button>
                            <form action="{{ route('exam-marks.destroy', $examMarks[$subject->id]->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
                                <button type="submit" class="delete_button" onclick="return confirm('Delete this mark?')">Delete</button>
                            </form>
                        @else
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addExamMarkModal-{{ $subject->id }}">➕ Add</button>

                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endif

</div>



@include('exam-marks.add_modal')
@include('exam-marks.edit_modal')


<script>
    // JS: load subjects based on course
    function filterSubjects() {
        let courseSelect = document.getElementById('course_id');
        let subjectSelect = document.getElementById('subject_id');
        subjectSelect.innerHTML = '<option value="">-- Select Subject --</option>';

        if (!courseSelect.value) return;

        let subjects = JSON.parse(courseSelect.options[courseSelect.selectedIndex].dataset.subjects);
        subjects.forEach(subject => {
            let option = document.createElement('option');
            option.value = subject.id;
            option.text = subject.name;
            option.selected = (subject.id == "{{ request('subject_id') }}");
            subjectSelect.appendChild(option);
        });
    }

    // Run once when page loads (if search params already exist)
    window.onload = filterSubjects;
</script>

@include('layouts.footer')
