@extends('adminlte')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Forms
                <small>Forms List</small>
            </h1>
            <!--ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol-->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Your Page Content Here -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-name">
                                <i class="fa fa-edit"></i>
                                <span>Form List</span>
                            </div>
                        </div>
                        <div class="box-body">
                            <section>
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif



                                <table class="table table-bordered table-striped table-hover table-heading table-datatable"
                                       id="datatable-allfeatures">
                                    <thead>

                                    <th>No.</th>
                                    <th>Form Name</th>
                                    <th>Descriptions</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    @permission('view.table')
                                    <th>Results</th>
                                    @endpermission
                                    @permission('edit.form')
                                    <th>Build</th>
                                    <th>View</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    @endpermission
                                    @permission('add.data')
                                    <th>Add Data</th>
                                    @endpermission
                                    </thead>
                                    <tbody>
                                    @role('admin')
                                    @foreach ($forms as $k => $form )
                                        <tr>
                                            <!--td>@{{ ( ( $forms->currentPage() * $forms->perPage()) - $forms->perPage() ) + $k + 1 }}</td-->
                                            <td>{{ $k + 1}}</td>
                                            <td>{{ $form->name }}</td>
                                            <td>{{ $form->descriptions }}</td>
                                            <td>{{ $form->start_date }}</td>
                                            <td>{{ $form->end_date }}</td>
                                            @permission('view.table')
                                            <td><a href={{ url("/forms/".$form->id."/results" ) }}>Results</a></td>
                                            @endpermission
                                            @permission('edit.form')
                                            <td><a href={{ url("/forms/".$form->id."/build" ) }}>Build</a></td>
                                            <td><a href={{ url("/forms/".$form->id ) }}>View</a></td>
                                            <td><a href={{ url("/forms/".$form->id."/edit" ) }}>Edit</a></td>
                                            <td><a href={{ url("/forms/".$form->id."/delete" ) }}>Delete</a></td>
                                            @endpermission
                                            @permission('view.form')
                                            <td><a href={{ url("/forms/".urlencode($form->name)."/dataentry" ) }}>Add
                                                    Data</a>
                                            </td>
                                            @endpermission
                                        </tr>
                                    @endforeach

                                    @endrole
                                    </tbody>
                                    <tfoot>
                                    <th>No.</th>
                                    <th>Form Name</th>
                                    <th>Descriptions</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    @permission('view.table')
                                    <th>Results</th>
                                    @endpermission
                                    @permission('edit.form')
                                    <th>Build</th>
                                    <th>View</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    @endpermission
                                    @permission('add.data')
                                    <th>Add Data</th>
                                    @endpermission
                                    </tfoot>
                                </table>
                                {!! Form::close() !!}
                                <!--div id="datatable-1_paginate" class="dataTables_paginate paging_bootstrap">
                                    @{!! $forms->render() !!}
                                </div-->
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection