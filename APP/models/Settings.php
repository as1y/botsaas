<?php
namespace APP\models;
use RedBeanPHP\R;

class Settings extends \APP\core\base\Model {

    // АТРИБУТЫ КОТОРЫЕ ЗАБИРАЕМ ПРИ ДОБАВЛЕНИИ
    public $ATR = [

        'idc' => '',
        'priceresult' => '',
        'aboutcompany' => '',
        'daylimit' => '',
        'mincall' => '',
        'bonuscall' => '',
        'timecall' => '',
        'email' => ''
    ];
    // Правила валидации
    public $rules = [
        'required' => [
            ['priceresult'],
            ['aboutcompany'],
            ['daylimit'],
            ['timecall'],
            ['idc'],
        ],
        'email' =>[
            ['email'],
        ],

//        'lengthMin' =>[
//            ['signup-password',5],
//            ['signup-password-confirm',5],
//        ],
//        'lengthMax' =>[
//            ['signup-password',30],
//            ['signup-password-confirm',30],
//            ['signup-username',30],
//        ],

    ];




	public function editsettingsroject($DATA) {

        $tbl = R::FindOne("company", "WHERE id = ?", [$DATA['idc']]);
        //ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
        foreach($DATA as $name=>$value)
        {
            $tbl->$name = $value;
        }
        return R::store($tbl);

            // По поводу валидации

	}






}
?>