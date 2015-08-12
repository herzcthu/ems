<table class="table">

    <tr>
        <td colspan="2">
            {!! Form::label('enu_id', 'Enumerator: ', ['class' => 'control-label']) !!}
        </td>
        <td colspan="4" class="pull-left">
            <div class="col-xs-12">
                {!! Form::select('enu_id', isset($enumerators) ? $enumerators:['none' => 'None'], ['class' => 'form-control']) !!}
            </div>
        </td>

        <td colspan="2">
            {!! Form::label('interviewee_id', $form_name.' ID: ', ['class' => 'control-label pull-left']) !!}
        </td>
        <td colspan="4" class="pull-left">
            <div class="col-xs-12">
               <!-- {!! Form::select('interviewee_id',array_combine(range(1,9), range(1,9)), ['class' => 'form-control']) !!} -->
                {!! Form::text('interviewee_id',null, ['class' => 'form-control']) !!}
            </div>
        </td>
    </tr>
    <tr>

        <td colspan="2">
            {!! Form::label('interviewee_gender', 'Interviewee Gender', ['class' => 'control-label pull-left']) !!}
        </td>
        <td colspan="4" class="pull-left">
            <div class="col-xs-12">
                {!! Form::select('interviewee_gender',['M' => 'Male', 'F' => 'Female', 'U' => 'Unspecified'], ['class' => 'form-control']) !!}
            </div>
        </td>
        <td colspan="2">
            {!! Form::label('interviewee_age', 'Interviewee Age', ['class' => 'control-label pull-left']) !!}
        </td>
        <td colspan="4" class="pull-left">
            <div class="col-xs-12">
                {!! Form::select('interviewee_age',array_combine(range(16,90), range(16,90)), ['class' => 'form-control']) !!}
            </div>
        </td>
    </tr>

    @foreach($questions as $k => $question)
        <tr>


            @if($question->q_type == 'single')



                <td><h4>{{ $question->question_number }}</h4></td>
                <td colspan="7">
                    <h4>{{ $question->question }}</h4>
                    <div class="col-xs-offset-1">
                        @if($question->input_type == 'radio')
                            <ul class="radio">
                                @foreach($question->answers as $answer_k => $answer_v)
                                    @if(!empty($answer_v))
                                        <li>
                                            {!! Form::radio("answers[$question->id][answer]",$answer_k,null ) !!} {{ $answer_v }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>             <!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
                        @endif
                        @if($question->input_type == 'choice')
                            @foreach($question->answers as $answer_k => $answer_v)
                                @if(!empty($answer_v))
                                    {!! Form::checkbox("answers[$question->id][answer]", $answer_k, null) !!} {{ $answer_v }}
                                @endif
                            @endforeach
                        @endif
                        @if($question->input_type == 'select')
                            <div class="">
                                {!! Form::select("answers[$question->id][answer]",array_filter($question->answers), null, ['class' => 'form-control']) !!}
                            </div>
                        @endif
                        @if($question->input_type == 'text')
                            <div class="">
                                {!! Form::text("answers[$question->id][answer]", null, ['class' => 'form-control']) !!}
                            </div>
                        @endif
                        @if($question->input_type == 'textarea')
                            <div class="">
                                {!! Form::textarea("answers[$question->id][answer]", null, ['class' => 'form-control']) !!}
                            </div>
                        @endif
                    </div>

                </td>
            @endif


            @if($question->q_type == 'main')

                <td><h4>{{ $question->question_number }}</h4></td>
                <td colspan="7">
                    <h4>{{ $question->question }}</h4>
                    @if($question->a_view == 'validated-table')
                        <table id="validated-table" class="table">
                            <thead>
                            <th> Test </th>
                            @if(is_array($question->answers) && $question->input_type == 'same')
                                @foreach($question->get_children as $children)
                                    <th>{{ $children->question_number }}. {{ $children->question }}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach($question->answers as $answer_k => $answer_v)
                                    <tr>test
                                        <td>{{ $answer_v }}</td>
                                        @foreach($question->get_children as $children)

                                            @if(!empty($answer_v))
                                                <td>
                                                    {!! Form::radio("answers[$children->id][answer]",$answer_k ,null ) !!}
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                            @endif
                        </table>
                        <script type="text/javascript">
                            $('tr').hover(function () {
                                $(this).toggleClass('validate');
                            });
                            var radioButton = $("tr");
                            radioButton.mousedown(function() {
                                if($(this).hasClass('validate')){
                                    $("tr.validate").find("tr.validate input:radio:checked").prop('checked',false);
                                }
                                //return false;
                            });
                        </script>

                    @else
                        @foreach($question->get_children as $children)
                            <div class="col-xs-offset-1">
                                <h4>{{ $children->question_number }}. {{ $children->question }}</h4>
                                @if(is_array($question->answers) && $question->input_type == 'same')
                                    @if($children->input_type == 'radio')
                                        <ul class="radio">
                                            @foreach($question->answers as $answer_k => $answer_v)
                                                @if(!empty($answer_v))
                                                    <li>
                                                        {!! Form::radio("answers[$children->id][answer]",$answer_k ) !!} {{ $answer_v }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>              <!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
                                    @endif
                                    @if($children->input_type == 'choice')
                                        @foreach($question->answers as $answer_k => $answer_v)
                                            @if(!empty($answer_v))
                                                {!! Form::checkbox("answers[$children->id][answer]", $answer_k, null) !!} {{ $answer_v }}
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($children->input_type == 'select')
                                        <div class="">
                                            {!! Form::select("answers[$children->id][answer]",array_filter($question->answers), ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                    @if($children->input_type == 'text')
                                        <div class="">
                                            {!! Form::text("answers[$children->id][answer]",  ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                    @if($children->input_type == 'textarea')
                                        <div class="">
                                            {!! Form::textarea("answers[$children->id][answer]", ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                @else
                                    @if($children->input_type == 'radio')
                                        <ul class="radio">
                                            <div class="">
                                                @foreach($children->answers as $answer_k => $answer_v)
                                                    @if(!empty($answer_v))
                                                        <li>
                                                            {!! Form::radio("answers[$children->id][answer]", $answer_k ) !!} {{ $answer_v }}
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </ul>
                                        <!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
                                    @endif
                                    @if($children->input_type == 'choice')
                                        <div class="">
                                            @foreach($children->answers as $answer_k => $answer_v)
                                                @if(!empty($answer_v))
                                                    {!! Form::checkbox("answers[$children->id][answer]", $answer_k ) !!} {{ $answer_v }}
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    @if($children->input_type == 'select')
                                        <div class="">
                                            {!!
                                            Form::select("answers[$children->id][answer]",array_filter($children->answers), ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                    @if($children->input_type == 'text')
                                        <div class="">
                                            {!! Form::text("answers[$children->id][answer]",  ['class' =>
                                            'form-control']) !!}
                                        </div>
                                    @endif
                                    @if($children->input_type == 'textarea')
                                        <div class="">
                                            {!! Form::textarea("answers[$children->id][answer]",  ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endforeach

                    @endif
                </td>
            @endif

        </tr>
    @endforeach
    <tr>
        <td>
            {!! Form::hidden('form_id', $form_id, ['class' => 'form-control']) !!}
            {!! Form::submit( $submitButton, ['class' => 'btn btn-primary form-control']) !!}
        </td>
        <td></td>
    </tr>
</table>