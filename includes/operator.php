<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md align-self-start">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content nav-item-divider">
        <div class="card card-sidebar-mobile">


            <!-- User menu -->
            <div class="sidebar-user">
                <div class="card-body">
                    <div class="media">
                        <div class="mr-3">
                            <a href="/panel/profile/"><img src="<?=$_SESSION['ulogin']['avatar']?>" width="38" height="38" class="rounded-circle" alt=""></a>
                        </div>

                        <div class="media-body">
                            <div class="media-title font-weight-semibold"><?=$_SESSION['ulogin']['username']?></div>
                            <div class="font-size-xs opacity-50">
                                <i class="fa fa-user font-size-sm"></i> <?=rendertypeaccount($_SESSION['ulogin']['role'])?>
                            </div>
                        </div>

                        <div class="ml-3 align-self-center">
                            <a href="/panel/profile/" class="text-white"><i class="icon-cog3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /user menu -->

            <?php
            $active[$this->route['action']] = 'active';
            ?>


            <!-- Main navigation -->
            <div class="card-body p-0">
                <ul class="nav nav-sidebar" data-nav-type="accordion">


                    <li class="nav-item">
                        <a href="/operator/stat" class="nav-link <?=isset($active['stat']) ? $active['stat'] : ''; ?>">
                            <i class="icon-stats-bars2"></i>
                            <span>	Статистика </span>
                        </a>
                    </li>

                    <?php
                    $myproject = \APP\core\base\Model::myproject();


                    ?>

                    <li class="nav-item">
                        <a href="/operator/" class="nav-link <?=isset($active['index']) ? $active['index'] : ''; ?>">
                            <i class="icon-briefcase3"></i>
                            <span>	Мои проекты </span>
                            <span class="badge badge-pill bg-secondary ml-auto"><?=$myproject['my']?></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/operator/all/" class="nav-link <?=isset($active['all']) ? $active['all'] : ''; ?>">
                            <i class="icon-star-full2"></i>
                            <span>	Каталог проектов </span>
                            <span class="badge badge-pill bg-secondary ml-auto"><?=$myproject['all']?></span>
                        </a>
                    </li>



                    <?php
                    $contact = \APP\core\base\Model::contact($_SESSION['ulogin']['id'], "user");
                    $result = \APP\core\base\Model::getres($_SESSION['ulogin']['id'], "user");

                    ?>


                    <!-- /main -->
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-sm line-height-sm">РЕЗУЛЬТАТЫ</div>
                    </li>

                    <li class="nav-item">
                        <a href="/operator/calls/" class="nav-link <?=isset($active['calls']) ? $active['calls'] : ''; ?>">
                            <i class="icon-phone2"></i>
                            <span>	Звонки сегодня </span>
<!--                            <span class="badge badge-pill bg-secondary ml-auto">--><?//=$contact['today']?><!--</span>-->
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="/operator/perezvon/" class="nav-link <?=isset($active['perezvon']) ? $active['perezvon'] : ''; ?>">
                            <i class="icon-calendar"></i>
                            <span>	Перезвон </span>
                            <span class="badge badge-pill bg-secondary ml-auto"><?=$contact['perezvon']?></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/operator/moderate/" class="nav-link <?=isset($active['moderate']) ? $active['moderate'] : ''; ?>">
                            <i class="icon-eye"></i>
                            <span>	На модерации </span>
                            <span class="badge badge-pill bg-secondary ml-auto"><?=$contact['moderate']?></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/operator/dorabotka/" class="nav-link <?=isset($active['dorabotka']) ? $active['dorabotka'] : ''; ?>">
                            <i class="icon-wrench"></i>
                            <span>	Доработка </span>

                            <span class="badge badge-pill bg-warning ml-auto"><?=$contact['dorabotka']?></span>

                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/operator/reject/" class="nav-link <?=isset($active['reject']) ? $active['reject'] : ''; ?>">
                            <i class="icon-stop"></i>
                            <span>	Отклоненные </span>
                            <span class="badge badge-pill bg-danger ml-auto"><?=$contact['reject']?></span>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a href="/operator/success/" class="nav-link <?=isset($active['success']) ? $active['success'] : ''; ?>">
                            <i class="icon-checkmark"></i>
                            <span>	Успешно </span>
                            <span class="badge badge-pill bg-success ml-auto"><?=$result['all']?></span>
                        </a>
                    </li>


<!--                    <li class="nav-item-header">-->
<!--                        <div class="text-uppercase font-size-sm line-height-sm">ТОП ОПЕРАТОРЫ</div>-->
<!--                    </li>-->
<!---->
<!--                    <li class="nav-item">-->
<!--                        <a href="/panel/operator/" class="nav-link --><?//=isset($active['operator']) ? $active['operator'] : ''; ?><!--" >-->
<!--                            <i class="icon-users4"></i>-->
<!--                            <span>	Операторы </span>-->
<!--                            <span class="badge badge-pill bg-secondary ml-auto">--><?//=\APP\core\base\Model::countoperator()?><!--</span>-->
<!---->
<!--                        </a>-->
<!--                    </li>-->




                </ul>
            </div>
            <!-- /main navigation -->

        </div>
    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->