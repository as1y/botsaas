<div class="wrapper image-wrapper bg-image page-title-wrapper inverse-text" data-image-src="/assets_landing/images/art/bg3.jpg">
    <div class="container inner text-center">
        <div class="space50"></div>
        <h1 class="page-title"><?=APPNAME?></h1>
        <p class="lead">Сервис и биржа удаленных операторов на телефоне</p>
    </div>
    <!-- /.container -->
</div>



<!-- /.wrapper -->
<section id="new">
<div class="wrapper light-wrapper">
    <div class="container inner">
        <h2 class="section-title mb-40 text-center">НОВЫЕ ОПЕРАТОРЫ</h2>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead class="thead-dark text-center">
                    <tr>
                        <th scope="col">Имя Фамилия</th>
                        <th scope="col">Резюме</th>
                        <th scope="col">Рейтинг</th>
                        <th scope="col">Аудио</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php
                    foreach ($operators as $key=>$val):?>

                        <tr>
                            <td> <img src="<?=$val['avatar']?>" width="38" height="38" class="rounded-circle" alt="">

                                <a href="<?=generateprofilelink($val)?>" target="_blank " ><b><?=$val['username']?></b></a>


                            </td>
                            <td width="40%"><?=obrezanie($val['aboutme'], 200)?></td>
                            <td><?= (empty($val['totalcall'])) ? 0 : $val['totalcall']  ?></td>
                            <td class="text-center">

                                <?php if($val['audio'] != NULL): ?>
                                    <audio controls="" src="/<?=AudioUploadPath.$val['audio']?>"></audio>
                                <?php endif;?>

                                <?php if($val['audio'] == NULL): ?>
                                    Не заполнил
                                <?php endif;?>


                            </td>
                        </tr>

                    <?php  endforeach;?>




                    </tbody>



                </table>




            </div>
            <!-- /column -->
        </div>
        <h3>ОПЕРАТОРОВ ВСЕГО: <?=\APP\models\Panel::countoperator()?></h3>
    </div>
    <!-- /.container -->
</div>
</section>
<div class="wrapper light-wrapper">
    <div class="box shadow p-60 image-wrapper bg-full bg-image inverse-text rounded d-md-flex align-items-md-center justify-content-center" data-image-src="/assets_landing/images/art/bg2.jpg" style="background-image: url(&quot;assets_landing/images/art/bg6.jpg&quot;);">
        <div class="row text-center justify-content-center">
            <h3 class="display-3 text-center mb-0">Начните работу с системой прямо сейчас</h3>
            <div class="space10"></div>
            <a href="/user/register" class="btn btn-white btn-strong-hover mb-0">РЕГИСТРАЦИЯ</a>
        </div>
    </div>
</div>
<section id="for">
    <div class="wrapper white-wrapper">
        <div class="container inner">
            <div class="row  row align-items-center  justify-content-center">
                <div class="col-md-4">
                    <h4>УДАЛЕННЫМ ОПЕРАТОРАМ</h4>
                    <ul class="unordered-list bullet-green">
                        <li>Для работы требуется интернет браузер и доступ в интернет.</li>
                        <li>Широкий выбор предложений о работе в различных сферах(тематический рубрикатор).</li>
                        <li>Стабильная оплата</li>
                    </ul>
                    <figure class="mb-30"><img src="#" srcset="assets_landing/images/concept/concept14.png 1x, assets_landing/images/concept/concept14@2x.png 2x" alt=""></figure>


                </div>
                <!--/column -->
                <div class="col-md-2">

                </div>
                <div class="space20 d-md-none"></div>
                <div class="col-md-4">
                    <h4>РЕКЛАМОДАТЕЛЯМ</h4>
                    <ul class="unordered-list bullet-green">
                        <li>Возможность быстро создать проект с оплатой по факту совершенного действия.</li>
                        <li>Широкий выбор удаленных операторов.</li>
                        <li>Прямое общение с операторами.</li>
                        <li>Быстрое масштабирование проекта.</li>
                        <li>Самостоятельное управление проектом на всех этапах.</li>
                    </ul>
                    <figure class="mb-30"><img src="#" srcset="assets_landing/images/concept/concept19.png 1x, assets_landing/images/concept/concept19@2x.png 2x" alt=""></figure>



                </div>

            </div>

        </div>
        <!-- /.container -->
    </div>

</section>




<section id="howitworks">
<div class="wrapper gray-wrapper">
    <div class="container">
        <div class="space30"></div>
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2">
                <figure>               <img src="#" srcset="/assets_landing/images/concept/concept13.png 1x, assets_landing/images/concept/concept13@2x.png 2x" alt=""></figure>
            </div>
            <!--/column -->
            <div class="space20 d-md-none"></div>
            <div class="space50 d-none d-md-block d-lg-none"></div>


            <div class="col-lg-6 pr-60 pr-md-15">
                <h3 class="display-3">Как это работает?</h3>
                <div class="space30"></div>


                <div class="d-flex flex-row justify-content-center">


                    <div class="col-md-3">
                        <div class="icon icon-svg mb-20"><img src="/assets_landing/images/icons/ui-user.png" alt=""></div>
                    </div>


                    <div>
                        <h5>Операторы подают заявки в проект</h5>
                        <p class="mb-0">Нужно заполнить свой профиль и отправить на рассмотрение рекламодателю.</p>
                    </div>
                </div>
                <div class="space30"></div>
                <div class="d-flex flex-row justify-content-center">

                    <div class="col-md-3">
                        <div class="icon icon-svg mb-20"><img src="/assets_landing/images/icons/hs-support-5.png" alt=""></div>
                    </div>


                    <div>
                        <h5>Операторы совершают звонки</h5>
                        <p class="mb-0">Для совершения звонков требуется интернет браузер и доступ в интернет.</p>
                    </div>
                </div>

                <div class="space30"></div>
                <div class="d-flex flex-row justify-content-center">

                    <div class="col-md-3 ">
                        <div class="icon icon-svg mb-20"><img src="/assets_landing/images/icons/hs-check.png" alt=""></div>
                    </div>

                    <div>
                        <h5>Успешный звонок</h5>
                        <p class="mb-0">Оператор совершил успешный звонок. Заинтереосвал клиента в продукте.</p>
                    </div>
                </div>

                <div class="space30"></div>
                <div class="d-flex flex-row justify-content-center">


                    <div class="col-md-3">
                        <div class="icon icon-svg mb-20"><img src="/assets_landing/images/icons/ui-chat.png" alt=""></div>
                    </div>


                    <div>
                        <h5><b>Рекламодатель проверяет звонок</b> </h5>
                        <p>Рекламодатель присваивает статус (отклонен, подтвержден, доработка).<br> Если статус подтвержден оператору поступает оплата.
                        </p>
                    </div>
                </div>



            </div>



            <!--/column -->
        </div>
        <!--/.row -->
        <div class="space160"></div>
    </div>
    <!-- /.container -->
</div>
</section>
<!-- /.wrapper -->



