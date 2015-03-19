@extends('adminlte')

@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Users
				<small>Add new user</small>
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
							<h3 class="box-title">Add New User</h3>
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
						{!! Form::open(['url' => 'users', 'class' => 'form-horizontal']) !!}
						@include('users._form', ['submitButton' => 'Add User', 'formtype' => 'create'])
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