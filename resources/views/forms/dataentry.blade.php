@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>Add New Data</h1></div>
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
						@if (Session::has('answer_success'))
							<div class="alert alert-success">{{ Session::get('answer_success') }}</div>
						@endif
						{!! Form::open(['url' => 'forms/'.$form_name_url.'/dataentry', 'class' => 'form-horizontal']) !!}

						<div class="form-group col-md-12">
							{!! Form::label('enu_id', 'Enumerator: ', ['class' => 'control-label']) !!}
							{!! Form::select('enu_id', $enumerators, ['class' => 'col-md-2 form-control']) !!}
						</div>

							@foreach($questions as $k => $question)

								@if($question->q_type == 'single')

									<div class="form-group col-md-12">

										<h4>{{ $k + 1 }}. {{ $question->question_number }}. {{ $question->question }}</h4>
										<div class="">
													@if($question->input_type == 'radio')
														@foreach($question->answers as $answer_k => $answer_v)
														@if(!empty($answer_v))
															{!! Form::radio("answers[$question->id][answer]",$answer_k ) !!} {{ $answer_v }}
														@endif
														@endforeach
													<!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
													@endif
													@if($question->input_type == 'choice')
														@foreach($question->answers as $answer_k => $answer_v)
															@if(!empty($answer_v))
															{!! Form::checkbox("answers[$question->id][answer]", $answer_k,false) !!} {{ $answer_v }}
															@endif
														@endforeach
													@endif
													@if($question->input_type == 'select')
														<div class="">
															{!! Form::select("answers[$question->id][answer]",array_filter($question->answers), ['class' => 'form-control']) !!}
														</div>
													@endif
													@if($question->input_type == 'text')
														<div class="">
															{!! Form::text("answers[$question->id][answer]",null, ['class' => 'form-control']) !!}
														</div>
													@endif
													@if($question->input_type == 'textarea')
														<div class="">
															{!! Form::textarea("answers[$question->id][answer]",null, ['class' => 'form-control']) !!}
														</div>
													@endif
										</div>
									</div>

								@endif


								@if($question->q_type == 'main')
										<div class="form-group col-md-12">

											<h4>{{ $k + 1 }}. {{ $question->question }}</h4>
											@foreach($question->get_children as $children)
											<div class="col-xs-offset-1">
													@if($children->input_type == 'radio')

														<h4>{{ $children->question }}</h4>
														<div class="">
														@foreach($children->answers as $answer_k => $answer_v)
															@if(!empty($answer_v))
															{!! Form::radio("answers[$children->id][answer]", $answer_k ) !!} {{ $answer_v }}
															@endif
														@endforeach
														</div>			<!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
													@endif
													@if($children->input_type == 'choice')

														<h4>{{ $children->question }}</h4>
														<div class="">
														@foreach($children->answers as $answer_k => $answer_v)
															@if(!empty($answer_v))
															{!! Form::checkbox("answers[$children->id][answer]", $answer_k,false) !!} {{ $answer_v }}
															@endif
														@endforeach
														</div>
													@endif
													@if($children->input_type == 'select')
														<h4>{{ $children->question }}</h4>
														<div class="">
															{!! Form::select("answers[$children->id][answer]",array_filter($children->answers), ['class' => 'form-control']) !!}
														</div>
													@endif
													@if($children->input_type == 'text')
														<h4>{{ $children->question }}</h4>
														<div class="">
															{!! Form::text("answers[$children->id][answer]",null, ['class' => 'form-control']) !!}
														</div>
													@endif
													@if($children->input_type == 'textarea')
														<h4>{{ $children->question }}</h4>
														<div class="">
															{!! Form::textarea("answers[$children->id][answer]",null, ['class' => 'form-control']) !!}
														</div>
													@endif
											</div>
											@endforeach
										</div>
								@endif
							@endforeach

						<div class="form-group">
							<div class="col-md-2">
								{!! Form::hidden('form_id', $form_id, ['class' => 'form-control']) !!}
								{!! Form::submit( 'Add Data', ['class' => 'btn btn-primary form-control']) !!}
							</div>
						</div>

						{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>	
@stop
