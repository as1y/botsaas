<div class="row">
    <div class="col-xl-3 col-sm-6">
        <div class="card card-body text-center">
            <div class="mb-3">
                <h6 class="font-weight-semibold mb-0 mt-1"><?= $_SESSION['ulogin']['username'] ?></h6>

                <span class="d-block text-muted"><?= rendertypeaccount($_SESSION['ulogin']['role']) ?></span>


            </div>



            <a href="#" class="d-inline-block mb-3">
                <img src="<?=$_SESSION['ulogin']['avatar']?>" class="rounded-round"
                     width="150" height="150" alt="">
            </a>

            <a href="<?=generateprofilelink()?>"  target="_blank" type="button" class=" btn btn-info"><i class="icon-eye mr-2"></i> Посмотреть профиль</a>
            <br>
            <a href="/panel/settings/" type="button" class=" btn btn-warning"><i class="icon-cog5 mr-2"></i> Настройки аккаунта</a>
        <br>



        </div>


        <ul class="list-group  border-top">

            <a href="#" class="list-group-item list-group-item-action">
                <span class="font-weight-semibold">
										<i class="icon-grid mr-2"></i>
										Рейтинг
									</span>
                <span class="badge bg-success ml-auto">0</span>
            </a>


            <a href="#" class="list-group-item list-group-item-action">
									<span class="font-weight-semibold">
										<i class="icon-grid mr-2"></i>
										Всего звонков
									</span>
                <span class="badge bg-success ml-auto">0</span>
            </a>


            <a href="#" class="list-group-item list-group-item-action">
									<span class="font-weight-semibold">
										<i class="icon-grid mr-2"></i>
										Успешных
									</span>
                <span class="badge bg-success ml-auto">0</span>
            </a>


        </ul>


    </div>


    <div class="col-xl-9 col-sm-6">



        <?php if($_SESSION['ulogin']['role'] == "O" && $_SESSION['ulogin']['audio'] == NULL): ?>

        <img width="200" height="200" id="loader" style="display: none;" src="/load.gif">
        <div class="card" id="audiopersend">

            <div class="card-header bg-dark text-white header-elements-inline">
                <h6 class="card-title">АУДИО ПРЕЗЕНТАЦИЯ</h6>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">



                <div class="col-md-6 text-center">

                    <div id="audio"></div>


                    <span id="record" style="display: none;" class="badge badge-warning">ИДЕТ ЗАПИСЬ!<br></span><br>
                    <button type="button" id="start" class="btn btn-success"><i class="icon-mic2 mr-2"></i> НАЧАТЬ ЗАПИСЬ</button>
                    <button type="button" id="stop" style="display: none;" class="btn btn-danger"><i class="icon-mic-off2 mr-2"></i> СТОП</button>


                    <div id="after" style="display: none;" >
                        <hr>
                        <button type="button" id="saverecord" class="btn btn-success"><i class="icon-checkmark mr-2"></i> СОХРАНИТЬ ЗАПИСЬ</button>
                        <a href="/panel/profile/"  class="btn btn-secondary"><i class="icon-reload-alt mr-2"></i> СБРОС</a>
                    </div>

                </div>



                <div class="col-md-6">
                    <span class="badge-secondary">ЗАПИСЬ АУДИО ПРЕЗЕНТАЦИИ</span><br>

                     Расскажите коротко о себе. Эту презентацию будут слушать клиенты и принимать решения о допуске к работе в проектах.<br>




                </div>




                </div>

            </div>

        </div>

        <?php endif;?>



        <?php if ($_SESSION['ulogin']['role'] == "O" && !empty($_SESSION['ulogin']['audio'])):?>

            <div class="card" >

                <div class="card-header bg-dark text-white header-elements-inline">
                    <h6 class="card-title">АУДИО ПРЕЗЕНТАЦИЯ</h6>
                </div>

                <div class="card-body">
                    <div class="row">



                        <div class="col-md-6 text-center">

                            <audio controls src="/<?=AudioUploadPath.$_SESSION['ulogin']['audio']?>"></audio><br>

                           <span class="badge-success">Презентация готова</span><br> Теперь она доступна в вашем профиле.<br>
                        </div>



                        <div class="col-md-6 text-right">


                            <a href="/panel/loadzapis/?action=ClearRecord" type="button" class=" btn btn-danger"><i class="icon-trash mr-2"></i> СТЕРЕТЬ</a>


                        </div>




                    </div>

                </div>

            </div>


        <?php endif;?>


        <!-- Profile info -->
        <div class="card">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h5 class="card-title">РЕДАКТИРОВАТЬ ПРОФИЛЬ</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <b>Адрес публичной страницы вашего профиля:</b>
                <a href="<?=generateprofilelink()?>" target="_blank">https:<?=generateprofilelink()?></a>
                
                <form enctype="multipart/form-data" action="/panel/profile/" method="post" data-fouc>


                    <div class="row">
                        <div class="col-md-6">


                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" disabled value="<?=$_SESSION['ulogin']['email']?>" class="form-control">
                                <span class="form-text text-muted">E-mail возможно изменить только через тикет</span>
                            </div>


                            <div class="form-group">
                            <label>Имя Фамилия<span class="text-danger">*</span></label>
                            <input type="text" name="username" value="<?=$_SESSION['ulogin']['username']?>" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Роль: <span class="text-danger">*</span> </label>
                                <select data-placeholder="Выберете направление" name="role" class="form-control form-control-select2 required" data-fouc>


                                    <option <?= ($_SESSION['ulogin']['role'] == "O") ? 'selected' : ""?> value="O" >Оператор</option>
                                    <option <?= ($_SESSION['ulogin']['role'] == "R") ? 'selected' : ""?> value="R" >Рекламодатель</option>



                                </select>

                            </div>





                        </div>
                        <div class="col-md-6">

                            <label>Аватар</label>
                            <input type="file" accept="image/*" name="file" class="file-input" data-fouc>
                            <span class="form-text text-muted">Для полноценной работе в сервисе необходимо загрузить аватар</span>





                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Моя презентация: </label>
                                <textarea rows="5" cols="5" name="aboutme"  class="form-control required" placeholder="Обо мне"><?=$_SESSION['ulogin']['aboutme']?></textarea>
                                <span class="form-text text-muted">Это описание будут видеть рекламодаели.</span>
                            </div>
                        </div>


                    </div>




                    <div class="text-left">
                        <button type="submit" class=" btn btn-warning"><i class="icon-pencil mr-2"></i> СОХРАНИТЬ
                            ИЗМЕНЕНИЯ
                        </button>
                    </div>


                </form>
            </div>
        </div>
        <!-- /profile info -->
    </div>
