<?php
namespace APP\models;
use APP\core\Mail;
use Psr\Log\NullLogger;
use RedBeanPHP\R;

class Operator extends \APP\core\base\Model {


    public function getcontactuser($status = NULL){

        if (!empty($status)){
            $mass = R::findAll("contact", "WHERE users_id = ? AND status =?", [$_SESSION['ulogin']['id'], $status]);
            return $mass;
        }

        $mass = R::findAll("contact", "WHERE users_id = ?", [$_SESSION['ulogin']['id']]);
        return $mass;


    }

    public function getresultuser($status = NULL){

        if (!empty($status)){
            $mass = R::findAll("result", "WHERE users_id = ? AND status =?", [$_SESSION['ulogin']['id'], $status]);
            return $mass;
        }

        $mass = R::findAll("result", "WHERE users_id = ?", [$_SESSION['ulogin']['id']]);
        return $mass;


    }



    public function SetOtkaz($DATA, $company){



        $contact = $this->loadcontact($DATA['contactid']);


        $contact->status = 3;
        $contact->datacall = date("Y-m-d");
        $contact->operatorcomment = $DATA['operatorcomment'];
        R::store($contact);


        $this->pluscall();

        $this->addzapis($DATA['contactid'], $company);


    }

    public function Setbezdostupa($DATA, $company){
        $contact = $this->loadcontact($DATA['contactid']);
        $contact->status =4;
        $contact->datacall = date("Y-m-d");
        $contact->operatorcomment = $DATA['operatorcomment'];
        R::store($contact);
    }



    public function addzapis($idcont, $company){

        $zapis = R::findOne("records", "WHERE contact_id =? " , [$idcont]);


        $DATAZAPIS = getrecord2($idcont);

        if (empty($zapis)){
            $massiv = [
                'contact_id' => $idcont,
                'users_id' => $_SESSION['ulogin']['id'],
                'company_id' => $company['id'],
                'DATA' => json_encode($DATAZAPIS, true),
                'date' => date("Y-m-d H:i:s"),
            ];
            $this->addnewBD("records", $massiv);

        }


        if (!empty($zapis)){
            $zapis->DATA = json_encode($DATAZAPIS, true);
            R::store($zapis);

        }

        return $DATAZAPIS;





        //
    }





    public function SetResult($DATA, $company){


        $nomerresult = pole_valid ($_POST['nomerresult'], 15, 's');
        if (!empty($nomerresult['error'])) message($nomerresult['error']);


        $operatorcomment = trim($_POST['operatorcomment']);
        $operatorcomment = strip_tags($operatorcomment);
        $operatorcomment = htmlspecialchars($operatorcomment);
        iconv_strlen($operatorcomment, 'UTF-8');
        if (strlen($operatorcomment) > 1000) message("Комментарий от оператора не может быть больше 1000 символов");

        // Считаем кол-во полей.

        $RESULTMASS = json_decode($company['formresult'],true);
        $countresult = count($RESULTMASS);
        //Считаем кол-во полей

        // Составляем массив результатов
        foreach ($RESULTMASS as $key=>$val){
            $valuepole = "";
            $valuepole = $DATA['customresult'.$key];
            $valuepole = pole_valid ($valuepole, 300, 's');
            if (!empty($valuepole['error'])) message($valuepole['error']);
            $RESULTMASS[$key]['VAL'] = $valuepole;
        }

        $RESULTMASS[] = ['NAME' => "Телефон", 'VAL' => $nomerresult];
        $RESULTMASS[] = ['NAME' => "Комментарий оператора", 'VAL' => $operatorcomment];


        // Обновляем статус контакта
        $contact = $this->loadcontact($DATA['contactid']);
        $contact->status =5;
        $contact->datacall = date("Y-m-d");
        $contact->operatorcomment = $DATA['operatorcomment'];
        $contact->resultmass = json_encode($RESULTMASS,true);
        R::store($contact);
        // Обновляем статус контакта



        $this->addzapis($DATA['contactid'], $company);

        //ПРОВЕРКА ЕСТЬ ЛИ ТАКОЙ КОНТАКТ



        $this->pluscall();

        $this->plusresult();


        $komy = R::Load("users", $company['client_id']);
        $USN = [
            'operatorname' => self::$USER['username'],
            'user' => $komy['username'],
            'idc' => $company['id'],
            'projectname' => $company['company']

        ];


//        if ($komy['nmessages'] == 1)
//            Mail::sendMail("newresult", "Успешный звонок! - ".CONFIG['NAME'], $USN, ['to' => [['email' =>$komy['email']]]] );






    }


