<div class="row">
    <div class="col-md-6">

        <div class="textarea-hint">
            <fieldset class="form-group">
                <textarea class="{{$question->id}}" class="form-control" name="{{$question->id}}[]" placeholder="Enter Your answer" rows="20"></textarea>
                <div id="resul"></div>
                <button id="button" type="button" name="button">Start Listening</button>
                or press Ctrl button to toggle
            </fieldset>
            <fieldset class="form-group">
                <input type="file" name="description">
            </fieldset>
        </div>

    </div>

</div>

<script>
    window.addEventListener("DOMContentLoaded", () => {
      const button = document.getElementById("button");
      const result = document.getElementById("{{$question->id}}[0]");
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
