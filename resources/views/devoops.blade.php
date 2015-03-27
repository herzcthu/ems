<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>{!! App\GeneralSettings::options('options', 'site_name') !!}</title>
		<meta name="description" content="{!! App\GeneralSettings::options('options', 'site_descriptions') !!}">
		<meta name="author" content="Kanaung">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="{{ asset('/plugins/bootstrap/bootstrap.css') }}" rel="stylesheet">
		<link href="{{ asset('/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
		<link href="{{ asset('/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
		<link href="{{ asset('/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
		<link href="{{ asset('/plugins/xcharts/xcharts.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/plugins/select2/select2.css') }}" rel="stylesheet">
		<link href="{{ asset('/plugins/justified-gallery/justifiedGallery.css') }}" rel="stylesheet">
		<link href="{{ asset('/css/style_v1.css') }}" rel="stylesheet">
		<link href="{{ asset('/plugins/chartist/chartist.min.css') }}" rel="stylesheet">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
				<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
				<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
<body>
<noscript>This page require to enable Javascript.</noscript>
<div id="no-js" style="display:none !important;">
<!--Start Header-->
<div id="screensaver">
	<canvas id="canvas"></canvas>
	<i class="fa fa-lock" id="screen_unlock"></i>
</div>
<div id="modalbox">
	<div class="devoops-modal">
		<div class="devoops-modal-header">
			<div class="modal-header-name">
				<span>Basic table</span>
			</div>
			<div class="box-icons">
				<a class="close-link">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
		<div class="devoops-modal-inner">
		</div>
		<div class="devoops-modal-bottom">
		</div>
	</div>
</div>
<header class="navbar">
	<div class="container-fluid expanded-panel">
		<div class="row">
			<div id="logo" class="col-xs-12 col-sm-2">
				<a href="/">{!! App\GeneralSettings::options('options', 'site_name') !!}</a>
			</div>
			<div id="top-panel" class="col-xs-12 col-sm-10">
				<div class="row">
					<div class="col-xs-8 col-sm-4">
						<div id="search">
							<input type="text" placeholder="search"/>
							<i class="fa fa-search"></i>
						</div>
					</div>
					<div class="col-xs-4 col-sm-8 top-panel-right">
						<a href="#" class="about">about</a>
						<a href="/" class="style2"></a>
						@if (Auth::guest())
							<li><a href="{{ url('/auth/login') }}">Login</a></li>
							<li><a href="{{ url('/auth/register') }}">Register</a></li>
						@else
						<ul class="nav navbar-nav pull-right panel-menu">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle account" data-toggle="dropdown">
									<div class="avatar">
										<img src="{{ asset('/img/avatar.jpg') }}" class="img-circle" alt="avatar" />
									</div>
									<i class="fa fa-angle-down pull-right"></i>
									<div class="user-mini pull-right">
										<span class="welcome">Welcome,</span>
										<span>{{ Auth::user()->name }}</span>
									</div>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="users/{{ Auth::user()->id }}" class="ajax-link">
											<i class="fa fa-user"></i>
											<span>Profile</span>
										</a>
									</li>
									@role('admin')
									<li>
										<a href="settings" class="ajax-link">
											<i class="fa fa-cog"></i>
											<span>Settings</span>
										</a>
									</li>
									@endrole
									<li>
										<a href="{{ url('/auth/logout') }}">
											<i class="fa fa-power-off"></i>
											<span>Logout</span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!--End Header-->
<!--Start Container-->
<div id="main" class="container-fluid">
	<div class="row">
		<div id="sidebar-left" class="col-xs-2 col-sm-2">
			<ul class="nav main-menu">
				<li>
					<a href="/home" class="ajax-link">
						<i class="fa fa-dashboard"></i>
						<span class="hidden-xs">Dashboard</span>
					</a>
				</li>

				<li class="dropdown">
					<a href="/forms" class="dropdown-toggle">
						<i class="fa fa-pencil-square-o"></i>
						 <span class="hidden-xs">Forms</span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="/forms" class="ajax-link">Forms List</a></li>
						<li><a href="#">First level menu</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-plus-square"></i>
								<span class="hidden-xs">Second level menu group</span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">Second level menu</a></li>
								<li><a href="#">Second level menu</a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle">
										<i class="fa fa-plus-square"></i>
										<span class="hidden-xs">Three level menu group</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="/locations" class="dropdown-toggle">
						<i class="fa fa-pencil-square-o"></i>
							<span class="hidden-xs">Locations</span>

					</a>
					<ul class="dropdown-menu">
						<li><a href="/locations" class="ajax-link">Locations List</a></li>
						<li><a href="#">First level menu</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<!--Start Content-->
		<div id="content" class="col-xs-12 col-sm-10">
			<div id="about">
				<div class="about-inner">
					<h4 class="page-header">{!! App\GeneralSettings::options('options', 'site_name') !!}</h4>
					<p>{!! App\GeneralSettings::options('options', 'site_descriptions') !!}</p>
					<p>Homepage - <a href="http://github.org/kanaung/ems" target="_blank">EMS</a></p>
					<p>Email - <a href="mailto:sithu@thwin.net">sithu@thwin.net</a></p>
				</div>
			</div>
			<div>
			@yield('content')
			</div>
			<div class="preloader">
				<img src="{{ asset('/img/devoops_getdata.gif') }}" class="devoops-getdata" alt="preloader"/>

			</div>

			<div id="ajax-content"></div>

		</div>
		<!--End Content-->
	</div>
</div>
<!--End Container-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="http://code.jquery.com/jquery.js"></script>-->
<script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('/plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('/plugins/justified-gallery/jquery.justifiedGallery.min.js') }}"></script>
<script src="{{ asset('/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('/plugins/tinymce/jquery.tinymce.min.js') }}"></script>
<!-- All functions for this theme + document.ready processing -->
<script src="{{ asset('/js/devoops.js') }}"></script>
</div>
</body>
</html>
