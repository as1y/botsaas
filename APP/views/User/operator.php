<div class="col-md-12">

    <div class="row">

        <div class="col-xl-3 col-sm-6">
            <div class="card card-body text-center">
                <div class="mb-3">
                    <h6 class="font-weight-semibold mb-0 mt-1"><?=$userinfo['username'] ?></h6>

                    <span class="d-block text-muted"><?= rendertypeaccount($userinfo['role']) ?></span>


                </div>



                <a href="#" class="d-inline-block mb-3">
                    <img src="<?=$userinfo['avatar']?>" class="rounded-round"
                         width="150" height="150" alt="">
                </a>

                <a href="/panel/messages/?newdialog=<?=$userinfo['id']?>"  class=" btn btn-success"><i class="icon-bubbles5 mr-2"></i> ОТПРАВИТЬ СООБЩЕНИЕ</a>
                <br>
<!--                <a href="#" type="button" class=" btn btn-warning"><i class="icon-book mr-2"></i> ПРЕДЛОЖИТЬ ПРОЕКТ</a>-->

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
                    <span class="badge bg-success ml-auto"><?=$userinfo['totalcall'] ?></span>
                </a>


                <a href="#" class="list-group-item list-group-item-action">
									<span class="font-weight-semibold">
										<i class="icon-grid mr-2"></i>
										Успешных
									</span>
                    <span class="badge bg-success ml-auto"><?=$userinfo['totalresult'] ?></span>
                </a>


            </ul>


        </div>
        <div class="col-xl-6 col-sm-6">
            <div class="card">

                <div class="card-header bg-dark text-white header-elements-inline">
                    <h6 class="card-title">ИНФОРМАЦИЯ</h6>
                </div>
                <div class="card-body">
                    <?=$userinfo['aboutme']?>
                </div>

            </div>

            <div class="card">

                <div class="card-header bg-dark text-white header-elements-inline">
                    <h6 class="card-title">ОТЗЫВЫ</h6>
                </div>
                <div class="card-body">
                    Отзывов пока нет
                </div>

            </div>

        </div>

        <div class="col-xl-3 col-sm-6">


            <div class="card">

                <div class="card-header bg-info text-white header-elements-inline">
                    <h6 class="card-title">АУДИО ПРЕЗЕНТАЦИЯ</h6>
                </div>
                <div class="card-body">
                    <audio controls="" src="/<?=AudioUploadPath.$userinfo['audio']?>"></audio>

                </div>

            </div>


        </div>


    </div>








</div>