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
                                <th>No.</th>
                                <th>Interviewee ID</th>
                                @foreach($totalquestions_per_form as $q)

                                    <th>

                                        @if($q['q_type'] == 'sub')
                                            <?php
                                            $answer = " \n";
                                            foreach ($q['answers'] as $ansk => $ansv) {
                                                $answer .= " (". $ansk."): " . $ansv. " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            }
                                            $answer .= " ";
                                            $answer .= " ";

                                            ?>
                                            <a href="#" data-toggle="modal" data-target="#popupModal"
                                               data-mainquestion="{{ $q->get_parent()->get()->first()['question']}}" data-subquestion="{{ $q['question'] }}" data-answers="{{{ $answer }}}">
                                            {{ $q->get_parent()->get()->first()['question_number']}}

                                        @else
                                             <?php
                                                    $answer = " \n";
                                                    foreach ($q['answers'] as $ansk => $ansv) {
                                                        $answer .= " (". $ansk.") : " . $ansv. " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                    }
                                                    $answer .= " ";
                                                    $answer .= " ";
                                                    ?>
                                             <a href="#" data-toggle="modal" data-target="#popupModal"
                                                data-mainquestion="{{ $q['question']}}" data-answersonly="{{ $answer }}">
                                        @endif
                                        {{ $q['question_number'] }}
                                            </a>
                                    </th>
                                @endforeach
                                </thead>
                                <tbody>
                                @permission('view.table')
                                @foreach($gettotalinv as $k => $inv)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $inv }}</td>
                                        @foreach($totalquestions_per_form as $f => $q)
                                            <td>
                                                @if($q['q_type'] == 'sub')
                                               <!--     @{{ $q->get_parent()->get()->first()['question_number']}} -->
                                                @endif
                                                <!--    @{{ $q['question_number'] }} -->
                                                {{ \App\EmsQuestionsAnswers::OfAnsByInvWithQ($inv, $q['id'])->first()['answers']['answer'] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                @endpermission
                                </tbody>
                            </table>
                                {!! $paginator->render() !!}
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