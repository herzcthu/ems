@extends('adminlte')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Users
                <small>Users List</small>
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
                    @if (Session::has('user_delete_error'))
                        <div class="alert alert-danger">{{ Session::get('user_delete_error') }}</div>
                    @endif
                        @if (Session::has('error_message'))
                            <div class="alert alert-danger">{{ Session::get('error_message') }}</div>
                        @endif
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Users List</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            {!! Form::open(['url' => 'roles']) !!}
                            <div class="form-group">
                            @role('admin')
                            {!! Form::select('user_role', ['1' => 'Admin', '2' => 'Office Staff', '3' => 'Data Entry',
                            '4' => 'Analyst' ], ['class' => 'form-control']) !!}
                            @endrole
                            @role('staff')
                            {!! Form::select('user_role', ['2' => 'Office Staff', '3' => 'Data Entry', '4' => 'Analyst'
                            ], ['class' => 'form-control']) !!}
                            @endrole
                            {!! Form::submit( 'Change Role') !!}
                            </div>
                            <table id="datatable-allfeatures" class="table table-bordered table-striped">
                                <thead>
                                <th>{!! Form::input('checkbox', 'userrole', null, ['id' => 'cb']) !!}</th>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Enu Form Count</th>
                                <th>User Role</th>
                                <th>Gender</th>
                                <th>Date of Birth</th>
                                <th>Profile</th>
                                <th>Edit</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @role('admin')
                                @foreach ($users as $k => $user)
                                    <tr>
                                        <td>{!! Form::input('checkbox', 'userid['.$user->id.']' , $user->id, ['class' => 'cb']) !!}</td>
                                        <td>{{ $k + 1}}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ \App\EmsQuestionsAnswers::where('user_id', '=', $user->id)->count() }}</td>
                                        <td>{{ $user->roles->toArray()[0]['name'] }}</td>
                                        <td>{{ $user->user_gender }}</td>
                                        <td>{{ $user->dob }}</td>
                                        <td><a href={{ url("/users/".$user->id ) }}>View</a></td>
                                        <td><a href={{ url("/users/".$user->id."/edit" ) }}>Edit</a></td>
                                        <td><a href={{ url("/users/".$user->id."/delete")}}>Delete</a></td>
                                    </tr>
                                @endforeach
                                @endrole
                                </tbody>
                            </table>
                            {!! Form::close() !!}
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