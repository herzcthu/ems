@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>General Settings</h1></div>
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

							{!! Form::model($options, ["method" => "PATCH", "action" => ["GeneralSettingsController@update"], "class" => "form-horizontal"]) !!}

							<div class="form-group">
								{!! Form::label("options['site_name']", "Site Name: ", ["class" => "col-md-4 control-label"]) !!}
								<div class="col-md-6">
									{!! Form::text("options[site_name]", isset($options[0]) ? $options[0]['options']['site_name']: null, ["class" => "form-control"]) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label("options[site_descriptions]", "Site Descriptions: ", ["class" => "col-md-4 control-label"]) !!}
								<div class="col-md-6">
									{!! Form::text("options[site_descriptions]", isset($options[0]) ? $options[0]['options']['site_descriptions']: null, ["class" => "form-control"]) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label("options[answers_per_question]", "Nos. of answers per question: ", ["class" => "col-md-4 control-label"]) !!}
								<div class="col-md-6">
									{!! Form::text("options[answers_per_question]", isset($options[0]) ? $options[0]['options']['answers_per_question']:null, ["class" => "form-control"]) !!}
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									{!! Form::submit( "Update Settings", ["class" => "btn btn-primary form-control"]) !!}
								</div>
							</div>
							{!! Form::close() !!}
					</section>
				</div>
			</div>
		</div>
	</div>
</div>	
@stop
