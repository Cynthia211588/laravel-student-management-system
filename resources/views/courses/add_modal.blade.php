<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="addCourseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add New Course</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>

        <div class="modal-body">
          <div class="form-group">
              <label>Course Code:</label>
              <input type="text" value="{{ $nextCourseId }}" readonly class="form-control">
          </div>

          <div class="form-group">
              <label>Course Name:</label>
              <input type="text" name="name" class="form-control" required>
          </div>

          <div class="form-group">
              <label>Subjects:</label><br>
              @foreach($subjects as $subject)
                  <label><input type="checkbox" name="subjects[]" value="{{ $subject->id }}"> {{ $subject->name }}</label><br>
              @endforeach
              <button type="button" class="btn btn-secondary mt-2" id="add-other-btn">➕ Add Other Subject</button>
              <div id="other-container"></div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById('add-other-btn').addEventListener('click', function () {
    const input = document.createElement('input');
      input.type = 'text';
      input.name = 'subjects[]';
      input.placeholder = 'Enter new subject';
      input.required = true;
      input.classList.add('form-control', 'mt-1');
      document.getElementById('other-container').appendChild(input);
  });
</script>