    public function SetPerezvon($DATA, $company){


        $nomerperezvona = pole_valid ($_POST['nomerperezvona'], 15, 's');
        if (!empty($nomerperezvona['error'])) message($nomerperezvona['error']);

        $dataperezvona = pole_valid ($_POST['dataperezvona'], 15, 's');
        if (!empty($dataperezvona['error'])) message($dataperezvona['error']);


        $contact = $this->loadcontact($DATA['contactid']);
        $contact->status = 2;
        $contact->dataperezvona = $dataperezvona;
        $contact->tel = $nomerperezvona;
        $contact->datacall = date("Y-m-d");
        $contact->operatorcomment = $DATA['operatorcomment'];
        R::store($contact);



        $this->addzapis($DATA['contactid'], $company);


    }



    public function joincompany($idc){

        $company = R::load('company', $idc);

        $massivoperatorov = json_decode($company['operators'], true);
        if (!$massivoperatorov) $massivoperatorov = [];

        $operatorInProject = array_key_exists($_SESSION['ulogin']['id'],$massivoperatorov);

        // СТАТУС 1 = НА МОДЕРАЦИИ
        // СТАТУС 2 = ОПЕРАТОР РАБОТАЕТ НА ПРОЕКТЕ
        // СТАТУС 3 = ОПЕРАТОРо ЗАБАНЕН НАПРОЕКТЕ

        if ($operatorInProject == false){
            $massivoperatorov[$_SESSION['ulogin']['id']] = 1;
            $company->operators = json_encode($massivoperatorov, true);
            R::store($company);

            return true;
        }

        if ($operatorInProject == true){
            if ($massivoperatorov[$_SESSION['ulogin']['id']] == 1) return "Вы уже подали заявку в этот проект";
            if ($massivoperatorov[$_SESSION['ulogin']['id']] == 2) return "Вы уже работаете на этом проекте";
            if ($massivoperatorov[$_SESSION['ulogin']['id']] == 3) return "Вы не можете подать заявку в данный проект";
        }


    }

    public function allcompanies() {
        $companyDB = R::findAll('company', 'WHERE status != 2');
        return $companyDB;
    }


    public function addbonuce(){

        $datedoday = date("Y-m-d");

         $bilaliviplata =  R::findOne('paybonus', 'WHERE user_id =? AND `date` =? ', [$_SESSION['ulogin']['id'], $datedoday]);


         if (!empty($bilaliviplata)) return false;

         if (empty($bilaliviplata)){

             $user = R::load(CONFIG['USERTABLE'], $_SESSION['ulogin']['id']);
             $this->addbalanceuser($user, 300, "Начисление бонуса за KPI");


             $DATA = [
                 'user_id' => $_SESSION['ulogin']['id'],
                'date' => $datedoday
                 ];


             $this->addnewBD("paybonus", $DATA);



         }



        return true;

    }




    public function topleaders(){

        $datedoday = date("Y-m-d");


        // ЗВОНКИ СО СТАТУСОМ
        $result['all'] = R::findAll('contact', 'WHERE  (`status` = 5 OR `status` = 8) AND datacall =? LIMIT 10', [$datedoday]);

        $result['group'] = R::findAll('contact', 'WHERE (`status` = 5 OR `status` = 8) AND datacall =? GROUP BY `users_id` LIMIT 10 ', [$datedoday]);


        return $result;

    }



    public function mycalls(){

        // ЗВОНКИ СО СТАТУСОМ
        $mycalls = R::findAll('contact', 'WHERE `users_id` =? AND `status` != 1  ', [$_SESSION['ulogin']['id']]);


        return $mycalls;

    }


    public function todaystat(){

        $datedoday = date("Y-m-d");

        // ЗВОНКИ СО СТАТУСОМ
        $calltoday['calls'] = R::count('contact', 'WHERE datacall =? AND `users_id` =? AND `status` != 4 AND `status` !=1  ', [$datedoday, $_SESSION['ulogin']['id']]);

        // УСПЕШНЫЕ ЗВОНКИ
        $calltoday['moderate'] = R::count('contact', 'WHERE datacall =? AND `users_id` =? AND `status` = 5', [$datedoday, $_SESSION['ulogin']['id']]);

        // МОДЕРАЦИЯ
        $calltoday['result'] = R::count('contact', 'WHERE datacall =? AND `users_id` =? AND `status` = 8', [$datedoday, $_SESSION['ulogin']['id']]);


        return $calltoday;

    }



