<?php
namespace APP\models;
use APP\core\Mail;
use RedBeanPHP\R;

class Project extends \APP\core\base\Model {


    public function switcnedostup($idc) {
        //ОБНОВЛЯЕМ СБРАСЫВАЕМ СТАТУСЫ
        R::exec(" UPDATE `contact` SET `status` = '0', `users_id` = '0'   WHERE `company_id` = '".$idc."' AND `status` = 4  ;	");
        //ОБНОВЛЯЕМ СБРАСЫВАЕМ СТАТУСЫ
        return true;
    }


    public function switchotkaz($idc) {
        //ОБНОВЛЯЕМ СБРАСЫВАЕМ СТАТУСЫ
        \R::exec(" UPDATE `contact` SET `status` = '0', `users_id` = '0'   WHERE `company_id` = '".$idc."' AND `status` = 3; ");
        //ОБНОВЛЯЕМ СБРАСЫВАЕМ СТАТУСЫ
        return true;
    }


    public function dubli($idc) {

        $result = R::getAll( "SELECT tel,id FROM `contact` WHERE  `status` = '0' AND `company_id` = '".$idc."' ");
        $tel = array();
        $dublcount = 0;

        foreach ($result as $row) {
            unset($dubl);
            $dubl = in_array($row['tel'], $tel);
            if ($dubl) {
                $row['tel'] = "ДУБЛЬ";
                $dublcount++;
                R::exec(" DELETE FROM `contact` WHERE `contact`.`id` = '".$row['id']."' ");
            }
            $tel[] = $row['tel'];
        }
        if (!isset($dublcount)) $dublcount = 0;

        return "Найдено и удалено <b> ".$dublcount." </b> дублей ";

    }




    public function acceptresult($contactresult){

        $contactresult->status = 8;
        R::store($contactresult);

        $userinfo = $contactresult->users;
        $companyinfo = $contactresult->company;


        // ЗАЧИСЛЕНИЕ БАЛАНСА МОДЕРАТОРУ
            // Сумма на начисление
            $cenazaresult = $companyinfo['priceoperator'];
             $cenazaresult = round(($cenazaresult/100*13), 2);
            $moderator =  R::Load("users", "183");

        $comment = 'Модерация готовых лидов в проекте '.$companyinfo['company'];
        $this->addbalanceuser($moderator, $cenazaresult, $comment);

        // ЗАЧИСЛЕНИЕ БАЛАНСА МОДЕРАТОРУ


        // Добавление в таблицу результат
        $result = [
            'users_id' => $contactresult['users_id'],
            'company_id' => $companyinfo['id'],
            'contact_id' => $contactresult['id'],
            'dataresult' => $contactresult['resultmass'],
            'contactinfo' => json_encode($contactresult, true),
            'status' => 1,
            'date' => date("Y-m-d"),
            'type' => $companyinfo['type'],
        ];
        $this->addnewBD("result", $result);
        // Добавление в таблицу результат




        // Прибавление статистики
        $userinfo->totalresult = $userinfo->totalresult++;


        // Зачислить пользователю
        $comment = 'Заработок в проекте '.$companyinfo['company'];
        $this->addbalanceuser($userinfo, $companyinfo['priceoperator'], $comment);
        // Зачислить пользователю


        // Списать баланс с пользователя
        $imuser = $this->loaduser(CONFIG['USERTABLE'], $_SESSION['ulogin']['id']);

        $_SESSION['ulogin']['bal'] = $_SESSION['ulogin']['bal'] - $companyinfo['priceresult'];

        $comment = 'Списание за результат в проекте '.$companyinfo['company'];
        $this->spisaniebalanceuser($imuser, $companyinfo['priceresult'], $comment);
        // Списать баланс с пользователя


        //Зачислить реффералу
//        $comment = 'Рефферальные отчисления пользователь '.$userinfo['username'];
//        $this->addbalanceuser($userinfo, $companyinfo['resultcall'], $comment);
        //Зачислить реффералу



        // Пополнения балансов и всякой статистики (звонки/итп)


        return true;
    }


