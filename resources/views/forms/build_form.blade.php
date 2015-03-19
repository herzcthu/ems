@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>Build Form</h1></div>
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
						{!! Form::open(['url' => 'forms/build', 'class' => 'form-horizontal']) !!}
						<div class="form-group">
							{!! Form::label('form_id', 'Form Name: ', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::select('form_id',$forms, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('question', 'Question: ', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::textarea('question', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('q_type', 'Question Type: ', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::radio('q_type','single',true) !!} Single
								{!! Form::radio('q_type','main') !!} Main
								{!! Form::radio('q_type','sub') !!} Sub Question
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('main_id', 'Main Question: ', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::select('main_id',$questions, ['class' => 'form-control']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('input_type', 'Input Type: ', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::select('input_type', ['none' => 'None', 'radio' => 'Radio', 'choice' => 'Choice', 'select' => 'Select', 'text' => 'Text', 'textarea' => 'Textarea'], ['class' => 'form-control']) !!}
							</div>
						</div>
						@for($i=1; $i <= 5; $i++)
						<div class="form-group">
							{!! Form::label('answers['.$i.']', 'Answer '.$i.': ', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('answers['.$i.']', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						@endfor
						<div class="form-group">
							<div class="col-sm-2 col-md-offset-4">
								{!! Form::submit( 'Create', ['class' => 'btn btn-primary form-control']) !!}
							</div>
						</div>
						{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>	
@stop
