<!-- Edit Modal for Course -->
<div class="modal fade" id="editCourseModal-{{ $course->id }}" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel-{{ $course->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit Course: {{ $course->course_id }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Course Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $course->name }}" required>
          </div>

          <div class="form-group">
            <label>Subjects:</label>
            <div id="subject-container-{{ $course->id }}">
              @foreach($subjects as $subject)
              <div class="d-flex align-items-center mb-1 subject-item">
                <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                  @if(in_array($subject->id, $course->subjects->pluck('id')->toArray())) checked @endif>
                <span class="ml-2">{{ $subject->name }}</span>
              </div>
              @endforeach
            {{-- </div>

            <button type="button" class="btn btn-secondary mt-2" onclick="addNewSubject({{ $course->id }})">➕ Add Other Subject</button>
          </div> --}}
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function addNewSubject(courseId) {
    const container = document.getElementById('subject-container-' + courseId);

    const wrapper = document.createElement('div');
    wrapper.classList.add('d-flex', 'align-items-center', 'mb-1');

    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.name = 'subjects[]';
    checkbox.checked = true;

    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'subjects[]';
    input.placeholder = 'Enter new subject';
    input.required = true;
    input.classList.add('form-control', 'ml-2');

    checkbox.addEventListener('change', function () {
        if (!checkbox.checked) {
            wrapper.remove(); // Remove whole input + checkbox if unchecked
        }
    });

    wrapper.appendChild(checkbox);
    wrapper.appendChild(input);

    container.appendChild(wrapper);
}
</script>
