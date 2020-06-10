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
                            <li><a href="{{URL_MEETINGS}}">{{getPhrase('meetings')}}</a></li>
                            <li>{{$meeting->title}}</li>
                        </ol>
                    </div>
                </div>

		<div class="panel panel-custom col-lg-10 col-lg-offset-1" >
                    {{-- <div class="panel-heading text-center">
                        <h1>{{$meeting->title}}</h1> </div> --}}
                    <div class="panel-body">
                        <div class="meeting-details">
                            <div class="meeting-title text-center">
                                <h2>{{$meeting->title}}</h2></div>
                            <div class="meeting-content text-center">
                                {!!$meeting->description!!}
                            </div>
                            <div id="meet" class="meeting-footer text-center"></div>
                            @if($meeting->slug)
                            <div class="meeting-footer text-center">
                                <a type="button" href="{{URL_MEETINGS}}" class="btn btn-lg btn-danger button">{{getPhrase('END_meeting')}}</a>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <script src='https://meet.jit.si/external_api.js'></script>
        <script>
            const domain =  'meet.jit.si';
            const options = {
                roomName: '{{$meeting->slug}}',
                userInfo: {
                        email: '{{Auth::user()->email}}',
                        displayName: '{{Auth::user()->name}}'
                    },
                width: 853,
                height: 480,
                parentNode: document.querySelector('#meet')
            };
            const api = new JitsiMeetExternalAPI(domain, options);
            api.executeCommand('password', 'password');
        </script>
@endsection

@section('footer_scripts')

@stop
