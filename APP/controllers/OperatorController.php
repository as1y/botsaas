<?php
namespace APP\controllers;
use APP\models\Operator;
use APP\core\base\Model;
use APP\models\Panel;
use APP\models\Project;
use APP\models\crest;


class OperatorController extends AppController {

	public $layaout = 'PANEL';
    public $BreadcrumbsControllerLabel = "Кабинет оператора";
    public $BreadcrumbsControllerUrl = "/operator";

    public function calckeyAction(){
        $this->layaout = false;
        if($this->isAjax()){

            echo md5($_REQUEST['key'].'|'.md5(VOXuser.':voximplant.com:'.VOXpass));
        }
    }



    public function callresultAction (){
        $this->layaout = false;

        $operator = new Operator();

        // Обработка ошибок
        if(!$this->isAjax()) message("Запрос не Ajax");

        if (empty($_GET['id'])) message("Ошибка получения данных");
        $idc = $_GET['id'];


        $company = $operator->getmycom($_GET['id']);
        if ($company === false) message("Ошибка допуска к проекту");


        // Обработка ошибок

        if (empty($_POST['optionresult']) || $_POST['optionresult'] == "") message("Обязатеыефльно выберете результат разговора");

        if ($_POST['zvonok'] == 0) message("Вы не совершили звонок");

        if(strlen($_POST['operatorcomment']) > 3000) message('Комментарий слишком большой');
        $_POST['operatorcomment'] = trim($_POST['operatorcomment']);
        $_POST['operatorcomment'] = strip_tags($_POST['operatorcomment']);
        $_POST['operatorcomment'] = htmlspecialchars($_POST['operatorcomment']);
        iconv_strlen($_POST['operatorcomment'], 'UTF-8');


        $optionresult = pole_valid ($_POST['optionresult'], 10, 's');
        if (!empty($optionresult['error'])) message($optionresult['error']);

        if ( $_POST['optionresult'] !="otkaz" &&
            $_POST['optionresult'] !="bezdostupa" &&
            $_POST['optionresult'] !="perezvon" &&
            $_POST['optionresult'] !="result"
        ) message("Ошибка в передаче параметров");



        if ($_POST['optionresult'] == "otkaz") $operator->SetOtkaz($_POST, $company);
        if ($_POST['optionresult'] == "bezdostupa") $operator->Setbezdostupa($_POST, $company);
        if ($_POST['optionresult'] == "perezvon") $operator->SetPerezvon($_POST, $company);
        if ($_POST['optionresult'] == "result") $operator->SetResult($_POST, $company);





        // НАЗНАЧЕНИЕ НОВОГО КОНТАКТА

        if ($company['status'] != 1) {
            $_SESSION['errors'] = "Проект ".$company['company']." в данный момент не активен";
            go("/operator/");
        }

        // МОМЕНТ С ПРОВЕРКОЙ И ДОБАВЛЕНИЕМ ЗАПИСИ!




        // МОМЕНТ С ПРОВЕРКОЙ И ДОБАВЛЕНИЕМ ЗАПИСИ!
        $contactinfo = $operator->newcontact($idc);

        if (empty($contactinfo)) {
            $_SESSION['errors'] = "У компании".$company['company']." закончилась база для обзвона. Попробуйте позднее";
            go("/operator/");
        }
        //Ставим бронь
        $operator->setbron($contactinfo['id']);
        //Ставим бронь

        if (empty($contactinfo['sitename'])) $contactinfo['sitename'] = "";
        if (empty($contactinfo['comment'])) $contactinfo['comment'] = "";
        if (empty($contactinfo['namecont'])) $contactinfo['namecont'] = "";
        if (empty($contactinfo['companyname'])) $contactinfo['companyname'] = "";

        echo json_encode($contactinfo, true);


        return false;
    }




