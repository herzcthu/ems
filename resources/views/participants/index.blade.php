@extends('adminlte')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Participants
                <small>Add New Participant</small>
            </h1>
            <!--ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol-->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Import Participants List</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
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

                            @if (Session::has('participant_import_error'))
                                <div class="alert alert-success">{{ Session::get('participant_import_error') }}</div>
                            @endif
                            @if (Session::has('participant_success'))
                                <div class="alert alert-success">{{ Session::get('participant_success') }}</div>
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
                                {!! Form::close() !!}

                        </div>
                        <!-- box-body -->
                    </div>
                    <!-- box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Participants List Table</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            {!! Form::open(['url'=>'participants/setgroup','files'=>true, 'form-horizontal']) !!}
                            <div class="form-group">
                                @permission('edit.form')
                                {!! Form::select('p_groups', $p_group, ['class' => 'form-control']) !!}
                                @endpermission
                                {!! Form::submit('Change Group',['name' => 'change_group']) !!}
                                {!! Form::submit('Delete',['name' => 'delete']) !!}
                            </div>
                            @if (Session::has('participant_deleted'))
                                <div class="alert alert-success">{{ Session::get('participant_deleted') }}</div>
                            @endif
                            <table id="datatable-allfeatures" class="table table-bordered table-striped">
                                <thead>
                                <th style="background:none !important">{!! Form::input('checkbox', 'p_group', null, ['id' => 'cb']) !!}</th>
                                <th>PACE ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>NRC No.</th>
                                <th>Date of Birth</th>
                                <th>Participant Role</th>
                                <th>Location</th>
                                <th>Bank</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @permission('edit.form')
                                @foreach ($participants as $k => $participant)
                                    <tr>
                                        <td>{!! Form::input('checkbox', 'participant_id['.$participant->id.']' , $participant->id, ['class' => 'cb']) !!} </td>
                                        <td>{{ $participant->participant_id }}</td>
                                        <td><a href={{ url("/participants/".$participant->id ) }}>{{ $participant->name }}</a></td>
                                        <td>{{ $participant->user_mailing_address }}</td>
                                        <td>{{ $participant->nrc_id }}</td>
                                        <td>
                                        @if('01-01-1970' != $participant->dob)
                                        {{ $participant->dob }}
                                        @endif
                                        </td>
                                        <td>{!! ucwords($participant->participant_type) !!}</td>
                                        @if($participant->participant_type == 'coordinator')
                                            <td>{{ implode(', ', $participants->find($participant->id)->states->lists('state') ) }}</td>

                                        @elseif($participant->participant_type == 'enumerator')
                                            <td>{{ isset($participant->villages->toArray()[0]['village']) ? $participant->villages->toArray()[0]['village'] : 'undefined'  }}</td>
                                        @elseif($participant->participant_type == 'spotchecker')
                                            <td>{{ implode(', ', $participants->find($participant->id)->townships->lists('township')) }}</td>
                                        @endif
                                        <td>{{ $participant->bank }}</td>
                                        <td><a href={{ url("/participants/".$participant->id."/delete")}}>Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @endpermission
                                </tbody>
                            </table>
                            {!! Form::close() !!}
                            <!--   @{!! $participants->render(); !!} -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->


@endsection