{{-- resources/views/exam-marks/modals/add_modal.blade.php --}}
@if($selectedStudent)
@foreach($selectedStudent->course->subjects as $subject)
    @if(!$examMarks->has($subject->id))
    <div class="modal fade" id="addExamMarkModal-{{ $subject->id }}" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form action="{{ route('exam-marks.store') }}" method="POST">
          @csrf
          <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Marks - {{ $subject->name }}</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Marks for {{ $subject->name }}</label>
                <input type="number" name="marks[{{ $subject->id }}]" class="form-control" placeholder="Enter marks" min="0" max="100" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Save</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    @endif
@endforeach
@endif
