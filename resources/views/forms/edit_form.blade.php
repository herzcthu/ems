@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>Edit Question</h1></div>
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
						@if (Session::has('form_build_success'))
							<div class="alert alert-success">{{ Session::get('form_build_success') }}</div>
						@endif
						{!! Form::model($form, ['method' => 'PATCH', 'action' => ['EmsFormsController@edit', $form->id], 'class' => 'form-horizontal']) !!}
						@include('forms._form', ['submitButton' => 'Update', 'formtype' => 'create'])
						{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>	
@stop
