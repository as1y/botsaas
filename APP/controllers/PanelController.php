<?php
namespace APP\controllers;
use APP\core\Cache;
use APP\core\Cpayeer;
use APP\models\Addp;
use APP\models\Panel;
use APP\core\base\Model;


class PanelController extends AppController {
	public $layaout = 'PANEL';
    public $BreadcrumbsControllerLabel = "Кабинет оператора";
    public $BreadcrumbsControllerUrl = "/panel";



    public function indexAction()
    {

        //Информация о компаниях клиента

            $this->layaout = false;
             $this->view = false;

            if ($_SESSION['ulogin']['role'] == "R") redir("/master");
           if ($_SESSION['ulogin']['role'] == "O") redir("/operator");



    }



    public function refferalAction(){
       $Panel = new Panel();


        $META = [
            'title' => 'Партнерская программа',
            'description' => 'Партнерская программа',
            'keywords' => 'Партнерская программа',
        ];

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Партнерская программа"];


        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);


        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);







       $allref =   $Panel->getrefferals();


        $this->set(compact('allref'));



    }

    public function balanceAction(){
        $Panel =  new Panel();

        $balancelog = [];
        $balancelog = $Panel->balancelog();

        $invoicelog = $Panel->invoicelog();




        if (empty($balancelog)) $balancelog = [];



        $META = [
            'title' => 'Баланс',
            'description' => 'Баланс',
            'keywords' => 'Баланс',
        ];
        \APP\core\base\View::setMeta($META);

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Баланс"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);


        if (!empty($_GET['success']) && $_GET['success'] == 1){
            $_SESSION['success'] = "Баланс упешно пополнен!<br>";
            redir("/panel/balance/");
        }
        if (!empty($_GET['error']) && $_GET['error'] == 1){

            $_SESSION['errors'] = "Ошибка пополнения <br>";
            redir("/panel/balance/");

        }


        if (!empty($_GET['action']) && $_GET['action'] == "delinvoice"){

            $Panel->deleteinvoice($_GET['idinvoice'], $invoicelog);
            $_SESSION['success'] = "Счет успешно удален!<br>";

            redir("/panel/balance/");



        }






        $this->set(compact('balancelog', 'invoicelog'));

    }

    public function payoutAction(){
        $Panel =  new Panel();

        if ($_SESSION['ulogin']['woof'] != 1) exit();

        $META = [
            'title' => 'Вывод баланса пользователями',
            'description' => 'Вывод баланса пользователями',
            'keywords' => 'Вывод баланса пользователями',
        ];
        \APP\core\base\View::setMeta($META);

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Вывод баланса пользователями"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);


        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);



        $accountNumber = PaccountNumber;
        $apiId = PapiId;
        $apiKey = PapiKey;


        if (!empty($_GET) && !empty($_GET['id'])){

            $payoutinfo = $Panel->payoutinfo($_GET['id']);


            $payeer = new CPayeer($accountNumber, $apiId, $apiKey);


            //Получение списка платежных систем

            if ($payeer->isAuth()) $arPs = $payeer->getPaySystems();


//
//            show($arPs);
//            // Получение списка платежных систем
//            show(getPS($arPs, $payoutinfo['method']));

            $PS = getPS($arPs, $payoutinfo['method'])['id'];


            $sum = $payoutinfo['sum'];


            if ($payeer->isAuth())
            {
                $initOutput = $payeer->initOutput(array(
                    'ps' => $PS,
                    'sumIn' => $sum,
                    'curIn' => 'RUB',
                    'curOut' => 'RUB',
                    'param_ACCOUNT_NUMBER' => $payoutinfo['number']
                ));

                if ($initOutput)
                {
                    $historyId = $payeer->output();
                    if ($historyId > 0)
                    {

                        //echo "Выплата успешна";

                        $Panel->sucesspayout($_GET['id']);
                        redir("/panel/payout/");



                    }
                    else
                    {
                        echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
                    }
                }
                else
                {
                    echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
                }
            }
            else
            {
                echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
            }


            exit();




        }


        $allbalance = $Panel->allBalance();


        $balancelogout = $Panel->balancelogout();



        $this->set(compact('balancelogout', 'allbalance'));

    }

    public function workAction(){
        $Panel =  new Panel();

        if ($_SESSION['ulogin']['woof'] != 1) exit();

        $META = [
            'title' => 'Сколько заработали операторы',
            'description' => 'Сколько заработали операторы',
            'keywords' => 'Сколько заработали операторы',
        ];
        \APP\core\base\View::setMeta($META);

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Вывод баланса пользователями"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);


        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);





        $allbalance = $Panel->allBalance();


        $balancelogout = $Panel->balancelogout();



        $this->set(compact('balancelogout', 'allbalance'));

    }




    public function generatelinkAction()
    {

        //Информация о компаниях клиента

        $Panel =  new Panel();


        $META = [
            'title' => 'Создание ссылки для',
            'description' => 'Создание ссылки',
            'keywords' => 'Создание ссылки',
        ];


        $ASSETS[] = ["js" => "/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"];


        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/wizards/steps.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/selects/select2.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/inputs/inputmask.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/validation/validate.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/extensions/cookie.js"];

        $ASSETS[] = ["js" => "/assets/js/form_wizard.js"];
        $ASSETS[] = ["js" => "/global_assets/js/demo_pages/form_select2.js"];



        if ($_POST){
            $link = $Panel->GenerateLink($_POST);
            if ($link === false){
                $_SESSION['errors'] = "Заполните все поля";
                redir();
            }

        }









        \APP\core\base\View::setAssets($ASSETS);


        \APP\core\base\View::setMeta($META);






        $this->set(compact( 'link'));




    }


    public function newoperatorsAction()
    {

        //Информация о компаниях клиента

        $Panel =  new Panel();


        $META = [
            'title' => 'Создание ссылки для',
            'description' => 'Создание ссылки',
            'keywords' => 'Создание ссылки',
        ];


        $ASSETS[] = ["js" => "/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"];


        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/wizards/steps.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/selects/select2.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/inputs/inputmask.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/validation/validate.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/extensions/cookie.js"];

        $ASSETS[] = ["js" => "/assets/js/form_wizard.js"];
        $ASSETS[] = ["js" => "/global_assets/js/demo_pages/form_select2.js"];



        if ($_GET){

            $Panel->ApproveTalk($_GET['id']);

            $_SESSION['success'] = "";

        }


        \APP\core\base\View::setAssets($ASSETS);

        \APP\core\base\View::setMeta($META);


        $operators = $Panel->getnewoperators();
        $operatorsfunnel = $Panel->operatorsfunnel();


        $this->set(compact( 'link', 'operators', 'operatorsfunnel' ));




    }

    public function newreklAction()
    {

        //Информация о компаниях клиента

        $Panel =  new Panel();


        $META = [
            'title' => 'Создание ссылки для',
            'description' => 'Создание ссылки',
            'keywords' => 'Создание ссылки',
        ];


        $ASSETS[] = ["js" => "/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"];


        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/wizards/steps.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/selects/select2.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/inputs/inputmask.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/validation/validate.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/extensions/cookie.js"];

        $ASSETS[] = ["js" => "/assets/js/form_wizard.js"];
        $ASSETS[] = ["js" => "/global_assets/js/demo_pages/form_select2.js"];



        if ($_GET){

            $Panel->ApproveTalk($_GET['id']);
            $_SESSION['success'] = "";


        }


        \APP\core\base\View::setAssets($ASSETS);

        \APP\core\base\View::setMeta($META);



        $rekl = $Panel->getnewrekl();


        $this->set(compact( 'link', 'rekl' ));




    }


    public function cashoutAction(){
        $Panel =  new Panel();

        $balancelog = [];
        $balancelog = $Panel->balancelog();

        if (empty($balancelog)) $balancelog = [];



        $META = [
            'title' => 'Вывести средства',
            'description' => 'Вывести средства',
            'keywords' => 'Вывести средства',
        ];
        \APP\core\base\View::setMeta($META);

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Вывести средства"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



        $ASSETS[] = ["js" => "/global_assets/js/demo_pages/form_actions.js"];
        $ASSETS[] = ["js" => "/assets/js/form_inputs.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/selects/select2.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);


        $requis = json_decode($Panel::$USER->requis, true);
        if (empty($requis)) $requis = [];



        if ($_POST && $_GET['action'] == "changerequis"){

            foreach ($_POST as $key=>$value){
                if (!empty($value) && empty($requis[$key])){

                    $result = validationpay($key, $value);


                    if ($result == true){

                        $Panel->addrequis($_POST);
                        if (empty($_SESSION['success'])) $_SESSION['success'] = "";
                        $_SESSION['success'] .= "Метод оплаты $key успешно добавлен! <br>";


                    }
                    if ($result == false){
                        if (empty($_SESSION['errors'])) $_SESSION['errors'] = "";
                        $_SESSION['errors'] .= "Ошибка в заполнеии метода оплаты $key <br>";


                    }

                }


            }

            redir();


        }

        if ($_POST && $_GET['action'] == "viplata"){


            if (empty($_POST['summa']) ){
                $_SESSION['errors'] = "Укажите сумму вывода";
                redir("/panel/cashout/");
            }

            if (empty($_POST['sposob'])){
                $_SESSION['errors'] = "Укажите способ вывода";
                redir("/panel/cashout/");
            }

            if ($Panel::$USER->bal < 100){
                $_SESSION['errors'] = "Минимальный заказ выплаты 100 рублей";
                redir("/panel/cashout/");
            }

            if ($Panel::$USER->bal < $_POST['summa']){
                $_SESSION['errors'] = "Недостаточно средств на балансе";
                redir("/panel/cashout/");
            }

            $Panel->createviplata($_POST);

            redir("/panel/balance/");
        }





        $this->set(compact('requis'));

    }



    // Прием платежей на сайте

    public function payredirectAction(){

        $Panel =  new Panel();


        $META = [
            'title' => 'Пополнение баланса',
            'description' => 'Пополнение баланса',
            'keywords' => 'Пополнение баланса',
        ];
        \APP\core\base\View::setMeta($META);

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Пополнение баланса"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);


        if ($_POST && $_POST['paymethod'] == "Payeer"){
           $form = $Panel->generatePayeerform($_POST);
        }


        $this->set(compact('form'));



    }
    public function payobrabotkaAction(){
        $this->layaout = false;

        $Panel =  new Panel();

        $META = [
            'title' => 'Пополнение баланса',
            'description' => 'Пополнение баланса',
            'keywords' => 'Пополнение баланса',
        ];
        \APP\core\base\View::setMeta($META);

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Пополнение баланса"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



        if (!empty($_GET['method']) && $_GET['method'] == "Payeer"){


            if (!in_array($_SERVER['REMOTE_ADDR'], array('185.71.65.92', '185.71.65.189', '149.202.17.210'))) return;
            if (isset($_POST['m_operation_id']) && isset($_POST['m_sign']))
            {
                $m_key = 'XvmQQSVbf8aV';

                $arHash = array(
                    $_POST['m_operation_id'],
                    $_POST['m_operation_ps'],
                    $_POST['m_operation_date'],
                    $_POST['m_operation_pay_date'],
                    $_POST['m_shop'],
                    $_POST['m_orderid'],
                    $_POST['m_amount'],
                    $_POST['m_curr'],
                    $_POST['m_desc'],
                    $_POST['m_status']
                );

                if (isset($_POST['m_params']))
                {
                    $arHash[] = $_POST['m_params'];
                }

                $arHash[] = $m_key;

                $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

                if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success')
                {

                    //Добавляем баланс пользователю через параметры или БД


                    //Добавляем баланс пользователя через баланс или БД

                    ob_end_clean(); exit($_POST['m_orderid'].'|success');
                }

                ob_end_clean(); exit($_POST['m_orderid'].'|error');
            }





        }





    }

    // Прием платежей на сайте

    public function loadzapisAction(){
        $this->layaout = false;
        $this->view = false;

        $Panel = new Panel();


        if (!empty($_GET['action']) && $_GET['action'] == "ClearRecord"){



            $Panel->resetrecord();


            redir("/panel/profile");

        }


        if ($_FILES['file']['size'] > 0){

            $validation = $Panel->filevalidation($_FILES['file'], ['ext' => ["mp3"], 'type' => 'audio/mp3']);

            if (!$validation) message("Ошибка валидации");


            if ($validation){

                $urlnew = AudioUploadPath.$_FILES['file']['name'];

                copy($_FILES['file']['tmp_name'], $urlnew); // Копируем из общего котла в тизерку

                if (!empty($_SESSION['ulogin']['audio'])) unlink($_SESSION['ulogin']['audio']);

                $Panel->saverecord($_FILES['file']['name']);

                $_SESSION['ulogin']['audio'] = $_FILES['file']['name'];
//                $_SESSION['success'] = "Аудио презентация сохранена";

                go("/panel/profile/");
            }




        }else{
            message("error");
        }


        return true;
    }

    public function profileAction(){
        $Panel =  new Panel();

        if ($_POST && $_FILES['file']['size'] > 0){

            $validation = $Panel->filevalidation($_FILES['file'], ['ext' => ["jpg","png"], 'type' => 'image/jpeg']);


            if (!$validation){
                $Panel->getErrorsVali();
            }

            if ($validation){

                $name = md5(uniqid(rand(),1));
                $urlnew = "uploads/user_avatar/".$name.".jpg";


                copy($_FILES['file']['tmp_name'], $urlnew); // Копируем из общего котла в тизерку


                $Panel->myresize($urlnew, 200,200);


                if (($_SESSION['ulogin']['avatar']) != BASEAVATAR) unlink(WWW.$_SESSION['ulogin']['avatar']);


                $Panel->changeavatar("/".$urlnew);
                $_SESSION['ulogin']['avatar'] = "/".$urlnew;
                $_SESSION['success'] = "Аватар изменен";

                redir("/panel/profile");
            }



        }



        if ($_POST){



            $result = $Panel->changeprofileinfo($_POST);
            if ($result == 1){
                $_SESSION['success'] = "Изменения сохранены";
                redir("/panel/profile/");
            }else{
                $_SESSION['errors'] = $result;
                redir("/panel/profile/");
            }



        }


        $META = [
            'title' => 'Профиль',
            'description' => 'Профиль',
            'keywords' => 'Профиль',
        ];
        \APP\core\base\View::setMeta($META);

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Мой профиль"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



        $ASSETS[] = ["js" => "/global_assets/js/demo_pages/form_actions.js"];
        $ASSETS[] = ["js" => "/assets/js/form_inputs.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/selects/select2.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js"];
        $ASSETS[] = ["js" => "/assets/js/uploader_bootstrap.js"];
        $ASSETS[] = ["js" => "//cdn.webrtc-experiment.com/RecordRTC.js"];



        \APP\core\base\View::setAssets($ASSETS);








    }


    public function messagesAction(){

        $Panel =  new Panel();


        $META = [
            'title' => 'Мои диалоги',
            'description' => 'Мои диалоги',
            'keywords' => 'Мои диалоги',
        ];

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Даилоги"];


        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);


        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);



        // Инициация диалога
        if (!empty($_GET['newdialog']) ){

            $sobesednik = $Panel->getsobesednik($_GET['newdialog']);

            //Если ничего не нашел
            if (!$sobesednik) redir("/panel/dialog/");

            //Если диалог сам с собой
            if ($_GET['newdialog'] == $_SESSION['ulogin']['id']) redir("/panel/dialog/");

            //Проверка на существование данного диалога
            $dialog = $Panel->checkdialog($_GET['newdialog']);


            if ($dialog){



                $Panel->clearuvedmolenie($dialog);
                $dialog['messages'] = json_decode($dialog['messages'], true);
                if (empty($dialog['messages'])) $dialog['messages']  = [];
                $this->set(compact('dialog', 'sobesednik'));
                return true;
            }



            // Создаем диалог

            $data = [
                'p1' => $sobesednik['id'],
                'p2' => $_SESSION['ulogin']['id'],
                'zagolovok' => "Новый диалог",
                'messages' => NULL,
                'date' => date('d:m:Y'),
            ];

         $idd =   $Panel->addnewBD("dialog", $data);

            $dialog['messages'] = [];
            $dialog['id'] = $idd;

            $this->set(compact('sobesednik', 'dialog'));
            return true;


        }


        //Отправка сообщения в диалоге
        if ($_POST && $_GET['idd']){

            $result = $Panel->addmessage($_POST, $_GET['idd']);

            if ($result == 1) redir("/panel/messages/?idd=".$_GET['idd']);
            else{
                $_SESSION['errors'] = $result;
                redir("/panel/messages/?idd=".$_GET['idd']);
            }

            return true;

        }



        // Удаление диалога
        if ($_GET['idd'] && !empty($_GET['action']) && $_GET['action'] == "delete"){
           $Panel->deletedialog($_GET['idd']);
            redir("/panel/dialog/");
        }
        // Удаление диалога

        // Чтение диалога
        if ($_GET['idd']){

            $dialog = $Panel->getdialog($_GET['idd']);

            if (!$dialog) redir("/panel/dialog/");


            if ($dialog){


                $Panel->clearuvedmolenie($dialog);
                $dialog->uvedomlenie = NULL;


                // Определить собеседника

                $sobesednik = $Panel->lookingsobesednik($dialog);
                $dialog['messages'] = json_decode($dialog['messages'], true);


                if (empty($dialog['messages'])) $dialog['messages']  = [];
                $this->set(compact('dialog', 'sobesednik'));
                return true;
            }



        }







        redir("/panel/dialog/");


    }


    public function dialogAction(){

        $Panel =  new Panel();


        $META = [
            'title' => 'Мои диалоги',
            'description' => 'Мои диалоги',
            'keywords' => 'Мои диалоги',
        ];

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Даилоги"];


        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);


        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);




        $dialogsinfo = $Panel->getdialogsinfo();




        $this->set(compact('dialogsinfo'));




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
                redir("/panel/settings/");
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

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Настройки аккаунта"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/wizards/steps.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/selects/select2.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];
        $ASSETS[] = ["js" => "/assets/js/form_wizard.js"];
        \APP\core\base\View::setAssets($ASSETS);








    }



    public function urlegalAction(){
        $Panel =  new Panel();



        $META = [
            'title' => 'Юридическая информация',
            'description' => 'Юридическая информация',
            'keywords' => 'Юридическая информация',
        ];

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "Юридическая информация"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/wizards/steps.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/selects/select2.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];
        $ASSETS[] = ["js" => "/assets/js/form_wizard.js"];
        \APP\core\base\View::setAssets($ASSETS);



        if ($_POST && !empty($_GET) && $_GET['action'] == "baseinfo"){

            $validate = $Panel->validationur($_POST);

            if (!$validate){
                $Panel->getErrorsVali(); //Записываем ошибки в сессию
                redir("/panel/urlegal");
            }

            $Panel->changeurlegal($_POST);

            $_SESSION['success'] = "Информация сохранена!<br>";
            redir("/panel/urlegal/");


        }

        if ($_POST && !empty($_GET) && $_GET['action'] == "payinfo"){



            $validate = $Panel->validationpayurinfo($_POST);

            if (!$validate){
                $Panel->getErrorsVali(); //Записываем ошибки в сессию
                redir("/panel/urlegal");
            }



            $Panel->cahngepayurinfo($_POST);

            $_SESSION['success'] = "Информация сохранена!<br>";
            redir("/panel/urlegal/");


        }




        $urlegal = json_decode($Panel::$USER['urlegal'], true);
        $payurinfo = json_decode($Panel::$USER['payurinfo'], true);


        $this->set(compact('urlegal', 'payurinfo'));






    }



    public function faqAction(){
        $Panel =  new Panel();


        $META = [
            'title' => 'Помощь',
            'description' => 'FAQ',
            'keywords' => 'FAQ',
        ];

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "FAQ"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



    }

    public function faqpromoAction(){
        $Panel =  new Panel();


        $META = [
            'title' => 'Помощь',
            'description' => 'FAQ',
            'keywords' => 'FAQ',
        ];

        if ($_SESSION['ulogin']['role'] == "R") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет рекламодателя", 'Url' => "/master"];
        if ($_SESSION['ulogin']['role'] == "O") $BREADCRUMBS['HOME'] = ['Label' => "Кабинет  оператора", 'Url' => "/operator"];
        $BREADCRUMBS['DATA'][] = ['Label' => "FAQ"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



    }


    public function operatorAction(){


        $Panel =  new Panel();


        $META = [
            'title' => 'Каталог операторов',
            'description' => 'Каталог операторов',
            'keywords' => 'Каталог операторов',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "FAQ"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);


        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);


        $operators = $Panel->getoperators();

        $this->set(compact('operators'));




    }

    public function ratingAction(){


        $Panel =  new Panel();


        $META = [
            'title' => 'Каталог операторов',
            'description' => 'Каталог операторов',
            'keywords' => 'Каталог операторов',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "FAQ"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);


        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);


        $operators = $Panel->getoperators();

        $this->set(compact('operators'));




    }


    public function otziviAction(){


        $Panel =  new Panel();


        $META = [
            'title' => 'ОТЗЫВЫ ОПЕРАТОРОВ',
            'description' => 'Каталог операторов',
            'keywords' => 'Каталог операторов',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "FAQ"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);


        $ASSETS[] = ["js" => "/global_assets/js/plugins/tables/datatables/datatables.min.js"];
        $ASSETS[] = ["js" => "/assets/js/datatables_basic.js"];
        \APP\core\base\View::setAssets($ASSETS);


        $operators = $Panel->getcustomoperators([]);

        $this->set(compact('operators'));




    }



    public function chatAction(){


        $Panel =  new Panel();


        $META = [
            'title' => 'ОТЗЫВЫ ОПЕРАТОРОВ',
            'description' => 'Каталог операторов',
            'keywords' => 'Каталог операторов',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "FAQ"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);


        // Загрузка чата

        // Отправка сообщения
        if($this->isAjax()){
            $this->layaout = false;


            // Запись сообщения в БД
            if (!empty($_POST['message']) && !empty($_POST['room']) ) {
                $message = $Panel->addmessagechat($_POST);
                echo json_encode($message);
            }
            // Запись сообщения в БД


            // Рендеринг готового сообщения
            if (!empty($_POST['data']) && !empty($_POST['type']) ) {

                $DATA = json_decode($_POST['data'], true);

               rendermessage($DATA, $rendertype = "ajax");



            }
            // Рендеринг готового сообщения




        }


        $chat = $Panel->loadchatmessage(1);


        $this->set(compact('chat'));




    }



}
?>