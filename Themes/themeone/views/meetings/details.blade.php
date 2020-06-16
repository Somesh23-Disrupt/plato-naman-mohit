@extends($layout)
@section('header_scripts')
<link href="{{CSS}}ajax-datatables.css" rel="stylesheet">
@stop
@section('content')

<div  id="page-wrapper">
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
                                <a type="button" href="{{URL_MEETINGS}}" class="btn btn-lg btn-danger button">{{getPhrase('end_meeting')}}</a>
                            </div>
                            @endif

                        </div>
                        <!--
                        @include('meetings.recordings-video-player', array('content' => $meeting))
                        @if(checkRole(['teacher']))
                        {{ Form::model($meeting,
						array('url' => URL_MEETINGS_EDIT.$meeting->slug,
						'method'=>'patch', 'name'=>'formMeetings ', 'files' => true, 'novalidate'=>'')) }}
                        <input type="hidden" value="recording" >
                        <div  class="row">


    					 <fieldset ng-if="content_type=='url' || content_type=='iframe' || content_type=='video_url'|| content_type=='audio_url'" class="form-group col-md-6">
    							{{ Form::label('file_path', getphrase('resource_link')) }}

    							{{ Form::text('file_path', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Resource URL',
    								'ng-model'=>'file_path',
    								'required'=> 'true',
    								'ng-class'=>'{"has-error": formMeetings.file_path.$touched && formMeetings.file_path.$invalid}',

    						)) }}
    						<div class="validation-error" ng-messages="formMeetings.file_path.$error" >
    	    					{!! getValidationMessage()!!}
    						</div>

    						</fieldset>

    					<fieldset ng-if="content_type=='file' || content_type=='video' || content_type=='audio'" class="form-group col-md-6">
    							{{ Form::label('meetings_file', getphrase('meetings_file')) }}
    							 <input type="file"
    							 class="form-control"
    							 name="meetings_file"  >
    					</fieldset>
                        </div>
                        <div class="buttons text-center">
							<button class="btn btn-lg btn-success button"
							ng-disabled='!formMeetings.$valid'>{{ getphrase('update') }}</button>
						</div>

                        {!! Form::close() !!}

                        @endif
                    -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>





        <script src='https://meet.jit.si/external_api.js'></script>
        <script>

            function startmeeting(){
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
                //api.executeCommand('password', 'The Password');
                api.executeCommand('toggleVideo');
                api.executeCommand('startRecording', {
                    //mode: 'stream', //recording mode, either `file` or `stream`.
                    //dropboxToken: string, //dropbox oauth2 token.
                    //shouldShare: true, //whether the recording should be shared with the participants or not. Only applies to certain jitsi meet deploys.
                    //youtubeStreamKey: '', //the youtube stream key.
                    //youtubeBroadcastID: string //the youtube broacast ID.
                });
                //api.executeCommand('password', 'password');
                //api.executeCommand('avatarUrl', 'http://localhost/totbox/plato-naman-mohit/public/uploads/users/thumbnail/{{Auth::user()->image}}');
            }
            startmeeting();

        </script>
@endsection

@section('footer_scripts')

@stop
