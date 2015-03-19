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
                                </div><!-- box-body -->
                        </div><!-- box -->
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Participants List Table</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                <table id="datatable-allfeatures" class="table table-bordered table-striped">
                                <thead>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>NRC No.</th>
                                <th>Participant Role</th>
                                <th>Location</th>
                                <th>View</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @role('admin')
                                @foreach ($participants as $k => $participant)
                                    <tr>
                                        <!--td>@{{ (( $participants->currentPage() * $participants->perPage()) - $participants->perPage() ) + $k + 1}}</td-->
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $participant->name }}</td>
                                        <td>{{ $participant->email }}</td>
                                        <td>{{ $participant->nrc_id }}</td>
                                        <td>{!! ucwords($participant->participant_type) !!}</td>
                                        <td>{{ isset($participant->districts->toArray()[0]['district']) ? $participant->districts->toArray()[0]['district'] : $participant->states->toArray()[0]['state'] }}</td>
                                        <td><a href={{ url("/participants/".$participant->id ) }}>Edit</a></td>
                                        <td><a href={{ url("/participants/".$participant->id."/delete")}}>Delete</a></td>
                                    </tr>
                                @endforeach
                                @endrole
                                </tbody>
                            </table>

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