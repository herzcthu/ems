<div class="form-group">
    {!! Form::label('name', 'Name: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="input-group col-md-4">
        <div class="input-group-addon"><i class="fa fa-user"></i></div>
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>
@if ($formtype == 'create')
    <div class="form-group">
        {!! Form::label('email', 'Email: ', ['class' => 'col-md-4 control-label']) !!}
        <div class="input-group col-md-4">
            <div class="input-group-addon"><i class="fa fa-at"></i></div>
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
    </div>
@endif
<div class="form-group">
    {!! Form::label('password', 'password: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="input-group col-md-4">
        <div class="input-group-addon"><i class="fa fa-user-secret"></i></div>
        {!! Form::password('password',  ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('user_gender', 'Gender: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="input-group col-md-4">
        <div class="input-group-addon"><i class="fa fa-venus-mars"></i></div>
        {!! Form::select('user_gender', ['M' => 'Male', 'F' => 'Female', 'U' => 'Not Specified'], null, ['class' =>
        'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('dob', 'Date of Birth: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="input-group col-md-4">
        <div class="input-group-addon"><i class="fa fa-birthday-cake"></i></div>
        {!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control dobdatepicker']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('user_line_phone', 'Line Phone: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="input-group col-md-4">
        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
        {!! Form::text('user_line_phone', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('user_mobile_phone', 'Mobile Phone: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="input-group col-md-4">
        <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
        {!! Form::text('user_mobile_phone', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('user_mailing_address', 'Mailing Address: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="input-group col-md-4">
        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
        {!! Form::textarea('user_mailing_address', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('user_biography', 'User Biography: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="input-group col-md-4">
        <div class="input-group-addon"><i class="fa fa-list-alt"></i></div>
        {!! Form::textarea('user_biography', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-md-2 col-md-offset-5">
        {!! Form::submit( $submitButton, ['class' => 'btn btn-primary form-control']) !!}
    </div>
</div>