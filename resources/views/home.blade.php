@extends('adminlte')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ _t('Dashboard') }}
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

                            <span class="info-box-number">{{ !empty($data_array)? count($data_array): 0 }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa  ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Gender</span>
                            <span class="info-box-number">M {{ !empty($data_array)? sprintf("%.2f%%",(((array_key_exists('M', array_count_values(array_column($data_array,'Interviewee Gender')))? array_count_values(array_column($data_array,'Interviewee Gender'))['M']:0)/count($data_array))*100)):0 }}</span>
                            <span class="info-box-number">F {{ !empty($data_array)? sprintf("%.2f%%",(((array_key_exists('F', array_count_values(array_column($data_array,'Interviewee Gender')))? array_count_values(array_column($data_array,'Interviewee Gender'))['F']:0)/count($data_array))*100)):0 }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Incomplete Answers</span>
                            <span class="info-box-number"> {{ sprintf("%.2f%%", (isset($no_answers_percent)?$no_answers_percent:0)) }}</span>
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

                <div class="col-md-12">
                    <!-- Bar chart -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="fa fa-bar-chart-o"></i>
                            <h3 class="box-title">Total Answers Statistics</h3>
                        </div>
                        <div class="box-body">
                            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                        </div><!-- /.box-body-->
                    </div><!-- /.box -->

                </div><!-- /.col -->
            </div><!-- /.row -->

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
        @if(!empty($data_array))
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
        var mon = {{ array_key_exists('Mon', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Mon']:0 }};
        var tanintharyi = {{ array_key_exists('Tanintharyi', array_count_values(array_column($data_array,'State')))? array_count_values(array_column($data_array,'State'))['Tanintharyi']:0 }};
        @endif

        if (typeof ayeyarwady === 'undefined') {
            var ayeyarwady = '0';
        }
        if (typeof bago_west === 'undefined') {
            var bago_west = '0';
        }
        if (typeof bago_east === 'undefined') {
            var bago_east = '0';
        }
        if (typeof chin === 'undefined') {
            var chin = '0';
        }
        if (typeof sagaing === 'undefined') {
            var sagaing = '0';
        }
        if (typeof mandalay === 'undefined') {
            var mandalay = '0';
        }
        if (typeof magway === 'undefined') {
            var magway = '0';
        }
        if (typeof kachin === 'undefined') {
            var kachin = '0';
        }
        if (typeof rakhaing === 'undefined') {
            var rakhaing = '0';
        }
        if (typeof kayin === 'undefined') {
            var kayin = '0';
        }
        if (typeof shan_north === 'undefined') {
            var shan_north = '0';
        }
        if (typeof shan_south === 'undefined') {
            var shan_south = '0';
        }
        if (typeof mon === 'undefined') {
            var mon = '0';
        }
        if (typeof tanintharyi === 'undefined') {
            var tanintharyi = '0';
        }
    </script>


        <script type="text/javascript">

            window.onload = function () {

                var chart = new CanvasJS.Chart("chartContainer",

                        {

                            theme: "theme3",

                            animationEnabled: true,

                            title:{

                                text: "Total Answers Statistics",

                                fontSize: 20

                            },

                            toolTip: {

                                shared: true

                            },

                            axisY: {

                                title: "Nos. of answers"

                            },

                            axisY2: {

                                title: "unanswered count"

                            },



                            legend:{

                                verticalAlign: "top",

                                horizontalAlign: "center"

                            },

                            data: [

                                {

                                    type: "column",

                                    name: "Total Answers",

                                    legendText: "Total Answers",

                                    showInLegend: true,

                                    dataPoints:[

                                        {label: "Ayeyarwady", y: 262},

                                        {label: "Sagaing", y: 137},

                                        {label: "Chin", y: 115},

                                        {label: "Bago (W)", y: 211},

                                        {label: "Bago (E)", y: 175},

                                        {label: "Kachin", y: 104},

                                        {label: "Kayah", y: 97.8},

                                        {label: "Kayin", y: 60},

                                        {label: "Rakhaing", y: 23.3},

                                        {label: "Shan (S)", y: 20.4},

                                        {label: "Shan (N)", y: 20.4},

                                        {label: "Mon", y: 20.4},

                                        {label: "Tanyitharyi", y: 20.4}





                                    ]

                                },

                                {

                                    type: "column",

                                    name: "Unanswered Count",

                                    legendText: "Unanswered Count",

                                    axisYType: "secondary",

                                    showInLegend: true,

                                    dataPoints:[

                                        {label: "Ayeyarwady", y: 26.2},

                                        {label: "Sagaing", y: 13.7},

                                        {label: "Chin", y: 11.5},

                                        {label: "Bago (W)", y: 21.1},

                                        {label: "Bago (E)", y: 17.5},

                                        {label: "Kachin", y: 10.4},

                                        {label: "Kayah", y: 9.78},

                                        {label: "Kayin", y: 6.0},

                                        {label: "Rakhaing", y: 2.33},

                                        {label: "Shan (S)", y: 2.04},

                                        {label: "Shan (N)", y: 7.4},

                                        {label: "Mon", y: 5.4},

                                        {label: "Tanyitharyi", y: 4.4}





                                    ]

                                }



                            ],

                            legend:{

                                cursor:"pointer",

                                itemclick: function(e){

                                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {

                                        e.dataSeries.visible = false;

                                    }

                                    else {

                                        e.dataSeries.visible = true;

                                    }

                                    chart.render();

                                }

                            },

                        });



                chart.render();

            }

        </script>

    <script src="{{ asset('/plugins/camvasjs/jquery.canvasjs.min.js') }}" type="text/javascript"></script>



    <!-- FLOT CHARTS -->
    <script src="{{ asset('/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="{{ asset('/plugins/flot/jquery.flot.pie.min.js') }}" type="text/javascript"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="{{ asset('/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>


    <style type="text/css">
        #gender-chart { height:300px;}
    </style>
    <script type="text/javascript">


        $(function( ) {

            var data = {
                data: [["Ayeyawady", ayeyarwady], ["Bago (West)", bago_west], ["Bago (East)", bago_east], ["Chin", chin], ["Sagaing", sagaing],
                    ["Mandalay", mandalay], ["Magway", magway], ["Kachin", kachin], ["Kayin", kayin], ["Rakhaing", rakhaing], ["Shan (North)", shan_north], ["Shan (South)", shan_south]],
                color: "#3c8dbc"
            };

            $.plot($("#gender-chart"), [data], {
                grid: {
                    borderWidth: 1,
                    borderColor: "#f3f3f3",
                    tickColor: "#f3f3f3"
                },
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.5,
                        align: "center"
                    }
                },
                xaxis: {
                    mode: "categories",
                    tickLength: 0,
                    tickDecimals: 0,
                    tickSize: 1
                },
                yaxis: {
                    tickLength: 0,
                    tickDecimals: 0,
                    tickSize: 1
                }
            });

        });

    </script>




@endsection