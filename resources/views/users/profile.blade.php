@extends('adminlte')

@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				User Profile
				<small>{{ $user->name }}</small>
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
							<h3 class="box-title">{{ $user->name }} profile</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
					<div>{{ $user->name }}</div>
					<div>{{ $user->email }}</div>
					<div>{{ $user->user_gender }}</div>
					<div>{{ $user->user_line_phone }}</div>
					<div>{{ $user->user_mobile_phone }}</div>
					<div>{{ $user->user_mailing_address }}</div>
					<div>{{ $user->user_biography }}</div>
					<div><a class="btn btn-primary" href={{ url("/users/".$user->id. "/edit" ) }}>Edit</a>
					</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
				</div>
			</div>
				<!-- /.row -->
		</section>
		<!-- /.content -->
	</div><!-- /.content-wrapper -->


@endsection