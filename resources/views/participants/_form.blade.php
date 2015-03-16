<div class="form-group">
    {!! Form::label('name', 'Name: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>
@if ($formtype == 'create')
<div class="form-group">
    {!! Form::label('email', 'Email: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>
</div>
@endif
<div class="form-group">
    {!! Form::label('nrc_id', 'NRC No: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nrc_id', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('ethnicity', 'Ethnicity: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('ethnicity', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('participant_type', 'Participant Type: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('participant_type', ['coordinator' => 'Coordinator', 'enumerator' => 'Enumerator', 'spotchecker' => 'Spot Checker' ], ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('parent_id', 'Coordinator Name: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    <?php

        array_unshift($coordinators, ['null' =>'No Coordinator']);

        ?>
        {!! Form::select('parent_id', $coordinators, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('location', 'Location Assigned: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('location', ['Region' => $districts, 'Township' => $townships, 'Village' => $villages ], ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('user_gender', 'Gender: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('user_gender', ['male' => 'Male', 'female' => 'Female', 'third_gender' => 'Not Specified'], ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('dob', 'Date of Birth: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('date', 'dob', date('Y-m-d'), ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('user_line_phone', 'Line Phone: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('user_line_phone', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('user_mobile_phone', 'Mobile Phone: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('user_mobile_phone', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('current_org', 'Current Organization: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('current_org', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('user_mailing_address', 'Mailing Address: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('user_mailing_address', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('education_level', 'Education: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('education_level', ['none' => 'Not Defined', 'primary' => 'Primary', 'middle' => 'Middle', 'highschool' => 'High School', 'under_graduate' => 'Under Graduate', 'graduated' => 'Graduated', 'post_graduated' => 'Post Graduate'], ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('user_biography', 'User Biography: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('user_biography', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::submit( $submitButton, ['class' => 'btn btn-primary form-control']) !!}
    </div>
</div>