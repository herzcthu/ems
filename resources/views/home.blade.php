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
                            <span class="info-box-number">M {{ sprintf("%.2f%%", $gender['M']) }}</span>
                            <span class="info-box-number">F {{ sprintf("%.2f%%", $gender['F']) }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Incomplete forms Total</span>
                            <span class="info-box-number"> {{ sprintf("%.2f%%", (isset($no_answers_percent)?$no_answers_percent:0)) }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Spotchecker count</span>
                            <span class="info-box-number">{{ count($spotchecker_answers) }}</span>
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
            @role('admin')
            <div class="row">

                <div class="col-md-12">
                    <!-- Bar chart -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="fa fa-bar-chart-o"></i>
                            <h3 class="box-title">Completed dataentry by enumerator ID</h3>
                        </div>
                        <div class="box-body">
                            <table id="datatable-allfeatures" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                <th>Enumerator form ID</th>
                                <th>Forms in database</th>
                                <th>Data Entry ID (ID, Form ID)</th>
                                <th>Incomplete Forms</th>
                                <th>Perfect Forms</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach (array_count_values(array_column($dataentry->toArray(), 'interviewer_id')) as $key => $value)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                        <td>
                                            @foreach (array_unique(\App\EmsQuestionsAnswers::OfAnswersByEmu($key)->lists('user_id')) as $k => $v)

                                                    (<a href="/users/{{ $v }}">{{ sprintf('%02d',$v) }}</a>)
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach (\App\EmsQuestionsAnswers::OfAnswersByEmu($key)->lists('form_complete', 'interviewee_id') as $fk => $fv)
                                                @if($fv === 0)
                                                @role('admin|staff')
                                                <a href="/{{ urlencode($dashboard_form->name) }}/dataentry/{{\App\EmsQuestionsAnswers::where('interviewee_id',$fk)->pluck('id')}}/edit">
                                                @endrole
                                                {{ $fk }}
                                                @role('admin|staff')
                                                </a>
                                                @endrole
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach (\App\EmsQuestionsAnswers::OfAnswersByEmu($key)->lists('form_complete', 'interviewee_id') as $fk => $fv)
                                                @if($fv === 1)
                                                @role('admin|staff')
                                                <a href="/{{ urlencode($dashboard_form->name) }}/dataentry/{{\App\EmsQuestionsAnswers::where('interviewee_id',$fk)->pluck('id')}}/edit">
                                                @endrole
                                                {{ $fk }}
                                                @role('admin|staff')
                                                </a>
                                                @endrole
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div><!-- /.box-body-->
                    </div><!-- /.box -->

                </div><!-- /.col -->
            </div><!-- /.row -->
            @endrole
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

                            data: [

                                {

                                    type: "stackedColumn100",

                                    toolTipContent: " {name1} <br><span class='text-red'>Incomplete Forms: {y}%</span>",

                                    color: "#C24642",

                                    name: "Incomplete forms",
                                    //legendText: "Incomplete forms",

                                    //axisYType: "secondary",

                                    showInLegend: true,

                                    dataPoints:[

                                    @if(!empty($data_array))
                                        @foreach($all_state as $state_name)
                                            @if(array_key_exists($state_name, array_count_values(array_column($data_array,'State'))))
                                                {label: "{{ $location_data[$state_name]['abbr'] }}", y: {{ $location_data[$state_name]['incomplete_form'] }} , name1: "{{ $state_name }}" },
                                            @else
                                                {label: "{{ $location_data[$state_name]['abbr'] }}", y: 0},
                                            @endif
                                    @endforeach
                                @endif
                                    ]

                                },
                                {

                                    type: "stackedColumn100",

                                    toolTipContent: "<span class='text-blue'>Completed forms: {y}%</span>",

                                    //legendText: "Dataentry forms",

                                    color: "#369EAD",

                                    name: "Completed forms",

                                    showInLegend: true,

                                    dataPoints:[

                                    @if(!empty($data_array))
                                        @foreach($all_state as $state_name)
                                            @if(array_key_exists($state_name, array_count_values(array_column($data_array,'State'))))
                                                {label: "{{ $location_data[$state_name]['abbr'] }}", y: {{ $location_data[$state_name]['completed_forms'] }} , name: "{{ $state_name }}" },
                                            @else
                                                {label: "{{ $location_data[$state_name]['abbr'] }}", y: 0, name1: "{{ $state_name }}" },
                                            @endif
                                        @endforeach
                                    @endif
                                ]

                                },
                                {

                                    type: "stackedColumn100",

                                    toolTipContent: "<span style='color:#F39C12'>Forms not in Database: {y}%</span> <br> <span>Total Forms in Region: {name1}</span> <br><span>Total forms in database: {name2}</span>",

                                    color: "#F39C12",

                                    name: "Forms not in Database",
                                    //legendText: "Incomplete forms",

                                    //axisYType: "secondary",

                                    showInLegend: true,

                                    dataPoints:[

                                    @if(!empty($data_array))
                                        @foreach($all_state as $state_name)
                                            @if(array_key_exists($state_name, array_count_values(array_column($data_array,'State'))))
                                                {label: "{{ $location_data[$state_name]['abbr'] }}", y: {{ $location_data[$state_name]['forms_not_in_db']  }} , name1: "{{ count($location_data[$state_name]['villages']) * 9 }}", name2: "{{ $location_data[$state_name]['answer_count'] }}" },
                                            @else
                                                {label: "{{ $location_data[$state_name]['abbr'] }}", y: 0},
                                            @endif
                                    @endforeach
                                @endif
                                    ]

                                },


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

                        });



                chart.render();

            }

        </script>

    <script src="{{ asset('/plugins/camvasjs/jquery.canvasjs.min.js') }}" type="text/javascript"></script>




@endsection