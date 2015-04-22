<table class="table">
    @if($form->type == 'spotchecker')
        <tr lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
            <td>
                {!! Form::label('enu_form_id', _t('Enumerator Form ID (7 Digits): '), ['class' => 'control-label']) !!}
            </td>
            <td class="">

                {!! Form::text('enu_form_id', null, ['class' => 'form-control']) !!}
                <p class="flash" id="flash"></p>

            </td>

            <td>
                {!! Form::label('psu', 'PSU :', ['class' => 'control-label']) !!}
            </td>
            <td>

                {!! Form::select('psu',['1' => _t('Urban'), '2' => _t('Rural')], ['class' => 'form-control']) !!}

            </td>

        </tr>
    @else

    <tr lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
        <td>
            {!! Form::label('interviewer_id', _t('Enumerator ID: '), ['class' => 'control-label']) !!}
        </td>
        <td class="">

                {!! Form::text('interviewer_id', null, ['class' => 'form-control']) !!}
            <p class="flash" id="flash"></p>

        </td>

        <td>
            {!! Form::label('interviewee_id', _t($form_name.' ID: '), ['class' => 'control-label']) !!}
        </td>
        <td>

               {!! Form::select('interviewee_id',array_combine(range(1,9), range(1,9)), ['class' => 'form-control']) !!}

        </td>

    </tr>
    <tr lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">

        <td>
            {!! Form::label('interviewee_gender', _t('Interviewee Gender'), ['class' => 'control-label']) !!}
        </td>
        <td>

                {!! Form::select('interviewee_gender',['M' => _t('Male'), 'F' => _t('Female'), 'U' => _t('Unspecified')], ['class' => 'form-control']) !!}

        </td>
        <td>
            {!! Form::label('psu', 'PSU :', ['class' => 'control-label']) !!}
        </td>
        <td>

            {!! Form::select('psu',['1' => _t('Urban'), '2' => _t('Rural')], ['class' => 'form-control']) !!}

        </td>
    </tr>
    @endif
    @foreach($questions as $k => $question)
        <tr>
            @if($question->q_type == 'single')
                <td><h4 class="{{ $question->question_number }}">{{ $question->question_number }}</h4></td>
                <td colspan="7">
                    <h4 class="{{ $question->question_number.'-question' }}" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ _t($question->question) }}</h4>
                    @if($question->a_view == 'notes')
                        {!! Form::text("notes[$question->id]", null, ['class' => 'form-control']) !!}
                    @endif
                    <div class="col-xs-offset-1">
                        @if($question->input_type == 'radio')
                            <ul class="radio" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
                                @foreach($question->answers as $answer_k => $answer_v)
                                    @if(!empty($answer_v))
                                        <li>
                                            {!! Form::radio("answers[$question->id]",$answer_k,null ) !!} {{ $answer_k.' ('._t($answer_v).')' }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>             <!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
                        @endif
                        @if($question->input_type == 'choice')
                            @foreach($question->answers as $answer_k => $answer_v)
                                @if(!empty($answer_v))
                                    {!! Form::checkbox("answers[$question->id]", $answer_k, null) !!} {{ $answer_k.' ('._t($answer_v).')' }}
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

                <td><h4 class="{{ $question->question_number }}">{{ $question->question_number }}</h4></td>
                <td colspan="7">
                    <h4 class="{{ $question->question_number.'-question' }}" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ _t($question->question) }}</h4>
                    @if($question->a_view == 'notes')
                        {!! Form::text("notes[$question->id]", null, ['class' => 'form-control']) !!}
                    @endif

                    @if($question->a_view == 'validated-table')
                        <table id="validated-table" class="table">
                            <th> </th>
                            @if(is_array($question->answers))
                                @foreach($question->get_children as $children)
                                    <th lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ $children->question_number }}. {{ _t($children->question) }}</th>
                                    @if($children->a_view == 'notes')
                                        {!! Form::text("notes[$children->id]", null, ['class' => 'form-control']) !!}
                                    @endif

                                @endforeach
                                @foreach($question->answers as $answer_k => $answer_v)
                                    <tr>
                                        <td lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ _t($answer_v) }}</td>
                                        @foreach($question->get_children as $children)

                                            @if(!empty($answer_v))
                                                <td>
                                                    <div class="radio" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
                                                    {!! Form::radio("answers[$children->id]",$answer_k ,null ) !!} {{ $answer_k }}
                                                    </div>
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
                                <h4 class="{{ $children->question_number }}" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ $children->question_number }}. {{ _t($children->question) }}</h4>
                                @if($children->a_view == 'notes')
                                    {!! Form::text("notes[$children->id]", null, ['class' => 'form-control']) !!}
                                @endif
                                @if($children->a_view == 'categories')
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $('#addCat').on('click', function(e) {
                                                e.preventDefault();
                                                var container = $('.categories');
                                                var count = container.children().length + 1;
                                                var proto = container.data('prototype').replace(/__NAME__/g, count);
                                                container.append(proto);
                                                $( "select[name='notes[cat-"+ count +"]']" ).change(function () {

                                                    $('.ans-radio-cat-'+ count +'').attr('name', 'answers[{{ $children->id }}]['+ count +']['+$(this).val()+']')

                                                }).change();
                                            });
                                            $(".delCat").on('click', function(e){
                                                e.preventDefault();
                                                $(this).parent('div').remove();
                                            });
                                        });
                                    </script>
                                    <a href="#" class="btn btn-box-tool" id="addCat"><i class="fa fa-plus"></i> <span lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ _t('Click here to answer') }}</span></a>

                                    <div class="categories" data-prototype='<div class="addinput"><a href="#" class="btn btn-box-tool delCat" id="delCat"><i class="fa fa-minus"></i></a>{!! Form::select("notes[cat-__NAME__]",array_combine(range(1,15), array_map(function($n) { return sprintf('Category_%03d', $n); }, range(1, 15) )), '__NAME__', ['class' => '', 'id'=>'cat-__NAME__']) !!}

                                    <ul class="radio" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
                                        @foreach($question->answers as $answer_k => $answer_v)
                                            @if(!empty($answer_v))
                                                <li>
                                                    {!! Form::radio("answers[ $children->id ][ __NAME__ ][]",$answer_k,null, ['class' => 'ans-radio-cat-__NAME__'] ) !!} {{ $answer_k.' ('._t($answer_v).')' }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    </div>'>

                                    </div>
                                @elseif(is_array($question->answers) && $children->q_type == 'same')
                                    @if($children->input_type == 'radio')
                                        <ul class="radio" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
                                            @foreach($question->answers as $answer_k => $answer_v)
                                                @if(!empty($answer_v))
                                                    <li>
                                                        {!! Form::radio("answers[$children->id]",$answer_k ) !!} {{ $answer_k.' ('._t($answer_v).')' }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>              <!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
                                    @endif
                                    @if($children->input_type == 'choice')
                                        @foreach($question->answers as $answer_k => $answer_v)
                                            @if(!empty($answer_v))
                                                {!! Form::checkbox("answers[$children->id]", $answer_k, null) !!} {{ $answer_k.' ('._t($answer_v).')' }}
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($children->input_type == 'select')
                                        <div class="">
                                            {!! Form::select("answers[$children->id]",array_filter($question->answers), null,['class' => 'form-control']) !!}
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
                                            <div class="" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
                                                @foreach($children->answers as $answer_k => $answer_v)
                                                    @if(!empty($answer_v))
                                                        <li>
                                                            {!! Form::radio("answers[$children->id]", $answer_k ) !!} {{ $answer_k.' ('._t($answer_v).')' }}
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
                                                    {!! Form::checkbox("answers[$children->id]", $answer_k ) !!} {{ $answer_k.' ('._t($answer_v).')' }}
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
    @if($form->type == 'spotchecker')
    <tr><th></th><th>Section/Question</th><th>Spotchecker Answer</th><th></th><th></th></tr>
    @foreach($questions as $k => $question)

            @if($question->q_type == 'spotchecker')
                <td><h4 class="{{ $question->question_number }}">{{ $question->question_number }}</h4></td>

                    <td><h4 class="{{ $question->get_parent->question_number.'-question' }}" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ $question->get_parent->question_number }} {{ _t($question->get_parent->question) }}</h4></td>

                    <td>
                    @if($question->get_parent->a_view == 'notes')
                        {!! Form::text("notes[$question->get_parent->id]", null, ['class' => 'form-control']) !!}
                    @endif
                    <div>
                        @if($question->get_parent->input_type == 'radio')
                            <ul class="radio" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
                                @foreach($question->get_parent->answers as $answer_k => $answer_v)
                                    @if(!empty($answer_v))
                                        <li>
                                            {!! Form::radio("answers[$question->id]",$answer_k,null ) !!} {{ $answer_k.' ('._t($answer_v).')' }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>             <!--{!! Form::input('date', 'dob', date('d-m-Y'), ['class' => 'form-control']) !!} -->
                        @endif
                        @if($question->get_parent->input_type == 'choice')
                            @foreach($question->answers as $answer_k => $answer_v)
                                @if(!empty($answer_v))
                                    {!! Form::checkbox("answers[$question->id]", $answer_k, null) !!} {{ $answer_k.' ('._t($answer_v).')' }}
                                @endif
                            @endforeach
                        @endif
                        @if($question->get_parent->input_type == 'select')
                            <div class="">
                                {!! Form::select("answers[$question->id]",array_filter($question->answers), null, ['class' => 'form-control']) !!}
                            </div>
                        @endif
                        @if($question->get_parent->input_type == 'text')
                            <div class="">
                                {!! Form::text("answers[$question->id]", null, ['class' => 'form-control']) !!}
                            </div>
                        @endif
                        @if($question->get_parent->input_type == 'textarea')
                            <div class="">
                                {!! Form::textarea("answers[$question->id]", null, ['class' => 'form-control']) !!}
                            </div>
                        @endif
                        @if($question->get_parent->input_type == 'date' || $question->get_parent->input_type == 'year' || $question->get_parent->input_type == 'month' || $question->get_parent->input_type == 'time')
                            <div class="bootstrap-timepicker">
                                {!! Form::text("answers[$question->id]", null, ['class' => 'form-control '.$question->input_type.'-picker']) !!}
                            </div>
                        @endif
                    </div>
                    </td>
            <td>
                </td>
            @endif
        </t>
    @endforeach
    @endif
    <tr>
        <td>
            {!! Form::hidden('form_id', $form_id, ['class' => 'form-control']) !!}
            {!! Form::submit( $submitButton, ['class' => 'btn btn-primary form-control']) !!}
        </td>
        <td></td>
    </tr>
</table>
<style type="text/css">
    .QEN{display:none;}
</style>

<script type="text/javascript">
    if (typeof ajaxURL === 'undefined') {
        var ajaxURL = "{{ '/'.$form_name_url.'/ajax' }}";
    }
    $(function(){

        @if($form->type == 'spotchecker')
        $("#enu_form_id").focusout(function() {
            $.get( ajaxURL, { enu_form_id: $('#enu_form_id').val() } )
                    .success(function( data ) {
                        var json = JSON.parse(data);
                        if(json.status == true){
                            $( "p.flash" ).html( json.message );

                        }
                        if(json.status == false){
                            $( "p.flash" ).html( json.message );
                        }
                    });
        });
        @else

        $("#interviewer_id").focusout(function() {
            $.get( ajaxURL, { interviewer_id: $('#interviewer_id').val() } )
                    .success(function( data ) {
                        var json = JSON.parse(data);
                        if(json.status == true){
                            $( "p.flash" ).html( json.message );

                        }
                        if(json.status == false){
                            $( "p.flash" ).html( json.message );
                        }
                    });
        });

        $("#row1").on('mouseleave', function() {
            $.get( ajaxURL, { interviewer_id: $('#interviewer_id').val(), interviewee_id: $('#interviewee_id').val() } )
                    .success(function( data ) {
                        var json = JSON.parse(data);
                        if(json.status == true){
                            $( "p.flash" ).html( json.message );

                        }
                        if(json.status == false){
                            $( "p.flash" ).html( json.message );
                        }
                    });
        });

        $("#interviewee_id").change(function() {
            $.get( ajaxURL, { interviewer_id: $('#interviewer_id').val(), interviewee_id: $('#interviewee_id').val() } )
                    .success(function( data ) {
                        var json = JSON.parse(data);
                        if(json.status == true){
                            $( "p.flash" ).html( json.message );

                        }
                        if(json.status == false){
                            $( "p.flash" ).html( json.message );
                        }
                    });
        }).change();

        @endif
    });
</script>