<div class="row">

    <div class="col-md-12">

        <div class="card">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h5 class="card-title">ОБЩИЙ ЧАТ ОПЕРАТОРОВ</h5>

            </div>

            <div class="card-body">
                <ul class="media-list media-chat-scrollable mb-3" id="messagelist" style="max-height: 400px">

                    <?php foreach ($chat as $message):?>
                        <?=rendermessage($message);?>
                    <?php endforeach;?>




                </ul>


                <div class="row">
                    <div class="col-md-10">  <input type="text" autocomplete="off" class="form-control mb-3" autofocus placeholder="Введите сообщение" id="messageinput"></div>
                    <div class="col-md-2">

                        <button onclick="sendmessage()" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto">
                            <b><i class="icon-paperplane"></i></b> ОТПРАВИТЬ
                        </button>

                    </div>
                </div>






            </div>



        </div>


    </div>




</div>






<script>

    var conn = new WebSocket('wss://chat.cashcall.ru/wss2/:8080');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        rendermessage (e.data);
    };

    conn.onerror = function(e) {

        $("#messagelist").append("<h1 style='color : red'>Ошибка подключения. Перезагрузите страницу</h1>");

    };



    var div = $("#messagelist");
    div.scrollTop(div.prop('scrollHeight'));



    function rendermessage(data){

        str =  '&data=' + data + '&type=render';

        $.ajax(
            {
                url : '/panel/chat/',
                type: 'POST',
                data: str,
                cache: false,
                success: function(result ) {

                    $("#messagelist").append(result);
                    div.scrollTop(div.prop('scrollHeight'));

                }
            }
        );


    }







    $("#messageinput").keydown(function(e) {
        if(e.keyCode === 13) {
            sendmessage();
        }
    });

    function sendmessage() {

        var message = $("#messageinput").val();
        $("#messageinput").val("");

        str =  '&message=' + message + '&room=1';

        $.ajax(
            {
                url : '/panel/chat/',
                type: 'POST',
                data: str,
                cache: false,
                success: function(result ) {
                    conn.send(result);

                }
            }
        );



       // conn.send(JSON.stringify(data));

    }




</script>



