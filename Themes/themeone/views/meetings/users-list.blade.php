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
                            <li>{{$title}}</li>
                        </ol>
                    </div>
                </div>

                <div class="panel panel-custom">
                    <div class="panel-heading">
                        <h1>{{$title}}</h1> </div>
                    <div class="panel-body">
                        <ul class="list-unstyled meeting-list">
                            @foreach($meetings as $meeting)

                            <li>
                                <a href="{{URL_MEETINGS_VIEW.$meeting->slug}}">
                                    <h4>{{$meeting->title}}</h4>
                                    <p>{{$meeting->short_description}}</p> <span class="posted-time">{{getPhrase('posted_on')}} : <i class="fa fa-calendar"></i> {{ $meeting->updated_at}}</span> </a>
                            </li>
                            @endforeach

                        </ul>
                            {!! $meetings->links() !!}

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
@endsection

@section('footer_scripts')



@stop
