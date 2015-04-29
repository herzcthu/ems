<div class="form-group" id="form-name">
    {!! Form::label('form_id', 'Form Name: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('form_id',$forms, isset($form_id) ? $form_id : null, ['class' => 'form-control',
        isset($form_id) ? 'disabled' : '']) !!}
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
<div class="form-group" id="question">
    {!! Form::label('optional', 'Optional(check for optional Question): ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::checkbox("optional", 1, false, []) !!} Optional Question
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
            {!! Form::radio('q_type','spotchecker',false, ['id' => 'spotchecker', 'class' => 'show-spotchecker']) !!}
            Spotchecker Question
        @endif
    </div>
</div>
@if($form_type == 'spotchecker')
    <div class="form-group" id="enumerator-question-list">
        {!! Form::label('enu_id', 'Enumerator Question: ', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::select('enu_id',$enu_questions, isset($enu_question->parent_id) ? $question->parent_id:null,
            ['class' => 'form-control']) !!}
        </div>
    </div>
@endif
<div class="form-group" id="main-question-list">
    {!! Form::label('main_id', 'Main Question: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('main_id',$main_questions, isset($main_question->parent_id) ? $question->parent_id:null,
        ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group" id="input-type">
    {!! Form::label('input_type', 'Input Type: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('input_type', ['none' => 'None', 'radio' =>
        'Radio', 'choice' => 'Choice', 'select' => 'Select', 'text' => 'Text', 'textarea' => 'Textarea','date' =>
        'Date', 'year' => 'Year', 'month' => 'Month', 'time' => 'Time', 'different' => 'Different input type for each answer'],isset($question->input_type) ?
        $question->input_type: null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group" id="answer-view">
    {!! Form::label('a_view', 'Question Display Type: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('a_view', ['none' => 'None', 'categories' => 'Categories', 'notes' => 'With Text Field Question
        Notes', 'list' => 'List','table' => 'Table','table-column' => 'Table with Sub Questions in column', 'validated-list' => 'Validated List', 'validated-table' =>
        'Validated Table'],isset($question->a_view) ? $question->a_view: null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group" id="predefined-answers">
    {!! Form::label("pre-answers","Predefined Answers",['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        @if(isset($question))
            {!! Form::checkbox("pre-answers[dont-know]","Don't Know", array_key_exists('-97', $question->answers)? $question->answers[-97]: false, ['id' => 'dont-know']) !!} Don't Know
            {!! Form::checkbox("pre-answers[refuse]","Refuse to Answer", array_key_exists('-98', $question->answers)? $question->answers[-98]: false, ['id' => 'refuse-to-answer']) !!} Refuse to Answer
            {!! Form::checkbox("pre-answers[no-answer]","No Answers", array_key_exists('-99', $question->answers)? $question->answers[-99]: false, ['id' => 'no-answers']) !!} No Answers
        @else
            {!! Form::checkbox("pre-answers[dont-know]","Don't Know", true, ['id' => 'dont-know']) !!} Don't Know
            {!! Form::checkbox("pre-answers[refuse]","Refuse to Answer", true, ['id' => 'refuse-to-answer']) !!} Refuse to Answer
            {!! Form::checkbox("pre-answers[no-answer]","No Answers", true, ['id' => 'no-answers']) !!} No Answers
        @endif
    </div>
</div>
<div class="form-group">
    {!! Form::label('answers', 'Answers for Question: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <table class="table">
            <tr>
                <th>No.</th>
                </td>
                <th>Answer Text</th>
                <th>Input Type</th>
                <th>Value</th>
            </tr>
            @for($i=1; $i <= $form_answers_count; $i++)

                <tr id="answers-{{ $i }}">
                    @if(isset($question) && array_key_exists($i, $question->answers))
                        <td>
                            {!! Form::label('answers['.$i.']', $i.': ', ['class' => 'control-label']) !!}
                        </td>

                        <td>
                            {!! Form::text('answers['.$i.'][text]', array_key_exists('text', $question->answers[$i]) ?
                            $question->answers[$i]['text']:null, ['class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::select('answers['.$i.'][type]', ['same' => 'Get from Question','radio' => 'Radio',
                            'choice' => 'Choice', 'select' => 'Select', 'text' => 'Text', 'textarea' =>
                            'Textarea','date' => 'Date', 'year' => 'Year', 'month' => 'Month', 'time' =>
                            'Time'],array_key_exists('type', $question->answers[$i]) ?
                            $question->answers[$i]['type']:'same', ['class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::text('answers['.$i.'][value]', array_key_exists('value',
                            $question->answers[$i]) ? $question->answers[$i]['value']:null, ['class' =>
                            'form-control']) !!}
                        </td>

                    @else
                        <td>
                            {!! Form::label('answers['.$i.']', $i.': ', ['class' => 'control-label']) !!}
                        </td>
                        <td>
                            {!! Form::text('answers['.$i.'][text]', null, ['class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::select('answers['.$i.'][type]', ['same' => 'Get from Question','radio' => 'Radio',
                            'choice' => 'Choice', 'select' => 'Select', 'text' => 'Text', 'textarea' =>
                            'Textarea','date' => 'Date', 'year' => 'Year', 'month' => 'Month', 'time' =>
                            'Time'], 'same', ['class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::text('answers['.$i.'][value]', null, ['class' =>
                            'form-control']) !!}
                        </td>
                    @endif
                </tr>

            @endfor
        </table>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2 col-md-offset-4">
        {!! Form::submit( $submitButton, ['class' => 'btn btn-primary form-control']) !!}
    </div>
</div>