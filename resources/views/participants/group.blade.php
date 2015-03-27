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
                @if (Session::has('pgroup_error'))
                    <div class="col-xs-12 text-center">
                    <div class="col-xs-4 col-xs-offset-4 alert alert-danger">{{ Session::get('pgroup_error') }}</div>
                    </div>

                @endif
                @if (Session::has('pgroup_success'))
                     <div class="col-xs-12 text-center">
                        <div class="col-xs-4 col-xs-offset-4 alert alert-success">{{ Session::get('pgroup_success') }}</div>
                    </div>
                @endif
                <div class="col-xs-4">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Add New Group</h3>
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


                                {!! Form::open(['url'=>'participants/group','files'=>true, 'form-horizontal']) !!}
                                <div class="form-group">
                                    {!! Form::label('name','Name : ',['id'=>'','class'=>'control-label']) !!}
                                    <div class="input-group">
                                        {!! Form::text('name',null,['id'=>'','class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('descriptions','Group Descriptions : ',['id'=>'','class'=>'control-label']) !!}
                                    <div class="input-group">
                                        {!! Form::text('descriptions',null,['id'=>'','class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        {!! Form::submit('Add New', ['class'=>'btn btn-default']) !!}
                                    </div>
                                </div>

                                {!! Form::close() !!}
                                </div><!-- box-body -->
                        </div><!-- box -->
                    </div>
                    <div class="col-xs-8">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Participants Group</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                <table id="datatable-allfeatures" class="table table-bordered table-striped">
                                <thead>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Descriptions</th>
                                <th>No. of Participants</th>
                                <th>Edit</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @role('admin')
                                @foreach ($p_groups as $k => $p_group)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $p_group->name }}</td>
                                        <td>{{ $p_group->descriptions }}</td>
                                        <td>{{ count($p_group->participants) }}</td>
                                        <td><a href={{ url("/participants/group/".$p_group->id ) }}>Edit</a></td>
                                        <td><a href={{ url("/participants/group/".$p_group->id."/delete")}}>Delete</a></td>
                                    </tr>
                                @endforeach
                                @endrole
                                </tbody>
                            </table>


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