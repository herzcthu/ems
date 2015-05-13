@extends('adminlte')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
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
                            <span class="info-box-text">Incomplete forms</span>
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
                            <h3 class="box-title">Data Entry Completion</h3>
                        </div>
                        <div class="box-body">
                            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                        </div><!-- /.box-body-->
                    </div><!-- /.box -->

                </div><!-- /.col -->
            </div><!-- /.row -->

        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->

        <script type="text/javascript">

            window.onload = function () {

                var chart = new CanvasJS.Chart("chartContainer",

                        {

                            theme: "theme3",

                            animationEnabled: true,

                            title:{

                                text: "Data Entry",

                                fontSize: 20

                            },

                            toolTip: {

                                shared: true

                            },

                            axisY: {

                                title: "Nos. of forms Dataentry"

                            },

                            axisY2: {

                                title: "Incomplete forms"

                            },



                            legend:{

                                verticalAlign: "top",

                                horizontalAlign: "center"

                            },

                            data: [

                                {

                                    type: "column",

                                    toolTipContent: " {name} <p class='text-blue'>Dataentry forms: {y}%</p>",

                                    legendText: "Dataentry forms",

                                    showInLegend: true,

                                    dataPoints:[

                                    @if(!empty($data_array))
                                        @foreach($all_state as $state_name)
                                            @if(array_key_exists($state_name, array_count_values(array_column($data_array,'State'))))
                                                {label: "{{ $location_data[$state_name]['abbr'] }}", y: {{ round(( $location_data[$state_name]['answer_count'] / (count($location_data[$state_name]['villages']) * 9)  * 100 ), 2) }} , name: "{{ $state_name }}" },
                                            @else
                                                {label: "{{ $location_data[$state_name]['abbr'] }}", y: 0, name: "{{ $state_name }}" },
                                            @endif
                                        @endforeach
                                    @endif
                                ]

                                },

                                {

                                    type: "column",

                                    toolTipContent: "<p class='text-red'>Incomplete Forms: {y}%</p>",

                                    legendText: "Incomplete forms",

                                    axisYType: "secondary",

                                    showInLegend: true,

                                    dataPoints:[

                                    @if(!empty($data_array))
                                        @foreach($all_state as $state_name)
                                            @if(array_key_exists($state_name, array_count_values(array_column($data_array,'State'))))
                                                {label: "{{ $location_data[$state_name]['abbr'] }}", y: {{ round(( $location_data[$state_name]['incomplete_count'] / (count($location_data[$state_name]['villages']) * 9)  * 100 ), 2) }} },
                                            @else
                                                {label: "{{ $location_data[$state_name]['abbr'] }}", y: 0},
                                            @endif
                                    @endforeach
                                @endif
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


                        /** Set axisY properties here*/
                        axisY:{
                            //prefix: "$",
                            suffix: "%"
                        },
                        axisY2:{
                            //prefix: "$",
                            suffix: "%"
                        }

                        });



                chart.render();

            }

        </script>

    <script src="{{ asset('/plugins/camvasjs/jquery.canvasjs.min.js') }}" type="text/javascript"></script>




@endsection