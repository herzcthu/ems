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
                                            @if(isset($dataentry[$question->id]) && $dataentry[$question->id]['answer'] == $answer_k)
                                                {!! Form::radio("answers[$question->id][answer]",$answer_k, $dataentry[$question->id]['answer'] ) !!} {{ $answer_v }}
                                            @else
                                                {!! Form::radio("answers[$question->id][answer]",$answer_k, null ) !!} {{ $answer_v }}
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                                </ul>             <!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
                            @endif
                            @if($question->input_type == 'choice')
                                @foreach($question->answers as $answer_k => $answer_v)
                                    @if(!empty($answer_v))
                                        <li>
                                            @if(isset($dataentry[$question->id]) && $dataentry[$question->id]['answer'] == $answer_k)
                                                {!! Form::checkbox("answers[$question->id][answer]", $answer_k, $dataentry[$question->id]['answer']) !!} {{ $answer_v }}
                                            @else
                                                {!! Form::checkbox("answers[$question->id][answer]", $answer_k, $dataentry[$question->id]['answer']) !!} {{ $answer_v }}
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                            @if($question->input_type == 'select')
                                <div class="">
                                    @if(isset($dataentry[$question->id]) && $dataentry[$question->id]['answer'] == $answer_k)
                                        {!! Form::select("answers[$question->id][answer]",array_filter($question->answers), $dataentry[$question->id]['answer'], ['class' => 'form-control']) !!}
                                    @else
                                        {!! Form::select("answers[$question->id][answer]",array_filter($question->answers), null, ['class' => 'form-control']) !!}
                                    @endif
                                </div>
                            @endif
                            @if($question->input_type == 'text')
                                <div class="">
                                    @if(isset($dataentry[$question->id]) && $dataentry[$question->id]['answer'] == $answer_k)
                                        {!! Form::text("answers[$question->id][answer]", $dataentry[$question->id]['answer'], ['class' => 'form-control']) !!}
                                    @else
                                        {!! Form::text("answers[$question->id][answer]", null, ['class' => 'form-control']) !!}
                                    @endif
                                </div>
                            @endif
                            @if($question->input_type == 'textarea')
                                 <div class="">
                                     @if(isset($dataentry[$question->id]) && $dataentry[$question->id]['answer'] == $answer_k)
                                         {!! Form::textarea("answers[$question->id][answer]", $dataentry[$question->id]['answer'], ['class' => 'form-control']) !!}
                                     @else
                                         {!! Form::textarea("answers[$question->id][answer]", null, ['class' => 'form-control']) !!}
                                     @endif
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
                                    <th> </th>
                                    @if(is_array($question->answers))
                                        @foreach($question->get_children as $children)
                                        <th>{{ $children->question_number }}. {{ $children->question }}</th>
                                        @endforeach
                                        @foreach($question->answers as $answer_k => $answer_v)
                                            <tr>
                                                <td>{{ $answer_v }}</td>
                                            @foreach($question->get_children as $children)
                                                @if(!empty($answer_v))
                                                    <td>
                                                        @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                            {!! Form::radio("answers[$children->id][answer]",$answer_k, $dataentry[$children->id]['answer'] ) !!}
                                                        @else
                                                            {!! Form::radio("answers[$children->id][answer]",$answer_k, null ) !!}
                                                        @endif
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
                                @foreach($question->get_children as $ck => $children)
                                    <div class="col-xs-offset-1">
                                        <h4>{{ $children->question_number }}. {{ $children->question }}</h4>
                                        @if(is_array($question->answers) && $question->input_type == 'same')
                                            @if($children->input_type == 'radio')
                                                <ul class="radio">
                                                @foreach($question->answers as $answer_k => $answer_v)
                                                    @if(!empty($answer_v))
                                                        <li>
                                                            @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                                {!! Form::radio("answers[$children->id][answer]",$answer_k, $dataentry[$children->id]['answer'] ) !!} {{ $answer_v }}
                                                            @else
                                                                {!! Form::radio("answers[$children->id][answer]",$answer_k, null ) !!} {{ $answer_v }}
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                                </ul>              <!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
                                            @endif
                                            @if($children->input_type == 'choice')
                                                @foreach($question->answers as $answer_k => $answer_v)
                                                     @if(!empty($answer_v))
                                                            @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                                {!! Form::checkbox("answers[$children->id][answer]", $answer_k, $dataentry[$children->id]['answer']) !!} {{ $answer_v }}
                                                            @else
                                                                {!! Form::checkbox("answers[$children->id][answer]", $answer_k, null) !!} {{ $answer_v }}
                                                            @endif
                                                     @endif
                                                @endforeach
                                            @endif
                                            @if($children->input_type == 'select')
                                                <div class="">
                                                    @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                        {!! Form::select("answers[$children->id][answer]",array_filter($question->answers), $dataentry[$children->id]['answer'], ['class' => 'form-control']) !!}
                                                    @else
                                                        {!! Form::select("answers[$children->id][answer]",array_filter($question->answers), null, ['class' => 'form-control']) !!}
                                                    @endif
                                                </div>
                                            @endif
                                            @if($children->input_type == 'text')
                                                <div class="">
                                                    @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                        {!! Form::text("answers[$children->id][answer]", $dataentry[$children->id]['answer'], ['class' => 'form-control']) !!}
                                                    @else
                                                        {!! Form::text("answers[$children->id][answer]", null, ['class' => 'form-control']) !!}
                                                    @endif
                                                </div>
                                            @endif
                                            @if($children->input_type == 'textarea')
                                                 <div class="">
                                                     @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                        {!! Form::textarea("answers[$children->id][answer]", $dataentry[$children->id]['answer'], ['class' => 'form-control']) !!}
                                                     @else
                                                         {!! Form::textarea("answers[$children->id][answer]", null, ['class' => 'form-control']) !!}
                                                     @endif
                                                 </div>
                                            @endif
                                        @else
                                            @if($children->input_type == 'radio')
                                                <ul class="radio">
                                                <div class="">
                                                    @foreach($children->answers as $answer_k => $answer_v)
                                                        @if(!empty($answer_v))
                                                            <li>
                                                                @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                                    {!! Form::radio("answers[$children->id][answer]", $answer_k, $dataentry[$children->id]['answer'] ) !!} {{ $answer_v }}
                                                                @else
                                                                    {!! Form::radio("answers[$children->id][answer]", $answer_k, null ) !!} {{ $answer_v }}
                                                                @endif
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
                                                            @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                                {!! Form::checkbox("answers[$children->id][answer]", $answer_k, $dataentry[$children->id]['answer']) !!} {{ $answer_v }}
                                                            @else
                                                                {!! Form::checkbox("answers[$children->id][answer]", $answer_k, null) !!} {{ $answer_v }}
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                            @if($children->input_type == 'select')
                                                <div class="">
                                                    @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                        {!! Form::select("answers[$children->id][answer]",array_filter($children->answers), $dataentry[$children->id]['answer'],['class' => 'form-control']) !!}
                                                    @else
                                                        {!! Form::select("answers[$children->id][answer]",array_filter($children->answers), null,['class' => 'form-control']) !!}
                                                    @endif
                                                </div>
                                            @endif
                                            @if($children->input_type == 'text')
                                                <div class="">
                                                    @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                        {!! Form::text("answers[$children->id][answer]", $dataentry[$children->id]['answer'], ['class' => 'form-control']) !!}
                                                    @else
                                                        {!! Form::text("answers[$children->id][answer]", null, ['class' => 'form-control']) !!}
                                                    @endif
                                                </div>
                                            @endif
                                            @if($children->input_type == 'textarea')
                                                <div class="">
                                                    @if(isset($dataentry[$children->id]) && $dataentry[$children->id]['answer'] == $answer_k)
                                                        {!! Form::textarea("answers[$children->id][answer]", $dataentry[$children->id]['answer'], ['class' => 'form-control']) !!}
                                                    @else
                                                        {!! Form::textarea("answers[$children->id][answer]", null, ['class' => 'form-control']) !!}
                                                    @endif
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