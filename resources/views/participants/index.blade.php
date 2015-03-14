@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>Participant List  <a class='btn btn-primary pull-right' href={{ url("/participants/create" ) }}>Add New participant</a></h1></div>
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

                                @if (Session::has('flash_message'))
                                    <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
                                @endif
                                {!! Form::open(['url'=>'participants/import','files'=>true, 'form-horizontal']) !!}
                                <div class="form-group">
                                    {!! Form::label('file','File',['id'=>'','class'=>'sr-only control-label col-sm-1']) !!}
                                    <div class="col-sm-2">
                                        {!! Form::file('file','',['id'=>'','class'=>'form-control file']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-1 col-sm-1">
                                        {!! Form::submit('Import', ['class'=>'btn btn-default']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- reset buttons -->
                                    <div class="">
                                        {!! Form::reset('Reset', ['class'=>'btn btn-default']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::close() !!}
                                </div>

                            <table class="table">
                                <thead>
                                <th>ID.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>NRC No.</th>
                                <th>State</th>
                                <th>View</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @role('admin')
                                @foreach ($participants as $k => $participant)
                                    <tr>
                                        <td>{{ $participant->id }}</td>
                                        <td>{{ $participant->name }}</td>
                                        <td>{{ $participant->email }}</td>
                                        <td>{{ $participant->nrc_id }}</td>
                                        <td>{{{ isset($participant->states[0]->state) ? $participant->states[0]->state : 'Undefined' }}}</td>
                                        <td><a href={{ url("/participants/".$participant->id ) }}>Edit</a></td>
                                        <td><a href={{ url("/participants/".$participant->id."/delete")}}>Delete</a></td>
                                    </tr>
                                @endforeach
                                @endrole
                                </tbody>
                            </table>

                                 {!! $participants->render(); !!}
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop