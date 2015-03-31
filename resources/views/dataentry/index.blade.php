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
                                <!--th>Action</th-->
                                @endpermission
                                <!--th>Form Name</th>
                                <th>Interviewer</th>
                                <th>Interviewee</th-->

                                @foreach($questions as $qk => $q)
                                    <th>
                                        @if($q->q_type == 'same')
                                            <a href='#' data-toggle='modal' data-target='#popupModal'
                                               data-mainquestion='{{ $q->get_parent->question_number." ".$q->get_parent->question}}'
                                               data-subquestion='{{ $q->question_number." ".$q->question }}' data-answers='&lt;ul&gt;
                                                   @foreach($q->get_parent->answers as $k => $answer)
                                                   {{ "&lt;li&gt;(".$k.") ".$answer." " }}
                                                   {{ array_key_exists($k,array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $q->id)))? (((array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $q->id))[$k])/count($alldata))*100).'%':'' }}
                                                   &lt;/li&gt;
                                                   @endforeach
                                                    &lt;/ul&gt;'>
                                                {{ $q->get_parent->question_number.' '.$q->question_number }}
                                        @elseif($q->q_type == 'sub')
                                                    <a href='#' data-toggle='modal' data-target='#popupModal'
                                                       data-mainquestion='{{ $q->get_parent->question_number." ".$q->get_parent->question}}'
                                                       data-subquestion='{{ $q->question_number." ".$q->question }}' data-answers='&lt;ul&gt;
                                                    @foreach($q->answers as $k => $answer)
                                                    {{ "&lt;li&gt;(".$k.") ".$answer." " }}
                                                   {{ array_key_exists($k,array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $q->id)))? (((array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $q->id))[$k])/count($alldata))*100).'%':'' }}
                                                   &lt;/li&gt;
                                                    @endforeach
                                                            &lt;/ul&gt;'>

                                                {{ $q->get_parent->question_number.' '.$q->question_number }}

                                         @else
                                                    <a href='#' data-toggle='modal' data-target='#popupModal'
                                                        data-mainquestion='{{ $q->question_number." ".$q->question }}'
                                                        data-answersonly='&lt;ul&gt;
                                                        @foreach($q->answers as $k => $answer)
                                                        {{ "&lt;li&gt;(".$k.") ".$answer." " }}
                                                   {{ array_key_exists($k,array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $q->id)))? (((array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $q->id))[$k])/count($alldata))*100).'%':'' }}
                                                   &lt;/li&gt;
                                                        @endforeach
                                                                &lt;/ul&gt;'>
                                                {{ $q->question_number }}

                                        @endif
                                             </a>
                                    </th>
                                @endforeach


                                </thead>
                                <tbody>
                                @permission('view.table')
                                @foreach($dataentry as $data)

                                    <tr>
                                        <td>{!! $data->interviewee_id !!}</td>
                                        @permission('edit.data')
                                        <!--td>Edit</td-->
                                        @endpermission
                                        <!--td>{!! $data->form_id !!}</td>
                                        <td>{!! $data->interviewer_id !!}</td-->

                                        @foreach($questions as $q)
                                            @if(array_key_exists($q->id, $data->answers))
                                                <td>
                                                    @if(array_key_exists($q->id, $data->notes))
                                                        <a href='#' data-toggle='modal' data-target='#popupModal' data-notequestion='{{ $q->question }}'
                                                           data-notes='{{ $data->notes[$q->id] }}'>
                                                            {{ $data->answers[$q->id] }}
                                                        </a>

                                                    @else
                                                    {{ $data->answers[$q->id] }}
                                                    @endif
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                                @endpermission
                                </tbody>
                                <tfoot>



                                </tfoot>
                            </table>

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