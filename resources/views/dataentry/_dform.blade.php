<table class="table">
    @if($form->type == 'spotchecker')
        <tr lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
            <td>
                {!! Form::label('enu_form_id', _t('Enumerator Form ID (7 Digits): '), ['class' => 'control-label']) !!}
            </td>
            <td class="">

                {!! Form::text('enu_form_id', null, ['class' => 'form-control']) !!}
                <p id="spotcheck" class="btn btn-info btn-xs">Click to check</p>

            </td>
            <td class="col-xs-5" colspan="4" rowspan="2">
                <div class="flash" id="flash">
                    <p></p>
                    <table class='table table-bordered'>
                        <tr>
                            <td>{{ _t('Spot Checker Name:') }}</td>
                            <td id="spotchecker_name">__Spot Checker__</td>
                        </tr>
                        <tr>
                            <td>{{ _t('Spot Checker ID:') }}</td>
                            <td id="spotchecker_id">__Spot Checker ID__</td>
                        </tr>
                        <tr>
                            <td>{{ _t('Enumerator Name:') }}</td>
                            <td id="enu_name">__NAME__</td>
                        </tr>
                        <tr>
                            <td>{{ _t('Village:') }}</td>
                            <td id="village">__Village__</td>
                        </tr>
                    </table>
                </div>
            </td>


        </tr>

        <tr lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
            <td>
                {!! Form::label('psu', _t('PSU :'), ['class' => 'control-label']) !!}
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
                <p id="enucheck" class="btn btn-info btn-xs">{{ _t('Click to check') }}</p>

            </td>
            <td colspan="2" rowspan="2">
                <div class="flash" id="flash">
                    <p></p>
                    <table class='table table-bordered'>
                        <tr>
                            <td>{{ _t('Enumerator Name:') }}</td>
                            <td id="enumerator">__NAME__</td>
                        </tr>
                        <tr>
                            <td>{{ _t('State:') }}</td>
                            <td id="state">__State__</td>
                        </tr>
                        <tr>
                            <td>{{ _t('Village:') }}</td>
                            <td id="village">__Village__</td>
                        </tr>
                    </table>
                </div>
            </td>


        </tr>
        <tr lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
            <td>
                {!! Form::label('interviewee_id', _t($form_name.' ID: '), ['class' => 'control-label']) !!}
            </td>
            <td>

                {!! Form::select('interviewee_id',array_combine(range(1,9), range(1,9)), ['class' => 'form-control'])
                !!}

            </td>
        </tr>
        <tr lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">

            <td>
                {!! Form::label('interviewee_gender', _t('Interviewee Gender'), ['class' => 'control-label']) !!}
            </td>
            <td>

                {!! Form::select('interviewee_gender',['M' => _t('Male'), 'F' => _t('Female'), 'U' =>
                _t('Unspecified')], ['class' => 'form-control']) !!}

            </td>
            <td>
                {!! Form::label('psu', _t('PSU :'), ['class' => 'control-label']) !!}
            </td>
            <td>

                {!! Form::select('psu',['1' => _t('Urban'), '2' => _t('Rural')], ['class' => 'form-control']) !!}

            </td>
        </tr>
    @endif
    <?php function anscmp($a, $b)
        {
            $aa = str_replace('-','199', $a);
            $bb = str_replace('-','199', $b);
            $a = preg_replace('@^0@','1999', $aa);
            $b = preg_replace('@^0@','1999', $bb);
            return strcmp($a, $b);
        }
        function csort($array){
            $answers = $array;
            ksort($answers,SORT_NATURAL);
            //dd($answers);
            if(null != $answers || !empty($answers)){
                foreach($answers as $ak => $av){
                    if($ak > 0 ){
                        $positive[$ak] = $av;
                    }
                    if($ak <= 0){
                        $negative[$ak] = $av;
                    }
                }
                if(!isset($positive)){

                    $positive = array();
                }
                if(!isset($negative)){

                    $negative = array();
                }
                $sorted = (array)$positive + (array)$negative;
                return $sorted;
            }

        }
        ?>
    @foreach($questions as $question)
            <?php
            $answers = csort($question->answers);
            ?>

        <tr>

            @if($question->q_type == 'main')

                <td><h4>{{ $question->question_number }}</h4></td>
                <td colspan="3">
                    <h4>{{ _t($question->question) }} <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p></h4>

                    <!-- check form field view -->
                    @if($question->a_view == 'none')

                        @foreach($question->get_children as $child)

                            @if($child->q_type == 'sub')

                                @if($child->a_view == 'categories')
                                    <h4>{{ $child->question_number }} {{ _t($child->question) }}</h4>
                                    <div class="col-xs-offset-1">
                                        @foreach($answers as $answer_k => $answer_v)
                                            @if(!empty($answer_v))
                                                @if( in_array($answer_k, array('-99', '-98', '-97')) )
                                                    {!! Form::radio("answers[$child->id]",$answer_v['value'] )
                                                    !!} {{ $answer_v['value'].' ('._t($answer_v['text']).')' }}
                                                @endif
                                            @endif
                                        @endforeach
                                        <p>
                                            <a href="#" class="btn btn-box-tool" id="addCat"><i class="fa fa-plus"></i>
                                                <span lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ _t('Click here to answer') }}</span></a>
                                        </p>
                                    </div>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#addCat').on('click', function (e) {
                                                e.preventDefault();
                                                var container = $('.categories');
                                                var count = container.children().length + 1;
                                                var proto = container.data('prototype').replace(/__NAME__/g, count);
                                                container.append(proto);
                                                //alert($('#cat-' + count+ ' option[value="'+ count +'"]').html());
                                                $('#cat-' + count + ' option[value="'+ count +'"]').attr("selected","selected");
                                                $("select[name='notes[cat-" + count + "]']").change(function () {

                                                    $('.ans-radio-cat-' + count + '').attr('name', 'answers[{{ $child->id }}][' + count + '][' + $(this).val() + ']');

                                                    // $('.ans-radio-cat-' + count + '').attr("selected","selected");

                                                }).change();
                                            });
                                            $(".delCat").on('click', function (e) {
                                                e.preventDefault();
                                                $(this).parent('div').remove();
                                            });
                                        });
                                    </script>

                                    <div class="col-xs-offset-1 categories"
                                         data-prototype='<div class="addinput">{!! Form::select("notes[cat-__NAME__]",array_combine(range(1,15), array_map(function($n) { return sprintf("Category_%03d", $n); }, range(1, 15) )), "__NAME__", ["class" => "","id"=>"cat-__NAME__"]) !!}

                                        <ul class="radio" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
                                            @foreach($question->answers as $answer_k => $answer_v)
                                                @if(!empty($answer_v))
                                                    @if( !in_array($answer_k, array('-99', '-98', '-97')) )

                                                        <li>
                                                            {!! Form::radio("answers[ $child->id ][__NAME__]",$answer_v["value"],null, ["class" => "garlic-auto-save ans-radio-cat-__NAME__"] )!!} {{ $answer_v['value']." ("._t($answer_v['text']).")" }}
                                    </li>
                                    @endif
                                    @endif
                                    @endforeach
                                    </ul>
                                    </div>'>

                                    </div>
                                @elseif($child->a_view == 'list')

                                @elseif($child->a_view == 'validated-list')

                                @elseif($child->a_view == 'table')
                                    <h4>{{ $child->question_number.' '._t($child->question) }}</h4>
                                    <table class="table">
                                        <tr>
                                            @if($child->q_type == 'same')
                                                    @foreach($answers as $ans_k => $ans_v)
                                                        <td style="text-align: center" class="col-xs-1">
                                                            @if(array_key_exists('type', $ans_v))
                                                                @if($ans_v['type'] == 'text')
                                                                    <div class="">
                                                                        {!! Form::text("answers[$child->id][text-$ans_k]", null, ['class' => 'form-control', 'placeholder' => $ans_v["value"]]) !!}
                                                                        {!! Form::label("answers[$child->id][text-$ans_k]", _t($ans_v['text']), ['class' => 'control-label']) !!}
                                                                    </div>
                                                                @elseif($ans_v['type'] == 'radio')
                                                                    <div class="radio">
                                                                        {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                                    </div>
                                                                @elseif($ans_v['type'] == 'textarea')
                                                                    <div>

                                                                    </div>
                                                                @elseif($ans_v['type'] == 'select')
                                                                    <div>

                                                                    </div>
                                                                @elseif($ans_v['type'] == 'none')
                                                                    <div class="radio">
                                                                        {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="radio">
                                                                    {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                    @endforeach

                                            @elseif($child->q_type == 'sub')
                                                    @foreach(csort($child->answers) as $ans_k => $ans_v)
                                                        <td style="text-align: center" class="col-xs-1">
                                                            @if(array_key_exists('type', $ans_v))
                                                                @if($ans_v['type'] == 'text')
                                                                    <div class="">
                                                                        {!! Form::text("answers[$child->id][text-$ans_k]", null, ['class' => 'form-control', 'placeholder' => $ans_v["value"]]) !!}
                                                                        {!! Form::label("answers[$child->id][text-$ans_k]", _t($ans_v['text']), ['class' => 'control-label']) !!}
                                                                    </div>
                                                                @elseif($ans_v['type'] == 'radio')
                                                                    <div class="radio">
                                                                        {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} {{ _t($ans_v['text']) }}
                                                                    </div>
                                                                @elseif($ans_v['type'] == 'textarea')
                                                                    <div>

                                                                    </div>
                                                                @elseif($ans_v['type'] == 'select')
                                                                    <div>

                                                                    </div>
                                                                @elseif($ans_v['type'] == 'none')
                                                                    <div class="radio">
                                                                        {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} {{ _t($ans_v['text']) }}
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="radio">
                                                                    {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} {{ _t($ans_v['text']) }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                    @endforeach

                                            @endif
                                        </tr>
                                    </table>
                                @elseif($child->a_view == 'table-column')

                                @elseif($child->a_view == 'validated-table')

                                @else
                                    <h4>{{ $child->question_number }} {{ _t($child->question) }}</h4>
                                    <div class="col-xs-offset-1">
                                        @if(!empty($child->answers))
                                            @foreach(csort($child->answers) as $ans_k => $ans_v)
                                                <?php $as_no = $ans_k + 1; ?>

                                                @if(array_key_exists('type', $ans_v))
                                                    @if($ans_v['type'] == 'text')
                                                        <div class="">
                                                            {!! Form::text("answers[$child->id][text-$ans_k]", null, ['class' => 'form-control']) !!}
                                                            {!! Form::label("answers[$child->id][text-$ans_k]", _t($ans_v['text']), ['class' => 'control-label']) !!}
                                                        </div>
                                                    @elseif($ans_v['type'] == 'radio')
                                                        <div class="radio">
                                                            {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                                        </div>
                                                    @elseif($ans_v['type'] == 'textarea')
                                                        <div>

                                                        </div>
                                                    @elseif($ans_v['type'] == 'select')
                                                        <div>

                                                        </div>
                                                    @elseif($ans_v['type'] == 'none')
                                                        <div class="radio">
                                                            {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="radio">
                                                        {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                                    </div>
                                                @endif
                                            @endforeach

                                        @endif
                                    </div>
                                @endif
                            @elseif($child->q_type == 'spotchecker')
                            @elseif($child->q_type == 'same')
                                @if($child->a_view == 'categories')
                                    <h4>{{ $child->question_number }} {{ _t($child->question) }}</h4>
                                    <div class="col-xs-offset-1">
                                        @foreach($answers as $answer_k => $answer_v)
                                            @if(!empty($answer_v))
                                                @if( in_array($answer_k, array('-99', '-98', '-97')) )
                                                    {!! Form::radio("answers[$child->id]",$answer_v['value'] )
                                                    !!} {{ $answer_v['value'].' ('._t($answer_v['text']).')' }}
                                                @endif
                                            @endif
                                        @endforeach
                                        <p>
                                            <a href="#" class="btn btn-box-tool" id="addCat"><i class="fa fa-plus"></i>
                                                <span lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ _t('Click here to answer') }}</span></a>
                                        </p>
                                    </div>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#addCat').on('click', function (e) {
                                                e.preventDefault();
                                                var container = $('.categories');
                                                var count = container.children().length + 1;
                                                var proto = container.data('prototype').replace(/__NAME__/g, count);
                                                container.append(proto);
                                                //alert($('#cat-' + count+ ' option[value="'+ count +'"]').html());
                                                $('#cat-' + count + ' option[value="'+ count +'"]').attr("selected","selected");
                                                $("select[name='notes[cat-" + count + "]']").change(function () {

                                                    $('.ans-radio-cat-' + count + '').attr('name', 'answers[{{ $child->id }}][' + count + '][' + $(this).val() + ']');

                                                   // $('.ans-radio-cat-' + count + '').attr("selected","selected");

                                                }).change();
                                            });
                                            $(".delCat").on('click', function (e) {
                                                e.preventDefault();
                                                $(this).parent('div').remove();
                                            });
                                        });
                                    </script>

                                    <div class="col-xs-offset-1 categories"
                                         data-prototype='<div class="addinput">{!! Form::select("notes[cat-__NAME__]",array_combine(range(1,15), array_map(function($n) { return sprintf("Category_%03d", $n); }, range(1, 15) )), "__NAME__", ["class" => "","id"=>"cat-__NAME__"]) !!}

                                        <ul class="radio" lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
                                            @foreach($question->answers as $answer_k => $answer_v)
                                                @if(!empty($answer_v))
                                                    @if( !in_array($answer_k, array('-99', '-98', '-97')) )

                                                        <li>
                                                            {!! Form::radio("answers[ $child->id ][__NAME__]",$answer_v["value"],null, ["class" => "garlic-auto-save ans-radio-cat-__NAME__"] )!!} {{ $answer_v['value']." ("._t($answer_v['text']).")" }}
                                                        </li>
                                                    @endif
                                         @endif
                                         @endforeach
                                                 </ul>
                                                 </div>'>

                                    </div>
                                @else
                                    <h4>{{ $child->question_number }} {{ _t($child->question) }}</h4>
                                    <div class="col-xs-offset-1">
                                        @if(!empty($answers))
                                            @foreach($answers as $ans_k => $ans_v)
                                                <?php $as_no = $ans_k + 1; ?>

                                                @if(array_key_exists('type', $ans_v))
                                                    @if($ans_v['type'] == 'text')
                                                        <div class="">
                                                            {!! Form::text("answers[$child->id][text-$ans_k]", null, ['class' => 'form-control']) !!}
                                                            {!! Form::label("answers[$child->id][text-$ans_k]", _t($ans_v['text']), ['class' => 'control-label']) !!}
                                                        </div>
                                                    @elseif($ans_v['type'] == 'radio')
                                                        <div class="radio">
                                                            {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                                        </div>
                                                    @elseif($ans_v['type'] == 'textarea')
                                                        <div>

                                                        </div>
                                                    @elseif($ans_v['type'] == 'select')
                                                        <div>

                                                        </div>
                                                    @elseif($ans_v['type'] == 'none')
                                                        <div class="radio">
                                                            {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="radio">
                                                        {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                                    </div>
                                                @endif
                                            @endforeach

                                         @endif
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @elseif($question->a_view == 'categories')
                        Main Categories
                    @elseif($question->a_view == 'notes')
                        Main Notes
                    @elseif($question->a_view == 'list')
                        Main List
                    @elseif($question->a_view == 'validated-list')
                        Main Validated List
                    @elseif($question->a_view == 'table')
                        <table class="table">
                            <tr>
                                <th>{{ _t('Question') }}</th>
                                @foreach($answers as $ans_k => $ans_v)
                                    <th>{{ _t($ans_v['text']) }}</th>
                                @endforeach
                            </tr>
                            @foreach($question->get_children as $child)
                                @if($child->q_type == 'same')
                                <tr>
                                    <td>{{ $child->question_number.' '._t($child->question) }}</td>
                                    @foreach($answers as $ans_k => $ans_v)
                                        <td style="text-align: center" class="col-xs-1">
                                            @if(array_key_exists('type', $ans_v))
                                                @if($ans_v['type'] == 'text')
                                                    <div class="">
                                                        {!! Form::text("answers[$child->id][text-$ans_k]", null, ['class' => 'form-control', 'placeholder' => $ans_v["value"]]) !!}
                                                        {!! Form::label("answers[$child->id][text-$ans_k]", _t($ans_v['text']), ['class' => 'control-label']) !!}
                                                    </div>
                                                @elseif($ans_v['type'] == 'radio')
                                                    <div class="radio">
                                                        {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                    </div>
                                                @elseif($ans_v['type'] == 'textarea')
                                                    <div>

                                                    </div>
                                                @elseif($ans_v['type'] == 'select')
                                                    <div>

                                                    </div>
                                                @elseif($ans_v['type'] == 'none')
                                                    <div class="radio">
                                                        {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="radio">
                                                    {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @elseif($child->q_type == 'sub')
                                    <tr>
                                        <td>{{ $child->question_number.' '.$child->question }}</td>
                                        @foreach(csort($child->answers) as $ans_k => $ans_v)
                                            <td style="text-align: center" class="col-xs-1">
                                                @if(array_key_exists('type', $ans_v))
                                                    @if($ans_v['type'] == 'text')
                                                        <div class="">
                                                            {!! Form::text("answers[$child->id][text-$ans_k]", null, ['class' => 'form-control', 'placeholder' => $ans_v["value"]]) !!}
                                                            {!! Form::label("answers[$child->id][text-$ans_k]", _t($ans_v['text']), ['class' => 'control-label']) !!}
                                                        </div>
                                                    @elseif($ans_v['type'] == 'radio')
                                                        <div class="radio">
                                                            {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} {{ _t($ans_v['text']) }}
                                                        </div>
                                                    @elseif($ans_v['type'] == 'textarea')
                                                        <div>

                                                        </div>
                                                    @elseif($ans_v['type'] == 'select')
                                                        <div>

                                                        </div>
                                                    @elseif($ans_v['type'] == 'none')
                                                        <div class="radio">
                                                            {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} {{ _t($ans_v['text']) }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="radio">
                                                        {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} {{ _t($ans_v['text']) }}
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach

                        </table>
                    @elseif($question->a_view == 'table-column')
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ _t('Question') }}</th>
                                @foreach($question->get_children as $child)
                                    <th>{{ _t($child->question) }}</th>
                                @endforeach
                            </tr>
                            @for($i=0; $i < count($question->get_children); $i++)

                            @endfor

                            @foreach($answers as $ans_k => $ans_v)
                                <?php $as_no = $ans_k + 1; ?>
                                <tr>
                                    <td>{{ _t($ans_v['text']) }}</td>
                                    @foreach($question->get_children as $child)
                                    <td style="text-align: center" class="col-xs-1">
                                        @if(array_key_exists('type', $ans_v))
                                            @if($ans_v['type'] == 'text')
                                                <div class="">
                                                    {!! Form::text("answers[$child->id][text-$ans_k]", null, ['class' => 'form-control']) !!}
                                                </div>
                                            @elseif($ans_v['type'] == 'radio')
                                                <div class="radio">
                                                {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                </div>
                                            @elseif($ans_v['type'] == 'textarea')
                                                <div>

                                                </div>
                                            @elseif($ans_v['type'] == 'select')
                                                <div>

                                                </div>
                                            @elseif($ans_v['type'] == 'none')
                                                <div class="radio">
                                                    {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                </div>
                                            @endif
                                        @else
                                            <div class="radio">
                                                {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                            </div>
                                        @endif
                                    </td>
                                    @endforeach

                                </tr>
                            @endforeach
                        </table>
                    @elseif($question->a_view == 'validated-table')
                        @foreach($answers as $answer_k => $answer_v)
                            @if(!empty($answer_v))
                                @if( in_array($answer_k, array('0', '-98', '-99')) )
                                    {!! Form::radio("answers[$question->id]",$answer_v['value'] )
                                    !!} {{ $answer_v['value'].' ('._t($answer_v['text']).')' }}
                                @endif
                            @endif
                        @endforeach
                        <table id="validated-table" class="table">
                            <th></th>
                            @if(is_array($answers))
                                @foreach($question->get_children as $children)
                                    <th lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ $children->question_number }}
                                        . {{ _t($children->question) }}</th>
                                    @if($children->a_view == 'notes')
                                        {!! Form::text("notes[$children->id]", null, ['class' => 'form-control']) !!}
                                    @endif

                                @endforeach
                                @foreach($answers as $ans_k => $ans_v)
                                    @if( !in_array($ans_k, array('-99', '-98')) )

                                        <tr>
                                            <td lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">{{ _t($ans_v['text']) }}</td>
                                            @foreach($question->get_children as $child)
                                                <td style="text-align: center" class="col-xs-1">
                                                    @if(array_key_exists('type', $ans_v))
                                                        @if($ans_v['type'] == 'text')
                                                            <div class="">
                                                                {!! Form::text("answers[$child->id][text-$ans_k]", null, ['class' => 'form-control']) !!}
                                                            </div>
                                                        @elseif($ans_v['type'] == 'radio')
                                                            <div class="radio">
                                                                {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                            </div>
                                                        @elseif($ans_v['type'] == 'textarea')
                                                            <div>

                                                            </div>
                                                        @elseif($ans_v['type'] == 'select')
                                                            <div>

                                                            </div>
                                                        @elseif($ans_v['type'] == 'none')
                                                            <div class="radio">
                                                                {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="radio">
                                                            {!! Form::radio("answers[$child->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                        </div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </table>

                    @endif
                </td>

            @elseif($question->q_type == 'single')

                <!-- check form field view -->
                @if($question->a_view == 'none')
                    <td><h4>{{ $question->question_number }}</h4></td>

                        @if(in_array($question->input_type, array('date','month','year','time')))
                            <td><h4>{{ _t($question->question) }}</h4> <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p>
                            </td><td colspan="2">

                                {!! Form::text("answers[$question->id]", null, ['class' => 'form-control '.$question->input_type.'-picker', 'placeholder' => $ans_v["value"]]) !!}

                        @elseif($question->input_type == 'radio')
                            <td colspan="3"><h4>{{ _t($question->question) }} <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p></h4>
                            <div class="col-xs-offset-1">
                            @foreach($answers as $ans_k => $ans_v)
                            <div class="radio">
                                {!! Form::radio("answers[$question->id]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                            </div>
                            @endforeach
                            </div>
                        @elseif($question->input_type == 'text')
                            <td colspan="3"><h4>{{ _t($question->question) }} <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p></h4>
                            @if(is_array($answers))

                                @foreach($answers as $answer_k => $answer_v)
                                    @if(!empty($answer_v))
                                        @if( in_array($answer_k, array('0', '-97', '-98', '-99')) )
                                            <div class="col-xs-4">
                                            {!! Form::radio("answers[$question->id]",$answer_v['value'] )
                                            !!} {{ $answer_v['value'].' ('._t($answer_v['text']).')' }}
                                            </div>
                                        @else
                                            <div class="col-xs-4">
                                            {!! Form::label("answers[$question->id][$answer_k]", _t($answer_v['text']), ['class' => 'control-label']) !!}
                                            {!! Form::text("answers[$question->id][$answer_k]", null, ['class' => 'form-control', 'placeholder' => $ans_v["value"]]) !!}
                                            </div>
                                        @endif
                                    @endif
                                @endforeach

                            @else
                                {!! Form::text("answers[$question->id]", null, ['class' => 'form-control']) !!}
                            @endif
                        @elseif($question->input_type == 'textarea')
                            <td colspan="3"><h4>{{ _t($question->question) }} <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p></h4>
                            {!! Form::textarea("answers[$question->id]", null, ['class' => 'form-control']) !!}
                        @elseif($question->input_type == 'choice')
                            <td colspan="3"><h4>{{ _t($question->question) }} <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p></h4>
                            {!! Form::text("answers[$question->id]", null, ['class' => 'form-control']) !!}
                        @elseif($question->input_type == 'different')

                            <td colspan="3"><h4>{{ _t($question->question) }} <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p></h4>
                            <table class="table">
                            @foreach($answers as $ans_k => $ans_v)
                                <tr>
                                <?php $as_no = $ans_k + 1; ?>
                                @if(array_key_exists('type', $ans_v))

                                    @if( in_array($ans_k, array('0', '-97', '-98', '-99')) )
                                        <td>{{ _t($ans_v['text']) }}</td>
                                        <td class="text-left">
                                            <div class="radio col-xs-offset-1">
                                            {!! Form::radio("answers[$question->id][choice]",$ans_v['value'] )
                                                !!} {{ $ans_v['value'] }}
                                            </div>
                                        </td>
                                    @else
                                        @if($ans_v['type'] == 'text')
                                            <td>{{ _t($ans_v['text']) }}</td>
                                            <td>

                                                {!! Form::text("answers[$question->id][text-$ans_k]", null, ['class' => 'form-control', 'placeholder' => $ans_v["value"]]) !!}

                                            </td>
                                        @elseif($ans_v['type'] == 'radio')
                                            <td>{{ _t($ans_v['text']) }}</td>
                                            <td>
                                            <div class="radio">
                                                {!! Form::radio("answers[$question->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                            </div>
                                            </td>
                                        @elseif($ans_v['type'] == 'textarea')
                                        @elseif($ans_v['type'] == 'select')
                                        @elseif($ans_v['type'] == 'none')
                                            <td>{{ _t($ans_v['text']) }}</td>
                                            <td>
                                            <div class="radio">
                                                {!! Form::radio("answers[$question->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}

                                            </div>
                                            </td>
                                        @endif
                                    @endif

                                @else
                                    <div class="radio">
                                        {!! Form::radio("answers[$question->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                    </div>
                                @endif
                                </tr>
                            @endforeach
                            </table>
                        @else
                            <td colspan="3"><h4>{{ _t($question->question) }} <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p></h4>
                                <div class="col-xs-offset-1">
                                    @foreach($answers as $ans_k => $ans_v)
                                        <div class="radio">
                                            {!! Form::radio("answers[$question->id]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                        </div>
                                    @endforeach
                                </div>
                        @endif
                    </td>
                @elseif($question->a_view == 'categories')
                    Single Categories
                @elseif($question->a_view == 'notes')
                    Single Notes
                @elseif($question->a_view == 'list')
                    Single List
                @elseif($question->a_view == 'validated-list')
                    Single Validated List
                @elseif($question->a_view == 'table-column')
                    Single Table with Questions in column
                @elseif($question->a_view == 'table')

                    <td><h4>{{ $question->question_number }}</h4></td>
                    <td colspan="3"><h4>{{ _t($question->question) }} <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p></h4>
                    <table class="table">

                        <tr>

                            @foreach($answers as $ans_k => $ans_v)
                                <?php $as_no = $ans_k + 1; ?>

                                <td style="text-align: center" class="col-xs-1">
                                    @if($question->input_type == 'different')
                                        @if(array_key_exists('type', $ans_v))
                                            @if(in_array($ans_v['type'], array('date','month','year','time')))

                                                {!! Form::text("answers[$question->id][text-$ans_k]", null, ['placeholder'=> _t($ans_v["text"]),'class' => 'form-control '.$ans_v["type"].'-picker']) !!}

                                            @elseif($ans_v['type'] == 'text')
                                                <div class="">
                                                    {!! Form::text("answers[$question->id][text-$ans_k]", null, ['class' => 'form-control', 'placeholder' => $ans_v["value"]]) !!}
                                                    {!! Form::label("answers[$question->id][text-$ans_k]", _t($ans_v['text']), ['class' => 'control-label']) !!}
                                                </div>
                                            @elseif($ans_v['type'] == 'radio')
                                                <div class="radio">
                                                    {!! Form::radio("answers[$question->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                                </div>
                                            @elseif($ans_v['type'] == 'textarea')
                                            @elseif($ans_v['type'] == 'select')
                                            @elseif($ans_v['type'] == 'none')
                                                <div class="radio">
                                                    {!! Form::radio("answers[$question->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                                </div>
                                            @endif
                                        @else
                                            <div class="radio">
                                                {!! Form::radio("answers[$question->id][choice]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                            </div>
                                        @endif
                                    @else
                                        @if(array_key_exists('type', $ans_v))
                                            @if(in_array($ans_v['type'], array('date','month','year','time')))

                                            {!! Form::text("answers[$question->id]", null, ['placeholder'=> _t($ans_v["text"]),'class' => 'form-control '.$ans_v["type"].'-picker']) !!}

                                            @elseif($ans_v['type'] == 'text')
                                                <div class="">
                                                    {!! Form::text("answers[$question->id]", null, ['class' => 'form-control', 'placeholder' => $ans_v["value"]]) !!}
                                                    {!! Form::label("answers[$question->id]", _t($ans_v['text']), ['class' => 'control-label']) !!}
                                                </div>
                                            @elseif($ans_v['type'] == 'radio')
                                                <div class="radio">
                                                    {!! Form::radio("answers[$question->id]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                                </div>
                                            @elseif($ans_v['type'] == 'textarea')
                                            @elseif($ans_v['type'] == 'select')
                                            @elseif($ans_v['type'] == 'none')
                                                <div class="radio">
                                                    {!! Form::radio("answers[$question->id]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                                </div>
                                            @endif
                                        @else
                                            <div class="radio">
                                                {!! Form::radio("answers[$question->id]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }} ( {{ _t($ans_v['text']) }} )
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                    </table>
                    </td>

                @elseif($question->a_view == 'validated-table')
                    Single Validated Table
                @endif
            @elseif($question->q_type == 'spotchecker')
                <td><h4>{{$question->question_number}}</h4></td>
                <td colspan="2">
                    @if(!empty($question->get_parent->answers))
                    <h4>{{ $question->get_parent->question_number.'. '._t($question->get_parent->question) }} <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p></h4>
                    <div class="col-xs-offset-1">
                        <table class="table">

                    @foreach(csort($question->get_parent->answers) as $ans_k => $ans_v)
                        <tr>
                            @if($ans_v['type'] == 'text')
                                <td>{{ _t($ans_v['text']) }}</td>
                                <td>

                                    {!! Form::text("answers[$question->id][text-$ans_k]", null, ['class' => 'form-control', 'placeholder' => $ans_v["value"]]) !!}
                                    {!! Form::label("answers[$question->id][text-$ans_k]", _t($ans_v['text']), ['class' => 'control-label']) !!}
                                </td>
                            @elseif($ans_v['type'] == 'radio')
                                <td>{{ _t($ans_v['text']) }}</td>
                                <td>
                                    <div class="radio">
                                        {!! Form::radio("answers[$question->id][spot_answer]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                    </div>
                                </td>
                            @elseif($ans_v['type'] == 'textarea')
                            @elseif($ans_v['type'] == 'select')
                            @elseif($ans_v['type'] == 'none')
                                <td>{{ _t($ans_v['text']) }}</td>
                                <td>
                                    <div class="radio">
                                        {!! Form::radio("answers[$question->id][spot_answer]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}

                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @else

                            <h4>{{ \App\EmsFormQuestions::enu_parent($question->get_parent->id)->question_number.' '.$question->get_parent->question_number.'. '._t($question->get_parent->question) }} <p class="btn btn-info btn-xs reset pull-right">{{ _t('reset') }}</p></h4>
                            <div class="col-xs-offset-1">
                                <table class="table">

                                    @foreach(csort(\App\EmsFormQuestions::enu_parent($question->get_parent->id)->answers) as $ans_k => $ans_v)
                                        <tr>
                                            @if($ans_v['type'] == 'text')
                                                <td>{{ _t($ans_v['text']) }}</td>
                                                <td>

                                                    {!! Form::text("answers[$question->id][text-$ans_k]", null, ['class' => 'form-control', 'placeholder' => $ans_v["value"]]) !!}

                                                </td>
                                            @elseif($ans_v['type'] == 'radio')
                                                <td>{{ _t($ans_v['text']) }}</td>
                                                <td>
                                                    <div class="radio">
                                                        {!! Form::radio("answers[$question->id][spot_answer]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}
                                                    </div>
                                                </td>
                                            @elseif($ans_v['type'] == 'textarea')
                                            @elseif($ans_v['type'] == 'select')
                                            @elseif($ans_v['type'] == 'none')
                                                <td>{{ _t($ans_v['text']) }}</td>
                                                <td>
                                                    <div class="radio">
                                                        {!! Form::radio("answers[$question->id][spot_answer]",$ans_v['value'] ,null) !!} {{ $ans_v['value'] }}

                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                    @endif
                         <tr>
                             <td>{{ _t('Enumerator Answer:') }} </td>
                             <td colspan="3"><p class="enuanswer" id="q-{{ $question->get_parent->id }}"></p></td>
                         </tr>
                         <tr>
                             <td colspan="4">
                                 <div class="checkbox">
                                     {!! Form::checkbox("answers[$question->id][accuracy]", 1, null, ['class' => 'field']) !!} {{ _t("Response Accurate (Check if 'Yes')") }}
                                 </div>
                             </td>
                         </tr>
                        </table>
                    </div>
                </td>

            @endif

        </tr>
    @endforeach
        <tr>
            <td>
                {!! Form::hidden('form_id', $form_id, ['class' => 'form-control']) !!}
                {!! Form::submit( _t($submitButton), ['class' => 'btn btn-primary form-control']) !!}
            </td>
            <td></td>
        </tr>
</table>
<style type="text/css">
    .QEN {
        display: none;
    }
    .warning-text {
        color: red;
    }
    .success-text {
        color: green;
    }
    .warning-box {
        border: 2px solid red;
    }
    .success-box {
        border: 2px solid green;
    }
</style>
<script type="text/javascript">
    $('form tr').hover(function () {
        $(this).toggleClass('validate');

    });
    var radioButton = $("#validated-table tr");
    radioButton.mousedown(function () {
        if ($(this).hasClass('validate')) {
            if ($("tr.validate").find("tr.validate input:radio").val() == 0 || $("tr.validate").find("tr.validate input:radio").val() == '-8' || $("tr.validate").find("tr.validate input:radio").val() == '-9') {
            } else {
                $("tr.validate").find("tr.validate input:radio:checked").prop('checked', false);
                //alert($("tr.validate").find("tr.validate input:radio").val());
            }
        }
        //return false;
    });
    $('.reset').on('click',function(){
        //alert($('form tr.validate').html());
        $( "form tr.validate").find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'text':
                case 'textarea':
                case 'file':
                case 'select-one':
                case 'select-multiple':
                    jQuery(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
            }
        });
    });
    $('#dataentry').find(':input').blur().each(function() {
        var $input = $( this );
            switch(this.type) {
                case 'password':
                    if( !$(this).val() ) {
                       // $(this).addClass('warning-text');
                       // $(this).removeClass('success-text');
                    }else{
                        $(this).removeClass('warning-text');
                        $(this).addClass('success-text');
                    }
                    break;
                case 'text':
                    if( !$(this).val() ) {
                      //  $(this).addClass('warning-box');
                      //  $(this).removeClass('success-box');
                    }else{
                        $(this).removeClass('warning-box');
                        $(this).addClass('success-box');
                    }
                    break;
                case 'textarea':
                    if( !$(this).val() ) {
                      //  $(this).addClass('warning-text');
                      //  $(this).removeClass('success-text');
                    }else{
                        $(this).removeClass('warning-text');
                        $(this).addClass('success-text');
                    }
                    break;
                case 'file':
                    if( !$(this).val() ) {
                      //  $(this).addClass('warning-text');
                      //  $(this).removeClass('success-text');
                    }else{
                        $(this).removeClass('warning-text');
                        $(this).addClass('success-text');
                    }
                    break;
                case 'select-one':
                    if( !$(this).val() ) {
                      //  $(this).addClass('warning-box');
                      //  $(this).removeClass('success-box');
                    }else{
                        $(this).removeClass('warning-text');
                        $(this).addClass('success-text');
                    }
                    break;
                case 'select-multiple':
                    if( !$(this).val() ) {
                      //  $(this).addClass('warning-box');
                      //  $(this).removeClass('success-box');
                    }else{
                        $(this).removeClass('warning-text');
                        $(this).addClass('success-text');
                    }
                    break;
                case 'checkbox':
                    if( !$(this).val() ) {
                      //  $(this).addClass('warning-box');
                      //  $(this).removeClass('success-box');
                    }else{
                        $(this).removeClass('warning-text');
                        $(this).addClass('success-text');
                    }
                    break;
                case 'radio':
                    if( !$(this).prop('checked') ) {
                      //  $(this).closest('div.radio').addClass('warning-text');
                      //  $(this).closest('div.radio').removeClass('success-text');
                    }else{
                        $(this).closest('div').removeClass('warning-box');
                        $(this).closest('div.radio').addClass('success-box');
                    }
                    break;
            }

    });


</script>
<script type="text/javascript">
    //startDate: "2013-02-14 10:00",
    var startDate = "{{ date("Y-m-d", strtotime($form->start_date))  }} 00:00";
    if (typeof ajaxURL === 'undefined') {
        var ajaxURL = "{{ '/'.$form_name_url.'/ajax' }}";
    }
    $(function () {

        @if($form->type == 'spotchecker')
        $("#enu_form_id").focusout(function () {
            $.get(ajaxURL, {enu_form_id: $('#enu_form_id').val()})
                    .success(function (data) {
                        var json = JSON.parse(data);
                        if (json.status == true) {
                            $("div.flash table").show();
                            $("p.enuanswer").show();
                            $("div.flash p").hide();
                            $.each(json.message, function (key, value) {
                                $("#" + key).html("<b>" + value + "</b>");
                            });

                        }
                        if (json.status == false) {
                            $("div.flash p").show();
                            $("div.flash p").html(json.message);
                            $("div.flash table").hide();
                            $("p.enuanswer").hide();
                        }
                    });
        });
        $("#spotcheck").on('click', function () {
            $.get(ajaxURL, {enu_form_id: $('#enu_form_id').val()})
                    .success(function (data) {
                        var json = JSON.parse(data);
                        if (json.status == true) {
                            $("div.flash table").show();
                            $("p.enuanswer").show();
                            $("div.flash p").hide();
                            $.each(json.message, function (key, value) {
                                $("#" + key).html("<b>" + value + "</b>");
                            });

                        }
                        if (json.status == false) {
                            $("div.flash p").show();
                            $("div.flash p").html(json.message);
                            $("div.flash table").hide();
                            $("p.enuanswer").hide();
                        }
                    });
        });
        @else
        $("#enucheck").on('click', function () {
                    $.get(ajaxURL, {
                        interviewer_id: $('#interviewer_id').val(),
                        interviewee_id: $('#interviewee_id').val()
                    })
                            .success(function (data) {
                                var json = JSON.parse(data);
                                if (json.status == true) {
                                    $("div.flash table").show();
                                    $("p.enuanswer").show();
                                    $("div.flash p").hide();
                                    $.each(json.message, function (key, value) {
                                        $("#" + key).html("<b>" + value + "</b>");
                                    });
                                }
                                if (json.status == false) {
                                    $("div.flash p").show();
                                    $("div.flash p").html(json.message);
                                    $("div.flash table").hide();
                                    $("p.flash").html(json.message);
                                }
                            });
                });

        $("#interviewer_id").focusout(function () {
            $.get(ajaxURL, {interviewer_id: $('#interviewer_id').val(), interviewee_id: $('#interviewee_id').val()})
                    .success(function (data) {
                        var json = JSON.parse(data);
                        if (json.status == true) {
                            $("div.flash table").show();
                            $("p.enuanswer").show();
                            $("div.flash p").hide();
                            $.each(json.message, function (key, value) {
                                $("#" + key).html("<b>" + value + "</b>");
                            });
                        }
                        if (json.status == false) {
                            $("div.flash p").show();
                            $("div.flash p").html(json.message);
                            $("div.flash table").hide();
                            $("p.flash").html(json.message);
                        }
                    });
        });

        $("#row1").on('mouseleave', function () {
            $.get(ajaxURL, {interviewer_id: $('#interviewer_id').val(), interviewee_id: $('#interviewee_id').val()})
                    .success(function (data) {
                        var json = JSON.parse(data);
                        if (json.status == true) {
                            $("div.flash table").show();
                            $("p.enuanswer").show();
                            $("div.flash p").hide();
                            $.each(json.message, function (key, value) {
                                $("#" + key).html("<b>" + value + "</b>");
                            });
                        }
                        if (json.status == false) {
                            $("div.flash p").show();
                            $("div.flash p").html(json.message);
                            $("div.flash table").hide();
                            $("p.flash").html(json.message);
                        }
                    });
        });

        $("#interviewee_id").change(function () {
            $.get(ajaxURL, {interviewer_id: $('#interviewer_id').val(), interviewee_id: $('#interviewee_id').val()})
                    .success(function (data) {
                        var json = JSON.parse(data);
                        if (json.status == true) {
                            $("div.flash table").show();
                            $("p.enuanswer").show();
                            $("div.flash p").hide();
                            $.each(json.message, function (key, value) {
                                $("#" + key).html("<b>" + value + "</b>");
                            });
                        }
                        if (json.status == false) {
                            $("div.flash p").show();
                            $("div.flash p").html(json.message);
                            $("div.flash table").hide();
                            $("p.flash").html(json.message);
                        }
                    });
        }).change();

        @endif

    });
</script>

