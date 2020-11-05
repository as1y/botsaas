
<?php
if (empty($company)) {
    $company = [];
    ?>

    <div class="row">

        <div class="col-md-12">
            <div class="alert alert-info alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <span class="font-weight-semibold">Что-то не получается?</span> Обратитесь в раздел <a href="/panel/faqpromo/" target="_blank" class="alert-link">Помощь</a>
            </div>

            <div class="card">
                <div class="card-header bg-dark text-white header-elements-inline">
                    <h5 class="card-title">МОИ ПРОЕКТЫ</h5>

                </div>

                <div class="card-body">
                    Список пуст

                </div>



            </div>



        </div>




    </div>




<?php
}




?>


<?php foreach ($company as $row): ?>

    <div class="col-lg-12">


        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h6 class="card-title">Проект: <b><?=$row['company']?></b></h6>


                <div class="header-elements">
                    <div class="list-icons">
                        <div class="dropdown">
                            <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu7"></i></a>
                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(33px, 19px, 0px);">
                                <a href="/panel/edit/?id=<?=$row['id']?>" class="dropdown-item">Редактировать</a>
                                <a href="/panel/delete/?id=<?=$row['id']?>" class="dropdown-item">Удалить</a>
                            </div>
                        </div>
                    </div>
                </div>



            </div>



            <div class="card-body justify-content-center text-center-end">

                <div class="row">

                    <div class="col-md-2 align-self-center text-center">
                        <img class="card-img-top" src="<?=$row['logo']?>" width="25" alt="">
                        <b><?=$row['company']?></b>

                    </div>




                    <div class="col-md-6">

                        <?php
                        $todaycall = \APP\core\base\Model::contact($row['id'])['today'];
                        $todayresult = \APP\core\base\Model::getres($row['id'])['today'];
                        ?>


                        <div class="row text-center">
                            <div class="col-4">
                                <p><i class="icon-phone2 icon-2x d-inline-block text-indigo-400"></i></p>
                                <h5 class="font-weight-semibold mb-0"><?=$todaycall?></h5>
                                <span class="text-muted font-size-sm">Звонков сегодня</span>
                            </div>

                            <div class="col-4">
                                <p><i class="icon-target2 icon-2x d-inline-block text-success-400"></i></p>
                                <h5 class="font-weight-semibold mb-0"><?=$todayresult?></h5>
                                <span class="text-muted font-size-sm">Успешных сегодня</span>
                            </div>

                            <div class="col-4">
                                <p><i class="icon-percent icon-2x d-inline-block text-warning-400"></i></p>
                                <h5 class="font-weight-semibold mb-0"><?=getconversion($todayresult, $todaycall);?></h5>
                                <span class="text-muted font-size-sm">Конверсия сегодня</span>
                            </div>
                        </div>

                        <br>
                        <ul class="list-group list-group-flush border-top">

                            <a href="/project/result/?id=<?=$row['id']?>" class="list-group-item list-group-item-action">
									<span class="font-weight-semibold">
										<i class="icon-grid mr-2"></i>
										Новых звонков на одобрение
									</span>

                                <?php $countresult =  \APP\models\Master::countresultid($row['id']);?>

                                <?php if($countresult > 0):?>
                                    <span class="badge bg-warning ml-auto"><?=$countresult?></span>
                                <?php endif;?>

                                <?php if($countresult == 0):?>
                                    <span class="badge bg-success ml-auto">0</span>
                                <?php endif;?>




                            </a>




                            <a href="/project/operator/?id=<?=$row['id']?>" class="list-group-item list-group-item-action">
									<span class="font-weight-semibold">
										<i class="icon-grid mr-2"></i>
										Новых операторов на одобрение
									</span>


                                <?php
                                    $countnew = countoperators($row, "new");
                                ?>

                                <?php if($countnew > 0):?>
                                    <span class="badge bg-warning ml-auto"><?=$countnew?></span>
                                <?php endif;?>

                                <?php if($countnew == 0):?>
                                    <span class="badge bg-success ml-auto">0</span>
                                <?php endif;?>







                            </a>


                            <a href="/project/operator/?id=<?=$row['id']?>" class="list-group-item list-group-item-action">
									<span class="font-weight-semibold">
										<i class="icon-grid mr-2"></i>
										Операторов на проекте
									</span>
                                <span class="badge bg-success ml-auto"><?=countoperators($row, "all")?></span>
                            </a>


                        </ul>







                    </div>


                    <div class="col-md-2 text-center align-self-center">


                    <?php if ($row['status'] == 2): ?>
                        <i class="icon-cross2 icon-2x text-danger border-danger border-3 rounded-round p-3 mb-3"></i>
                        <h5 class="card-title">НЕ РАБОТАЕТ</h5>
                    <?endif;?>

                        <?php if ($row['status'] == 1): ?>
                            <i class="icon-play4 icon-2x text-success border-success border-3 rounded-round p-3 mb-3"></i>
                            <h5 class="card-title">АКТИВЕН</h5>
                        <?endif;?>




                    </div>


                    <div class="col-md-2 text-center align-self-center">


                        <div>
                            <a href="/project/?id=<?=$row['id']?>" class="btn bg-success-300"><i class="icon-cog2 mr-2"></i> УПРАВЛЕНИЕ</a>
                        </div>


                    </div>


                </div>




            </div>
        </div>


    </div>




<?php endforeach;?>



