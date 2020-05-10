<?php
namespace APP\controllers;
use APP\core\base\View;
use APP\core\Cache;
use APP\models\Addp;
use APP\models\Panel;
use APP\core\base\Model;
use Dompdf\Dompdf;

class PayController extends AppController {
	public $layaout = 'PANEL';
    public $mininvoice = 1000;



    // Прием платежей на сай
    public function redirectAction(){

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




        if ($_POST['summa'] < $this->mininvoice){

            $_SESSION['errors'] = "Минимальное пополнение ".$this->mininvoice." рублей<br>";
            redir("/panel/balance/");

        }



        $invoice =[
            'users_id' => $_SESSION['ulogin']['id'],
            'paymethod' => $_POST['paymethod'],
            'summa' => $_POST['summa'],
            'status' => 0
        ];






        if ($_POST && $_POST['paymethod'] == "Payeer"){
            $invoiceid = $Panel->addnewBD("invoice", $invoice);
           $form = $Panel->generatePayeerform($_POST, $invoiceid);
        }


        if ($_POST && $_POST['paymethod'] == "Beznal"){

            if (!$Panel::$USER['urlegal']){
                $_SESSION['errors'] = "
                Чтобы выставить счет по безналичному рассчету необходимо заполнить юридическую информацию<br>
                <a href='/panel/urlegal/'>По ссылке</a><br>";
                redir("/panel/balance/");
            }


            if (!$Panel::$USER['payurinfo']){
                $_SESSION['errors'] = "Чтобы выставить счет по безналичному рассчету необходимо заполнить платежную информацию
                <br>
                <a href='/panel/urlegal/'>По ссылке</a><br>";
                redir("/panel/balance/");
            }

            show($invoice);
            exit();


              $invoiceid = $Panel->addnewBD("invoice", $invoice);
//            $form = $Panel->generatePayeerform($_POST, $invoiceid);





        }




        $this->set(compact('form'));



    }

