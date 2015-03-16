@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>User List <a class='btn btn-primary pull-right' href={{ url("/users/create" ) }}>Add New User</a></h1></div>
				<div class="panel-body">
					<section>
						@if (count($errors) > 0)
							<div class="alert alert-danger">
								<strong>Whoops!</strong> There were some problems with your input.<br><br>
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

							@if (Session::has('flash_message'))
								<div class="alert alert-success">{{ Session::get('flash_message') }}</div>
							@endif
							@if (Session::has('user_delete_error'))
								<div class="alert alert-danger">{{ Session::get('user_delete_error') }}</div>
							@endif

						{!! Form::open(['url' => 'roles']) !!}
							@role('admin')
							{!! Form::select('user_role', ['1' => 'Admin', '2' => 'Office Staff', '3' => 'Data Entry', '4' => 'Analyst' ], ['class' => 'form-control']) !!}
							@endrole
							@role('staff')
							{!! Form::select('user_role', ['2' => 'Office Staff', '3' => 'Data Entry', '4' => 'Analyst' ], ['class' => 'form-control']) !!}
							@endrole
							{!! Form::submit( 'Change Role') !!}
							<table class="table">
							<thead>
								<th>{!! Form::input('checkbox', 'userrole', null) !!}</th>
								<th>No.</th>
								<th>Name</th>
								<th>Email</th>
								<th>User Role</th>
								<th>Gender</th>
								<th>Date of Birth</th>
								<th>View</th>
								<th>Action</th>
							</thead>
							<tbody>
							@role('admin')
								@foreach ($users as $k => $user)
									<tr>
										<td>{!! Form::input('checkbox', 'userid-'.$user->id , $user->id) !!}</td>
										<td>{{ (($users->currentPage() * $users->perPage()) - $users->perPage() ) + $k + 1 }}</td>
										<td>{{ $user->name }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ $user->roles->toArray()[0]['name'] }}</td>
										<td>{{ $user->user_gender }}</td>
										<td>{{ $user->dob }}</td>
										<td><a href={{ url("/users/".$user->id."/edit" ) }}>Edit</a></td>
										<td><a href={{ url("/users/".$user->id."/delete")}}>Delete</a></td>
									</tr>
								@endforeach
							@endrole
							</tbody>
						</table>
							{!! Form::close() !!}
					</section>
				</div>
			</div>
		</div>
	</div>
</div>	
@stop
