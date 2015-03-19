@extends('adminlte')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Locations
                <small>Geolocation Data</small>
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
                            <h3 class="box-title">Geolocation Table</h3>
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

                        @if (Session::has('location_import_error'))
                            <div class="alert alert-danger">{{ Session::get('location_import_error') }}</div>
                        @endif
                        @if (Session::has('location_import_success'))
                            <div class="alert alert-success">{{ Session::get('location_import_success') }}</div>
                        @endif
                        {!! Form::open(['url'=>'locations/import','files'=>true, 'form-horizontal']) !!}
                        <div class="form-group">
                            {!! Form::label('file','File',['id'=>'','class'=>'sr-only control-label col-sm-1'])
                            !!}
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

                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Geolocation Table</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="datatable-allfeatures" class="table table-bordered table-striped">
                                <thead>
                                <th>No.</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Township</th>
                                <th>Village Track</th>
                                <th>Village/Ward</th>
                                <th>Village Burmese</th>
                                </thead>
                                <tbody>
                                @role('admin')
                                @foreach ($locations as $k => $location )
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $location->township->district->state->state }}</td>
                                        <td>{{ $location->township->district->district }}</td>
                                        <td>{{{ $location->township->township }}}</td>
                                        <td>{{{ isset($location->villagetrack ) ? $location->villagetrack : '' }}}</td>
                                        <td>{{{ isset($location->village ) ? $location->village : '' }}}</td>
                                        <td>{{{ isset($location->village_my ) ? $location->village_my : '' }}}</td>
                                    </tr>
                                @endforeach

                                @endrole
                                </tbody>
                            </table>
                            {!! Form::close() !!}
                            <!--div id="datatable-1_paginate" class="dataTables_paginate paging_bootstrap">
                                    @{!! $locations->render(); !!}
                                </div-->
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

