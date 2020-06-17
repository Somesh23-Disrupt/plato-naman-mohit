<div class="row">
    <div class="col-md-6">

        <div class="textarea-hint">
            <fieldset class="form-group">
                <textarea class="{{$question->id}}" class="form-control" name="{{$question->id}}[0]" placeholder="Enter Your answer" rows="20"></textarea>
                <button class="{{$question->id}}-button" type="button" name="button"><i class="fa fa-microphone" aria-hidden="true"></i></button>

            </fieldset>
            <fieldset class="form-group">
                <input type="file" name="{{$question->id}}[1]">
            </fieldset>
        </div>

    </div>

</div>

<script>
    window.addEventListener("DOMContentLoaded", () => {

      const button_next = document.getElementsByClassName("next")[0];
      const button_prev = document.getElementsByClassName("prev")[0];
      const button_review = document.getElementsByClassName("review")[0];
      const button = document.getElementsByClassName("{{$question->id}}-button")[0];
      const result = document.getElementsByClassName("{{$question->id}}")[0];

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
              button.classList.add('btn-danger');
              console.log(button);
              buffer=result.value+" ";
          };
          const stop = () => {
              recognition.stop();
              button.classList.remove('btn-danger');
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
          button.addEventListener("click", () => {
            listening ? stop() : start();
            listening = !listening;
          });
          button_next.addEventListener("click", () => {
            stop();
            listening = false;
          });
          button_prev.addEventListener("click", () => {
            stop();
            listening = false;
          });
          button_review.addEventListener("click", () => {
            stop();
            listening = false;
          });
      }
    });
</script>
