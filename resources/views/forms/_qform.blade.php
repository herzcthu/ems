<div class="form-group" id="form-name">
    {!! Form::label('form_id', 'Form Name: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('form_id',$forms, isset($form_id) ? $form_id : null, ['class' => 'form-control', isset($form_id) ? 'disabled' : '']) !!}
        @if(isset($form_id))
            {!! Form::hidden('form_id', $form_id) !!}
        @endif
    </div>
</div>

<div class="form-group" id="question-number">
    {!! Form::label('question_number', 'Question No.: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('question_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group" id="question">
    {!! Form::label('question', 'Question: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('question', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group" id="question-type">
    {!! Form::label('q_type', 'Question Type: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::radio('q_type','single',true, ['id' => 'single', 'class' => 'mainhide']) !!} Single
        {!! Form::radio('q_type','main',false,['id' => 'main', 'class' => 'mainhide']) !!} Main
        {!! Form::radio('q_type','sub',false, ['id' => 'sub', 'class' => 'mainshow']) !!} Sub Question
        {!! Form::radio('q_type','same',false, ['id' => 'same', 'class' => 'mainshow']) !!} Same Answers as Main
        @if($form_type == 'spotchecker')
            {!! Form::radio('q_type','spotchecker',false, ['id' => 'spotchecker', 'class' => 'show-spotchecker mainshow']) !!} Spotchecker Question
        @endif
    </div>
</div>
@if($form_type == 'spotchecker')
    <div class="form-group" id="enumerator-question-list">
        {!! Form::label('main_id', 'Enumerator Question: ', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::select('main_id',$main_questions, isset($question->parent_id) ? $question->parent_id:null, ['class' => 'form-control']) !!}
        </div>
    </div>
@else
<div class="form-group" id="main-question-list">
    {!! Form::label('main_id', 'Main Question: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('main_id',$main_questions, isset($question->parent_id) ? $question->parent_id:null, ['class' => 'form-control']) !!}
    </div>
</div>
@endif
<div class="form-group" id="input-type">
    {!! Form::label('input_type', 'Input Type: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('input_type', ['none' => 'None', 'same' => 'Same answers for all Sub Questions','radio' => 'Radio', 'choice' => 'Choice', 'select' => 'Select', 'text' => 'Text', 'textarea' => 'Textarea','date' => 'Date', 'year' => 'Year', 'month' => 'Month', 'time' => 'Time'],isset($question->input_type) ? $question->input_type: null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group" id="answer-view">
    {!! Form::label('a_view', 'Question Display Type: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('a_view', ['none' => 'None', 'categories' => 'Categories', 'notes' => 'With Text Field Question Notes', 'list' => 'List','table' => 'Table', 'validated-list' => 'Validated List', 'validated-table' => 'Validated Table'],isset($question->a_view) ? $question->a_view: null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group" id="predefined-answers">
    {!! Form::label("answers[-8]","Predefined Answers",['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::checkbox("answers[0]","No Answers",true, ['id' => 'no-answers']) !!} No Answers
        {!! Form::checkbox("answers[-8]","Don't Know",true, ['id' => 'dont-know']) !!} Don't Know
        {!! Form::checkbox("answers[-9]","Refuse to Answer",true, ['id' => 'refuse-to-answer']) !!} Refuse to Answer
    </div>
</div>
@for($i=1; $i <= $form_answers_count; $i++)
    <div class="form-group" id="answers-{{ $i }}">
        {!! Form::label('answers['.$i.']', 'Answer '.$i.': ', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::text('answers['.$i.']', isset($question->answers[$i]) ? $question->answers[$i]:null, ['class' => 'form-control']) !!}
        </div>
    </div>
@endfor
<div class="form-group">
    <div class="col-sm-2 col-md-offset-4">
        {!! Form::submit( $submitButton, ['class' => 'btn btn-primary form-control']) !!}
    </div>
</div>