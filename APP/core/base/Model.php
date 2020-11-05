<?php
namespace APP\core\base;
use RedBeanPHP\R;
use APP\models\Panel;
use APP\models\Operator;


abstract class Model
{
	public $errors = [];
    static $USER = [];

	public function __construct()
	{
        if(!R::testConnection()){

            R::setup(CONFIG['db']['dsn'],CONFIG['db']['user'],CONFIG['db']['pass']);
//              R::fancyDebug( TRUE );
            //  R::freeze(TRUE);

            if (!empty($_SESSION['ulogin']['id'])){
                self::$USER = $this->loaduser(CONFIG['USERTABLE'], $_SESSION['ulogin']['id']);
            }



        }

	}
	// ЗАГРУЗКА ДАННЫХ ИЗ ФОРМЫ



	public function load($data)
	{
		foreach($this->ATR as $name => $val)
		{
			if(isset($data[$name])) $this->ATR[$name] = $data[$name];
		}
	}
	// ЗАГРУЗКА ДАННЫХ ИЗ ФОРМЫ
	// ПРОВЕРКА ДАННЫХ



	public function validate($data)
	{
		$v = new \Valitron\Validator($data);
		$v->rules($this->rules);
		if($v->validate())
		{
			return true;
		}
		$this->errors = $v->errors();
		return false;
	}
	// ПРОВЕРКА ДАННЫХ
	// Красивый вывод ошибок валидации


    public function validatenew($data, $rules, $labels)
    {

        foreach ($data as $key=>$val){
            $data[$key] = trim($val);
            $data[$key] = strip_tags($val);
            $data[$key] = htmlspecialchars($val);
        }



        $v = new \Valitron\Validator($data);
        $v->rules($rules);
        $v->labels($labels);

        if($v->validate())
        {
            return true;
        }
        $this->errors = $v->errors();
        return false;
    }





	public function getErrorsVali()
	{
		$errors = "<ul>";
		foreach($this->errors as $error) {
			foreach($error as $item)
			{
				$errors .= "<li>".$item."</li>";
			}
		}
		$errors .= "</ul>";
		$_SESSION['errors'] = $errors;
	}
	// Красивый вывод ошибок валидации


    public function loaduser($table,$iduser) {
        return R::load($table, $iduser);
    }




    public function checkbalance($table) {
        $balnow = R::load($table, $_SESSION['ulogin']['id']);
        return $balnow['balance'];
    }

    public function allcontact($iduser) {
        $mass = R::find("contact", "WHERE users_id = ?", [$iduser]);
        return $mass;
    }

    public function allresult($iduser) {
        $mass = R::find("result", "WHERE users_id = ?", [$iduser]);
        return $mass;
    }



    public function addbalanceuser($user, $summa, $comment = ""){

        $user->bal = $user->bal + $summa;
        R::store($user);

        //Зачислить в баланслог
        $balancelog = [
            'users_id' => $user['id'],
            'date' => date("Y-m-d H:i:s"),
            'sum' => $summa,
            'comment' => $comment,
            'type' => "debet",
            'status' => 1,
        ];
        $this->addnewBD("balancelog", $balancelog);
        //Зачислить в баланслог

        return true;
    }


    public function spisaniebalanceuser($user, $summa, $comment = ""){

        $user->bal = $user->bal - $summa;
        R::store($user);

        //Зачислить в баланслог
        $balancelog = [
            'users_id' => $user['id'],
            'date' => date("Y-m-d H:i:s"),
            'sum' => $summa,
            'comment' => $comment,
            'type' => "credit",
            'status' => 1
        ];
        $this->addnewBD("balancelog", $balancelog);
        //Зачислить в баланслог

        return true;
    }


    public static function getBal(){

	    return self::$USER['bal'];
    }


    public static function myproject() {
        $myproject['my'] = 0;

        $operator = new Operator();
        $mycompanies = $operator->mycompanies();

        $allcompanies = $operator->allcompanies();

        $myproject['my'] = count($mycompanies);
        $myproject['all'] = count($allcompanies);

	    return $myproject;

    }




    public static function contact($id, $type = "company") {

	    if ($type == "company") $mass = R::findAll("contact", "WHERE company_id = ?", [$id]);
        if ($type == "user") $mass = R::findAll("contact", "WHERE users_id = ?", [$id]);


        $contact['all'] = '0';
        $contact['free'] = '0';
        $contact['ready'] = '0';
        $contact['perezvon'] = '0';
        $contact['otkaz'] = '0';
        $contact['bezdostupa'] = '0';
        $contact['moderate'] = '0';
        $contact['dorabotka'] = '0';
        $contact['today'] = '0';
        foreach ($mass as  $val) {
            $contact['all']++;
            if ($val['status'] != 0 ) $contact['ready']++;
            if ($val['status'] == 0 ) $contact['free']++;
            if ($val['status'] == 2 ) $contact['perezvon']++;
            if ($val['status'] == 3 ) $contact['otkaz']++;
            if ($val['status'] == 4 ) $contact['bezdostupa']++;
            if ($val['status'] == 5 ) $contact['moderate']++;
            if ($val['status'] == 6 ) $contact['dorabotka']++;
            if ($val['datacall'] == date("Y-m-d") ) $contact['today']++;
        }
        return $contact;

    }


    public static function getres($id, $type = "company") {
        if ($type == "company")  $mass = R::findAll("result", "WHERE company_id = ?", [$id]);
        if ($type == "user")  $mass = R::findAll("result", "WHERE users_id = ?", [$id]);



        $result['all'] = '0';
        $result['moderation'] = '0';
        $result['dorabotka'] = '0';
        $result['today'] = '0';

        foreach ($mass as $val) {
            if ($val['status'] == 1 ) $result['all']++;
            if ($val['status'] == 0 ) $result['moderation']++;
            if ($val['date'] == date("Y-m-d") and $val['status'] == 1  ) $result['today']++;
            if ($val['status'] == 3 ) $result['dorabotka']++;

        }
        return $result;
    }