    public function callAction(){

        $operator = new Operator();

        if (empty($_GET['id'])){
            //$_SESSION['errors'] = "noparam";
            redir ("/operator/");
        }

        $idc = $_GET['id'];
        $company = $operator->getmycom($_GET['id']);

        if ($company === false){
            $_SESSION['errors'] = "У Вас нет допуска к проекту";
            redir ("/operator/");
        }


        //Информация о компаниях клиента
        $META = [
            'title' => 'Рабочая область ',
            'description' => 'Рабочая область ',
            'keywords' => 'Рабочая область ',
        ];
        \APP\core\base\View::setMeta($META);
        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => $company['company']];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);




        $ASSETS[] = ["js" => "/global_assets/js/plugins/notifications/sweet_alert.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];
        $ASSETS[] = ["js" => "//cdn.voximplant.com/edge/voximplant.min.js"];
        \APP\core\base\View::setAssets($ASSETS);



        // Забираем скрипт
        $script = $operator->getscript($idc);
        // Забираем скрипт


        // Проверяем перезвон. Если он есть, то загружаем его
        if (!empty($_GET['perezvon'])){

            $contactinfo = $operator->loadcontact($_GET['perezvon']);
            if (empty($contactinfo) || ($contactinfo['status'] != 2 && $contactinfo['status'] != 6) ) {
                $_SESSION['errors'] = "Ошибка в базе контактов №148. Обратить в тех. поддержку";
                redir ("/operator/perezvon/");
            }
            $perezvon = true;

            $this->set(compact('company', 'contactinfo', 'script', 'perezvon'));
            return true;


        }
        //Проверяем перезвон. Если он есть, то загрзужаем контакт их перезвона



        //if (isset($_GET['perezvon'])) $idcontact = $_GET['perezvon'];


        // Проверяем компанию на статус
        $company = $operator->checkcompany($idc);
        if (empty($company)) {
            $_SESSION['errors'] = "Проект в данный момент не активен";
            redir ("/operator/");
        }

        // Берем контакт на звонок


        // Проверяем есть ли бронь на контакт. Если есть, то загружаем данные контакта из брони
//        $contactinfo = $operator->Getbron($idc);
//        if ($contactinfo){
//            $this->set(compact('company', 'contactinfo', 'script'));
//            return true;
//        }
        // Проверяем есть ли бронь на контакт. Если есть, то загружаем данные контакта из брони


        // Брони на контакт нет. Берем новый контакт
        $contactinfo = $operator->newcontact($idc);
        if (empty($contactinfo)) {
            $_SESSION['errors'] = "На проекте ".$company['company']." закончилась база контактов";
            redir ("/operator/");
        }

        //Ставим бронь
        $operator->setbron($contactinfo['id']);
        //Ставим бронь


        $this->set(compact('company', 'contactinfo', 'script'));
        return true;




    }


    public function indexAction()
    {

        //Информация о компаниях клиента

        $META = [
            'title' => 'Кабинет ОПЕРАТОРА',
            'description' => 'Кабинет ОПЕРАТОРА',
            'keywords' => 'Кабинет ОПЕРАТОРА ',
        ];
        \APP\core\base\View::setMeta($META);


        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Мои проекты"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



        $operator = new Operator(); //Вызываем Моудль


        $statuscall = $operator->statuscall();

        $mycompanies = $operator->mycompanies();

        if (count($mycompanies) == 0 && $statuscall['acess'] === true ) redir("/operator/all");

        $this->set(compact( 'statuscall', 'mycompanies'));



    }



    // РАБОТА С КОНТАКТАМИ

    public function perezvonAction()
    {

        $operator = new Operator();
        $project = new Project;

        //Информация о компаниях клиента

        $META = [
            'title' => 'Контакты на перезвон',
            'description' => 'Контакты на перезвон',
            'keywords' => 'Контакты на перезвон',
        ];
        \APP\core\base\View::setMeta($META);


        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Контакты на перезвон"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        $ASSETS[] = ["js" => "/global_assets/js/demo_pages/components_popups.js"];


        \APP\core\base\View::setAssets($ASSETS);

        $contactperezvon = $operator->getcontactuser(2);

        $allzapis = $operator->allzapis($_SESSION['ulogin']['id'], "user");


        $this->set(compact('contactperezvon', 'allzapis'));


    }

    public function moderateAction()
    {

        $operator = new Operator();
        //Информация о компаниях клиента

        $META = [
            'title' => 'Звонки на модерации',
            'description' => 'Звонки на модерации',
            'keywords' => 'Звонки на модерации',
        ];
        \APP\core\base\View::setMeta($META);


        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Звонки на модерации"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);


        $contactmoderate = $operator->getcontactuser(5);

        $allzapis = $operator->allzapis($_SESSION['ulogin']['id'], "user");

        $this->set(compact('contactmoderate','allzapis'));


    }

    public function dorabotkaAction()
    {

        $operator = new Operator();
        //Информация о компаниях клиента

        $META = [
            'title' => 'Доработка',
            'description' => 'Доработка',
            'keywords' => 'Доработка',
        ];
        \APP\core\base\View::setMeta($META);


        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Доработка"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);

//        $contactperezvon = $operator->getcontactuser(2);

        $allzapis = $operator->allzapis($_SESSION['ulogin']['id'], "user");

        $contactdorabotka = $operator->getcontactuser(6);


        $this->set(compact('contactdorabotka', 'allzapis'));


    }

    public function rejectAction()
    {

        $operator = new Operator();
        //Информация о компаниях клиента

        $META = [
            'title' => 'Отказ',
            'description' => 'Отказ',
            'keywords' => 'Отказ',
        ];
        \APP\core\base\View::setMeta($META);


        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Отказ"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);

//        $contactperezvon = $operator->getcontactuser(2);

        $allzapis = $operator->allzapis($_SESSION['ulogin']['id'], "user");

        $contactreject= $operator->getcontactuser(7);


        $this->set(compact('contactreject', 'allzapis'));


    }




    public function successAction()
    {

        $operator = new Operator();
        //Информация о компаниях клиента

        $META = [
            'title' => 'Звонки на модерации',
            'description' => 'Звонки на модерации',
            'keywords' => 'Звонки на модерации',
        ];
        \APP\core\base\View::setMeta($META);


        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Звонки на модерации"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);

//        $contactperezvon = $operator->getcontactuser(2);

      //  $allzapis = $operator->allzapis($_SESSION['ulogin']['id'], "user");

        $resultuser = $operator->getresultuser(1);


        $this->set(compact('resultuser', 'allzapis'));


    }
    // РАБОТА С КОНТАКТАМИ


    public function allAction()
    {

        $operator = new Operator(); //Вызываем Моудль

        //Информация о компаниях клиента

        $META = [
            'title' => 'Все проекты',
            'description' => 'Все проекты',
            'keywords' => 'Все проекты',
        ];
        \APP\core\base\View::setMeta($META);


        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Все проекты"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        $ASSETS[] = ["js" => "/global_assets/js/demo_pages/components_popups.js"];


        \APP\core\base\View::setAssets($ASSETS);



        if (!empty($_GET) && $_GET['action'] == "join"  ) {


            $statuscall = $operator->statuscall();
            if ($statuscall['acess'] === FALSE){
                $_SESSION['errors'] = "Подать заявку можно после получения разрешения на звонки. Посмотреть ваш статус можно в разделе <a href='/operator/'>Моя работа</a>";
                redir("/operator/all/");
            }


            $result = $operator->joincompany($_GET['id']);

            if ($result == 1){
                $_SESSION['success'] = "Заявка отправлена";
                redir("/operator/all/");
            }else{
                $_SESSION['errors'] = $result;
                redir("/operator/all/");
            }

        }



        $allcompanies = $operator->allcompanies();




        $this->set(compact('allcompanies'));




    }



    public function statAction()
    {

        $operator = new Operator(); //Вызываем Моудль

        //Информация о компаниях клиента

        $META = [
            'title' => 'Статистика',
            'description' => 'Статистика',
            'keywords' => 'Статистика',
        ];
        \APP\core\base\View::setMeta($META);


        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Все проекты"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        $ASSETS[] = ["js" => "/global_assets/js/demo_pages/components_popups.js"];


        \APP\core\base\View::setAssets($ASSETS);



        $mystat = $operator->todaystat();


        $result = $operator->topleaders();

        if ($_POST){

            if ($_POST['callsminute'] != $mystat['callsminute']){
                $_SESSION['errors'] = "Системная ошибка";
                redir();
            }


            $resultbonus = $operator->addbonuce();

            if ($resultbonus == true){
                $_SESSION['success'] = "Бонус начислен!";
                redir('/panel/balance/');
            }


            if ($resultbonus == false){
                $_SESSION['errors'] = "Бонус за сегодня Вам уже начислен";
                redir();
            }

            exit("");

        }


        $Panel = new Panel();
        $chat = $Panel->loadchatmessage(1);

         $user =  $Panel->usermy();

        $this->set(compact('mystat', 'result', 'chat', 'user'));




    }

    public function callsAction()
    {

        $operator = new Operator(); //Вызываем Моудль
        $project = new Project(); //Вызываем Моудль

        //Информация о компаниях клиента

        $META = [
            'title' => 'Статистика',
            'description' => 'Статистика',
            'keywords' => 'Статистика',
        ];
        \APP\core\base\View::setMeta($META);


        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Все проекты"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        $ASSETS[] = ["js" => "/global_assets/js/demo_pages/components_popups.js"];


        \APP\core\base\View::setAssets($ASSETS);


        $mycalls = $operator->mycalls();
        $allzapis = $project->allzapis($_SESSION['ulogin']['id'], "user");


        $this->set(compact('mycalls', 'allzapis'));




    }




}
?>