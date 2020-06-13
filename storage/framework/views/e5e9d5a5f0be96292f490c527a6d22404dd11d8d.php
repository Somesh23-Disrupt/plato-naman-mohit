<?php $__env->startSection('header_scripts'); ?>
<link href="<?php echo e(CSS); ?>ajax-datatables.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>
                            <li><a href="<?php echo e(URL_MEETINGS); ?>"><?php echo e(getPhrase('meetings')); ?></a></li>
                            <li><?php echo e($meeting->title); ?></li>
                        </ol>
                    </div>
                </div>

		<div class="panel panel-custom col-lg-10 col-lg-offset-1" >
                    
                    <div class="panel-body">
                        <div class="meeting-details">
                            <div class="meeting-title text-center">
                                <h2><?php echo e($meeting->title); ?></h2></div>
                            <div class="meeting-content text-center">
                                <?php echo $meeting->description; ?>

                                <textarea id="result"></textarea>
                                <div id="resul"></div>
                                <button id="button" type="button" name="button">Start Listening</button>
                                or press Ctrl button to toggle
                            </div>
                            <div id="meet" class="meeting-footer text-center"></div>
                            <?php if($meeting->slug): ?>
                            <div class="meeting-footer text-center">
                                <a type="button" href="<?php echo e(URL_MEETINGS); ?>" class="btn btn-lg btn-danger button"><?php echo e(getPhrase('END_meeting')); ?></a>
                            </div>
                            <?php endif; ?>

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
                roomName: '<?php echo e($meeting->slug); ?>',
                userInfo: {
                        email: '<?php echo e(Auth::user()->email); ?>',
                        displayName: '<?php echo e(Auth::user()->name); ?>'

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
            //api.executeCommand('avatarUrl', 'http://localhost/totbox/plato-naman-mohit/public/uploads/users/thumbnail/<?php echo e(Auth::user()->image); ?>');
        </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>