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
                                <textarea id="result"></textarea>
                                <div id="resul"></div>
                                <button id="button" type="button" name="button">Start Listening</button>
                                or press Ctrl button to toggle
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

        <script>
            window.addEventListener("DOMContentLoaded", () => {
              const button = document.getElementById("button");
              const result = document.getElementById("result");
              //const main = document.getElementsByTagName("main")[0];
              const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition
              if (typeof SpeechRecognition === "undefined") {
                button.remove();
                const message = document.getElementById("message");
                message.removeAttribute("hidden");
                message.setAttribute("aria-hidden", "false");
              } else {
                  let listening = false;
                  var buffer = "";
                  const recognition =  new webkitSpeechRecognition() ;
                  const start = () => {
                      recognition.start();
                      button.textContent = "Stop listening";
                      //main.classList.add("speaking");
                      buffer=result.value+" ";
                  };
                  const stop = () => {
                      recognition.stop();
                      button.textContent = "Start listening";
                      //main.classList.remove("speaking");
                      buffer=result.value+" ";
                  };
                  const onResult = event => {
                      result.value = '';
                      result.value = buffer;
                      for (const res of event.results) {
                        var text =  res[0].transcript;
                        if (res.isFinal) {
                            ;//buffer=result.value;
                        }
                        result.value+=text;

                      }
                  };
                  recognition.continuous = true;
                  recognition.interimResults = true;
                  recognition.addEventListener("result", onResult);
                  document.addEventListener('keyup', event => {
                      if (event.key === 'Control') {
                          listening ? stop() : start();
                          listening = !listening;
                      }
                  });
                  button.addEventListener("click", () => {
                    listening ? stop() : start();
                    listening = !listening;
                  });
              }
            });
        </script>





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
            api.executeCommand('toggleVideo');
            api.executeCommand('startRecording', {
                mode: 'stream', //recording mode, either `file` or `stream`.
                //dropboxToken: string, //dropbox oauth2 token.
                shouldShare: true, //whether the recording should be shared with the participants or not. Only applies to certain jitsi meet deploys.
                youtubeStreamKey: 'rd6k-ck2r-rt5b-yxbp-bx4r', //the youtube stream key.
                //youtubeBroadcastID: string //the youtube broacast ID.
            });
            //api.executeCommand('password', 'password');
            //api.executeCommand('avatarUrl', 'http://localhost/totbox/plato-naman-mohit/public/uploads/users/thumbnail/{{Auth::user()->image}}');
        </script>
@endsection

@section('footer_scripts')

@stop
