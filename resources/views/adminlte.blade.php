<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>{!! App\GeneralSettings::options('options', 'site_name') !!}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="{{ asset('/plugins/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- Ionicons -->
    <link href="{{ asset('/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="{{ asset('/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <!--link href="{{ asset('/dist/css/skins/skin-blue.min.css') }}" rel="stylesheet" type="text/css"/-->

    <link href="{{ asset('/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css">

    <!-- DATA TABLES -->
    <link href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Date Picker -->
    <!--link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Time Picker -->
    <!--link href="{{ asset('/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css"/>


    <!-- DateTime Picker -->
    <link href="{{ asset('/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link href="{{ asset('/css/fonts/fonts.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('/css/ems-custom.css') }}" rel="stylesheet" type="text/css"/>

    <!-- JQuery UI 1.11.4 -->
    <link href="{{ asset('/plugins/jquery-ui-1.11.4/jquery-ui.min.css') }}" rel="stylesheet" type="text/css"/>
    <!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script-->
    <!-- jQuery 2.1.3 -->
    <script src="{{ asset('/js/jquery-2.1.3.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('/plugins/jquery-ui-1.11.4/jquery-ui.min.js') }}"></script>


</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|---------------------------------------------------------|

-->
<body class="skin-blue">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">{!! App\GeneralSettings::options('options', 'site_name') !!}</a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>



            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">


                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/auth/login') }}">Login</a></li>
                        <li><a href="{{ url('/auth/register') }}">Register</a></li>
                    @else
                        @if(\App\User::find(Auth::user()->id)->roles->first()->slug == 'dataentry')
                            <li class="dropdown messages-menu pull-left">
                                <a style="padding: 5px; margin:0px;"><span class="hidden-xs"><h4>Dataentry ID: <b>{{ sprintf('%02d', Auth::user()->id )}}</b></h4></span></a>
                            </li>
                        @endif
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="/dist/img/avatar5.png" class="user-image" alt="User Image"/>
                                <span class="hidden-xs">{{ Auth::user()->name }}</span> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="/dist/img/avatar5.png" class="img-circle" alt="User Image"/>

                                    <p>
                                        {{ Auth::user()->name }}
                                        - {{ \App\User::find(Auth::user()->id)->roles->first()->name }}
                                        <small>Member since {{ \App\User::find(Auth::user()->id)->created_at }}</small>
                                    </p>
                                </li>
                                <li class="user-body">
                                    <div class="text-center">
                                        @if(\App\User::find(Auth::user()->id)->roles->first()->slug == 'dataentry')
                                        <p>Dataentry ID: {{ sprintf('%02d', Auth::user()->id )}}</p>
                                        @endif
                                    </div>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a class="btn btn-default btn-flat" href="{{ url('/auth/logout') }}">Logout</a>
                                    </div>
                                @role('admin')
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-flat" href="{{ url('/settings') }}">General Settings</a>
                                     </div>
                                @endrole
                                </li>
                            </ul>
                        </li>
                    @endif

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/dist/img/avatar5.png" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- search form (Optional) -->
            <!--form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form-->
            <!-- /.search form -->

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">HEADER</li>
                <!-- Optionally, you can add icons to the links -->
                <li class="active"><a href="/home"><i class="fa fa-home"></i><span>Home</span></a></li>

                <li class="treeview">
                    <a href="#"><i class="fa fa-edit"></i><span>Forms</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="/forms">Form List</a></li>
                        @permission('create.form')
                        <li><a href="/forms/create">Create New Form</a></li>
                        @endpermission
                    </ul>
                </li>
                @permission('add.data')
                <li class="treeview">
                    <a href="#"><i class="fa fa-street-view"></i><span>Locations</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="/locations">Locations List</a></li>
                        @role('admin|staff')
                        <li><a href="/locations/create">Add New Location</a></li>
                        @endrole
                    </ul>
                </li>
                @endpermission
                @role('admin|staff')
                <li class="treeview">
                    <a href="#"><i class="fa fa-group"></i><span>Participants</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="/participants">Participants List</a></li>
                        <li><a href="/participants/create">Add New Participant</a></li>
                        <li><a href="/participants/group">Participants Group</a></li>
                    </ul>
                </li>
                @endrole
                <li class="treeview">
                    <a href="#"><i class="fa fa-user"></i><span>Users</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="/users">Users List</a></li>
                        @permission('add.users')
                        <li><a href="/users/create">Add New User</a></li>
                        @endpermission
                    </ul>
                </li>
                @permission('view.table')
                <li class="treeview">
                    <a href="#"><i class="fa fa-bar-chart"></i><span>Results</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @foreach(\App\EmsForm::all() as $form)
                        <li><a href="/{{ urlencode($form->name)}}/dataentry">{{ $form->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @endpermission
                @role('admin')
                <li><a href="/languages"><i class="fa fa-language"></i><span>Languages</span></a></li>
                @endrole
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>


    <!-- yield page content -->
    @yield('content')

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.
    </footer>

</div>
<!-- ./wrapper -->


    <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <span id="sub"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <!--button type="button" class="btn btn-primary">Save changes</button-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<!-- REQUIRED JS SCRIPTS -->

<script type="text/javascript">

</script>
<!--script src="{{ asset('/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script-->
<script src="{{ asset('/plugins/jquery-validation/jquery.validate.js') }}" type="text/javascript"></script>


<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{ asset('/plugins/fastclick/fastclick.min.js') }}"></script>
<!-- Date Picker -->
<!--script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Time Picker -->
<!--script src="{{ asset('/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<!-- Bootstrap DateTime Picker -->
<script src="{{ asset('/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    if (typeof startDate === 'undefined') {
        var startDate = new Date();
    }
    $(".date-picker").datetimepicker({initialDate: startDate, startView:'month', format: 'dd-mm-yyyy', autoclose: true, forceParse: true, minView:'month', maxView:'month'});
    $(".month-picker").datetimepicker({startView:'year', format: 'yyyy', autoclose: true, forceParse: true, minView:'year', maxView:'year'});
    $(".year-picker").datetimepicker({startView:'decade', format: 'yyyy', autoclose: true, forceParse: true, minView:'decade', maxView:'decade'});
    $(".time-picker").datetimepicker({initialDate: startDate, startDate: startDate, startView:'hour', format: 'hh:ii', autoclose: true,forceParse: true, minuteStep:1, minView:'hour', maxView:'hour'});
    $(".dobdatepicker").datetimepicker({format: 'dd-mm-yyyy'});

</script>
<!--script type="text/javascript">


    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
    $('.dobdatepicker').datepicker({
        format: 'dd-mm-yyyy'
    });
    $('.year-picker').datepicker({
        format: 'yyyy',
        startView: 2,
        minViewMode: 2
        //defaultViewDate: year
    });
    $('.month-picker').datepicker({
        format: 'mm',
        startView: 1,
        minViewMode: 1
        //defaultViewDate: year
    });
    $('.date-picker').datepicker({
        format: 'dd-mm-yyyy'
    });
    $('.time-picker').timepicker({
        showMeridian: false,
        showInputs: false,
        disableFocus: true
    });
    jQuery.noConflict();
    (function( $ ) {
        $(document).ready(function ($) {
            $('#popupModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var info = button.data('mainquestion') // Extract info from data-* attributes
                var question = button.data('subquestion')
                var answers = button.data('answers')
                var answersonly = button.data('answersonly')
                var notes = button.data('notes')
                var notequestion = button.data('notequestion')
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)

                if (typeof question !== 'undefined') {
                    modal.find('.modal-title').text(info)
                    modal.find('.modal-body span').html(question)
                    modal.find('.modal-body span').append("&nbsp;" + answers)
                }else if(typeof notes !== 'undefined'){
                    modal.find('.modal-title').text(notequestion)
                    modal.find('.modal-body span').html("&nbsp;" + notes)
                }else{
                    modal.find('.modal-title').text(info)
                    modal.find('.modal-body span').html("&nbsp;" + answersonly)
                }
            })
            $('#datatable-allfeatures').dataTable({
                    "scrollX":true,
                    "aoColumnDefs": [
                        { 'bSortable': false, 'aTargets': [ 0 ] }
                    ]});
     //       $('#datatable-results').dataTable({
      //          "bPaginate": false,
      //          "bLengthChange": false,
       //         "bFilter": false,
       //         "bSort": false,
       //         "bInfo": false,
        //        "bAutoWidth": false
         //   });
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                startDate: '-3d'
            });
            $('.dobdatepicker').datepicker({
                format: 'dd-mm-yyyy'
            });
            $('.year-picker').datepicker({
                format: 'yyyy',
                startView: 2,
                minViewMode: 2
                //defaultViewDate: year
            });
            $('.month-picker').datepicker({
                format: 'mm',
                startView: 1,
                minViewMode: 1
                //defaultViewDate: year
            });
            $('.date-picker').datepicker({
                format: 'dd-mm-yyyy'
            });
            $('.time-picker').timepicker({
                showMeridian: false,
                showInputs: false,
                disableFocus: true
            });
            // http://www.sanwebe.com/2014/01/how-to-select-all-deselect-checkboxes-jquery
            $('#cb').click(function(event) {  //on click
                if(this.checked) { // check select status
                    $('.cb').each(function() { //loop through each checkbox
                        this.checked = true;  //select all checkboxes with class "checkbox1"
                    });
                }else{
                    $('.cb').each(function() { //loop through each checkbox
                        this.checked = false; //deselect all checkboxes with class "checkbox1"
                    });
                }
            });

        });
    })(jQuery);
</script-->





<script src="{{ asset('/plugins/Garlic/garlic.min.js') }}" type="text/javascript"></script>


<!-- AdminLTE App -->
<script src="{{ asset('/dist/js/app.js') }}" type="text/javascript"></script>
<!--script src="{{ asset('/dist/js/demo.js') }}" type="text/javascript"></script-->



<script src="{{ asset('/js/ems-custom.js') }}" type="text/javascript"></script>

<script src="{{ asset('/js/jquery-2.1.3.min.js') }}"></script>
<script src="{{ asset('/js/jquery-migrate-1.2.1.js') }}" type="text/javascript"></script>
<!-- InputMask -->
<script src="{{ asset('/plugins/input-mask/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>
<!--script src="{{ asset('/plugins/input-mask/jquery.inputmask.date.extensions.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/input-mask/jquery.inputmask.extensions.js') }}" type="text/javascript"></script-->

<script type="text/javascript">
    var dom = {};
    dom.query = jQuery.noConflict( true );
    dom.query(document).ready(function($){
        $("[data-mask]").inputmask();
        $("#email").inputmask({ alias: "email"});
        $( ".year-picker" ).inputmask("y");
        $( ".time-picker" ).inputmask("h:s");
        $( ".date-picker" ).inputmask("d-m-y");
        $( "#enu_form_id" ).inputmask({ "mask": "9", "repeat": 7 });
        $( "#interviewer_id" ).inputmask({ "mask": "9", "repeat": 6 });
    });
</script>

</body>
</html>