    public function rejectresult($contactresult, $comment){


        $contactresult->status = 7;
        $contactresult->dorabotkacomment = $comment;
        R::store($contactresult);

        $companyinfo = $contactresult->company;

        // Добавление в таблицу результат
        $result = [
            'users_id' => $contactresult['users_id'],
            'company_id' => $companyinfo['id'],
            'contact_id' => $contactresult['id'],
            'dataresult' => $contactresult['resultmass'],
            'contactinfo' => json_encode($contactresult, true),
            'status' => 2,
            'date' => date("Y-m-d"),
            'type' => $companyinfo['type'],
        ];
        $this->addnewBD("result", $result);
        // Добавление в таблицу результат



        return true;
    }




    public function editoffer($DATA, $company){



        $nameproduct = pole_valid ($DATA['nameproduct'], 100, 's');
        if (!empty($nameproduct['error'])) return $nameproduct['error'];

        $aboutproduct = pole_valid ($DATA['aboutproduct'], 2000, 's');
        if (!empty($aboutproduct['error'])) return $aboutproduct['error'];

        $minimumprice = pole_valid ($DATA['minimumprice'], 20, 'smax');
        if (!empty($minimumprice['error'])) return $minimumprice['error'];

        $dopmaterial = pole_valid ($DATA['dopmaterial'], 2000, 's');
        if (!empty($dopmaterial['error'])) return $dopmaterial['error'];




        $company->nameproduct = $nameproduct;
        $company->aboutproduct = $aboutproduct;
        $company->minimumprice = $minimumprice;
        $company->dopmaterial = $dopmaterial;
        R::store($company);
        return true;


    }


    public function addtrebovanie($DATA, $company){


        $trebovanie = pole_valid ($DATA['trebovanie'], 1000, 'smax');
        if (!empty($trebovanie['error'])) return $trebovanie['error'];

        $company->trebovanie = $trebovanie;
        R::store($company);
        return true;


    }


    public function acceptoperator($company, $idoper){

        $operators = json_decode( $company['operators'], true);

        if ($operators[$idoper] == 1) $operators[$idoper] = 2;
        $operators = json_encode($operators, true);
        $company->operators = $operators;

        R::store($company);


        // Уведомление на E-mail
        $komyuser = R::Load("users", $idoper);
        $USN = [
            'user' => $komyuser['username'],
            'projectname' => $company['company'],
        ];

        if ($komyuser['nmessages'] == 1)
            Mail::sendMail("acceptoperator", "Допуск на проект - ".CONFIG['NAME'], $USN, ['to' => [['email' =>$komyuser['email']]]] );

        // Уведомление на E-mail

        return true;


    }


    public function rejectoperator($company, $idoper){


        $operators = json_decode( $company['operators'], true);

        if ($operators[$idoper] ) $operators[$idoper] = 3;

        $operators = json_encode($operators, true);

        $company->operators = $operators;

        R::store($company);

        return true;


    }






    public function operatorsinproject($company){

        $OperatoriNaModeracii = [];
        $OperatoriNaProekte = [];

        $newpass = json_decode($company['operators'], true);
        if (empty($newpass)) $newpass = [];

        foreach ($newpass as $key=>$val){
            if ($val == 2) $OperatoriNaProekte[]  = R::load('users', $key);
            if ($val == 1) $OperatoriNaModeracii[]  = R::load('users', $key);
        }


        $result['OperatoriNaProekte'] = $OperatoriNaProekte;
        $result['OperatoriNaModeracii'] = $OperatoriNaModeracii;

        return $result;

    }




	public function getcom($idc) {


		if( isset($_SESSION['ulogin']['woof']) || $_SESSION['ulogin']['woof'] == "1") {
			$company = R::findOne('company', 'WHERE id = ? LIMIT 1', [$idc]);
		} else {
			$company = R::findOne('company', 'WHERE id = ? AND client_id = ? LIMIT 1', [$idc, $_SESSION['ulogin']['id']]);
		}
		if(!isset($company)) redir('/panel');
		return $company;
	}

