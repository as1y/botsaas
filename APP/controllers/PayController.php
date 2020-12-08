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
    public $mininvoice = 10000;



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
            'date' => date("d-m-Y"),
            'paymethod' => $_POST['paymethod'],
            'summa' => $_POST['summa'],
            'status' => 0
        ];



        if ($_POST && $_POST['paymethod'] == "Unitpay"){
            $invoiceid = $Panel->addnewBD("invoice", $invoice);

            // Параметры для подписи
            $account = $invoiceid;
            $desc = "Пополнение баланса в сервисе CASHCALL.RU";
            $secret_key = "c13019bbc23cd68ee7f10ac60bde34b1";
            $sum = $_POST['summa'];
            $currency = "RUB";

            $signature = getFormSignatureUnit($account, $currency, $desc, $sum, $secret_key);


            $locate = "ru";
            $backUrl = "https://cashcall.ru/panel/balance/";


            $url = "https://unitpay.money/pay/254981-acd93/card";

            $url .= "?sum=".$sum;
            $url .= "&account=".$account;
            $url .= "&currency=RUB";
            $url .= "&locate=".$locate;
            $url .= "&signature=".$signature;
            $url .= "&hideMenu=true";

            $DATA = [
                'desc' => $desc,
                'backUrl' => $backUrl,

            ];


            $url = $url."&".http_build_query($DATA);

             redir($url);





        }



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


            $invoice['id'] = $Panel->addnewBD("invoice", $invoice);


           $this->generatebeznal($invoice);

            show($invoice);
            exit();






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




        if (!empty($_GET['system']) && $_GET['system'] == "Unitpay"){


            if (!in_array($_SERVER['REMOTE_ADDR'], array('31.186.100.49', '178.132.203.105', '52.29.152.23', '52.19.56.234'))) exit("");


            if ($_GET['params']['account'] != "test"){
                $Panel->invoicesuccess($_GET['params']['account']);
            }

            echo '{"result": {"message": "Запрос успешно обработан"}}';

            exit();



        }





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

    public function generatebeznal($invoice){

        $Panel =  new Panel();

        $prods = [
            [
                'name' => 'Размещение рекламных материалов на площадке kodypromo.ru',
                'count' => 1,
                'unit' => 'шт',
                'price' => $invoice['summa'],
                'nds' => 0
            ],
        ];


        $urlegal = json_decode($Panel::$USER['urlegal'], true);

        $payurinfo = json_decode($Panel::$USER['payurinfo'], true);

        $myrequis = [

          'company' => 'ИП Балацкая Дарья Викторовна',
          'ogrn' => '319774600142574',
          'inn' => '771505082314',

        ];



        $html = '<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<style type="text/css">
		* { 
            font-family: DejaVu Sans; 
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
Просим оплатить этот счет в течении 5 дней с даты
выставления. Вы можете сделать это в любом
банковском учреждении РФ. Не забудьте указать
номер этого счета в платежном документе. 
	</p>
 
	<table class="details">
		<tbody>
			<tr>
				<td colspan="2" style="border-bottom: none;">Банк получателя</td>
				<td>БИК</td>
				<td style="border-bottom: none;">'.$payurinfo['bic'].'</td>
			</tr>
			<tr>
				<td colspan="2" style="border-top: none; font-size: 10px;">'.$payurinfo['bank'].'</td>
				<td>К/С. №</td>
				<td style="border-top: none;">'.$payurinfo['kor'].'</td>
			</tr>
			<tr>
				<td width="25%">ИНН '.$payurinfo['inn'].'</td>
				<td width="30%">КПП '.$payurinfo['kpp'].'</td>
				<td width="10%" rowspan="3">Сч. №</td>
				<td width="35%" rowspan="3">'.$payurinfo['rs'].'</td>
			</tr>
			<tr>
				<td colspan="2" style="border-bottom: none;">Получатель</td>
			</tr>
			<tr>
				<td colspan="2" style="border-top: none; font-size: 10px;">'.$urlegal['company'].'</td>
			</tr>
		</tbody>
	</table>
 
	<h1>Счет на оплату № '.$invoice['id'].'1133 от '.$invoice['date'].' г.</h1>
 
	<table class="contract">
		<tbody>
			<tr>
				<td width="15%">Поставщик:</td>
				<th width="85%">
					'.$urlegal['company'].', ИНН '.$payurinfo['inn'].', Адрес '.$urlegal['uradres'].'
				</th>
			</tr>
			<tr>
				<td>Покупатель:</td>
				<th>
					'.$myrequis['company'].', ИНН '.$myrequis['inn'].'
			
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
					<td width="70%">'.$payurinfo['fio'].'</td>
				</tr>
				<tr>
					<th>Бухгалтер</th>
					<td>'.$payurinfo['fio'].'</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>';




        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
//        $dompdf->stream('schet-10');


        $pdf = $dompdf->output();
        file_put_contents(WWW . UrInvoicepath.'schet-'. $invoice['id'].'.pdf', $pdf);


        //Добавляем адрес файла в счет
        $path = UrInvoicepath.'schet-'. $invoice['id'].'.pdf';
        $Panel->addpathinvoice($invoice['id'], $path);
        //Добавляем адрес файла в счет

        redir($path);



    }


}
?>