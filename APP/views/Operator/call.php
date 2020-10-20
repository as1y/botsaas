<script type="text/javascript">
    var initialized = false,
        loggedIn = false,
        connected = false,
        voxImplant = VoxImplant.getInstance();
    var call = null;
    var timerId = null;
    voxImplant.addEventListener(VoxImplant.Events.SDKReady, handleSDKReady);
    voxImplant.addEventListener(VoxImplant.Events.ConnectionEstablished, handleConnectionEstablished);
    voxImplant.addEventListener(VoxImplant.Events.AuthResult, handleAuthResult);

    function handleSDKReady() {
        voxImplant.connect();
    }
    voxImplant.init({
        micRequired: true
    });

    function handleConnectionEstablished() {
        connected = true;
        $('#call').removeAttr('disabled');
    }

    function handleAuthResult(e) {
        if (e.result) {
            loggedIn = true;
            cont = $("#contactid").val();
            tel = $("#tel").val();
            call = voxImplant.call(tel, false, cont);
            call.on(VoxImplant.CallEvents.Connected, handleCallConnected);
            call.on(VoxImplant.CallEvents.Failed, handleCallFailed);
            call.on(VoxImplant.CallEvents.Disconnected, handleCallDisconnected);
            logMessage("Идет дозвон...");
        } else {
            if (e.code == 302) {
                $.post('/operator/calckey/', {
                    "key": e.key
                }, function(token) {
                    VoxImplant.getInstance().loginWithOneTimeKey("<?=VOXIMPLANTUSER?>", token);
                }, 'text');
            } else {
                logMessage("Authorization failed. Please specify correct username and password");
            }
        }
    }

    function logMessage(msg) {
        $("#log").text(msg);
    }

    function handleCallConnected() {
        timerId = setInterval(function() {
            tm = call.getCallDuration();
            tm = tm / 1000;
            tm = Math.round(tm);
            logMessage("Разговор идет: " + tm + " сек.");
        }, 1000);
        $("#zvonok").val('1'); // Индикатор совершение звонка
    }

    function handleCallFailed(e) {
        if (e.code == "486") {
            logMessage("Абонент бросил трубку. Попробуйте перезвонить позже.");
        }
        if (e.code == "402") {
            logMessage("Что-то пошло не так. Попробуйте через пару минут");
        }
        if (e.code == "408") {
            logMessage("Телефон абонента не доступен (ОТКЛЮЧЕН)");
        }
        if (e.code == "484") {
            logMessage("Телефон абонента не доступен (ОТКЛЮЧЕН)");
        }
        if (e.code != "486" && e.code != "402" && e.code != "408" && e.code != "484") {
            logMessage("Техническая ошибка. Код: " + e.code + " Описание: " + e.reason);
        }
        $("#zvonok").val('1'); // Индикатор совершение звонка
    }

    function handleCallDisconnected() {
        clearInterval(timerId);
        $("#hangup").hide();
        $("#call").show();
        $("#info").prop("class", "badge badge-warning d-block");
        $("#info").text('ЗАПОЛНИТЕ РЕЗУЛЬТАТ ЗВОНКА');
        $("#zvonok").val('1'); // Индикатор совершение звонка
        logMessage("Сборс");
    }

    function GoCall() {
        voxImplant.requestOneTimeLoginKey("<?=VOXIMPLANTUSER?>");
    }
    function han() {
        call.hangup();
    }
    function mute() {
        call.muteMicrophone(); // don't send audio from microphone to the call
    }
    function unmute() {
        call.unmuteMicrophone(); // start sending audio from microphone to the cal
    }
</script>



<img width="200" height="200" id="loader" style="display: none;" src="/load.gif">
<div class="row" id="rw">

    <div class="col-md-8">
        <div class="card border-dark">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h6 class="card-title"><?=$company['company']?></h6>

                <div class="header-elements">
                    <button type="button" data-toggle="modal"  data-target="#modal_aboutcompany" class="btn bg-secondary"><i class="icon-city mr-2"></i> О компании</button>
                    &nbsp;
                    <button type="button" data-toggle="modal"  data-target="#modal_aboutproduct" class="btn bg-secondary"><i class="icon-question3 mr-2"></i> О продукте</button>
                    &nbsp;
                    <button type="button"data-toggle="modal"  data-target="#modal_trebovanie"  class="btn bg-warning"><i class="icon-warning22 mr-2"></i> Требования</button>
                </div>


            </div>


            <table border="1" class="table table-striped  ">
                <thead>
                <tr>
                    <th width="20%"><b>ТЕКУЩИЙ КОНТАКТ</b></th>
                    <th><b>Имя</b></th>
                    <th><b>Компания</b></th>
                    <th><b>Сайт</b></th>
                    <th><b>Комментарий</b></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style='vertical-align: middle' >
                <span class="badge bg-success">
                        <div id="idcontact">#<?=$contactinfo['id']?></div></span>
                    </td>
                    <td style='vertical-align: middle'>
                        <div id="namecont"><?=$contactinfo['name']?></div>
                    </td>

                    <td style='vertical-align: middle'>
                        <div id="company"><?=$contactinfo['namecompany']?></div>
                    </td>
                    <td style='vertical-align: middle'>
                        <div id="siteurl"> <a href="http://<?=$contactinfo['sitename']?> " target="_blank"><?=$contactinfo['sitename']?></a> </div>
                    </td>
                    <td style='vertical-align: middle'>
                        <div id="comment"><?=$contactinfo['comment']?></div>
                    </td>
                </tr>
                </tbody>
            </table>
   
            <div class="card-body">

                <?php show($script) ?>

            </div>


        </div>
    </div>

    <div class="col-md-4" >

