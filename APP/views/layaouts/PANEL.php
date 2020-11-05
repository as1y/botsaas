<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php \APP\core\base\Model::online()?>
    <?php \APP\core\base\View::getMeta()?>


    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="/global_assets/js/main/jquery.min.js"></script>
    <script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <?php \APP\core\base\View::getAssets("js");?>


    <script src="/assets/js/app.js"></script>

</head>

<body>







<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-xl rounded-top">

    <a href="/panel/" class="navbar-nav-link " >
        <!--        <img src="/global_assets/images/dribbble.png" class="align-top mr-2 rounded" width="20" height="20" alt="">-->
        <b><?=APPNAME?> </b>   <?= ($_SESSION['ulogin']['role'] == "O") ? '<span class="badge-secondary">Кабинет ОПЕРАТОРА</span>' : ' <span class="badge-secondary">Кабинет РЕКЛАМОДАТЕЛЯ</span>'?>
    </a>

    <div class="d-md-none">
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="d-xl-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-demo1-mobile">
            <i class="icon-grid3"></i>
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-demo1-mobile">



        <span class="navbar-text ml-xl-3">
   Пользователей онлайн:  <span class="badge bg-success"><b><?= \APP\core\base\Model::countonline()?></b></span>
        </span>

        <?php if ($_SESSION['ulogin']['role'] == "O"):?>

<!--        fdsf-->
        <?php endif;?>


        <ul class="navbar-nav ml-xl-auto">


            <li class="nav-item dropdown">
                <a href="/panel/messages/?newdialog=24" class="navbar-nav-link dropdown-toggle caret-0">
                    <i class="icon-comment-discussion mr-2"></i>
                    Поддержка
                </a>




            </li>





            <li class="nav-item dropdown">
                <a href="/panel/dialog/" class="navbar-nav-link dropdown-toggle caret-0">
                    <i class="icon-bubbles4"></i>
                   Сообщения
                    <span class="badge badge-pill bg-danger-400 ml-auto ml-md-0"><?= \APP\core\base\Model::countnewmessages()?></span>
                </a>
            </li>


            <li class="nav-item dropdown dropdown-user">
                <a href="/panel/profile/" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?=$_SESSION['ulogin']['avatar']?>" class="rounded-circle mr-2" height="34" alt="">
                    <span><?=$_SESSION['ulogin']['username']?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="/panel/balance/" class="dropdown-item"><i class="icon-wallet"></i> Баланс  &nbsp;<span class="badge badge-success"><b><?=\APP\models\Panel::getBal()?></b> Р.</span></a>
                    <a href="/panel/profile/" class="dropdown-item"><i class="icon-user-plus"></i> Мой профиль</a>
                    <a href="/panel/refferal/" class="dropdown-item"><i class="icon-cash"></i> Партнерскся программа</a>

                    <div class="dropdown-divider"></div>
                    <a href="/panel/urlegal/" class="dropdown-item"><i class="icon-pencil"></i> Юр. Информация</a>
                    <a href="/panel/settings/" class="dropdown-item"><i class="icon-cog5"></i> Настройки аккаунта</a>
                    <a href="/user/logout/" class="dropdown-item"><i class="icon-switch2"></i> Выход</a>
                </div>
            </li>




        </ul>
    </div>



</div>
<!-- /main navbar -->







<div class="page-header">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">

                <?php \APP\core\base\View::getBreadcrumbs();?>

            </div>

            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none">
            <div class="breadcrumb justify-content-center">

                &nbsp;<?php if($_SESSION['ulogin']['role'] == "O"):?>
                    <a href="/panel/rating" class="btn btn-success btn-sm">
                        <i class="icon-users4 mr-2"></i>
                        РЕЙТИНГ ОПЕРАТОРОВ
                    </a>

                    &nbsp;

                    <a href="/panel/otzivi" class="btn btn-primary btn-sm">
                        <i class="icon-file-text mr-2"></i>
                        ОТЗЫВЫ ОПЕРАТОРОВ
                    </a>

                    &nbsp;

                    <a href="/panel/faq" class="btn btn-danger btn-sm">
                        <i class="icon-reading mr-2"></i>
                        ПОМОЩЬ
                    </a>
                <?php endif;?>

                &nbsp;<?php if($_SESSION['ulogin']['role'] == "R"):?>
                    <a href="/panel/faqpromo" class="btn btn-danger btn-sm">
                        <i class="icon-reading mr-2"></i>
                        ПОМОЩЬ
                    </a>

                <?php endif;?>







            </div>
        </div>
    </div>


</div>



<!-- Page content -->
<div class="page-content">




        <?php
        // Вставка панели на главной странице


        if ($_SESSION['ulogin']['role'] == "O"){
            if ($this->route['controller'] == "Panel") require_once( 'includes/operator.php' );
            if ($this->route['controller'] == "Pay") require_once( 'includes/operator.php' );
            if ($this->route['controller'] == "Operator" && $this->route['action'] != "call") require_once( 'includes/operator.php' );
        }


        if ($_SESSION['ulogin']['role'] == "R"){

            if ($this->route['controller'] == "Panel") require_once( 'includes/recl.php' );
            if ($this->route['controller'] == "Master") require_once( 'includes/recl.php' );
            if ($this->route['controller'] == "Project") require_once( 'includes/project.php' );
            if ($this->route['controller'] == "Pay") require_once( 'includes/recl.php' );

        }









        ?>










    <!-- Main content -->
    <div class="content-wrapper">


        <!-- Content area -->
        <div class="content">


            <?php if(isset($_SESSION['errors'])): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                    <span class="font-weight-semibold">Ошибка!</span> <br><?=$_SESSION['errors']; unset($_SESSION['errors']);?>
                </div>
            <?php endif;?>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                    <span class="font-weight-semibold">Успех!</span> <?=$_SESSION['success']; unset($_SESSION['success']);?>
                </div>

            <?php endif;?>



            <?=$content?>



        </div>
        <!-- /content area -->




    </div>
    <!-- /content wrapper -->




</div>
<!-- /page content -->


<!-- Footer -->
<div class="navbar navbar-expand-lg navbar-dark">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Подвал сайта
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-footer">
			<span class="navbar-text">
				&copy; 2020 <b><a href="/panel/"><?=APPNAME?></a></b> - Биржа удаленных операторов на телефоне.
			</span>

        <ul class="navbar-nav ml-lg-auto">
            <li class="nav-item"><a href="mailto: <?=CONFIG['BASEMAIL']['email']?>" class="navbar-nav-link" target="_blank"><i class="icon-mail-read mr-2"></i> <?=CONFIG['BASEMAIL']['email']?></a></li>


        </ul>
    </div>
</div>
<!-- /footer -->


</body>
</html>
