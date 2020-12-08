<?php
// ВЫКЛЮЧАТЬ ОШИБКИ
$er = ERRORS;
if($er == 1){
	//ВЫВОД ОШИБОК
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	//ВЫВОД ОШИБОК
} else{
	error_reporting(E_ERROR);
}
function not_found() { // ЕСЛИ НЕ НАЙДЕНА СТРАНЦИА


	if (isset($_SESSION['ulogin'])){
		echo "<script>document.location.href='/panel';</script>\n";
		exit();
	}
	else{
		http_response_code(404);
		include ("404.php");
		exit();
	}
} // ЕСЛИ НЕ НАЙДЕНА СТРАНЦИА


// Функция вывода сообщений в обработчике форм
function message( $text ) {
	exit('{ "message" : "'.$text.'"}');
}
// Функция вывода сообщений в обработчике форм
// Функция редирект при возвращении из формы через ajax
function go( $url ) {
	exit('{ "go" : "'.$url.'"}');
}
// Функция редирект при возвращении из формы через ajax



function redir($http = FALSE){
	if($http){
		$redirect = $http;
	}else{
		$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
	}
	header("Location: $redirect");
	exit();
}
// Екзит из интерфейса


// СООБЩЕНИЕ ЧЕРЕЗ PHP
function mes ( $mess ) {
	echo ( '
	<script>
		alert(" '.$mess. '");
	</script>
		 ') ;
}
// СООБЩЕНИЕ ЧЕРЕЗ PHP
function dumpf($PARAM){
	file_put_contents($_SERVER["DOCUMENT_ROOT"] .'/log.log', var_export($PARAM, true), FILE_APPEND);
}



function getFormSignatureUnit($account, $currency, $desc, $sum, $secretKey) {
    $hashStr = $account.'{up}'.$currency.'{up}'.$desc.'{up}'.$sum.'{up}'.$secretKey;
    return hash('sha256', $hashStr);
}



function hurl($url){
	$url = str_replace("http://", "", $url); // Убираем http
	$url = str_replace("https://", "", $url); // Убираем https
	$url = str_replace("www.", "", $url); // Убираем https
	return $url;
}
// Генерируем рандом символы 30 шт
function random_str( $num = 30 ) {
	return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $num);
}
// Генерируем рандом символы 30 шт
function show($par){
	echo "<pre>";
	print_r($par);
	echo "</pre>";
}
// ФУНКЦИЯ ЗАГРУЗКИ КЛАССОВ
spl_autoload_register(function ($class) {
		$path = str_replace( '\\', '/', $class.'.php' );
		if (file_exists($path)){
			require $path;
		}
	});
