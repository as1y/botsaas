<?php
namespace APP\models;
use Psr\Log\NullLogger;
use RedBeanPHP\R;
use APP\models\Panel;

class User extends \APP\core\base\Model
{
	// АТРИБУТЫ КОТОРЫЕ ЗАБИРАЕМ ПРИ РЕГИСТРАЦИИ


    public function validateregistration($DATA){


    if ($DATA['role'] == "O"){
        $rules = [

            'required' => [
                ['username'],
                ['email'],
                ['password'],
                ['password2'],
                ['terms'],
                ['contact'],
            ],
            'email' =>[
                ['email'],
            ],
            'lengthMin' =>[
                ['password',5],
                ['password2',5],
            ],
            'lengthMax' =>[
                ['password',30],
                ['password2',30],
                ['username',30],
            ],
            'equals' =>[
                ['password', 'password2' ],
            ],


        ];
    }

        if ($DATA['role'] == "R"){
            $rules = [

                'required' => [
                    ['username'],
                    ['email'],
                    ['password'],
                    ['password2'],
                    ['terms'],
                    ['phone'],
                ],
                'email' =>[
                    ['email'],
                ],
                'lengthMin' =>[
                    ['password',5],
                    ['password2',5],
                ],
                'lengthMax' =>[
                    ['password',30],
                    ['password2',30],
                    ['username',30],
                ],
                'equals' =>[
                    ['password', 'password2' ],
                ],


            ];
        }

        $labels = [
            'phone' => '<b>Телефон</b>',
            'contact' => '<b>Контакт SKYPE или TELEGRAM</b>',
            'username' => '<b>Имя Фамилия</b>',
            'email' => '<b>email</b>',
            'password' => '<b>Пароль</b>',
            'password2' => '<b>Повтор пароля</b>'
        ];


        return  $this->validatenew($DATA, $rules, $labels);




    }



	// ПРОВЕРКА НА УНИКАЛЬНЫЙ ЕМЕЙЛ
	public function checkUniq($table, $email)
	{
		$uni = R::findOne($table, 'email = ? LIMIT 1',[$email]);
		if($uni){
			if($uni->email == $email){
				$this->errors['uniq'][] = "Пользователь с таким E-mail уже зарегистрирован";
			}
			return false;
		}
		return true;
	}
	// ПРОВЕРКА НА УНИКАЛЬНЫЙ ЕМЕЙЛ
	//СБРОС ПАРОЛЯ
	public function newpass()
	{
		$newpass = random_str(10);
		$tbl = R::load(CONFIG['USERTABLE'], $_SESSION['confirm']['id']);
		$tbl->pass = password_hash($newpass , PASSWORD_DEFAULT);
		R::store($tbl);
		return $newpass;
	}
	//СБРОС ПАРОЛЯ


    public function confirmemail($email, $code){


        $confirm = R::findOne(CONFIG['USERTABLE'], 'email = ? AND code = ? LIMIT 1',[$email, $code]);


        if ($confirm){

            $confirm->code = NULL;
            R::store($confirm);
            return $confirm;
        }



        if (!$confirm)  return false;


    }






	//ЛОГИН
	public function login($table)
	{




		$email = !empty(trim($_POST['email'])) ? trim($_POST['email']) : NULL;
		$pass = !empty(trim($_POST['password'])) ? trim($_POST['password']) : NULL;


		if ($email && $pass){
			$user = R::findOne($table, 'email = ? LIMIT 1',[$email]);
			if($user){
				if(password_verify($pass, $user->pass)){
					// АВТОРИЗАЦИЯ
					foreach ($user as $k => $v){
						$_SESSION['ulogin'][$k] = $v;
						$_SESSION['ulogin']['pass'] = "";
					}
					// АВТОРИЗАЦИЯ
					return true;
				}
			}
		}
		return false;
	}
	//ЛОГИН

    public function logintest($table)
    {

        $email = !empty(trim($_POST['email'])) ? trim($_POST['email']) : NULL;
        $pass = !empty(trim($_POST['password'])) ? trim($_POST['password']) : NULL;


        if ($email && $pass){
            $user = R::findOne($table, 'email = ? LIMIT 1',[$email]);
            if($user){
                // АВТОРИЗАЦИЯ
                foreach ($user as $k => $v){
                    $_SESSION['ulogin'][$k] = $v;
                    $_SESSION['ulogin']['pass'] = "";
                }
                // АВТОРИЗАЦИЯ
                return true;
            }
        }
        return false;
    }




	public function saveuser($table)
	{
		$tbl = R::dispense($table);

        //Проверяем рефку
		if(empty($_SESSION['confirm']['ref'])) $_SESSION['confirm']['ref'] = NULL;

		// Проверяем РОЛЬ
       $role = ($_SESSION['confirm']['role'] == "R") ? "R" : "O";



//       $avatar = "/assets/oper1.jpg"; //Выставляем базовый аватар в зависимости от роли

        // Отправка конверсии в GA
        $Panel = new Panel();
        if ($role == "O") $Panel->sendPostBackGA();
        if ($role == "R") $Panel->sendPostBackGArekl();
        unset($_SESSION['form_data']);
        // Отправка конверсии в GA


		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
		$MASSREG = [
	    	'username' => $_SESSION['confirm']['username'],
            'contact' => $_SESSION['confirm']['contact'],
            'phone' => $_SESSION['confirm']['phone'],
	    	'email' => $_SESSION['confirm']['email'],
	    	'pass' => $_SESSION['confirm']['password'],
	    	'ref' => $_SESSION['confirm']['ref'],
	    	'datareg' => date("Y-m-d H:i:s"),
            'avatar' => BASEAVATAR, // Расположение базового аватара
            'nnews' => 1, // Уведомления почтовые
            'nmessages' => 1, // Уведомления почтовые
            'role' => $role, //Роль
            'bal' => 0, //Баланс
            'code' => $_SESSION['confirm']['code'],
            'systemuserid' => $_SESSION['SystemUserId'],
            'talk' => '0',
            'totalcall' => '0',
            'bonusrefu' => NULL,

		];
		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
		foreach($MASSREG as $name=>$value)
		{
			$tbl->$name = $value;
		}
		return R::store($tbl);


	}
	// SAVEUSER
	// ПРОВЕРКА ЕСТЬ ЛИ ТАКОЙ ЕМЕЙЛ
	public function checkemail($table, $email)
	{
		$uni = R::findOne($table, 'email = ? LIMIT 1', [$email]);

		if($uni){
			if($uni->email == $email){
				$_SESSION['confirm']['id'] = $uni->id;
				return true;
			}
		}
		return false;
	}
	// ПРОВЕРКА ЕСТЬ ЛИ ТАКОЙ ЕМЕЙЛ
}
?>