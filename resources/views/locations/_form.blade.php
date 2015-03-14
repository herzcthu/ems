<div class="form-group">
    {!! Form::label('state', 'State: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <input list="state" name="state">
        <datalist id="state">
            @foreach ($states as $k => $state)
                <option value="{{ $state }}">
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group">
    {!! Form::label('district', 'District: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <input list="district" name="district">
        <datalist id="district">
            @foreach ($districts as $k => $district)
                <option value="{{ $district }}">
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group">
    {!! Form::label('township', 'Township: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <input list="township" name="township">
        <datalist id="township">
            @foreach ($townships as $k => $township)
                <option value="{{ $township }}">
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group">
    {!! Form::label('villagetrack', 'Village Track: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <input list="villagetrack" name="villagetrack">
        <datalist id="villagetrack">
            @foreach ($villagetracks as $k => $villagetrack)
                <option value="{{ $villagetrack }}">
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group">
    {!! Form::label('village', 'Village/Ward: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <input list="village" name="village">
        <datalist id="village">
            @foreach ($villages as $k => $village)
                <option value="{{ $village }}">
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::submit( $submitButton, ['class' => 'btn btn-primary form-control']) !!}
    </div>
</div>