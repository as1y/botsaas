
<div class="row">
    <div class="col-md-6">
        
        <div class="card">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h5 class="card-title">ПОДДЕРЖКА ОПЕРАТОРОВ</h5>

            </div>

            <div class="card-body">
                <ul class="media-list media-chat-scrollable mb-3" id="messagelist" style="max-height: 400px">

                    <?php foreach ($chat as $message):?>
                        <?=rendermessage($message);?>
                    <?php endforeach;?>




                </ul>


                <div class="row">
                    <div class="col-md-8">  <input type="text" autocomplete="off" class="form-control mb-3" autofocus placeholder="Введите сообщение" id="messageinput"></div>
                    <div class="col-md-2">

                        <button onclick="sendmessage()" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto">
                            <b><i class="icon-paperplane"></i></b> ОТПРАВИТЬ
                        </button>

                    </div>
                </div>






            </div>



        </div>
    </div>
    <div class="col-md-6">



        <div class="card">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h5 class="card-title">СЕГОДНЯ: МОЯ СТАТИСТИКА</h5>
            </div>
            <div class="card-body">
                <a href="<?=generateprofilelink($user)?>"  target="_blank" class="btn btn-success btn-sm">
                    <i class="icon-user mr-2"></i>
                    МОЙ ПРОФИЛЬ
                </a>
                <div class="table-responsive">
                    <table class="table ">
                        <tbody>
                        <tr>
                            <td class="wmin-md-100"><b>ВСЕГО НАБОРОВ:</b></td>
                            <td class="wmin-md-350">
                                <a href="/operator/calls/"><b><?=$mystat['callscount']?></b></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="wmin-md-100"><b>БОЛЬШЕ 10 СЕКУНД:</b></td>
                            <td class="wmin-md-350">
                                <a href="/operator/calls/"><b><?=$mystat['callsminute']?></b></a>
                            </td>
                        </tr>

                        <tr>
                            <td class="wmin-md-100"><b>НА МОДЕРАЦИИ:</b></td>
                            <td class="wmin-md-350">
                                <a href="/operator/moderate/"><b><?=$mystat['moderate']?></b></a>
                            </td>
                        </tr>

                        <tr>
                            <td class="wmin-md-100"><b>ОДОБРЕНО:</b></td>
                            <td class="wmin-md-350">
                                <a href="/operator/result/"><b><?=$mystat['result']?></b></a>
                            </td>
                        </tr>



                        <tr>
                            <td class="wmin-md-100"><b>БОНУС ЗА 100 звонков:</b></td>
                            <td class="wmin-md-350">

                                <?php if ( $mystat['callsminute']< 15): ?>
                                    <button type="submit"  disabled class="btn btn-success">Получить 200 рублей</button>
                                <?php endif;?>

                                <?php if ( $mystat['callsminute'] > 15): ?>
                                    <form method="post" action="/operator/stat">
                                        <input type="hidden" name="callsminute" value="<?=$mystat['callsminute']?>">
                                        <button type="submit"  class="btn btn-success">Получить 200 рублей</button>
                                    </form>
                                <?php endif;?>



                            </td>
                        </tr>






                        </tbody>
                    </table>

                    Чтобы получить бонус 200 рублей необходимо совершить более 100 звонков!
                </div>


            </div>
        </div>
        <div class="card">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h5 class="card-title">ЛИДЕРЫ СЕГОДНЯ</h5>
            </div>


            <div class="card-body">

                <div class="table-responsive">
                    <table class="table ">
                        <tbody>

                        <tr>
                            <td class="wmin-md-50"><b>
                                    АВАТАР
                            </td>

                            <td class="wmin-md-50">
                                ИМЯ
                            </td>
                            <td class="wmin-md-100">
                                РЕЗУЛЬТАТ
                            </td>
                        </tr>


                        <?php

                        $countresult = [];
                        foreach ($result['all'] as $value){

                            if (empty($countresult[$value['users_id']]))  $countresult[$value['users_id']] = 0;
                            $countresult[$value['users_id']]++;
                        }

                        arsort($countresult);


                        $userinfo = [];
                        foreach ($result['group'] as $value){
                            if (empty($userinfo[$value['users_id']]))  $userinfo[$value['users_id']] = "";
                            $userinfo[$value['users_id']] = $value->users;
                        }



                        foreach ($countresult as $user=>$result):?>

                            <tr>
                                <td class="wmin-md-50"><b>
                                        <img src="<?=$userinfo[$user]['avatar']?>" width="38" height="38" class="rounded-circle" alt="">
                                </td>

                                <td class="wmin-md-50">
                                    <a href="<?=generateprofilelink($userinfo[$user])?>" target="_blank"><b><?=$userinfo[$user]['username']?></b></a>
                                </td>
                                <td class="wmin-md-100">

                                    <?=$result?>


                                </td>
                            </tr>


                        <?php endforeach;?>










                        </tbody>
                    </table>

                </div>


            </div>


        </div>




    </div>

</div>

<script>

    var conn = new WebSocket('wss://chat.cashcall.ru/wss2/:8080');
    conn.onopen = function(e) {
        // console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        rendermessage (e.data);
    };

    conn.onerror = function(e) {

        $("#messagelist").append("<h1 style='color : red'>Ошибка подключения. Попробуйте зайти в чат позднее</h1>");

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