    public  function setscript($script){

        $tbl = R::FindOne("script", "WHERE idc = ?", [$script['idc']]);

        if ($tbl){
            $tbl->script = $script['script'];
            return R::store($tbl);
        }else{

            $this->addnewBD("script", $script);


        }






	    return true;
    }


    public function delpoleformresult($DATA, $idc){


        if ($DATA['element'] == 0) return "Нельзя удалить единственный элемент формы";

        $element = pole_valid ($DATA['element'], 3, 'i');
        if (!empty($element['error'])) return $element['error'];


        $company = R::findOne("company", "WHERE id = ?", [$idc]);


        $formresult = json_decode($company['formresult'],TRUE);
        unset($formresult[$element]);
        $formresult = json_encode($formresult,JSON_UNESCAPED_UNICODE);
        $company->formresult = $formresult;
        R::store($company);



        return true;

    }





    public function addpoleformresult ($DATA, $idc){


        $name = pole_valid ($DATA['NAME'], 100, 's');
        if (!empty($name['error'])) return $name['error'];
        $type = pole_valid ($DATA['TYPE'], 5, 'i');
        if (!empty($type['error'])) return $type['error'];



        $company = R::findOne("company", "WHERE id = ?", [$idc]);

        $formresult = json_decode($company['formresult'],TRUE);

        $formresult[] = ["NAME" => $name, "TYPE" => $type] ;

        $formresult = json_encode($formresult,JSON_UNESCAPED_UNICODE);

        $company->formresult = $formresult;
        R::store($company);


        return true;




    }








    public function dorebotkaresult($contact, $DATA) {

        $contact->status = 6;
        $contact->dorabotkacomment = $DATA['comment'];
        R::store($contact);

        return true;



    }


    public function contactresult($idc, $status = 5) {

        $contactresult =  R::find('contact','WHERE company_id = ? AND status = ?' , [$idc, $status]);


        return $contactresult;
    }


    public function statoperator($idc) {

        // ОДОБРЕННЫЕ
        $accept = R::findAll('result', 'WHERE company_id =? AND status =1 ', [$idc]);

        // ОТКЛОНЕННЫЕ
        $reject = R::findAll('result', 'WHERE company_id =? AND status =2 ', [$idc]);


//        show($result);
        $MASSACEPT = [];
        foreach ($accept as $val){
            if (empty($MASSACEPT[$val->users['id']])) $MASSACEPT[$val->users['id']] = 0;
            $MASSACEPT[$val->users['id']]++;
            $USERMASS[$val->users['id']] = $val->users;
        }

        $MASSREJECT = [];
        foreach ($reject as $val){
            if (empty($MASSREJECT[$val->users['id']])) $MASSREJECT[$val->users['id']] = 0;
            $MASSREJECT[$val->users['id']]++;
            $USERMASS[$val->users['id']] = $val->users;
        }

        $result['USERMASS'] = $USERMASS;
        $result['MASSACEPT'] = $MASSACEPT;
        $result['MASSREJECT'] = $MASSREJECT;
        return $result;

    }




	public function companyresult($idc) {

        $result = R::findAll('result', 'WHERE company_id =? AND `status` = 1', [$idc]);
		return $result;


	}
	public function records($idc) {
		$records = R::find('zapisi_new','WHERE company_id = ?' , [$idc]);
		return $records;
	}
	public function operators($idc) {
		$operators = R::findAll( 'users' , ' ORDER BY `points` DESC ' );
		return $operators;
	}
	public function joincompany($idc) {
		$joincompany = R::findAll( 'joincompany' , 'WHERE company_id = ?',[$idc] );
		foreach ($joincompany as $val) {
			$join[$val['users_id']]['record'] = $val['record'];
			$join[$val['users_id']]['message'] = $val['message'];
		}
		return $join;
	}
	public function allrecord($idc) {
		$allrecord = R::find( 'contact' , 'WHERE  company_id = ? AND `status` != 1 AND `status` != 0 ORDER BY `id` DESC', [$idc] );
		return $allrecord;
	}





