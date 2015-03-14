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
    {!! Form::label('state', 'State Assigned: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('state', $states, ['class' => 'form-control']) !!}
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