    public function obrabotkaAction(){
        $this->layaout = false;

        $Panel =  new Panel();

        $META = [
            'title' => 'Пополнение баланса',
            'description' => 'Пополнение баланса',
            'keywords' => 'Пополнение баланса',
        ];
        \APP\core\base\View::setMeta($META);




        if (!empty($_GET['method']) && $_GET['method'] == "Payeer"){


            if (!in_array($_SERVER['REMOTE_ADDR'], array('185.71.65.92', '185.71.65.189', '149.202.17.210'))) exit("ip");


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


                    dumpf($_POST);
                    //Добавляем баланс пользователю через параметры или БД
                    $Panel->invoicesuccess($_POST['m_orderid']);

                    //Добавляем баланс пользователя через баланс или БД
                    ob_end_clean(); exit($_POST['m_orderid'].'|success');
                }

                ob_end_clean(); exit($_POST['m_orderid'].'|error');
            }





        }





    }

    // Прием платежей на сайте

    public function beznalAction(){
        $this->layaout = false;

        $prods = [
            [
                'name' => 'Пополнение баланаса в сервисе',
                'count' => 1,
                'unit' => 'шт',
                'price' => 1242,
                'nds' => 20
            ],
        ];


        $myrekviziti = [];




        $html = '<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<style type="text/css">
		* { 
			font-family: arial;
			font-size: 14px;
			line-height: 14px;
		}
		table {
			margin: 0 0 15px 0;
			width: 100%;
			border-collapse: collapse; 
			border-spacing: 0;
		}		
		table td {
			padding: 5px;
		}	
		table th {
			padding: 5px;
			font-weight: bold;
		}
 
		.header {
			margin: 0 0 0 0;
			padding: 0 0 15px 0;
			font-size: 12px;
			line-height: 12px;
			text-align: center;
		}
		
		/* Реквизиты банка */
		.details td {
			padding: 3px 2px;
			border: 1px solid #000000;
			font-size: 12px;
			line-height: 12px;
			vertical-align: top;
		}
 
		h1 {
			margin: 0 0 10px 0;
			padding: 10px 0 10px 0;
			border-bottom: 2px solid #000;
			font-weight: bold;
			font-size: 20px;
		}
 
		/* Поставщик/Покупатель */
		.contract th {
			padding: 3px 0;
			vertical-align: top;
			text-align: left;
			font-size: 13px;
			line-height: 15px;
		}	
		.contract td {
			padding: 3px 0;
		}		
 
		/* Наименование товара, работ, услуг */
		.list thead, .list tbody  {
			border: 2px solid #000;
		}
		.list thead th {
			padding: 4px 0;
			border: 1px solid #000;
			vertical-align: middle;
			text-align: center;
		}	
		.list tbody td {
			padding: 0 2px;
			border: 1px solid #000;
			vertical-align: middle;
			font-size: 11px;
			line-height: 13px;
		}	
		.list tfoot th {
			padding: 3px 2px;
			border: none;
			text-align: right;
		}	
 
		/* Сумма */
		.total {
			margin: 0 0 20px 0;
			padding: 0 0 10px 0;
			border-bottom: 2px solid #000;
		}	
		.total p {
			margin: 0;
			padding: 0;
		}
		
		/* Руководитель, бухгалтер */
		.sign {
			position: relative;
		}
		.sign table {
			width: 60%;
		}
		.sign th {
			padding: 40px 0 0 0;
			text-align: left;
		}
		.sign td {
			padding: 40px 0 0 0;
			border-bottom: 1px solid #000;
			text-align: right;
			font-size: 12px;
		}
		
		.sign-1 {
			position: absolute;
			left: 149px;
			top: -44px;
		}	
		.sign-2 {
			position: absolute;
			left: 149px;
			top: 0;
		}	
		.printing {
			position: absolute;
			left: 271px;
			top: -15px;
		}
	</style>
</head>
<body>
	<p class="header">
		Внимание! Оплата данного счета означает согласие с условиями поставки товара.
		Уведомление об оплате обязательно, в противном случае не гарантируется наличие
		товара на складе. Товар отпускается по факту прихода денег на р/с Поставщика,
		самовывозом, при наличии доверенности и паспорта.
	</p>
 
	<table class="details">
		<tbody>
			<tr>
				<td colspan="2" style="border-bottom: none;">ЗАО "БАНК", г.Москва</td>
				<td>БИК</td>
				<td style="border-bottom: none;">000000000</td>
			</tr>
			<tr>
				<td colspan="2" style="border-top: none; font-size: 10px;">Банк получателя</td>
				<td>Сч. №</td>
				<td style="border-top: none;">00000000000000000000</td>
			</tr>
			<tr>
				<td width="25%">ИНН 0000000000</td>
				<td width="30%">КПП 000000000</td>
				<td width="10%" rowspan="3">Сч. №</td>
				<td width="35%" rowspan="3">00000000000000000000</td>
			</tr>
			<tr>
				<td colspan="2" style="border-bottom: none;">ООО "Компания"</td>
			</tr>
			<tr>
				<td colspan="2" style="border-top: none; font-size: 10px;">Получатель</td>
			</tr>
		</tbody>
	</table>
 
	<h1>Счет на оплату № 10 от 01 февраля 2018 г.</h1>
 
	<table class="contract">
		<tbody>
			<tr>
				<td width="15%">Поставщик:</td>
				<th width="85%">
					ООО "Компания", ИНН 0000000000, КПП 000000000, 125009, Москва г, 
					Тверская ул, дом № 9
				</th>
			</tr>
			<tr>
				<td>Покупатель:</td>
				<th>
					ООО "Покупатель", ИНН 0000000000, КПП 000000000, 119019, Москва г, 
					Новый Арбат ул, дом № 10
				</th>
			</tr>
		</tbody>
	</table>
 
	<table class="list">
		<thead>
			<tr>
				<th width="5%">№</th>
				<th width="54%">Наименование товара, работ, услуг</th>
				<th width="8%">Коли-<br>чество</th>
				<th width="5%">Ед.<br>изм.</th>
				<th width="14%">Цена</th>
				<th width="14%">Сумма</th>
			</tr>
		</thead>
		<tbody>';


        $total = $nds = 0;
        foreach ($prods as $i => $row) {
            $total += $row['price'] * $row['count'];
            $nds += ($row['price'] * $row['nds'] / 100) * $row['count'];

            $html .= '
			<tr>
				<td align="center">' . (++$i) . '</td>
				<td align="left">' . $row['name'] . '</td>
				<td align="right">' . $row['count'] . '</td>
				<td align="left">' . $row['unit'] . '</td>
				<td align="right">' . format_price($row['price']) . '</td>
				<td align="right">' . format_price($row['price'] * $row['count']) . '</td>
			</tr>';
        }

        $html .= '
		</tbody>
		<tfoot>
			<tr>
				<th colspan="5">Итого:</th>
				<th>' . format_price($total) . '</th>
			</tr>
			<tr>
				<th colspan="5">В том числе НДС:</th>
				<th>' . ((empty($nds)) ? '-' : format_price($nds)) . '</th>
			</tr>
			<tr>
				<th colspan="5">Всего к оплате:</th>
				<th>' . format_price($total) . '</th>
			</tr>
			
		</tfoot>
	</table>
	
	<div class="total">
		<p>Всего наименований ' . count($prods) . ', на сумму ' . format_price($total) . ' руб.</p>
		<p><strong>' . num2str($total) . '</strong></p>
	</div>
	
	<div class="sign">
 <!--		<img class="sign-1" src="/demo/sign-1.png"> -->
	 <!--	<img class="sign-2" src="/demo/sign-2.png"> -->
	<!-- <img class="printing" src="/demo/printing.png"> -->
 
		<table>
			<tbody>
				<tr>
					<th width="30%">Руководитель</th>
					<td width="70%">Иванов А.А.</td>
				</tr>
				<tr>
					<th>Бухгалтер</th>
					<td>Сидоров Б.Б.</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>';

        iconv_strlen($html, 'UTF-8');

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('schet-10');

    }


}
?>