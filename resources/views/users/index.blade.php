@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>User List</h1></div>
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

						{!! Form::open(['url' => 'roles']) !!}
							{!! Form::select('user_role', ['1' => 'Admin', '2' => 'Office Staff', '3' => 'Data Entry', '4' => 'Analyst' ], ['class' => 'form-control']) !!}
							{!! Form::submit( 'Change Role') !!}
							<table class="table">
							<thead>
								<th>{!! Form::input('checkbox', 'userrole', null) !!}</th>
								<th>No.</th>
								<th>Name</th>
								<th>Email</th>
								<th>User Role</th>
								<th>View</th>
								<th>Action</th>
							</thead>
							<tbody>
							@role('admin')
								@foreach ($users as $k => $user)
									<tr>
										<td>{!! Form::input('checkbox', 'userid-'.$user->id , $user->id) !!}</td>
										<td>{{ $k + 1 }}</td>
										<td>{{ $user->name }}</td>
										<td>{{ $user->email }}</td>
										<td>{{{ isset($user->role) ? $user->role : 'Undefined' }}}</td>
										<td><a href={{ url("/users/".$user->id ) }}>Profile</a></td>
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
