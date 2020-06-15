
   <div class="row">


       <div class="col-md-6">
           <h4> Submitted</h4>
           <form>
               <ul class="filling-blank answersheet">

                   <li class="blank_correct-answer bg-primary" >{{$user_answers[0]}} </li>

                   <img href="{{$user_answers[1]}}">

               </ul>
           </form>
       </div>


       <div class="col-md-6">
           <h4>Image</h4>
           <form>

               <ul class="filling-blank answersheet">
                   <img class="image img-responsive"  src="{{IMAGE_PATH_UPLOAD_SUBMISSION}}{{$user_answers[1]}}" />

               </ul>
           </form>
       </div>

   </div>
