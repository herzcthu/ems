@extends('adminlte')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Results
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
                            <h3 class="box-title">Results</h3>
                            <a class="btn btn-primary pull-right" href="/results/{{ $form_name_url }}/export">Export All Data</a>
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
                            <section class="row">
                                @if (Session::has('answer_import_error'))
                                    <div class="alert alert-danger">{{ Session::get('answer_import_error') }}</div>
                                @endif
                                @if (Session::has('answer_import_success'))
                                    <div class="alert alert-success">{{ Session::get('answer_import_success') }}</div>
                                @endif

                            </section>


                            <table id="datatable-results" class="table table-bordered table-striped">
                                <thead>
                                <!--th>No.</th-->
                                <th>Interviewee ID</th>
                                @permission('edit.data')
                                <th>Action</th>
                                @endpermission
                                @foreach($totalquestions_per_form as $q)

                                    <th>

                                        @if($q['q_type'] == 'sub')
                                            <?php
                                            $answer = " \n";
                                            foreach ($q['answers'] as $ansk => $ansv) {
                                                $answer .= " (" . $ansk . "): " . $ansv . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            }
                                            $answer .= " ";
                                            $answer .= " ";

                                            if(is_array($q->get_parent->answers)){
                                            $main_answer = "";
                                                foreach($q->get_parent->answers as $mk => $mans){
                                                    $main_answer .= " (". $mk . "): " . $mans . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                }

                                                }

                                            ?>
                                            @if(isset($main_answer))
                                                    <a href="#" data-toggle="modal" data-target="#popupModal"
                                                       data-mainquestion="{{ $q->get_parent->question}}"
                                                       data-subquestion="{{ $q['question'] }}" data-answers="{{{ $main_answer }}}">
                                            @else
                                            <a href="#" data-toggle="modal" data-target="#popupModal"
                                               data-mainquestion="{{ $q->get_parent->question}}"
                                               data-subquestion="{{ $q['question'] }}" data-answers="{{{ $answer }}}">
                                            @endif
                                                {{ $q->get_parent()->get()->first()['question_number']}}

                                        @else
                                                    <?php
                                                    $answer = " \n";
                                                    foreach ($q['answers'] as $ansk => $ansv) {
                                                        $answer .= " (" . $ansk . ") : " . $ansv . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                    }
                                                    $answer .= " ";
                                                    $answer .= " ";
                                                    ?>
                                                    <a href="#" data-toggle="modal" data-target="#popupModal"
                                                       data-mainquestion="{{ $q['question']}}"
                                                       data-answersonly="{{ $answer }}">
                                        @endif
                                                        {{ $q['question_number'] }}
                                                    </a>
                                    </th>
                                @endforeach

                                </thead>
                                <tbody>
                                @permission('view.table')
                                @foreach($paginator->first() as $k => $v)

                                    @foreach($v['questions'] as $q)

                                        @if($q['q_type'] == 'single')

                                        @endif
                                        @if($q['q_type'] == 'sub')

                                        @endif

                                    @endforeach
                                @endforeach
                                @for($i=0; $i < count($paginator); $i++)

                                    @foreach($paginator[$i] as $k => $v)
                                        @permission('view.table')
                                        <tr>
                                            <!--td>{{ ($paginator->currentPageNo * $paginator->perPage()) + $i + 1 }}</td-->
                                            <td>{{ $k }}</td>
                                            @permission('edit.data')
                                            @if($v->all()['answers'][0]->first()['user_id'] == Auth::user()->id || Auth::user()->isAdmin())
                                            <td><a href="/forms/{{ $form_name_url }}/dataentry/{{ $k }}">edit</a></td>
                                            @endif
                                            @endpermission
                                            @if($v->all()['answers'][0]->exists(['q_id']))
                                            @foreach($v['answers'] as $ans)

                                                <td>{{ $ans->first()['answers']['answer'] }}</td>
                                            @endforeach
                                            @endif
                                        </tr>
                                        @endpermission
                                    @endforeach

                                @endfor
                                @foreach($paginator as $k => $interviewee)

                                    @foreach($interviewee as $inv => $data)
                                        @foreach($data['questions'] as $question)

                                        @endforeach
                                    @endforeach

                                @endforeach

                                @endpermission
                                </tbody>
                                <tfoot>
                                <!--th>No.</th-->
                                <th>Interviewee ID</th>
                                @permission('edit.data')
                                <th>Action</th>
                                @endpermission
                                @foreach($totalquestions_per_form as $q)

                                    <th>

                                        @if($q['q_type'] == 'sub')
                                            <?php
                                            $answer = " \n";
                                            foreach ($q['answers'] as $ansk => $ansv) {
                                                $answer .= " (" . $ansk . "): " . $ansv . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            }
                                            $answer .= " ";
                                            $answer .= " ";

                                            ?>
                                            <a href="#" data-toggle="modal" data-target="#popupModal"
                                               data-mainquestion="{{ $q->get_parent()->get()->first()['question']}}"
                                               data-subquestion="{{ $q['question'] }}" data-answers="{{{ $answer }}}">
                                                {{ $q->get_parent()->get()->first()['question_number']}}

                                                @else
                                                    <?php
                                                    $answer = " \n";
                                                    foreach ($q['answers'] as $ansk => $ansv) {
                                                        $answer .= " (" . $ansk . ") : " . $ansv . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                    }
                                                    $answer .= " ";
                                                    $answer .= " ";
                                                    ?>
                                                    <a href="#" data-toggle="modal" data-target="#popupModal"
                                                       data-mainquestion="{{ $q['question']}}"
                                                       data-answersonly="{{ $answer }}">
                                                        @endif
                                                        {{ $q['question_number'] }}
                                                    </a>
                                    </th>
                                @endforeach

                                </tfoot>
                            </table>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div id="datatable-allfeatures_info" class="dataTables_info">
                                        Showing {!! $paginator->current_showing !!}
                                        to {!! $paginator->last_item !!}
                                        of {!! $paginator->totalentry !!} entries
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="dataTables_paginate paging_bootstrap">
                                        <ul class="pagination">
                                            <li class="prev">
                                                <a href="{!! $paginator->first !!}">← First</a>
                                            </li>
                                            <li class="prev">
                                                <a href="{!! $paginator->previousPageUrl !!}">← Previous</a>
                                            </li>


                                            {!! $paginator->menu !!}


                                            <li class="next"><a href="{!! $paginator->nextPageUrl !!}">Next → </a></li>
                                            <li class="next"><a href="{!! $paginator->last !!}">Last → </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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