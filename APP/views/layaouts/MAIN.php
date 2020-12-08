<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=980, initial-scale=0.4, maximum-scale=1.0, user-scalable=yes" />



    <?php \APP\core\base\View::getMeta()?>




    <link rel="shortcut icon" href="/favicon.ico">

    <meta name="yandex-verification" content="9e94f6602d4730a4" />
    <link rel="stylesheet" type="text/css" href="/assets_landing/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets_landing/css/plugins.css">
    <link rel="stylesheet" type="text/css" href="/assets_landing/revolution/css/settings.css">
    <link rel="stylesheet" type="text/css" href="/assets_landing/revolution/css/layers.css">
    <link rel="stylesheet" type="text/css" href="/assets_landing/revolution/css/navigation.css">
    <link rel="stylesheet" type="text/css" href="/assets_landing/type/type.css">
    <link rel="stylesheet" type="text/css" href="/assets_base/style.css">
    <link rel="stylesheet" type="text/css" href="/assets_landing/css/color/blue.css">



    <?php gtmHEAD();?>
</head>
<body>
<?php gtmBODY();?>



<div class="content-wrapper">


    <nav class="navbar bg-white shadow navbar-expand-lg">
        <div class="container">
            <div class="navbar-brand"><a href="/">

                  <b> <?=APPNAME?> </b>

            </div>

            <div class="navbar-other ml-auto order-lg-3">
                <ul class="navbar-nav flex-row align-items-center" data-sm-skip="true">
                    <li class="nav-item">
                        <div class="navbar-hamburger d-lg-none d-xl-none ml-auto"><button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button></div>
                    </li>
                    <li class="nav-item d-none d-lg-block pl-0"><a href="/user/register/" class="btn btn-default m-0">РЕГИСТРАЦИЯ</a></li>
                </ul>
                <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-other -->
            <div class="navbar-collapse offcanvas-nav">

                <div class="offcanvas-header d-lg-none d-xl-none">
                    <a href="/"><?=APPNAME?></a>
                    <button class="plain offcanvas-close offcanvas-nav-close"><i class="jam jam-close"></i></button>
                </div>



                <ul class="navbar-nav mx-auto" >

                    <li class="nav-item"><a class="nav-link" href="/#for">Для кого это?</a>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="/#howitworks">Как это работает?</a>
                    </li>




                    <li class="nav-item"><a class="nav-link" href="/#new">Операторы</a>
                    </li>

                    <li class="nav-item"><a style="color: var(--color-default)" class="nav-link" href="/user/" target="_blank" "=""> <b>ВОЙТИ</b> </a>
                    </li>



                </ul>



                <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <?=$content?>




    <footer class="dark-wrapper inverse-text text-center">
        <div class="container inner pt-80 pb-80">
            <div class="widget">

                <h3><?=APPNAME?>.RU</h3> Автоматизированная коммуникационная CPA/CPL платформа. Биржа удаленных операторов на телефоне.


                <div class="space30"></div>
                <p>© 2020 Все права защищены.</p>
                <p><a href="mailto: info@cashcall.ru">info@cashcall.ru</a></p>
                <div class="space10"></div>



            </div>
            <!-- /.widget -->
        </div>
        <!-- /.container -->
    </footer>

    

</div>
<!-- /.content-wrapper -->
<script src="/assets_landing/js/jquery.min.js"></script>
<script src="/assets_landing/js/popper.min.js"></script>
<script src="/assets_landing/js/bootstrap.min.js"></script>
<script src="/assets_landing/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="/assets_landing/revolution/js/jquery.themepunch.revolution.min.js"></script>
<script src="/assets_landing/revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script src="/assets_landing/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
<script src="/assets_landing/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="/assets_landing/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="/assets_landing/revolution/js/extensions/revolution.extension.migration.min.js"></script>
<script src="/assets_landing/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
<script src="/assets_landing/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<script src="/assets_landing/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="/assets_landing/revolution/js/extensions/revolution.extension.video.min.js"></script>
<script src="/assets_landing/js/plugins.js"></script>
<script src="/assets_landing/js/scripts.js"></script>


<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(61998925, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/61998925" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<!-- COUPONS POP-UP ENGINE -->
<?php \APP\core\base\Model::SaveUsr();?>




</body>
</html>