    public function allzapis($id, $type = "company") {

        if ($type == "company")  $allrecord = R::find( 'records' , 'WHERE  company_id = ?', [$id] );
        if ($type == "user")  $allrecord = R::find( 'records' , 'WHERE  users_id = ?', [$id] );

        if ($type == "contid")  $allrecord = R::find( 'records' , 'WHERE  contact_id = ?', [$id] );


        $MASS = [];
        foreach ($allrecord as $key=>$val){
            $MASS[$val['contact_id']] = $val;
        }
        return $MASS;
    }


    public function myresize($url, $weight, $height ){



        $src = imagecreatefromjpeg($url);
        $w_src = imagesx($src);
        $h_src = imagesy($src);


        $needtype = getsizetypeimage($weight, $height); // Какой типа картинки нам нужен
        $sizetype = getsizetypeimage($w_src, $h_src); // Какую по факту дали


        $image_p = imagecreatetruecolor($weight, $height); // Создаем изображение

        if ($needtype == "kvadrat"){
            $w = 600;
            $dest = imagecreatetruecolor($w,$w);



                if ($sizetype == "kvadrat")
                    imagecopyresized($dest, $src, 0, 0, 0, 0, $w, $w, $w_src, $w_src);

                if ($sizetype == "horizont")
                    imagecopyresized($dest, $src, 0, 0,
                        round((max($w_src,$h_src)-min($w_src,$h_src))/2),
                        0, $w, $w, min($w_src,$h_src), min($w_src,$h_src));

                if ($sizetype == "vertikal"){
                    imagecopyresized($dest, $src, 0, 0, 0, 0, $w, $w,
                        min($w_src,$h_src), min($w_src,$h_src));
                }


            imagecopyresampled($image_p, $dest, 0, 0, 0, 0, $weight, $height, $w, $w);



        }



        if ($needtype == "horizont"){
            imagecopyresampled($image_p, $src, 0, 0, 0, 0, $weight, $height, $w_src, $h_src);
        }

        if ($needtype == "vertikal"){
            imagecopyresampled($image_p, $src, 0, 0, 0, 0, $weight, $height, $w_src, $h_src);
        }


        imagejpeg ($image_p ,$url, 100); // Сохраняем

        return true;







    }





    public function  changeavatar ($url){
        $user = R::load("users", $_SESSION['ulogin']['id']);
        $user->avatar = $url;
        R::store($user);
        return true;
    }


    public function  changelogo ($url, $company){

        if ($company['logo'] != BASELOGO) unlink(WWW.$company['logo']);
        $company->logo = $url;
        R::store($company);
        return true;
    }




    public static function addnewBD($table, $DATA) {

        $tbl = R::dispense($table);
        //ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
        foreach($DATA as $name=>$value)
        {
            $tbl->$name = $value;
        }
        return R::store($tbl);

        // По поводу валидации

    }

    public function filevalidation($FILE, $PARAMS = []){



        if ($FILE['size'] > 3000000) {
            $this->errors[] = ['Файл' => "Размер не должен превышать 3МБ" ];
            return false;
        }

        if ($FILE['size'] < 10) {
            $this->errors[] = ['Файл' => "Файл очень маленький" ];
            return false;
        }

        if ($FILE['type'] != $PARAMS['type']) {
            $this->errors[] = ['Файл' => "Не корректный формат1" ];
            return false;
        }

//        show($PARAMS['ext']);

        // Проверка на допустимый формат
        $format = false;
        foreach ($PARAMS['ext'] as $item) {
            if(preg_match("/$item\$/i", $FILE['name']))  $format = true;
        }
        if ($format == false){
            $this->errors[] = ['Файл' => "Не корректный формат" ];
            return false;
        }
        // Проверка на допустимый формат









	    return true;



    }



    public static function SaveUsr (){


        if (!empty($_GET['utm_source']) && $_GET['utm_source']){


            $Panel =  new Panel();
            $_SESSION['SystemUserId'] = SystemUserId();
            $Panel->AddUtminBD($_GET);




        }






    }




    public static function online (){

        if ($_SESSION['ulogin']) $user = $_SESSION['ulogin']['username'];
        else $user = "guest";


        if ($user != "guset"){

            $online = R::findOne("online", "WHERE user = ?", [$user]);
            if ($online){
                $online->timestamp = time();
                R::store($online);
                return true;
            }

        }

        if ($user == "guest"){
            $online = R::findOne("online", "WHERE ip = ?", [$_SERVER['REMOTE_ADDR']]);
            if ($online) {
                $online->timestamp = time();
                R::store($online);
                return true;
            }
        }


        $MASSREG = [
            'user' => $user,
            'ipu' => $_SERVER['REMOTE_ADDR'],
            'timestamp' => time(),
        ];


        self::addnewBD("online", $MASSREG);


        return true;




    }

    public static function countonline(){
	    return  R::count('online') +1;
    }


    public static function countnewmessages(){
        return  R::count('dialog', "WHERE uvedomlenie =?", [$_SESSION['ulogin']['id']]);
    }



    public static function countoperator(){
        return  R::count('users', "WHERE role=?", ["O"]);
    }


    public static function countrekl(){
        return  R::count('users', "WHERE role=?", ["R"]);
    }



	//ОТПРАВКА E - MAIL
}
?>