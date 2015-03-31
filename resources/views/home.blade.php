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
                            <span class="info-box-text">Dataentry Count</span>

                            <span class="info-box-number">{{ count($data_array) }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa  ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Gender</span>
                            <span class="info-box-number">M {{ (((array_key_exists('M', array_count_values(array_column($data_array,'Interviewee Gender')))? array_count_values(array_column($data_array,'Interviewee Gender'))['M']:0)/count($data_array))*100) }} %</span>
                            <span class="info-box-number">F {{ (((array_key_exists('F', array_count_values(array_column($data_array,'Interviewee Gender')))? array_count_values(array_column($data_array,'Interviewee Gender'))['F']:0)/count($data_array))*100) }} %</span>
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
                            <h3 class="box-title">Data Entry Completion</h3>
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

    <script type="text/javascript">
        var ayeyarwady = {{ array_key_exists('Ayeyarwady', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Ayeyarwady']:0 }};
        var bago_west = {{ array_key_exists('Bago (West)', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Bago (West)']:0 }};
        var bago_east = {{ array_key_exists('Bago (East)', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Bago (East)']:0 }};
        var sagaing = {{ array_key_exists('Sagaing', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Sagaing']:0 }};
        var chin = {{ array_key_exists('Chin', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Chin']:0 }};
        var kachin = {{ array_key_exists('Kachin', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Kachin']:0 }};
        var kayah = {{ array_key_exists('Kayah', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Kayah']:0 }};
        var kayin = {{ array_key_exists('Kayin', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Kayin']:0 }};
        var rakhaing = {{ array_key_exists('Rakhaing', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Rakhaing']:0 }};
        var yangon = {{ array_key_exists('Yangon', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Yangon']:0 }};
        var mandalay = {{ array_key_exists('Mandalay', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Mandalay']:0 }};
        var magway = {{ array_key_exists('Magway', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Magway']:0 }};
        var shan_north = {{ array_key_exists('Shan (North)', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Shan (North)']:0 }};
        var shan_south = {{ array_key_exists('Shan (South)', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Shan (South)']:0 }};
    </script>


@endsection