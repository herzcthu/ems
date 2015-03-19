@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>Question List</h1></div>
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
						{!! Form::open(['url' => 'forms', 'class' => 'form-horizontal']) !!}

						{!! Form::close() !!}
						<table class="table">
							<thead>

							<th>No.</th>
							<th>Question</th>
							@permission('edit.form')
							<th>Edit</th>
							<th>Delete</th>
							@endpermission
							</thead>
							<tbody>
							@role('admin')
							@foreach ($questions as $k => $question )
								@if( $question->q_type == 'single' )
									<tr>
										<td>{{ ( ( $questions->currentPage() * $questions->perPage()) - $questions->perPage() ) + $k + 1 }}</td>
											<td>{{ $question->question }}
											<div class="col-xs-offset-1">
													@if($question->input_type == 'radio')
														@foreach($question->answers as $answer_k => $answer_v)
															@if(!empty($answer_v))
															{!! Form::radio($question->id.'-'.$answer_k,$answer_k ) !!} {{ $answer_v }}
															@endif
														@endforeach
																<!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
													@endif
													@if($question->input_type == 'choice')
														@foreach($question->answers as $answer_k => $answer_v)
															@if(!empty($answer_v))
															{!! Form::checkbox($question->id.'-'.$answer_k, $answer_k,false) !!} {{ $answer_v }}
															@endif
														@endforeach
													@endif
													@if($question->input_type == 'select')
														<div class="">
															{!! Form::select($question->id,array_filter($question->answers), ['class' => 'form-control']) !!}
														</div>
													@endif
													@if($question->input_type == 'text')
														<div class="">
															{!! Form::text($question->id,null, ['class' => 'form-control']) !!}
														</div>
													@endif
													@if($question->input_type == 'textarea')
														<div class="">
															{!! Form::textarea($question->id,null, ['class' => 'form-control']) !!}
														</div>
													@endif
											</div>
											</td>
										@permission('edit.form')
										<td><a href={{ url("/forms/question/".$question->id ) }}>Edit</a></td>
										<td><a href={{ url("/forms/question/".$question->id."/delete" ) }}>Delete</a></td>
										@endpermission
									</tr>

								@elseif( $question->q_type == 'main' )
									<tr>
										<td>{{ ( ( $questions->currentPage() * $questions->perPage()) - $questions->perPage() ) + $k + 1 }}</td>
										<td>{{ $question->question }}
											<div class="col-md-offset-1">
												@foreach($question->get_children as $children)
													<p>{{ $children->question }}
													<a href={{ url("/forms/question/".$children->id ) }}>Edit</a>
													<a href={{ url("/forms/question/".$children->id."/delete" ) }}>Delete</a>
													</p>

															@if($children->input_type == 'radio')
																<div class="">
																	@foreach($children->answers as $answer_k => $answer_v)
																		@if(!empty($answer_v))
																		{!! Form::radio($children->id.'-'.$answer_k, $answer_k ) !!} {{ $answer_v }}
																		@endif
																	@endforeach
																</div>			<!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
															@endif
															@if($children->input_type == 'choice')
																<div class="">
																	@foreach($children->answers as $answer_k => $answer_v)
																		@if(!empty($answer_v))
																		{!! Form::checkbox($children->id.'-'.$answer_k, $answer_k,false) !!} {{ $answer_v }}
																		@endif
																	@endforeach
																</div>
															@endif
															@if($children->input_type == 'select')
																<div class="">
																	{!! Form::select($children->id,array_filter($children->answers), true, ['class' => 'form-control']) !!}
																</div>
															@endif
															@if($children->input_type == 'text')
																<div class="">
																	{!! Form::text($children->id,null, ['class' => 'form-control']) !!}
																</div>
															@endif
															@if($children->input_type == 'textarea')
																<div class="">
																	{!! Form::textarea($children->id,null, ['class' => 'form-control']) !!}
																</div>
															@endif

												@endforeach

											</div>
										</td>
										@permission('edit.form')
										<td><a href={{ url("/forms/question/".$question->id ) }}>Edit</a></td>
										<td><a href={{ url("/forms/question/".$question->id."/delete" ) }}>Delete</a></td>
										@endpermission
									</tr>

								@elseif( $question->q_type == 'sub' )
								@endif


							@endforeach

							@endrole
							</tbody>
						</table>
				</div>
			</div>
		</div>
	</div>
</div>	
@stop
