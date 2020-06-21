@extends($layout)
@section('content')
<div id="page-wrapper"  >
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
                            <li><a href="{{URL_MESSAGES}}">Messages</a> </li>
                            <li class="active"> {{ ucfirst($thread->subject) }} </li>
                        </ol>
                    </div>
                </div>
<!-- <h1>Create a new message</h1> -->
 <div class="row" >
                    <div class="col-md-7 col-sm-12">
<div class="panel panel-custom"  >
                    <div class="panel-heading">
                        <h1>{{ ucfirst($thread->subject) }}</h1>
                    </div>
    <div id="historybox" style="height: calc(80vh - 180px); overflow-y: auto;" class="panel-body packages inbox-messages-replay">
        <div class="row library-items">
            <div id="msgbox" class="col-md-12  pt-0">

                <?php $current_user = Auth::user()->id;
                        session()->put('currentcount',$thread->messages->count());
                 ?>
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
                                <img class="img-circle" style="width:45px" src="{{getProfilePath($message->user->image)}}" alt="{!! $message->user->name !!}" >
                            </a>
                            <div class="img-rounded  media-body" style="padding-top: 12px;padding-bottom:  0px;">
                                <h5 class="media-heading"><b>{!! $message->user->name !!}</b>
                                        <small class="  text-muted" ><i>{!! $message->created_at->diffForHumans() !!}</i></small>
                                </h5>
                                <p>{!! $message->body !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>

    <div class="reply-block">
            <div class="row">
                <div class="col-xs-8 col-sm-9">
                    <textarea name="message" class="form-control" id="send-message" ></textarea>
                </div>
                <div class="col-xs-2 col-sm-2">
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
        setInterval("getMessage()", 1000);
         function getMessage() {
            $.ajax({
               type:'GET',
               url:'getmsg/'+'{{$thread->id}}',
               data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                   var new_msg = data.msg;
                   if(new_msg!=""){
                       document.getElementById("msgbox").innerHTML=new_msg;
                       //console.log(data.msg);
                       $('#historybox').scrollTop($('#historybox')[0].scrollHeight);
                   }

               }
            });
         }

         function postMessage() {
            var msg=document.getElementById('send-message').value;
            if(msg!=""){
                document.getElementById('send-message').value="";
                $.ajax({
                   type:'POST',
                   url:'update/'+'{{$thread->id}}',
                   data: {
                        '_token' : '<?php echo csrf_token() ?>',
                        'message' : msg
                    },
                   success:function(data) {
                      //$("#msg").html(data.msg);
                      document.getElementById('send-message').value="";
                      console.log(data.msg);
                   }
                });
            }
         }
    </script>

@stop
