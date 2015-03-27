@extends('adminlte')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Dashboard</small>
            </h1>
            <!--ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol-->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Interviewee</span>

                            <span class="info-box-number">{{ count($data_array) }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa  ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"></span>
                            <span class="info-box-number"></span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"></span>
                            <span class="info-box-number"></span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"></span>
                            <span class="info-box-number"></span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
            </div>


            <div class="row">

                <div class="col-md-6">
                    <!-- Bar chart -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="fa fa-bar-chart-o"></i>
                            <h3 class="box-title">Data Entry Completion Process( Temporary Dummy Data)</h3>
                        </div>
                        <div class="box-body">
                            <div id="gender-chart"></div>
                        </div><!-- /.box-body-->
                    </div><!-- /.box -->

                </div><!-- /.col -->

                <div class="col-md-6">
                    <!-- Donut chart -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="fa fa-edit"></i>
                            <h3 class="box-title">Forms List</h3>
                        </div>
                        <div class="box-body">
                            <table style="height:300px" class="table table-bordered table-striped table-hover table-heading">
                                <thead>

                                <th>No.</th>
                                <th>Form Name</th>
                                <th>Descriptions</th>
                                @permission('view.table')
                                <th>Results</th>
                                <th>View</th>
                                @endpermission
                                @permission('add.data')
                                <th>Add Data</th>
                                @endpermission
                                </thead>
                                <tbody>
                                @permission('view.table')

                                @foreach ($forms as $k => $form )
                                    <tr>

                                        <td>{{ $k + 1}}</td>
                                        <td>{{ $form->name }}</td>
                                        <td>{{ $form->descriptions }}</td>
                                        @permission('view.table')
                                        <td>
                                            <a href={{ url("/results/".urlencode($form->name)."/details" ) }}>Results</a>
                                        </td>
                                        <td><a href={{ url("/forms/".urlencode($form->name) ) }}>View</a></td>
                                        @endpermission
                                        @permission('add.data')
                                        <td><a href={{ url("/forms/".urlencode($form->name)."/dataentry" ) }}>Add
                                                Data</a>
                                        </td>
                                        @endpermission
                                    </tr>
                                @endforeach

                                @endpermission
                                </tbody>
                                <tfoot>
                                <th>No.</th>
                                <th>Form Name</th>
                                <th>Descriptions</th>
                                @permission('view.table')
                                <th>Results</th>
                                <th>View</th>
                                @endpermission
                                @permission('add.data')
                                <th>Add Data</th>
                                @endpermission
                                </tfoot>
                            </table>
                            {!! $forms->render() !!}
                        </div><!-- /.box-body-->
                    </div><!-- /.box -->


                </div><!-- /.col -->
            </div><!-- /.row -->
        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->


@endsection