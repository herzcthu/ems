@extends('adminlte')

@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Participant Profile
				<small>{{ $participants->name }}</small>
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
							<h3 class="box-title">{{ $participants->name }} profile</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<table class="table table-user-information">
								<tbody>
								<tr>
									<td>Username:</td>
									<td>{{ $participants->name }} ({{ ucwords($participants->participant_type) }})</td>
								</tr>
								<tr>
									<td>Location Assigned:</td>
									<td>{{ $location }}</td>
								</tr>
								<tr>
									<td>Email Address:</td>
									<td><a href="mailto:{{ $participants->email }}">{{ $participants->email }}</a></td>
								</tr>
								<tr>
									<td>Date of Birth</td>
									<td>{{ $participants->dob }}</td>
								</tr>

								<tr>
								<tr>
									<td>Gender</td>
									<td>@if($participants->user_gender == 'Male')
											 Male
										@elseif($participants->user_gender == 'Female')
											 Female
										@else
											 Unspecified
										@endif
									</td>
								</tr>
								<tr>
									<td>Home Address</td>
									<td>{{ $participants->user_mailing_address }}</td>
								</tr>
								<tr>
								<td>Phone Number</td>
								<td>{!! isset($participants->user_line_phone)? $participants->user_line_phone.' (Landline)<br><br>':'' !!}{{ $participants->user_mobile_phone }} (Mobile)
								</td>

								</tr>
								<tr>
									<td>Current Organization</td>
									<td>{{ $participants->current_org }}</td>
								</tr>
								<tr>
									<td>Education</td>
									<td>{{ ucwords($participants->education_level) }}</td>
								</tr>
								<tr>
									<td>Ethnicity</td>
									<td>{{ $participants->ethnicity }}</td>
								</tr>
								<tr>
									<td>User Biography</td>
									<td>{{ $participants->user_biography }}</td>
								</tr>
								@if($participants->participant_type == 'coordinator')
								<tr>
									<td>Enumerators under management:</td>
									<td>
										<ul>
										@foreach( $participants->get_children as $enumerator )
											<li>
												{{ $enumerator->name }}
											</li>
										@endforeach
										</ul>
									</td>
								</tr>
								@else
									<tr>
										<td>Coordinator:</td>
										<td>
											{{ $participants->get_parent->name }}
										</td>
									</tr>

								@endif

								</tbody>
							</table>
					<div><a class="btn btn-primary" href={{ url("/participants/".$participants->id. "/edit" ) }}>Edit</a>
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