@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>Add New User</h1></div>
				<div class="panel-body">
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
						{!! Form::open(['url' => 'users', 'class' => 'form-horizontal']) !!}
						@include('users._form', ['submitButton' => 'Add User', 'formtype' => 'create'])
						{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>	
@stop
