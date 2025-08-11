@include('layouts.header')

<div class="container">
    <h2>Student List</h2>

    {{-- searching --}}
    <form method="GET" action="{{ route('students.index') }}" style="margin-bottom: 15px;">
        <input type="text" name="search" placeholder="Search by name or course..." value="{{ request('search') }}">
        <select name="sort_by">
        <option value="id" {{ $sort_by == 'id' ? 'selected' : '' }}>Sort by ID</option>
        <option value="name" {{ $sort_by == 'name' ? 'selected' : '' }}>Sort by Name</option>
    </select>

    <select name="sort_order">
        <option value="asc" {{ $sort_order == 'asc' ? 'selected' : '' }}>Ascending</option>
        <option value="desc" {{ $sort_order == 'desc' ? 'selected' : '' }}>Descending</option>
    </select>
        
        <button type="submit" class="btn-small">Search</button>
        <a href="{{ route('students.index') }}" class="btn-small">Reset</a>
    </form>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">➕ Add New Student</button>

    @if(session('success'))
        <div class="success-box">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
    <table class="styled-table">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>DOB</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           @forelse($students as $student)
                <tr class="{{ isset($highlight_id) && $highlight_id == $student->id ? 'highlight-row' : '' }}">
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->dob }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->course->name }}</td>
                    <td>
                        <!-- Edit button -->
                        <button class="edit_button" data-toggle="modal" data-target="#editStudentModal-{{ $student->id }}">Edit</button>

                        <!-- Delete form -->
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete_button" onclick="return confirm('Delete this student?')">Delete</button>
                        </form>
                    </td>
                </tr>

                {{-- Include the modal INSIDE the loop, passing the current $student --}}    
                @include('students.edit_modal', ['student' => $student])
                @empty
                    <tr><td >No students available</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

@include('Students.form_modal')

@include('layouts.footer')
