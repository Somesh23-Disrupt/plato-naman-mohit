@extends($layout)
@section('header_scripts')
<link href="{{CSS}}ajax-datatables.css" rel="stylesheet">
@stop
@section('content')

<div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
                            <li>{{ $heading }}</li>
                        </ol>
                    </div>
                </div>
                                
                <!-- /.row -->
                <div class="panel panel-custom">
                    <div class="panel-heading">
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="panel-body packages">
                        <div> 
                        <table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ getPhrase('Name')}}</th>
                                    <th>{{ getPhrase('UserName')}}</th>
                                    <th>{{ getPhrase('Email')}}</th>
                                </tr>
                            </thead>
                            @foreach($institutions as $institution)
                             <thead>
                                <tr>
                                    <td><a href="{{URL_USER_DETAILS.$institution->slug}}">{{ $institution->name}}</a></td>

                                    <td><a href="{{URL_USER_DETAILS.$institution->slug}}"> {{$institution->username}}</a></td>

                                    <td><a href="{{URL_USER_DETAILS.$institution->slug}}">{{ $institution->email}}</a></td>

                                    
                                </tr>
                            </thead>
                            @endforeach
                        </table>
                        </div>
                         

                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
@endsection
 
@section('footer_scripts')
 
@stop
