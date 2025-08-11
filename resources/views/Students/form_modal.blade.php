<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('students.store') }}" method="POST">
        @csrf

        @if ($errors->any())
    <div class="alert alert-danger">
        <ul style="margin-bottom: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="modal-header">
          <h5 class="modal-title" id="addStudentLabel">Add New Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          {{-- Student ID --}}
          <div class="form-group">
            <label>Student ID:</label>
            <input type="text" name="student_id" class="form-control" value="{{ $nextStudentId ?? '' }}" readonly>
          </div>

          {{-- Name --}}
          <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          {{-- DOB --}}
          <div class="form-group">
            <label>DOB:</label>
            <input type="date" name="dob" class="form-control" required>
          </div>

          {{-- Phone --}}
          <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" class="form-control" required>
          </div>

          {{-- Course --}}
          <div class="form-group">
            <label>Course:</label>
            <select name="course_id" class="form-control" required>
              @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
              @endforeach
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Student</button>
        </div>
      </form>
    </div>
  </div>
</div>
