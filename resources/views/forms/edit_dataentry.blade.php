@extends('adminlte')

@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Data Entry
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
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Add New Data</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
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
						@if (Session::has('answer_success'))
							<div class="alert alert-success">{{ Session::get('answer_success') }}</div>
						@endif
						{!! Form::model($dataentry, ['method' => 'PATCH', 'action' => ['EmsFormsController@dataentry_update', $form_name_url, $interviewee], 'class' => 'form-horizontal']) !!}
						@include('forms._dedit', ['submitButton' => 'Add Data', 'formtype' => 'create'])
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