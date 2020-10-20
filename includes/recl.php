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


                            <div class="media-title font-weight-semibold"> <?=$_SESSION['ulogin']['username']?> </div>
                            <div class="font-size-xs opacity-50">
                                <i class="fa fa-user font-size-sm"></i> <?=rendertypeaccount($_SESSION['ulogin']['role'])?>
                            </div>


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


                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-sm line-height-sm">МОИ ПРОЕКТЫ</div>
                    </li>


                    <?php if ($_SESSION['ulogin']['email'] == "raskrutkaweb@yandex.ru"): ?>
                    <li class="nav-item">
                        <a href="/panel/payout/" class="nav-link <?=isset($active['payout']) ? $active['payout'] : ''; ?>">
                            <i class="icon-coin-dollar"></i>
                            <span>	Выводы </span>
                        </a>
                    </li>
                <?php endif;?>


                    <?php if ($_SESSION['ulogin']['email'] == "raskrutkaweb@yandex.ru"): ?>
                        <li class="nav-item">
                            <a href="/panel/newoperators/" class="nav-link <?=isset($active['newoperators']) ? $active['newoperators'] : ''; ?>">
                                <i class="icon-user-plus"></i>
                                <span>	Операторы</span>
                            </a>
                        </li>
                    <?php endif;?>



                    <?php if ($_SESSION['ulogin']['email'] == "raskrutkaweb@yandex.ru"): ?>
                        <li class="nav-item">
                            <a href="/panel/generatelink/" class="nav-link <?=isset($active['generatelink']) ? $active['generatelink'] : ''; ?>">
                                <i class="icon-link2"></i>
                                <span>	Генератор ссылок</span>
                            </a>
                        </li>
                    <?php endif;?>



                    <li class="nav-item">
                        <a href="/master/" class="nav-link <?=isset($active['index']) ? $active['index'] : ''; ?>">
                            <i class="icon-home4"></i>
                            <span>	Проекты </span>
                        </a>
                    </li>
                    <li class="nav-item"><a href="/master/add" class="nav-link <?=isset($active['add']) ? $active['add'] : ''; ?>"><i class="icon-phone-plus"></i> <span>Добавить проект</span></a></li>


                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-sm line-height-sm">ТОП ОПЕРАТОРЫ</div>
                    </li>

                    <li class="nav-item">
                        <a href="/panel/operator/" class="nav-link <?=isset($active['operator']) ? $active['operator'] : ''; ?>" >
                            <i class="icon-users4"></i>
                            <span>	Операторы </span>
                            <span class="badge badge-pill bg-secondary ml-auto"><?=\APP\core\base\Model::countoperator()?></span>

                        </a>
                    </li>








                </ul>
            </div>
            <!-- /main navigation -->

        </div>
    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->