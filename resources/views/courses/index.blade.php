@include('layouts.header')

<div class="container">
    <h2>Course List</h2>

    {{-- searching --}}
    <form method="GET" action="{{ route('courses.index') }}" style="margin-bottom: 15px;" class="form-inline">
        <input type="text" name="search" class="form-control mr-2" placeholder="Search by course name" value="{{ request('search') }}">
        <button type="submit" class="btn-small">Search</button>
        <a href="{{ route('courses.index') }}" class="btn-small">Reset</a>
    </form>

    {{-- Open Add Modal --}}
    <button class="btn btn-primary" data-toggle="modal" data-target="#addCourseModal">➕ Add New Course</button>

    @if(session('success'))
        <div class="success-box">{{ session('success') }}</div>
    @endif
    

    <div class="table-responsive">
    <table class="styled-table">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Subjects</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
                <tr>
                    <td>{{ $course->course_id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>
                        
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach($course->subjects as $subject)
                                <li style="margin-bottom: 3px;">
                                    <span class="tag">{{ $subject->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        
                        <button class="edit_button" data-toggle="modal" data-target="#editCourseModal-{{ $course->id }}">Edit</button>

                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete_button" onclick="return confirm('Delete this course?')">Delete</button>
                        </form>
                    </td>
                </tr>

                
                @include('courses.edit_modal', ['course' => $course, 'subjects' => $subjects])
                @empty
                    <tr><td>No courses available</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>


@include('courses.add_modal', ['subjects' => $subjects, 'nextCourseId' => $nextCourseId])

@include('layouts.footer')
