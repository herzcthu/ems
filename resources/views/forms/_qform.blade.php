<div class="form-group">
    {!! Form::label('form_id', 'Form Name: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('form_id',$forms, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('question_number', 'Question No.: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('question_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('question', 'Question: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('question', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('q_type', 'Question Type: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::radio('q_type','single',true) !!} Single
        {!! Form::radio('q_type','main') !!} Main
        {!! Form::radio('q_type','sub') !!} Sub Question
    </div>
</div>
<div class="form-group">
    {!! Form::label('main_id', 'Main Question: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('main_id',$questions, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('input_type', 'Input Type: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('input_type', ['none' => 'None', 'radio' => 'Radio', 'choice' => 'Choice', 'select' => 'Select', 'text' => 'Text', 'textarea' => 'Textarea'],isset($question->input_type) ? $question->input_type: null, ['class' => 'form-control']) !!}
    </div>
</div>
@for($i=1; $i <= \App\GeneralSettings::options('options', 'answers_per_question'); $i++)
    <div class="form-group">
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