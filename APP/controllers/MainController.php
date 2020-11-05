<?php
namespace APP\controllers;
use APP\models\Main;
use APP\core\Cache;
use APP\core\base\Model;
use APP\models\Panel;

class MainController extends AppController {

	public function operatorAction(){

        $Panel = new Panel();

        $META = [
            'title' => 'Биржа операторов на телефоне, удаленная работа оператором '.APPNAME,
            'description' => 'Биржа операторов на телефоне'.APPNAME,
            'keywords' => 'Биржа операторов на телефоне'.APPNAME,
        ];



        \APP\core\base\View::setMeta($META);
        $operators = $Panel->getoperators(15);
        $this->set(compact('operators'));


	}


    public function indexAction(){

        $Panel = new Panel();

        $this->layaout = "REKLAMA";


        $META = [
            'title' => 'Биржа операторов на телефоне. Страница заказчика '.APPNAME,
            'description' => 'Биржа операторов на телефоне'.APPNAME,
            'keywords' => 'Биржа операторов на телефоне'.APPNAME,
        ];



        \APP\core\base\View::setMeta($META);
        $operators = $Panel->getoperators(6);
        $this->set(compact('operators'));


    }


    public function marketingAction(){

        $Panel = new Panel();

        $this->layaout = "REKLAMA";


        $META = [
            'title' => 'Биржа операторов на телефоне. Страница заказчика '.APPNAME,
            'description' => 'Биржа операторов на телефоне'.APPNAME,
            'keywords' => 'Биржа операторов на телефоне'.APPNAME,
        ];



        \APP\core\base\View::setMeta($META);
        $operators = $Panel->getoperators(6);
        $this->set(compact('operators'));


    }

}
?>