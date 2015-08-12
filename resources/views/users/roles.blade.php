@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>User Roles</h1></div>
				<div class="panel-body">
					<section>
						<table class="table">
							<thead>
								<th>No.</th>
								<th>Role</th>
								<th>slug</th>
								<th>Level</th>
								<th>Action</th>
							</thead>
							<tbody>
							@role('admin')  
								@foreach ($roles as $role)
									<tr>
										<td>{{ $role->id }}</td>
										<td>{{ $role->name }}</td>
										<td>{{ $role->slug }}</td>
										<td>{{ $role->level }}</td>
										<td><a href={{ url("/users/show/".$role->id ) }}>Edit Role</a></td>
									</tr>
								@endforeach
							@endrole
							</tbody>
						</table>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>	
@stop
