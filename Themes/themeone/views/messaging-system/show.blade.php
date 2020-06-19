@extends($layout)
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
                            <li><a href="{{URL_MESSAGES}}">Messages</a> </li>
                            <li class="active"> {{ $title }} </li>
                        </ol>
                    </div>
                </div>
<!-- <h1>Create a new message</h1> -->
 <div class="row">
                    <div class="col-md-7 col-sm-12">
<div class="panel panel-custom">
                    <div class="panel-heading">
                        <h1>{{ ucfirst($thread->subject) }}</h1>
                    </div>
    <div id="historybox" class="panel-body packages inbox-messages-replay">
        <div class="row library-items">
            <div id="msgbox" class="col-md-12">

                <?php $current_user = Auth::user()->id; ?>
                @foreach($thread->messages as $message)
                    <?php $class='message-sender';
                    if($message->user_id == $current_user)
                    {
                        $class = 'message-receiver';
                    }


                    ?>
                    <div class="{{$class}}">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img src="{{getProfilePath($message->user->image)}}" alt="{!! $message->user->name !!}" class="img-circle">
                            </a>
                            <div class="media-body">
                                <h5 class="media-heading"><b>{!! $message->user->name !!}</b></h5>
                                <p>{!! $message->body !!}</p>
                                <div class="text-muted pull-right"><small>{!! $message->created_at !!}</small></div>
                            </div>
                        </div>
                    </div>
                @endforeach
                    <div id ="msg">
                    </div>

            </div>
        </div>
    </div>
    <button onclick="getMessage()">get</button>

    <div class="reply-block">
            <div class="row">
                <div class="col-sm-10">
                    {!! Form::textarea('message', null, ['class' => 'form-control' , 'id' => 'send-message' ]) !!}
                </div>
                <div class="col-sm-2">
                    <button onclick="postMessage()" class = 'btn btn-primary btn-lg btn-width'>Send</button>
                </div>
            </div>
    </div>


</div>
</div>
</div>
</div>

@stop

@section('footer_scripts')
<script>
 $('#historybox').scrollTop($('#historybox')[0].scrollHeight);
</script>

    <script>
        //setInterval("getMessage()", 5000);
         function getMessage() {
            $.ajax({
               type:'GET',
               url:'getmsg/'+'{{$thread->id}}',
               data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                   var new_msg = data.msg;
                   if(new_msg!=""){
                       document.getElementById("msgbox").innerHTML+=new_msg;
                       //$("#msgbox").html(data.msg);
                       $('#historybox').scrollTop($('#historybox')[0].scrollHeight);
                   }

               }
            });
         }

         function postMessage() {
            var msg=document.getElementById('send-message').value;
            $.ajax({
               type:'POST',
               url:'update/'+'{{$thread->id}}',
               data: {
                    '_token' : '<?php echo csrf_token() ?>',
                    'message' : msg
                },
               success:function(data) {
                  //$("#msg").html(data.msg);
                  console.log(data.msg);
               }
            });
         }
    </script>

@stop