    public function statuscall(){

        $statuscall['acess'] = false;
        $statuscall['text'] = '<span class="badge badge-secondary">Вы НЕ можете звонить</span>';


        $statuscall['about']  =  ($_SESSION['ulogin']['aboutme'] == null) ? false : true;
        $statuscall['avatar'] = ($_SESSION['ulogin']['avatar'] == null || $_SESSION['ulogin']['avatar'] == BASEAVATAR ) ? false : true;
        $statuscall['audio'] = (empty($_SESSION['ulogin']['audio']) || $_SESSION['ulogin']['audio'] == null ) ? false : true;
        $statuscall['code'] = ($_SESSION['ulogin']['code'] != null ) ? false : true;


        if (
            $statuscall['about'] == true &&
            $statuscall['avatar'] == true &&
            $statuscall['audio'] == true &&
            $statuscall['code'] == true )

        {
            $statuscall['text'] = '<span class="badge badge-success">Вы можете звонить</span>';
            $statuscall['acess'] = true;
        }




        return $statuscall;

    }



    public function mycompanies() {
        $company = R::findAll('company');

        foreach ($company as $key=>$val){
            $massivoperatorov = json_decode($val['operators'], true);
            if (!$massivoperatorov) $massivoperatorov = [];
            $operatorInProject = array_key_exists($_SESSION['ulogin']['id'],$massivoperatorov);
            if ($operatorInProject == false) unset($company[$key]);
        }


        return $company;
    }

    public function getscript($idc) {

        $script = R::findOne('script', 'WHERE idc = ?', [$idc]);

        return $script['script'];
    }

    public function checkcompany($idc) {
        if (empty($_SESSION['ulogin']['perezvon'])) {
            $checkcompany = R::findOne('company', 'WHERE id = ? AND status = 1', [$idc]);
        }
        else {
            $checkcompany = R::findOne('company', 'WHERE id = ?', [$idc]);
        }
        if ($checkcompany) return $checkcompany;
        return false;
    }

    public function newcontact($idc) {
        $contactinfo = $this->Getbron($idc);
        if ($contactinfo) return $contactinfo;
        return R::findOne('contact', 'WHERE company_id = ? AND status = 0', [$idc]);
    }


    public function loadcontact($id) {
        return R::findOne('contact', 'id = ? ', [$id]);
    }



    public function setbron($idcont) {

        $contact = R::load('contact',$idcont);
        $contact->status = 1;
        $contact->usersId = $_SESSION['ulogin']['id'];
        R::store($contact);


    }

    public function Getbron($idc) {
        return R::findOne('contact', 'company_id = ? AND users_id =? AND status = 1', [$idc, $_SESSION['ulogin']['id']]);
    }


    public  function plusresult(){

        $userall = R::load('users', $_SESSION['ulogin']['id']);
        $userall->totalresult = $userall['totalresult'] +1;
        R::store($userall);

    }


    public  function pluscall(){

        $userall = R::load('users', $_SESSION['ulogin']['id']);
        $userall->totalcall = $userall['totalcall'] +1;
        R::store($userall);

        }


    public function getcom($idc){
        $company = R::findOne('company', 'WHERE id = ? LIMIT 1', [$idc]);
        return $company;
    }

    public function getmycom($idc){
        $company = R::findOne('company', 'WHERE id = ? LIMIT 1', [$idc]);

        $massivoperatorov = json_decode($company['operators'], true);
        if (!$massivoperatorov) $massivoperatorov = [];


        $operatorInProject = array_key_exists($_SESSION['ulogin']['id'],$massivoperatorov);

        // Проверка на допуск оператора к проекту
        if ($operatorInProject == true && $massivoperatorov[$_SESSION['ulogin']['id']] == 2) return $company;

//        if ($operatorInProject == true ) return $company;

        return false;


    }

    public static function mystatusincompany($company)
    {

        $massivoperatorov = json_decode($company['operators'], true);
        if (!$massivoperatorov) $massivoperatorov = [];
        $operatorInProject = array_key_exists($_SESSION['ulogin']['id'],$massivoperatorov);
        if ($operatorInProject === false) return false;
        return $massivoperatorov[$_SESSION['ulogin']['id']];


    }


}
?>