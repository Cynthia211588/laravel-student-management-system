{{-- resources/views/exam-marks/modals/edit_modal.blade.php --}}
@if($selectedStudent)
@foreach($selectedStudent->course->subjects as $subject)
    @if($examMarks->has($subject->id))
    <div class="modal fade" id="editExamMarkModal-{{ $subject->id }}" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form action="{{ route('exam-marks.update', ['student' => $selectedStudent->id, 'course_id' => $selectedStudent->course->id, 'subject_id' => $subject->id]) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Marks - {{ $subject->name }}</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>{{ $subject->name }}</label>
                <input type="number" 
                       name="marks[{{ $subject->id }}]" 
                       class="form-control"
                       value="{{ old('marks.'.$subject->id, $examMarks[$subject->id]->marks ?? '') }}"
                       min="0" max="100" required>
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
    @endif
@endforeach
@endif