// ФУНКЦИЯ ЗАГРУЗКИ КЛАССОВ
function h($str){
	return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * Выводит ошибку в специальном формате
 * @param string $error_message
 */
function e(string $error_message): void
{
    if(ERRORS) {
        ob_clean();
        ob_start();
        echo(sprintf('<h1 style="color:red">%s</h1>', $error_message));
        echo('<pre>' . print_r(debug_backtrace(), true) . '</pre>');
        ob_end_flush();
        exit();
    }
}




function getPS($arPs , $method){
    $PS = [];

    foreach ($arPs['list'] as $key=>$val ){
        if ($method == "qiwi" && $val['name'] == "QIWI"){
            $PS['id'] = $key;
            $PS['add'] = 0;
            return $PS;
        }
        if ($method == "yamoney" && $val['name'] == "Яндекс.Деньги") {
            $PS['id'] = $key;
            $PS['add'] = 0;
            return $PS;
        }

        if ($method == "cardvisa" && $val['name'] == "VISA") {
            $PS['id'] = $key;
            $PS['add'] = 45;
            return $PS;
        }

        if ($method == "cardmaster" && $val['name'] == "MasterCard") {
            $PS['id'] = $key;
            $PS['add'] = 45;
            return $PS;

        }
        if ($method == "cardmir" && $val['name'] == "МИР") {
            $PS['id'] = $key;
            $PS['add'] = 45;
            return $PS;
        }

        if ($method == "cardukr" && $val['name'] == "Банки Украины") {
            $PS['id'] = $key;
            $PS['add'] = 45;
            return $PS;
        }
    }

    return $PS;
}





function SystemUserId(){
    return  md5(uniqid().$_SERVER['REMOTE_ADDR'].$_SERVER['UNIQUE_ID']);
}

function gaUserIdGA(){

    if (!empty($_COOKIE['_ga']))   return preg_replace("/^.+\.(.+?\..+?)$/", "\\1", $_COOKIE['_ga']);

    return false;

}


function gaUserId(){


    if (!empty($_COOKIE['dscid'])) return $_COOKIE['dscid'];


    return false;



//    return preg_replace("/^.+\.(.+?\..+?)$/", "\\1", $_COOKIE['_ga']);


}


function gtmBODY(){
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KLJVZF8"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}

function gtmHEAD(){
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KLJVZF8');</script>
    <!-- End Google Tag Manager -->
    <?php
}



function skorogovorka(){

    $chislo = rand(1,3);


    ?>

        <?php if ($chislo == 1):?>
        <p class="text-muted">Расскажите про покупки! — Про какие про покупки?
            Про покупки, про покупки, про покупочки свои.</p>
        <?php endif;?>

    <?php if ($chislo == 2):?>
        <p class="text-muted">Ядро потребителей пиастров — пираты, а пиратов — пираньи.</p>
    <?php endif;?>

    <?php if ($chislo == 3):?>
        <p class="text-muted">На дворе — трава, на траве — дрова. Не руби дрова на траве двора!</p>
    <?php endif;?>



    <?php





}

function translit_sef($value)
{
    $converter = array(
        'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
        'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
        'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
        'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
        'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
        'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
        'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
    );

    $value = mb_strtolower($value);
    $value = strtr($value, $converter);
    $value = mb_ereg_replace('[^-0-9a-z]', '_', $value);
    $value = mb_ereg_replace('[-]+', '_', $value);
    $value = trim($value, '_');

    $value = str_replace("-", "_", $value); //Убираем тире, чтобы использовать его для IDшника


    return $value;
}

function generatepayform($form){

    echo '<form method="post" action="'.$form['action'].'">
    ';

    foreach ($form['input'] as $key=>$val) {
        ?>
        <input type="<?= $val['type'] ?>" name="<?= $val['name'] ?>" value="<?= $val['value'] ?>">
        <?php
    }

    echo "</form>";

}


function teleph($tel){
	$tel = str_replace("'", "", $tel); // Убираем +
	$tel = str_replace("+", "", $tel); // Убираем +
	$tel = str_replace("(", "", $tel); // Убираем (
	$tel = str_replace(")", "", $tel); // Убираем )
	$tel = str_replace("-", "", $tel); // Убираем )
	$tel = str_replace(".", "", $tel); // Убираем .
	$tel = str_replace(" ", "", $tel); // Убираем пробелы

    // Убираем телефоны после запятой
    $tel = preg_replace("/\,.+/", "", $tel);
    // Убираем телефоны после запятой


	$tel = trim($tel);
	if ($tel['0'] == '8'){
		$tel = substr($tel, 1);
	}
	if ($tel['0'] != '7') $tel = "7".$tel."";
	return $tel;
}


function getconversion ($value1, $value2){
    if ($value2 == 0) return 0;
    $result = $value1/$value2*100;
    $result = round($result);
    return $result;
}


function getsizetypeimage($w_src, $h_src){

    if ($w_src > $h_src)  return  "horizont";
  if ($w_src < $h_src)  return "vertikal";
  if ($w_src == $h_src)  return"kvadrat";




}

function fCURL($url, $PARAMS = []){

    $ch = curl_init();

    if (!empty($PARAMS['GET'])){
        $url = $url."?".http_build_query($PARAMS['GET']);
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);



    //  curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
    curl_setopt($ch, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');


    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json-patch+json'));
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);


    if (!empty($PARAMS['POST'])){
        $PARAMS['POST'] = json_encode($PARAMS['POST']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $PARAMS['POST']);
    }

    if (!empty($PARAMS['PATCH'])){
        $PARAMS['PATCH'] = json_encode($PARAMS['PATCH']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $PARAMS['PATCH']);
    }



    if (!empty($PARAMS['DELETE'])){
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $PARAMS['DELETE']);
    }





    $result = curl_exec($ch);

    curl_close($ch);

    //  $resultJson = $result;
    $resultJson = json_decode($result, TRUE);


    return $resultJson;



}

function clearrequis($value){

    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    $value = str_replace(" ", "", $value);

    return $value;
}


function validationpay($type, $value){

    $value = clearrequis($value);

    if ($type == "qiwi"){
        preg_match('/^\+\d{9,15}$/', $value, $matches);
        if (!empty($matches)) return true;
        if (empty($matches)) return false;
    }


    if ($type == "yamoney"){
        preg_match('/^41001[0-9]{7,11}$/', $value, $matches);
        if (!empty($matches)) return true;
        if (empty($matches)) return false;
    }

    if ($type == "cardvisa"){
        preg_match('/^([45]{1}[\d]{15}|[6]{1}[\d]{17})$/', $value, $matches);
        if (!empty($matches)) return true;
        if (empty($matches)) return false;
    }


    if ($type == "cardmaster"){
        preg_match('/^([45]{1}[\d]{15}|[6]{1}[\d]{17})$/', $value, $matches);
        if (!empty($matches)) return true;
        if (empty($matches)) return false;
    }

    if ($type == "cardmir"){
        preg_match('/^([245]{1}[\d]{15}|[6]{1}[\d]{17})$/', $value, $matches);
        if (!empty($matches)) return true;
        if (empty($matches)) return false;
    }

    if ($type == "cardukr"){
        preg_match('/^([45]{1}[\d]{15}|[6]{1}[\d]{17})$/', $value, $matches);
        if (!empty($matches)) return true;
        if (empty($matches)) return false;
    }






    return true;
}


// Форматирование цен.
function format_price($value)
{
    return number_format($value, 2, ',', ' ');
}

// Сумма прописью.
function num2str($num) {
    $nul='ноль';
    $ten=array(
        array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
    );
    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
    $unit=array( // Units
        array('копейка' ,'копейки' ,'копеек',	 1),
        array('рубль'   ,'рубля'   ,'рублей'    ,0),
        array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
        array('миллион' ,'миллиона','миллионов' ,0),
        array('миллиард','милиарда','миллиардов',0),
    );
    //
    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub)>0) {
        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit)-$uk-1; // unit key
            $gender = $unit[$uk][3];
            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
        } //foreach
    }
    else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
    $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
    $n = abs(intval($n)) % 100;
    if ($n>10 && $n<20) return $f5;
    $n = $n % 10;
    if ($n>1 && $n<5) return $f2;
    if ($n==1) return $f1;
    return $f5;
}

?>