<!--       ПАНЕЛЬ ЗВОНКА-->
        <div  class="card border-dark">
            <div class="card-body">


                <div class="badge badge-secondary d-block"  id="info">
                    ПОЗВОНИТЕ ПО КОНТАКТУ
                </div>
                <table class="table  table-bordered text-center">
                    <tr>

                        <td class="wmin-md-100">
                            <button type="button" id="call" disabled class="btn bg-teal-400 btn-labeled btn-labeled-left btn-lg"> <i class="icon-phone-wave"></i> ПОЗВОНИТЬ  </button>

                            <button type="button"  id="hangup" style="display: none;" class="btn bg-danger btn-labeled btn-labeled-left btn-lg"> <i class="icon-phone-slash" ></i> ЗАВЕРШИТЬ  </button>


                        </td>


                    </tr>
                </table>


                <b>ВНИМАНИЕ!:</b>
                Придерживайтесь скрипту и учитываете критерии. Иначе звонок может не пройти модерацию.



            </div>

        </div>
        <!--       ПАНЕЛЬ ЗВОНКА-->


        <!--        ЕСЛИ ПЕРЕЗВОН-->

        <?php  if (!empty($perezvon)):?>
        <div class="card border-dark">
            <div class="card-header bg-danger text-white text-center">
                <h6 class="card-title">ПЕРЕЗВОН ПО КОНТАКТУ</h6>
            </div>
            <b>МОЙ КОММЕНТАРИЙ:</b>
            <i><?=$contactinfo['operatorcomment']?></i>

        </div>
        <?php endif;?>
        <!--        ЕСЛИ ПЕРЕЗВОН-->



        <!--        РЕЗУЛЬТАТ ЗВОНКА-->
        <div class="card border-dark">

            <div class="card-header bg-dark text-white text-center">

                <h6 class="card-title">РЕЗУЛЬТАТ РАЗГОВОРА</h6>

            </div>


            <form id="resultdata" >
                <div class="card-body">
                    <div class="form-group mb-3 mb-md-2">



                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optionresult" value="perezvon" >
                                <span class="badge badge-warning"> ПЕРЕЗВОН</span>
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optionresult" value="otkaz">
                                <span class="badge badge-danger">ОТКАЗ </span>

                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optionresult" value="bezdostupa" >
                                <span class="badge badge-secondary"> ТЕЛЕФОН НЕ ДОСТУПЕН </span>
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" value="result" name="optionresult" >

                                <span class="badge badge-success">


                                 <b><?=companytype($company["type"]);?></b>+<?=$company['priceresult'];?> РУБЛЕЙ


                            </span>

                            </label>
                        </div>

                    </div>
                    <!-- перезвон -->
                    <div id="perez" style="display: none;">

                        <div class="form-group">

                            <label>Дата перезвона<span class="text-danger">*</span></label>

                            <div class="input-group">
										<span class="input-group-prepend">
											<span class="input-group-text">
												<i class="icon-calendar"></i>
											</span>
										</span>
                                <input type="date" name="dataperezvona" class="form-control datepicker" value="<?=date("Y-m-d")?>" placeholder="Дата перезвона">
                            </div>



                        </div>

                        <div class="form-group">
                            <label>На другой номер (если необходимо)<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="nomerperezvona" id="nomerperezvona" value="<?=$contactinfo['tel']?>" class="form-control" >
                            </div>

                        </div>
                    </div>
                    <!-- перезвон  -->
                    <!-- результат -->
                    <div id="result" style="display: none;">
                        <?php renderresultform($company['formresult'])?>
                        <div class="form-group">

                            <label>На другой номер (если необходимо)<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="nomerresult" id="nomerresult" value="<?=$contactinfo['tel']?>" class="form-control" >
                            </div>

                        </div>
                    </div>
                    <!-- результат  -->

                    <p><input type="hidden" name="zvonok" value="0" id="zvonok"></p>
                    <p><input type="hidden" name="contactid" value="<?=$contactinfo['id'];?>" id="contactid" ></p>
                    <p><input type="hidden" value="<?=$contactinfo['tel'];?>" id="tel"></p>


                    <div class="form-group mb-0">
                        <label>Комментарий:</label>
                        <textarea rows="3" cols="3" name="operatorcomment" class="form-control"  placeholder="Комментарий оператора"></textarea>
                    </div>




                </div>
            </form>

            <div class="text-center">

                <button  type="button" id="nextcontact" class="btn bg-success  btn-lg "> <i class="icon-circle-right2 mr2" ></i>  СЛЕДУЮЩИЙ КОНТАКТ  <i class="icon-circle-right2 mr2" ></i></button>

            </div>

            <br>

        </div>
        <!--        РЕЗУЛЬТАТ ЗВОНКА-->




    </div>



