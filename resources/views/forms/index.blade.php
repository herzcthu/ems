@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Form List</h1>
                    </div>
                    <div class="panel-body">
                        <section>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                <section class="row">
                                @if (Session::has('form_import_error'))
                                    <div class="alert alert-danger">{{ Session::get('form_import_error') }}</div>
                                @endif
                                @if (Session::has('form_import_success'))
                                    <div class="alert alert-success">{{ Session::get('form_import_success') }}</div>
                                @endif
                                {!! Form::open(['url'=>'forms','files'=>true, 'form-horizontal']) !!}
                                <div class="form-group">
                                    <div class="col-xs-2">

                                    {!! Form::label('name','Name',['id'=>'','class'=>'control-label']) !!}

                                    {!! Form::text('name','',['id'=>'','class'=>'form-control file']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-2">
                                    {!! Form::label('descriptions','Descriptions',['id'=>'','class'=>'control-label']) !!}

                                        {!! Form::text('descriptions','',['id'=>'','class'=>'form-control file']) !!}
                                    </div>
                                </div>
                                    <!--div class="form-group">
                                        <div class="col-xs-2">
                                            {!! Form::label('no_of_answers','Answers per question',['id'=>'','class'=>'control-label']) !!}

                                            {!! Form::text('no_of_answers','',['id'=>'','class'=>'form-control file']) !!}
                                        </div>
                                    </div-->
                                <div class="form-group">
                                    <div class="col-xs-2">
                                    {!! Form::label('start_date', 'Start Date: ', ['class' => 'control-label']) !!}

                                        {!! Form::input('date', 'start_date', date('d-m-Y'), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-2">
                                    {!! Form::label('end_date', 'End Date: ', ['class' => 'control-label']) !!}

                                        {!! Form::input('date', 'end_date', date('d-m-Y'), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('action', 'Action ', ['class' => 'control-label']) !!}
                                    <div class="col-xs-push-1">
                                    {!! Form::submit('Add New', ['class'=>'btn btn-default']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                {!! Form::close() !!}
                                </div>
                                </section>


                            <table class="table">
                                <thead>

                                <th>No.</th>
                                <th>Form Name</th>
                                <th>Descriptions</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                @permission('view.table')
                                <th>Results</th>
                                @endpermission
                                @permission('edit.form')
                                <th>Build</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                @endpermission
                                @permission('add.data')
                                <th>Add Data</th>
                                @endpermission
                                </thead>
                                <tbody>
                                @role('admin')
                                @foreach ($forms as $k => $form )
                                    <tr>
                                        <td>{{ ( ( $forms->currentPage() * $forms->perPage()) - $forms->perPage() ) + $k + 1 }}</td>
                                        <td>{{ $form->name }}</td>
                                        <td>{{ $form->descriptions }}</td>
                                        <td>{{ $form->start_date }}</td>
                                        <td>{{ $form->end_date }}</td>
                                        @permission('view.table')
                                        <td><a href={{ url("/forms/".$form->id."/results" ) }}>Results</a></td>
                                        @endpermission
                                        @permission('edit.form')
                                        <td><a href={{ url("/forms/".$form->id."/build" ) }}>Build</a></td>
                                        <td><a href={{ url("/forms/".$form->id ) }}>View</a></td>
                                        <td><a href={{ url("/forms/".$form->id."/edit" ) }}>Edit</a></td>
                                        <td><a href={{ url("/forms/".$form->id."/delete" ) }}>Delete</a></td>
                                        @endpermission
                                        @permission('view.form')
                                        <td><a href={{ url("/forms/".urlencode($form->name)."/dataentry" ) }}>Add Data</a></td>
                                        @endpermission
                                    </tr>
                                @endforeach

                                @endrole
                                </tbody>
                            </table>
                            {!! Form::close() !!}
                                 {!! $forms->render(); !!}
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
