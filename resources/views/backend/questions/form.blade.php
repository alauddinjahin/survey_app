<div class="modal-body">

    <div class="form-group">
        <label for="survey_id">Survey</label>
        <select name="survey_id" id="survey_id" class="form-control select2" required>
            <option value="" selected disabled>SELECT A SURVEY</option>
            @if(count($surveys)>0)
                @foreach ($surveys as $key=>$item)
                    <option value="{{ $key }}" {{ isset($question) ? ($question->survey_id == $key ? 'selected':'' ) :'' }}>{{ $item }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="form-group">
        <label for="question">Question</label>
        <input type="text" name="question" id="question" class="form-control" placeholder="Enter Question" required value="{{ isset($question) ? $question->question:'' }}">
    </div>


    <div class="form-group">
        <label for="question_type">Question's Type</label>
        <select name="type" id="question_type" class="form-control select2" required>
            <option value="" selected disabled>SELECT A TYPE</option>
            @foreach (questionTypes() as $k=>$opt)
                <option value="{{ $k }}" {{ isset($question) ? ($question->type==$k?'selected':'') :'' }}>{{ $opt }}</option>  
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="step_no">Step No</label>
        <input type="number" name="step_no" id="step_no" class="form-control" required value="{{ isset($question) ? $question->step_no:'0' }}">
    </div>
    
    <div class="form-group custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="is_required" name="is_required" {{ isset($question) ? (boolval($question->is_required)?'checked':''):'' }}>
        <label class="custom-control-label" for="is_required">Is Required</label>
    </div>

</div>