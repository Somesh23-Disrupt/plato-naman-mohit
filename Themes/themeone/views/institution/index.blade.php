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
                                    <th>{{ getPhrase('Institution Name')}}</th>
                                    <th>{{ getPhrase('No. of Admin')}}</th>
                                    <th>{{ getPhrase('No. of Student')}}</th>
                                    <th>{{ getPhrase('No. of Teacher')}}</th>
                                    <th>{{ getPhrase('No. of Parent')}}</th>
                                </tr>
                            </thead>
                            @foreach($institutions as $institution)
                             <thead>
                                <tr>
                                    <td>{{ $institution->institution_name}}</td>

                                    <td><a href="{{'institution/'.$institution->institution_name.'/admin'}}">{{ App\User::where('inst_id',$institution->id)->where('role_id',2)->count()}}</a></td>
                                    <td><a href="{{'institution/'.$institution->institution_name.'/student'}}">{{ App\User::where('inst_id',$institution->id)->where('role_id',5)->count()}}</a></td>

                                    <td><a href="{{'institution/'.$institution->institution_name.'/teacher'}}">{{ App\User::where('inst_id',$institution->id)->where('role_id',7)->count()}}</a></td>
                                    <td><a href="{{'institution/'.$institution->institution_name.'/parent'}}">{{ App\User::where('inst_id',$institution->id)->where('role_id',6)->count()}}</a></td>

                                    
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