</div>




<script>

    //КНОПКА ВЫЗОВА
    $("#call").click(function() {
        $("#call").hide();
        $("#hangup").show();
        $("#info").prop("class", "badge badge-danger d-block");
        $("#info").text('ИДЕТ РАЗГОВОР');
        GoCall();
    });
    //КНОПКА ВЫЗОВА

    //РАЗРЫВ СОЕДИНЕНИЯ
    $("#hangup").click(function() {
        $("#hangup").hide();
        $("#call").show();
        $("#info").prop("class", "bg-yellow bg-font-yellow");
        $("#info").text('ЗАПОЛНИТЕ РЕЗУЛЬТАТ ЗВОНКА');
        han();
    });


    $('[name = "optionresult"]').click(function() { // Клики на результат вызова

       let change = $(this).val();
        $("#perez").hide();
        $("#result").hide();

        if (change == "perezvon") $("#perez").show();
        if (change == "result"){
            $("#perez").hide();
            $("#result").show();
        }

    });

    function funcBefore() {
        $("#rw").hide();
        $("#loader").show();
    }

    $('[id = "nextcontact"]').click(function() {

        let data = $("#resultdata").serialize();

        // alert(data);
        // console.log(data);

        $.ajax({
            url: '/operator/callresult/?id='+<?=$company['id']?>,
            type: 'POST',
            data: data,
            beforeSend: funcBefore,
            cache: false,
            success: function(result) {

                console.log(result);


                obj = jQuery.parseJSON(result);

                if (obj.go) go(obj.go);

                if (obj.message) {
                    $("#rw").show();
                    $("#loader").hide();
                    alert(obj.message);
                }else{


                    document.getElementById('resultdata').reset();
                    $("#zvonok").val('0'); // Индикатор нажатия кнопки
                    $("#info").prop("class", "badge badge-secondary d-block");
                    $("#info").text('ПОЗВОНИТЕ ПО НОВОМУ КОНТАКТУ');
                    //Очищаем всею форму

                    // После прелоадера
                    $("#rw").show();
                    $("#loader").hide();

                    // Скрываем форму результата
                    $("#perez").hide();
                    $("#result").hide();
                    // Скрываем форму результата

                    // После прелоадера

                    $("#dataperezvona").val(<?=date("Y-m-d")?>);


                    // Загрузка таблицы контакт
                    $("#contactid").val(obj.id);
                    $("#idcontact").text('#' + obj.id);
                    $("#namecont").text(obj.namecont);
                    $("#company").text(obj.namecompany);
                    $("#comment").text(obj.comment);
                    $("#siteurl").html('<a href="//' + obj.siteurl + '" target="_blank">' + obj.sitename + '</a>');
                    // Загрузка таблицы контакт

                    //Обновление телефона
                    $("#nomerperezvona").val(obj.tel);
                    $("#nomerresult").val(obj.tel);
                    $("#tel").val(obj.tel);
                    //Обновление телефона



                }




            }
        });


        // swalInit.fire({
        //     title: 'Oops...',
        //     text: 'Something went wrong!',
        //     type: 'error'
        // });



    });


</script>


<div id="modal_aboutcompany" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">О КОМПАНИИ</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <h6 class="font-weight-semibold"> <?=$company['company']?></h6>
                <?=$company['aboutcompany']?>
            </div>





        </div>
    </div>
</div>

<div id="modal_aboutproduct" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">О ПРОДУКТЕ</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <h6 class="font-weight-semibold"> <?=$company['nameproduct']?></h6>
                <?=$company['aboutproduct']?>
            </div>





        </div>
    </div>
</div>

<div id="modal_trebovanie" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ТРЕБОВАНИЯ К РЕЗУЛЬТАТУ</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <h6 class="font-weight-semibold"> Критерий приема лида клиентом</h6>
                <?=$company['trebovanie']?>
            </div>





        </div>
    </div>
</div>