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
					@if (Session::has('flash_message'))
						<div class="alert alert-success">{{ Session::get('flash_message') }}</div>
					@endif
					@if (Session::has('user_delete_error'))
						<div class="alert alert-danger">{{ Session::get('user_delete_error') }}</div>
					@endif
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">{{ $user->name }} profile</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<table class="table table-user-information">
								<tbody>
								<tr>
									<td>Username:</td>
									<td>{{ $user->name }}</td>
								</tr>
								<tr>
									<td>Email Address:</td>
									<td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
								</tr>
								<tr>
									<td>Date of Birth</td>
									<td>{{ $user->dob }}</td>
								</tr>

								<tr>
								<tr>
									<td>Gender</td>
									<td>@if($user->user_gender == 'M')
											 Male
										@elseif($user->user_gender == 'F')
											 Female
										@else
											 Unspecified
										@endif
									</td>
								</tr>
								<tr>
									<td>Home Address</td>
									<td>{{ $user->user_mailing_address }}</td>
								</tr>
								<tr>
								<td>Phone Number</td>
								<td>{{ $user->user_line_phone }}(Landline)<br><br>{{ $user->user_mobile_phone }}(Mobile)
								</td>

								</tr>
								<tr>
									<td>User Biography</td>
									<td>{{ $user->user_biography }}</td>
								</tr>

								</tbody>
							</table>
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