<!-- edit_modal.blade.php -->
<div class="modal fade" id="editStudentModal-{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('students.update', $student->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Fields -->
          <div class="form-group">
            <label for="student_id">Student ID</label>
            <input type="text" name="student_id" class="form-control" value="{{ $student->student_id }}" readonly>
          </div>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $student->name }}">
          </div>
          <div class="form-group">
            <label for="dob">DOB</label>
            <input type="date" name="dob" class="form-control" value="{{ $student->dob }}">
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $student->phone }}">
          </div>
          <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id" class="form-control">
              @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ $course->id == $student->course_id ? 'selected' : '' }}>
                  {{ $course->course_id }} - {{ $course->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