</div>

<script>



    $('#start').click(function(){

        $('#start').hide();
        $('#stop').show();
        $('#record').show();


        navigator.mediaDevices.getUserMedia({ audio: true})
            .then(stream => {

                const mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.start();

                var audioChunks = [];
                mediaRecorder.addEventListener("dataavailable",function(event) {
                    audioChunks.push(event.data);
                });


                mediaRecorder.addEventListener("stop", function() {
                    const audioBlob = new Blob(audioChunks, {
                        type: 'audio/wav'
                    });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    var audio = document.createElement('audio');
                    audio.src = audioUrl;
                    audio.controls = true;
                    audio.autoplay = false;
                    document.querySelector('#audio').appendChild(audio);
                    audioChunks = [];



                    //ОТПРАВКА ФАЙЛА AJAX
                    var file = new File([audioBlob], getFileName('mp3'), {
                        type: 'audio/mp3'
                    });
                    // Отправление AJAX запроса

                    mediaRecorder.file = file;
                    // console.log(file);


                });


                $('#stop').click(function(){
                    mediaRecorder.stop();
                    $('#stop').hide();
                    $('#record').hide();
                    $('#after').show();

                });



                $('#saverecord').click(function(){

                    var fd = new FormData;
                    fd.append('file', mediaRecorder.file);
                    $.ajax({
                        url: '/panel/loadzapis',
                        data: fd,
                        beforeSend: funcBefore,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function (data) {

                            console.log(data);
                            $("#audiopersend").show();
                            $("#loader").hide();

                            obj = jQuery.parseJSON( data );
                            if ( obj.message ) { alert( obj.message ); }
                            if ( obj.go ) go( obj.go );



                        }
                    });

                });



            });



    });




    function funcBefore(){
        $("#audiopersend").hide();
        $("#loader").show();
    }




    function getFileName(fileExtension) {
        var d = new Date();
        var year = d.getFullYear();
        var month = d.getMonth();
        var date = d.getDate();
        return 'RecordRTC-' + year + month + date + '-' + getRandomString() + '.' + fileExtension;
    }
    function getRandomString() {
        if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
            var a = window.crypto.getRandomValues(new Uint32Array(3)),
                token = '';
            for (var i = 0, l = a.length; i < l; i++) {
                token += a[i].toString(36);
            }
            return token;
        } else {
            return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
        }
    }




</script>








