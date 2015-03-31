<table class="table">

    <tr>
        <td>
            {!! Form::label('interviewer_id', 'Enumerator ID: ', ['class' => 'control-label']) !!}
        </td>
        <td class="">

                {!! Form::text('interviewer_id', null, ['class' => 'form-control']) !!}

        </td>

        <td>
            {!! Form::label('interviewee_id', $form_name.' ID: ', ['class' => 'control-label']) !!}
        </td>
        <td>

               {!! Form::select('interviewee_id',array_combine(range(1,9), range(1,9)), ['class' => 'form-control']) !!}

        </td>
        <td>
            {!! Form::label('psu', 'PSU :', ['class' => 'control-label']) !!}
        </td>
        <td>

                {!! Form::select('psu',['1' => 'Urban', '2' => 'Rural'], ['class' => 'form-control']) !!}

        </td>
    </tr>
    <tr>

        <td>
            {!! Form::label('interviewee_gender', 'Interviewee Gender', ['class' => 'control-label']) !!}
        </td>
        <td>

                {!! Form::select('interviewee_gender',['M' => 'Male', 'F' => 'Female', 'U' => 'Unspecified'], ['class' => 'form-control']) !!}

        </td>
        <td>
            {!! Form::label('interviewee_age', 'Interviewee Age', ['class' => 'control-label']) !!}
        </td>
        <td>

                {!! Form::select('interviewee_age',array_combine(range(16,90), range(16,90)), ['class' => 'form-control']) !!}

        </td>
    </tr>

    @foreach($questions as $k => $question)
        <tr>


            @if($question->q_type == 'single')



                <td><h4>{{ $question->question_number }}</h4></td>
                <td colspan="7">
                    <h4>{{ $question->question }}</h4>
                    @if($question->a_view == 'notes')
                        {!! Form::text("notes[$question->id]", null, ['class' => 'form-control']) !!}
                    @endif
                    <div class="col-xs-offset-1">
                        @if($question->input_type == 'radio')
                            <ul class="radio">
                                @foreach($question->answers as $answer_k => $answer_v)
                                    @if(!empty($answer_v))
                                        <li>
                                            {!! Form::radio("answers[$question->id]",$answer_k,null ) !!} {{ $answer_v }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>             <!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
                        @endif
                        @if($question->input_type == 'choice')
                            @foreach($question->answers as $answer_k => $answer_v)
                                @if(!empty($answer_v))
                                    {!! Form::checkbox("answers[$question->id]", $answer_k, null) !!} {{ $answer_v }}
                                @endif
                            @endforeach
                        @endif
                        @if($question->input_type == 'select')
                            <div class="">
                                {!! Form::select("answers[$question->id]",array_filter($question->answers), null, ['class' => 'form-control']) !!}
                            </div>
                        @endif
                        @if($question->input_type == 'text')
                            <div class="">
                                {!! Form::text("answers[$question->id]", null, ['class' => 'form-control']) !!}
                            </div>
                        @endif
                        @if($question->input_type == 'textarea')
                            <div class="">
                                {!! Form::textarea("answers[$question->id]", null, ['class' => 'form-control']) !!}
                            </div>
                        @endif
                            @if($question->input_type == 'date' || $question->input_type == 'year' || $question->input_type == 'month' || $question->input_type == 'time')
                                <div class="bootstrap-timepicker">
                                    {!! Form::text("answers[$question->id]", null, ['class' => 'form-control '.$question->input_type.'-picker']) !!}
                                </div>
                            @endif
                    </div>

                </td>
            @endif


            @if($question->q_type == 'main')

                <td><h4>{{ $question->question_number }}</h4></td>
                <td colspan="7">
                    <h4>{{ $question->question }}</h4>
                    @if($question->a_view == 'notes')
                        {!! Form::text("notes[$question->id]", null, ['class' => 'form-control']) !!}
                    @endif
                    @if($question->a_view == 'validated-table')
                        <table id="validated-table" class="table">
                            <th> </th>
                            @if(is_array($question->answers))
                                @foreach($question->get_children as $children)
                                    <th>{{ $children->question_number }}. {{ $children->question }}</th>
                                    @if($children->a_view == 'notes')
                                        {!! Form::text("notes[$children->id]", null, ['class' => 'form-control']) !!}
                                    @endif
                                @endforeach
                                @foreach($question->answers as $answer_k => $answer_v)
                                    <tr>
                                        <td>{{ $answer_v }}</td>
                                        @foreach($question->get_children as $children)

                                            @if(!empty($answer_v))
                                                <td>
                                                    {!! Form::radio("answers[$children->id]",$answer_k ,null ) !!}
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
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
                                @if($children->a_view == 'notes')
                                    {!! Form::text("notes[$children->id]", null, ['class' => 'form-control']) !!}
                                @endif
                                @if(is_array($question->answers) && $children->q_type == 'same')
                                    @if($children->input_type == 'radio')
                                        <ul class="radio">
                                            @foreach($question->answers as $answer_k => $answer_v)
                                                @if(!empty($answer_v))
                                                    <li>
                                                        {!! Form::radio("answers[$children->id]",$answer_k ) !!} {{ $answer_v }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>              <!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
                                    @endif
                                    @if($children->input_type == 'choice')
                                        @foreach($question->answers as $answer_k => $answer_v)
                                            @if(!empty($answer_v))
                                                {!! Form::checkbox("answers[$children->id]", $answer_k, null) !!} {{ $answer_v }}
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($children->input_type == 'select')
                                        <div class="">
                                            {!! Form::select("answers[$children->id]",array_filter($question->answers), ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                    @if($children->input_type == 'text')
                                        <div class="">
                                            {!! Form::text("answers[$children->id]", null, ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                    @if($children->input_type == 'textarea')
                                        <div class="">
                                            {!! Form::textarea("answers[$children->id]", null, ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                        @if($children->input_type == 'date' || $children->input_type == 'year' || $children->input_type == 'month' || $children->input_type == 'time')
                                            <div class="">
                                                {!! Form::text("answers[$children->id]", null, ['class' => 'form-control '.$children->input_type.'-picker']) !!}
                                            </div>
                                        @endif
                                @else
                                    @if($children->input_type == 'radio')
                                        <ul class="radio">
                                            <div class="">
                                                @foreach($children->answers as $answer_k => $answer_v)
                                                    @if(!empty($answer_v))
                                                        <li>
                                                            {!! Form::radio("answers[$children->id]", $answer_k ) !!} {{ $answer_v }}
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
                                                    {!! Form::checkbox("answers[$children->id]", $answer_k ) !!} {{ $answer_v }}
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    @if($children->input_type == 'select')
                                        <div class="">
                                            {!!
                                            Form::select("answers[$children->id]",array_filter($children->answers), ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                    @if($children->input_type == 'text')
                                        <div class="">
                                            {!! Form::text("answers[$children->id]", null, ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                    @if($children->input_type == 'textarea')
                                        <div class="">
                                            {!! Form::textarea("answers[$children->id]", null, ['class' => 'form-control']) !!}
                                        </div>
                                    @endif
                                        @if($children->input_type == 'date' || $children->input_type == 'year' || $children->input_type == 'month' || $children->input_type == 'time')
                                            <div class="">
                                                {!! Form::text("answers[$children->id]", null, ['class' => 'form-control '.$children->input_type.'-picker']) !!}
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