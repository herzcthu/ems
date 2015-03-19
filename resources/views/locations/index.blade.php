@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>location List
                        <a class='btn btn-primary pull-right' href={{ url("/locations/create" ) }}>Add New</a>
                        </h1>

                    </div>
                    <div class="panel-body">
                        <section>
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

                                @if (Session::has('location_import_error'))
                                    <div class="alert alert-danger">{{ Session::get('location_import_error') }}</div>
                                @endif
                                @if (Session::has('location_import_success'))
                                    <div class="alert alert-success">{{ Session::get('location_import_success') }}</div>
                                @endif
                                {!! Form::open(['url'=>'locations/import','files'=>true, 'form-horizontal']) !!}
                                <div class="form-group">
                                    {!! Form::label('file','File',['id'=>'','class'=>'sr-only control-label col-sm-1']) !!}
                                    <div class="col-sm-2">
                                    {!! Form::file('file','',['id'=>'','class'=>'form-control file']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-1 col-sm-1">
                                    {!! Form::submit('Import', ['class'=>'btn btn-default']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                <!-- reset buttons -->
                                    <div class="">
                                    {!! Form::reset('Reset', ['class'=>'btn btn-default']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                {!! Form::close() !!}
                                </div>

                            <table class="table">
                                <thead>

                                <th>No.</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Township</th>
                                <th>Village Track</th>
                                <th>Village/Ward</th>
                                <th>Village Burmese</th>
                                </thead>
                                <tbody>
                                @role('admin')
                                @foreach ($locations as $k => $location )
                                    <tr>
                                        <td>{{ ( ( $locations->currentPage() * $locations->perPage()) - $locations->perPage() ) + $k + 1 }}</td>
                                        <td>{{ $location->township->district->state->state }}</td>
                                        <td>{{ $location->township->district->district }}</td>
                                        <td>{{{ $location->township->township }}}</td>
                                        <td>{{{ isset($location->villagetrack ) ? $location->villagetrack : '' }}}</td>
                                        <td>{{{ isset($location->village ) ? $location->village : '' }}}</td>
                                        <td>{{{ isset($location->village_my ) ? $location->village_my : '' }}}</td>
                                    </tr>
                                @endforeach

                                @endrole
                                </tbody>
                            </table>
                            {!! Form::close() !!}
                                 {!! $locations->render(); !!}
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
