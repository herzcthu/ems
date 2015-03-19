@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>answer List</h1>
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
                                @if (Session::has('answer_import_error'))
                                    <div class="alert alert-danger">{{ Session::get('answer_import_error') }}</div>
                                @endif
                                @if (Session::has('answer_import_success'))
                                    <div class="alert alert-success">{{ Session::get('answer_import_success') }}</div>
                                @endif
                                {!! answer::open(['url'=>'answers','files'=>true, 'answer-horizontal']) !!}
                                <div class="answer-group">
                                    <div class="col-xs-2">

                                    {!! answer::label('name','Name',['id'=>'','class'=>'control-label']) !!}

                                    {!! answer::text('name','',['id'=>'','class'=>'answer-control file']) !!}
                                    </div>
                                </div>
                                <div class="answer-group">
                                    <div class="col-xs-2">
                                    {!! answer::label('descriptions','Descriptions',['id'=>'','class'=>'control-label']) !!}

                                        {!! answer::text('descriptions','',['id'=>'','class'=>'answer-control file']) !!}
                                    </div>
                                </div>
                                    <!--div class="answer-group">
                                        <div class="col-xs-2">
                                            {!! answer::label('no_of_answers','Answers per question',['id'=>'','class'=>'control-label']) !!}

                                            {!! answer::text('no_of_answers','',['id'=>'','class'=>'answer-control file']) !!}
                                        </div>
                                    </div-->
                                <div class="answer-group">
                                    <div class="col-xs-2">
                                    {!! answer::label('start_date', 'Start Date: ', ['class' => 'control-label']) !!}

                                        {!! answer::input('date', 'start_date', date('d-m-Y'), ['class' => 'answer-control']) !!}
                                    </div>
                                </div>
                                <div class="answer-group">
                                    <div class="col-xs-2">
                                    {!! answer::label('end_date', 'End Date: ', ['class' => 'control-label']) !!}

                                        {!! answer::input('date', 'end_date', date('d-m-Y'), ['class' => 'answer-control']) !!}
                                    </div>
                                </div>
                                <div class="answer-group">
                                    {!! answer::label('action', 'Action ', ['class' => 'control-label']) !!}
                                    <div class="col-xs-push-1">
                                    {!! answer::submit('Add New', ['class'=>'btn btn-default']) !!}
                                    </div>
                                </div>
                                <div class="answer-group">
                                {!! answer::close() !!}
                                </div>
                                </section>


                            <table class="table">
                                <thead>

                                <th>No.</th>
                                <th>answer Name</th>
                                <th>Descriptions</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                @permission('view.table')
                                <th>Results</th>
                                @endpermission
                                @permission('edit.answer')
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
                                @foreach ($answers as $k => $answer )
                                    <tr>
                                        <td>{{ ( ( $answers->currentPage() * $answers->perPage()) - $answers->perPage() ) + $k + 1 }}</td>
                                        <td>{{ $answer->name }}</td>
                                        <td>{{ $answer->descriptions }}</td>
                                        <td>{{ $answer->start_date }}</td>
                                        <td>{{ $answer->end_date }}</td>
                                        @permission('view.table')
                                        <td><a href={{ url("/answers/".$answer->id."/results" ) }}>Results</a></td>
                                        @endpermission
                                        @permission('edit.answer')
                                        <td><a href={{ url("/answers/".$answer->id."/build" ) }}>Build</a></td>
                                        <td><a href={{ url("/answers/".$answer->id ) }}>View</a></td>
                                        <td><a href={{ url("/answers/".$answer->id."/edit" ) }}>Edit</a></td>
                                        <td><a href={{ url("/answers/".$answer->id."/delete" ) }}>Delete</a></td>
                                        @endpermission
                                        @permission('view.answer')
                                        <td><a href={{ url("/answers/".urlencode($answer->name)."/dataentry" ) }}>Add Data</a></td>
                                        @endpermission
                                    </tr>
                                @endforeach

                                @endrole
                                </tbody>
                            </table>
                            {!! answer::close() !!}
                                 {!! $answers->render(); !!}
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
