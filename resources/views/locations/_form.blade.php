<div class="form-group">
    {!! Form::label('state', 'State: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-xs-4">
        <input list="state" name="state" class="form-control">
        <datalist id="state">
            @foreach ($states as $k => $state)
                <option value="{{ $state }}">
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group">
    {!! Form::label('district', 'District: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-xs-4">
        <input list="district" name="district" class="form-control">
        <datalist id="district">
            @foreach ($districts as $k => $district)
                <option value="{{ $district }}">
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group">
    {!! Form::label('township', 'Township: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-xs-4">
        <input list="township" name="township" class="form-control">
        <datalist id="township">
            @foreach ($townships as $k => $township)
                <option value="{{ $township }}">
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group">
    {!! Form::label('villagetrack', 'Village Track: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-xs-4">
        <input list="villagetrack" name="villagetrack" class="form-control">
        <datalist id="villagetrack">
            @foreach ($villagetracks as $k => $villagetrack)
                <option value="{{ $villagetrack }}">
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group">
    {!! Form::label('village', 'Village/Ward: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-xs-4">
        <input list="village" name="village" class="form-control">
        <datalist id="village">
            @foreach ($villages as $k => $village)
                <option value="{{ $village }}">
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2 col-md-offset-4">
        {!! Form::submit( $submitButton, ['class' => 'btn btn-primary form-control']) !!}
    </div>
</div>