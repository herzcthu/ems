@extends('adminlte')

@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				General Settings
				<small></small>
			</h1>
			<!--ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
				<li class="active">Here</li>
			</ol-->
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
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
								{!! Form::label("options['site_name']", _t("Site Name: "), ["class" => "col-sm-3 control-label"]) !!}
								<div class="col-sm-6">
									{!! Form::text("options[site_name]", isset($options[0]) ? $options[0]['options']['site_name']: null, ["class" => "form-control"]) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label("options[site_descriptions]", _t("Site Descriptions: "), ["class" => "col-sm-3 control-label"]) !!}
								<div class="col-sm-6">
									{!! Form::text("options[site_descriptions]", isset($options[0]) ? $options[0]['options']['site_descriptions']: null, ["class" => "form-control"]) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label("options[answers_per_question]", _t("Nos. of answers per question: "), ["class" => "col-sm-3 control-label"]) !!}
								<div class="col-sm-6">
									{!! Form::text("options[answers_per_question]", isset($options[0]) ? $options[0]['options']['answers_per_question']:null, ["class" => "form-control"]) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label("options[form_for_dashboard]", _t("Select Form to show on Dashboard: "), ["class" => "col-sm-3 control-label"]) !!}
								<div class="col-sm-6">
									{!! Form::select("options[form_for_dashboard]", $forms, array_key_exists('form_form_dashboard', $options[0]['options']) ? $options[0]['options']['form_for_dashboard']:null, ["class" => "form-control"]) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label("options[locale]", _t("Select default language: "), ["class" => "col-sm-3 control-label"]) !!}
								<div class="col-sm-6">
									{!! Form::select("options[locale]", $locales,isset($options[0]) ? $options[0]['options']['locale']:null, ["class" => "form-control"]) !!}
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-2 col-sm-offset-3">
									{!! Form::submit( "Update Settings", ["class" => "btn btn-primary form-control"]) !!}
								</div>
							</div>
							{!! Form::close() !!}
				</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div><!-- /.content-wrapper -->


@endsection