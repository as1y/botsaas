<?php
namespace APP\models;
use RedBeanPHP\R;

class Addp extends \APP\core\base\Model {

	public function addproject($DATA) {


        //ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
        $uniq = [
            'client_id' => $_SESSION['ulogin']['id'],
            'status' => "2",
            'logo' => BASELOGO,
            'datastart' => date("Y-m-d H:i:s"),
            'daylimit' => "5",
            'formresult' => '[{"NAME":"Имя","TYPE":1}]',
        ];

        $DATA = array_merge($uniq, $DATA);

        show($DATA);

        $tbl = R::dispense("company");
        //ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
        foreach($DATA as $name=>$value)
        {
            $tbl->$name = $value;
        }
        return R::store($tbl);

            // По поводу валидации

	}



    public function validatenewproject($DATA){

        $rules = [
            'required' => [
                ['company'],
                ['transkr'],
                ['adress'],
                ['tematika'],
                ['aboutcompany'],
                ['nameproduct'],
                ['type'],
                ['priceresult'],
                ['timecall'],

            ],
            'email' =>[
                ['email'],
            ],

            ];

        $labels = [

            'company' => '<b>Компания</b>',
            'transkr' => '<b>Транскрипция</b>',
            'adress' => '<b>Адрес</b>',
            'tematika' => '<b>Тематика</b>',
            'aboutcompany' => '<b>О компании</b>',
            'nameproduct' => '<b>Название продукта</b>',
            'priceresult' => '<b>Цена за результат</b>',
            'mincall' => '<b>Минимальная цена</b>',
            'timecall' => '<b>Время звонков</b>'

        ];

        return  $this->validatenew($DATA, $rules, $labels);



    }





}
?>