@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>User Profile -> {{ $user->name }}</h1></div>
				<div class="panel-body">
					<div>{{ $user->name }}</div>
					<div>{{ $user->email }}</div>
					<div>{{ $user->user_gender }}</div>
					<div>{{ $user->user_line_phone }}</div>
					<div>{{ $user->user_mobile_phone }}</div>
					<div>{{ $user->user_mailing_address }}</div>
					<div>{{ $user->user_biography }}</div>
					<div><a class="btn btn-primary" href={{ url("/users/".$user->id. "/edit" ) }}>Edit</a></div>


				</div>
			</div>
		</div>
	</div>
</div>	
@stop
