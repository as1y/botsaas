<?php
namespace APP\controllers;
use APP\core\Cache;
use APP\models\Addp;
use APP\models\Panel;
use APP\core\base\Model;


class PanelController extends AppController {
	public $layaout = 'PANEL';
    public $BreadcrumbsControllerLabel = "Кабинет рекламодателя";
    public $BreadcrumbsControllerUrl = "/panel";



    public function indexAction()
    {

        //Информация о компаниях клиента

        $META = [
            'title' => 'Кабинет рекламодателя',
            'description' => 'Кабинет рекламодателя',
            'keywords' => 'Кабинет рекламодателя ',
        ];
        \APP\core\base\View::setMeta($META);


        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Мои проекты"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);




        $panel = new Panel(); //Вызываем Моудль

        $company = $panel->allcompany($_SESSION['ulogin']['id']);

        if($company){



            $this->set(compact('company'));

        }else{

        }






//        $this->set(compact('testpar'));


    }


    public function addAction()
    {

        //Информация о компаниях клиента

        $META = [
            'title' => 'Добавление проекта',
            'description' => 'Добавление проекта',
            'keywords' => 'Добавление проекта',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Добавление проекта"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $add = new Addp(); //Вызываем Моудль

        if ($_POST){

            $add->load($_POST); // Берем из POST только те параметры которые нам нужны

           $validation = $add->validate($_POST);

            if ($validation){
                if ($add->addproject($_POST)){
                    redir("/panel/");
                }else{
                    $_SESSION['errors'] = "Ошибка базы данных. Попробуйте позже.";
                }
            }



            if (!$validation){
                $_SESSION['errors'] = "Что-то пошло не так.";


            }

            echo "ok";
            exit();
        }




//        $this->set(compact('testpar'));


    }

    public function refferalAction(){
       $Panel = new Panel();


        $META = [
            'title' => 'Партнерская программа',
            'description' => 'Партнерская программа',
            'keywords' => 'Партнерская программа',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Партнерская программа"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);


       $allref =   $Panel->getrefferals();


        $this->set(compact('allref'));



    }

    public function balanceAction(){
        $Panel =  new Panel();

        $balancelog = [];
        $balancelog = $Panel->balancelog();

        if ($balancelog == NULL) $balancelog = [];



        $META = [
            'title' => 'Баланс',
            'description' => 'Баланс',
            'keywords' => 'Баланс',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Баланс"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



        $this->set(compact('balancelog'));

    }






    public function  viewticketAction(){
        $Panel =  new Panel();

        if ($_POST){
           $result = $Panel->addmessageticket($_POST, $_GET['id']);


            if ($result == 1) redir("/panel/viewticket/?id=".$_GET['id']);
            else{
                $_SESSION['errors'] = $result;
                redir("/panel/viewticket/?id=".$_GET['id']);
            }

        }


        if (!empty($_GET['action']) && $_GET['action'] == "close"){

            $Panel->closeticket($_GET['id']);
            redir("/panel/ticket/");


        }


        $tickets = $Panel->gettickets($_GET['id']);

        if (!$tickets) return false;

        $messages = json_decode($tickets['messages'], true);





        $META = [
            'title' => 'Системные тикеты',
            'description' => 'Системные тикеты',
            'keywords' => 'Системные тикеты',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Тикеты", 'Url' => "/panel/ticket/"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Тикет ".$tickets['zagolovok']];



        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



        $this->set(compact('tickets', 'messages'));




    }


    public function ticketAction(){
        $Panel =  new Panel();

        if ($_POST){


           $result = $Panel->addticket($_POST);

            if ($result == 1){
                $_SESSION['success'] = "Тикет добавлен";
                redir("/panel/ticket/");
            }else{
                $_SESSION['errors'] = $result;
                redir("/panel/ticket/");

            }


        }


        $META = [
            'title' => 'Системные тикеты',
            'description' => 'Системные тикеты',
            'keywords' => 'Системные тикеты',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Тикеты"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $tickets = $Panel->getticket();


        $this->set(compact('tickets'));




    }


    public function profileAction(){
        $Panel =  new Panel();


        if ($_POST){


            show($_FILES);

            $validation = $Panel->filevalidation($_FILES['file'], ['ext' => ["jpg","png"], 'type' => 'image/jpeg']);


            if (!$validation){
                $Panel->getErrorsVali();
            }

            if ($validation){

                $name = md5(uniqid(rand(),1));
                $urlnew = "uploads/user_avatar/".$name.".jpg";

                copy($_FILES['file']['tmp_name'], $urlnew); // Копируем из общего котла в тизерку


                if (!empty($_SESSION['ulogin']['avatar'])) unlink($_SESSION['ulogin']['avatar']);

                $Panel->changeavatar("/".$urlnew);
                $_SESSION['ulogin']['avatar'] = "/".$urlnew;

                $_SESSION['success'] = "Аватар изменен";

                redir("/panel/profile");
            }



        }




        $META = [
            'title' => 'Профиль',
            'description' => 'Профиль',
            'keywords' => 'Профиль',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Мой профиль"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);




    }


    public function messagesAction(){
        $Panel =  new Panel();
    }

    public function settingsAction(){
        $Panel =  new Panel();


        if (!empty($_POST['changepassword'])){

            $result = $Panel->changepassword($_POST);
            if ($result == 1){
                $_SESSION['success'] = "Изменения сохранены";
                redir("/panel/settings/");
            }else{
                $_SESSION['errors'] = $result;
            }

        }

        if (!empty($_POST['changenotification'])){

            $result = $Panel->changenotification($_POST);
            $_SESSION['success'] = "Изменения сохранены";
            redir("/panel/settings/");
        }






        $META = [
            'title' => 'Настройки аккаунта',
            'description' => 'Настройки аккаунта',
            'keywords' => 'Настройки аккаунта',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Настройки аккаунта"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);





    }

    public function faqAction(){
        $Panel =  new Panel();


        $META = [
            'title' => 'FAQ',
            'description' => 'FAQ',
            'keywords' => 'FAQ',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "FAQ"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



    }




}
?>