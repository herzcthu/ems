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
				<div class="col-xs-12">
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
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Geolocation Table</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
							<table id="datatable-allfeatures" class="table table-bordered table-striped">
								<thead>
								<th>No.</th>
								@foreach($locale_list as $lang)
									@if($lang->code == $default_locale)
										<th>{{ $lang->name }}</th>
									@endif
									@if($lang->code == $current_locale)
										<th lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ _t($lang->name) }}</th>
									@endif
								@endforeach
								<th>Action</th>
								</thead>
								<tbody>
								<?php $i = 1; ?>

								@foreach($translation_list->all() as $translation)

									@if($translation->translation_id !== null )
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $translation->parent->translation }}<span class="alert success text-green pull-right"></span></td>
										<td lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{!! Form::text("lang_id[$translation->translation_id]", $translation->translation, ['class' => 'form-control']) !!}</td>
										<td><a href="#" class="update">Update</a></td>
									</tr>
										<?php $i++ ?>
									@endif
								@endforeach

								</tbody>
							</table>
									<script type="text/javascript">
										$.ajaxSetup({
											headers: {
												'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
											}
										});
										$('tr').hover(function () {
											$(this).toggleClass('langupdate');
											$(this).find('span').toggleClass('flash');
											$(this).find('input').toggleClass('updateinput');
											$(this).find("a").unbind('click').on('click', function(e) {
												e.preventDefault();
												$.post( "ajax/langupdate", $( ".updateinput" ).serialize() ).success(function( data ) {
													var json = JSON.parse(data);
													if(json.status == true){
														$( "span.flash" ).html( json.message );
														$( "span.flash" ).fadeIn( "slow" );

													}
													if(json.status == false){
														$( "span.flash" ).html( json.message );
														$( "span.flash" ).fadeIn( "slow" );
													}
												});
											});
										});




									</script>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
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