	public function zayavki($idc) {
		$zayavki = R::findAll("joincompany", "WHERE status = 1 AND company_id = ?", [$idc] );;
		return $zayavki;
	}
	public function allcompany() {
		return  R::findAll("company");
	}
	public function getscript($idc) {
		$script = R::findOne('script','WHERE  idc = ?' , [$idc]);
		return $script['script'];
	}


	public function opers($idc) {
		$allop = R::findAll( 'users' );
		$opers = "";
		foreach ($allop as $row) {
			if ($row['mycamid']) {
				$mycamid = json_decode($row['mycamid'], true);
				$sm = in_array($idc, $mycamid);
				if ($sm) {
					$opers[$row['id']] = "".$row['firstname']." " ;
				}
			}
		}
		return $opers;
	}
	public function frecord($allrecord, $idc, $oper, $res, $data) {
		if ($res != "nope") {
			foreach ($allrecord as $key => $val) {
				if ($val['status'] !== $res) unset($allrecord[$key]);
			}
		}
		if ($data != "Выбрать дату") {
			foreach ($allrecord as $key => $val) {
				if ($val['datacall'] != $data) unset($allrecord[$key]);
			}
		}
		if ($oper != "nope") {
			foreach ($allrecord as $key => $val) {
				if ($val['users_id'] != $oper) unset($allrecord[$key]);
			}
		}
		return $allrecord;
	}
	public function checkbalance($table) {
		$balnow['bal'] = '0';
		$balnow = R::load($table, $_SESSION['ulogin']['id']);
		return $balnow['bal'];
	}
	public function filterresult($company,$dataresult) {
		foreach ( $company->ownResultList as $key=>$val) {
			if ($val['date'] != $dataresult) {
				unset($company->ownResultList[$key]);
			}
		}
		return $company;
	}
	public function checkbalanceinproject($table,$idc) {


		$balnow['bal'] = '0';
        $balnow = R::load($table, $_SESSION['ulogin']['id']);
        return $balnow['bal'];

//
//		if( isset($_SESSION['ulogin']['woof']) || $_SESSION['ulogin']['woof'] == "1") {
//			$cid = R::load("company", $idc);
//			$balnow = R::load($table, $cid['client_id']);
//		} else {
//
//		}




	}
	public function validbalance($balnow, $company) {
//		$balneed = $company['cfc']*($company['daylimit']/2);
        $balneed = 5000;
		if($balnow >= $balneed) return true;
		return false;
	}
	public function checkscript($idc) {
		$script = R::findOne('script','WHERE  idc = ?' , [$idc]);
		if (strlen($script['script']) <= 100) return false;
		return true;
	}
	public function tryplay($GET, $status, $idc) {


	//	$timenow = date("H:i");
//		$utro = "09:00";
//		$vecher = "19:00";
//		if ( strtotime($timenow) > strtotime($vecher)  ) return "Не время";


		if($status['balance'] == false)  return ('Проект НЕ активирован: Пополните баланс.');
		if($status['contact'] == false) return ('Проект НЕ активирован: Добавьте контактов.');
		if($status['script'] == false) return ('Проект НЕ активирован: Отредактируйте скрипт разговора.');

		if($status['balance'] == true &&  $status['contact'] == true && $status['script'] == true) {
			R::exec(" UPDATE `company` SET `status` = '1' WHERE `id` = '".$idc."' ");
		}

		return true;

	}



	public function pstop($GET, $idc) {
		R::exec(" UPDATE `company` SET `status` = '2' WHERE `id` = '".$idc."' ");
		go2('project/?id='.$GET['id'].'');
	}




	// ОКОНЧАНИЕ КЛАССА
}
?>