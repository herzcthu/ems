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

                            <div id="table">
                            <table id="datatable-results" class="table table-bordered table-hover table-striped">
                                <thead>
                                <!--th>No.</th-->
                                <th>Interviewee ID</th>
                                @role('admin')
                                <th>Delete</th>
                                @endrole
                                <th>Data Entry ID</th>
                                @permission('edit.data')
                                <!--th>Action</th-->
                                @endpermission
                                <!--th>Form Name</th>
                                <th>Interviewer</th>
                                <th>Interviewee</th-->

                                @foreach($questions as $qk => $q)
                                        @if($q->q_type == 'same')
                                            <th>
                                            <a href='#' data-toggle='modal' data-target='#popupModal'
                                               data-mainquestion='{{ $q->get_parent->question_number." ".$q->get_parent->question}}'
                                               data-subquestion='{{ $q->question_number." ".$q->question }}' data-answers='&lt;ul&gt;
                                                   @foreach($q->get_parent->answers as $k => $answer)
                                                       @if(is_array($answer))

                                                       @else
                                                       {{ "&lt;li&gt;(".$k.") ".$answer." " }}


                                                       &lt;/li&gt;
                                                       @endif
                                                   @endforeach
                                                    &lt;/ul&gt;'>
                                                {{ $q->get_parent->question_number.' '.$q->question_number }}
                                            </a>
                                            </th>
                                        @elseif($q->q_type == 'sub')
                                            <th>
                                                    <a href='#' data-toggle='modal' data-target='#popupModal'
                                                       data-mainquestion='{{ $q->get_parent->question_number." ".$q->get_parent->question}}'
                                                       data-subquestion='{{ $q->question_number." ".$q->question }}' data-answers='&lt;ul&gt;
                                                    @foreach($q->answers as $k => $answer)
                                                        @if(is_array($answer))

                                                        @else
                                                        {{ "&lt;li&gt;(".$k.") ".$answer." " }}
                                                        &lt;/li&gt;
                                                        @endif
                                                    @endforeach
                                                            &lt;/ul&gt;'>

                                                {{ $q->get_parent->question_number.' '.$q->question_number }}
                                                    </a>
                                            </th>
                                         @else
                                            <th>
                                                    <a href='#' data-toggle='modal' data-target='#popupModal'
                                                        data-mainquestion='{{ $q->question_number." ".$q->question }}'
                                                        data-answersonly='&lt;ul&gt;
                                                        @foreach($q->answers as $k => $answer)
                                                            @if(is_array($answer))

                                                            @else
                                                            {{ "&lt;li&gt;(".$k.") ".$answer." " }}
                                                            &lt;/li&gt;
                                                            @endif
                                                        @endforeach
                                                                &lt;/ul&gt;'>
                                                {{ $q->question_number }}
                                                    </a>
                                            </th>
                                        @endif


                                @endforeach


                                </thead>
                                <tbody>
                                @permission('view.table')
                                @foreach($dataentry as $data)

                                    <tr>
                                        @if($current_user->id == $data->user_id || ($current_user->is('admin|officestaff')) )
                                            @if($form->type == 'spotchecker')
                                            <td><a href="/{{ urlencode($form->name) }}/dataentry/{{ $data->id }}/edit">{!! $data->enumerator_form_id !!}</a></td>
                                            <td><a href="/{{ urlencode($form->name) }}/dataentry/{{ $data->id }}/delete">Delete</a></td>
                                            @endif
                                            @if($form->type == 'enumerator')
                                            <td><a href="/{{ urlencode($form->name) }}/dataentry/{{ $data->id }}/edit">{!! $data->interviewee_id !!}</a></td>
                                            <td><a href="/{{ urlencode($form->name) }}/dataentry/{{ $data->id }}/delete">Delete</a></td>
                                            @endif
                                        @else
                                            @if($form->type == 'spotchecker')
                                            <td>{!! $data->enumerator_form_id !!}</td>
                                            @endif
                                            @if($form->type == 'enumerator')
                                            <td>{!! $data->interviewee_id !!}</td>
                                            @endif
                                        @endif
                                        <td>{{ sprintf("%02d", $data->user_id) }}</td>
                                        @permission('edit.data')
                                        <!--td>Edit</td-->
                                        @endpermission
                                        <!--td>{!! $data->form_id !!}</td>
                                        <td>{!! $data->interviewer_id !!}</td-->

                                        @foreach($questions as $q)
                                            @if(array_key_exists($q->id, $data->answers))
                                                @if($form->type == 'enumerator')

                                                    @if(array_key_exists($q->id, (array)$data->notes))

                                                            <td>
                                                            <a href='#' data-toggle='modal' data-target='#popupModal' data-notequestion='{{ $q->question }}'
                                                               data-notes='{{ $data->notes[$q->id] }}'>
                                                                {{ $data->answers[$q->id] }}
                                                            </a>
                                                            </td>

                                                    @else

                                                        @if(is_array($data->answers[$q->id]))
                                                                <td lang="{!! Stevebauman\Translation\Facades\Translation::getLocale(); !!}">
                                                            @if(!empty($data->notes))
                                                                @for($i = 1; $i <= 15; $i++)
                                                                    @if(in_array($i, $data->notes))

                                                                        @foreach($data->notes as $nk =>$note)
                                                                            @if($note == $i)
                                                                                @foreach($data->answers[$q->id] as $da)
                                                                                    @if(is_array($da))
                                                                                        @if(array_key_exists($note, $da))
                                                                                        <p>{{ '('._t(sprintf("Category_%03d", $note)).') '.$da[$note] }}</p>
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                @endfor
                                                            @endif
                                                            <?php $i = 1;?>
                                                            @foreach(array_filter($data->answers[$q->id]) as $aq => $av)
                                                                @if(is_array($av))

                                                                @else
                                                               <p>{{ '('.$i.') '.$av }}</p>
                                                                @endif
                                                                <?php $i++;?>
                                                            @endforeach
                                                                </td>
                                                        @else
                                                            <td>
                                                            {{ $data->answers[$q->id] }}
                                                            </td>
                                                        @endif
                                                    @endif
                                                @endif
                                                    @if($form->type == 'spotchecker')

                                                        @if(array_key_exists($q->id, (array) $data->notes))

                                                            <td>
                                                                <a href='#' data-toggle='modal' data-target='#popupModal' data-notequestion='{{ $q->question }}'
                                                                   data-notes='{{ $data->notes[$q->id] }}'>
                                                                    {{ $data->answers[$q->id] }}
                                                                </a>
                                                            </td>

                                                        @else
                                                            @if(is_array($data->answers[$q->id]))
                                                                <td>
                                                                    @if(!empty($data->notes))
                                                                        @for($i = 1; $i <= 15; $i++)
                                                                            @if(in_array($i, $data->notes))

                                                                                @foreach($data->notes as $nk =>$note)
                                                                                    @if($note == $i)
                                                                                        @foreach($data->answers[$q->id] as $da)
                                                                                            @if(is_array($da))
                                                                                                @if(array_key_exists($note, $da))
                                                                                                    <p>{{ '('.$nk.') '.$da[$note] }}</p>
                                                                                                @endif
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                @endforeach

                                                                            @endif
                                                                        @endfor
                                                                    @endif
                                                                    <?php $i = 1;?>
                                                                    @foreach(array_filter($data->answers[$q->id]) as $aq => $av)
                                                                        @if(is_array($av))

                                                                        @else
                                                                            <p>{{ '('.$i.') '.$av }}</p>
                                                                        @endif
                                                                        <?php $i++;?>
                                                                    @endforeach
                                                                </td>
                                                            @else
                                                                <td>
                                                                    {{ $data->answers[$q->id] }}
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @endif

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
                            {!! $dataentry->render(); !!}
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

<style>
    #datatable-results{
        width:100%;
        overflow-x: hidden;}
</style>
@endsection