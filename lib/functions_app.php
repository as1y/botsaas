<?php

function getrecord2($idcont) {
    global $account_id;
    global $api_key;

    $url = "https://api.voximplant.com/platform_api/GetCallHistory/";

    $PARAMS['GET'] = [
        'account_id' => $account_id,
        'api_key' => $api_key,
        'from_date' =>    '2020-01-01 00:00:00',
        'to_date' => date("Y-m-d h:s:m", strtotime("+1 day")),
        'with_records' => true,
        'call_session_history_custom_data' => $idcont,
    ];


  $result =  fCURL($url, $PARAMS);

    return $result['result'];
}


function generateprofilelink($user = ""){

    if (empty($user)){
        return "//".CONFIG['DOMAIN']."/user/operator/?name=".translit_sef($_SESSION['ulogin']['username'])."-".$_SESSION['ulogin']['id'];
    }else{

        return "//".CONFIG['DOMAIN']."/user/operator/?name=".translit_sef($user['username'])."-".$user['id'];

    }

}


function raskladkazapisi($DATA) {


    if (empty($DATA)) return "Запись отсутсвует<br />";

    $DATA = json_decode($DATA, true);


    $records = '';

    foreach ($DATA as $key=>$val){

        foreach ($val['records'] as $record){
            if (!empty($record)){
                    $date = $val['start_date'];
                    $url = $record['record_url'];
                     $a = "<i class='icon-calendar3'></i>".$date."<p><a href='".$url."' target='_blank' >ЗАПИСЬ</a><hr>";

                if (!isset($url)) $a = "<p>Без записи</p>";
                $records = $records.$a;

            }

        }
    }

        return $records;


//        if (!empty($val['records'][$key])){
//            $date = $val['start_date'];
//            $url = $val['records'][$key]['record_url'];
//
////            $a = "<i class='icon-calendar3'></i>".$date."<p><audio src='".$val['records']['0']['record_url']."' controls></audio></p>";
//
//            $a = "<i class='icon-calendar3'></i>".$date."<p><a href='".$val['records'][$key]['record_url']."' target='_blank' >ЗАПИСЬ</a> ";
//
//
//            if (!isset($url)) $a = "<p>Без записи</p>";
//            $records = $records.$a;
//        }

        //if (empty($val['records']['0'])) return "Запись отсутсвует<br />";






}





function rendermessage($messages, $rendertype = "html"){

    if ($rendertype == "html"){
        $avatar = $messages->users['avatar'];
        $username = $messages->users['username'];
        $woof = $messages->users['woof'];
        $usermass['username'] = $messages->users['username'];
        $usermass['id'] = $messages->users['id'];
    }

    if ($rendertype == "ajax"){
        $avatar = $messages['avatar'];
        $username = $messages['username'];
        $woof = $messages['woof'];
        $usermass['username'] = $messages['username'];
        $usermass['id'] = $messages['userid'];
    }



?>
    <li class="media">
        <div class="mr-3"><img src="<?=$avatar?>" class="rounded-circle" width="40" height="40" alt=""></div>
        <div class="media-body">
            <div class="media-title d-flex flex-nowrap">
                <a href="<?=generateprofilelink($usermass)?>"  target="_blank" class="font-weight-semibold mr-3">
                    <?=$username?>
                    <?php if ($woof == 1): ?>
                        <b> (АДМИНИСТРАТОР)</b>
                    <?php endif?>
                </a>
                <span class="font-size-sm text-muted text-nowrap ml-auto"><?=$messages['time']?></span>
            </div>
            <?=$messages['message']?>
        </div>
    </li>

<?php

}



// ОБРАБОТКИ СТАТУСОВ НА ВИЗУАЛЬНЫЕ ЭФФЕКТЫ
function leadstatus ($status){
	if ($status=="0") return '<div class="label label-warning">НА МОДЕРАЦИИ</div>';
	if ($status=="1") return '<div class="label label-success"><b>ОДОБРЕН</b></div>';
	if ($status=="2") return '<div class="label label-danger">ОТКЛОНЕН</div>';
    if ($status=="3") return '<div class="label label-info">ДОРАБОТКА</div>';
}
function leadteable ($status){
	if ($status=="0") return '';
	if ($status=="1") return "";
	if ($status=="2") return "";
}


function contactstatus ($status){

    if ($status == '0') return  "НЕ ОБРАБОТАН";
    if ($status == '1') return  "ЗАБРОНИРОВАН";
    if ($status == '2') return  "ПЕРЕЗВОН";
    if ($status == '3') return  "ОТКАЗ";
    if ($status == '4') return  "ТЕЛЕФОН НЕ ДОСТУПЕН";
    if ($status == '5') return  "НА МОДЕРАЦИИ";
    if ($status == '6') return  "ДОРАБОТКА";
    if ($status == '7') return  "НЕ ПРОШЕЛ МОДЕРАЦИЮ";
    if ($status == '8') return  "РЕЗУЛЬТАТ";








}




function tematika ($status){
    if ($status=="1") return 'Digital';
    if ($status=="2") return 'Медицина';
    if ($status=="3") return 'Банковский сектр';
    if ($status=="4") return 'Страховка';
}



function companytype ($status)
{
    if ($status == "1") return '<i class="icon-target2 mr-2" data-popup="tooltip" title="ЛИД"></i>';
    if ($status == "2") return '<i class="icon-people mr-2" data-popup="tooltip" title="ВСТРЕЧА"></i>';
    if ($status == "3") return '<i class="icon-price-tag mr-2" data-popup="tooltip" title="УЧАСТИЕ В АКЦИИ"></i>';
    if ($status == "4") return '<i class="icon-theater mr-2" data-popup="tooltip" title="ПРИГЛАШЕНИЕ"></i>';
    if ($status == "5") return '<i class="icon-magazine mr-2" data-popup="tooltip" title="АНКЕТА"></i>';
    if ($status == "6") return '<i class="icon-info3 mr-2" data-popup="tooltip" title="ИНФОРМИРОВАНИЕ"></i>';


}



function passoperator ($status){
	if ($status=="1") return '<span class="badge badge-default">НА ПРОВЕРКЕ</span><br>';
	if ($status=="2") return '<span class="badge badge-default">ДОПУЩЕН</span><br>';
	if ($status=="3") return '<span class="badge badge-danger">ОТКЛОНЕН</span><br>';
}

function timecall ($status){
    if ($status=="standart") return 'Будние дни, рабочее время (09:00-19:00)';
    if ($status=="maximum") return 'Будние дни, расширенное время (09:00-21:00)';
    if ($status=="ultra") return 'Будни + выходные, расширенное время (09:00-21:00)';

}

function renderstatus($mystatus, $id){
?>
    <?php if($mystatus === false): ?>
        <a href="/operator/all/?id=<?=$id?>&action=join" type="button" class="btn btn-success"><i class="icon-add mr-2"></i>ЗАЯВКА</a>
    <?php endif;?>

                        <?php if ($mystatus == 2):?>
        <a href="/operator/call/?id=<?=$id?>" type="button" class="btn btn-danger"><i class="icon-phone-wave mr-2"></i>ЗВОНИТЬ</a>
    <?php endif;?>

    <br>
    <?php if($mystatus != false): ?>
        <b>СТАТУС:</b><?=passoperator($mystatus)?>
    <?php endif;?>

<?php

}


function renderacesscall($statuscall){
?>

            <div class="row">
            <div class="col-sm-6 col-xl-3 border">

                <div class="card-body">
                    <h5 class="card-title"><?=$statuscall['text']?></h5>


                    <? if($statuscall['acess'] === false):?>

                        <i class="icon-cross2 icon-2x text-danger border-danger border-3 rounded-round p-3 mb-3"></i>

                        <div class="list-feed">
                            <?php if($statuscall['code'] == false):?>
                                <div class="list-feed-item border-warning-400">
                                    Подтвердите E-mail <br>
                                </div>
                            <?php endif;?>

                            <?php if($statuscall['about'] == false):?>
                            <div class="list-feed-item border-warning-400">
                               Заполните информацию о себе
                            </div>
                            <?php endif;?>

                            <?php if($statuscall['avatar'] == false):?>
                            <div class="list-feed-item border-warning-400">
                               Загрузите аватар
                            </div>
                            <?php endif;?>

                            <?php if($statuscall['audio'] == false):?>
                            <div class="list-feed-item border-warning-400">
                               Запишите аудио презентацию
                            </div>
                            <?php endif;?>


                        </div>

                    <?else:?>

                        <i class="icon-checkmark icon-2x text-success border-success border-3 rounded-round p-3 mb-3"></i>
                        <h5 class="card-title">ВЫ ДОПУЩЕНЫ К ЗВОНКАМ</h5>


                    <?endif;?>


                </div>


            </div>


            <div class="col-sm-6 col-xl-3 border">


                <div class="card-body">

                    <h5 class="card-title">Информация о себе</h5>

                    <? if($statuscall['about'] === false):?>
                        <i class="icon-cross2 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3"></i>
                        <p class="mb-3">Заполните информацию о себе в профиле</p>
                        <a href="/panel/profile/" class="btn bg-success"><i class="icon-plus3 ml-2"></i> ДОБАВИТЬ</a>
                    <?else:?>
                        <i class="icon-checkmark icon-2x text-success border-success border-3 rounded-round p-3 mb-3"></i>
                        <p class="mb-3">Информация добавлена</p>

                    <?endif;?>







                </div>


            </div>
            <div class="col-sm-6 col-xl-3 border">


                <div class="card-body">

                    <h5 class="card-title">Аватар</h5>
                    <? if($statuscall['avatar'] === false):?>
                        <i class="icon-cross2 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3"></i>
                        <p class="mb-3">Загрузите Аватар в профиле</p>
                        <a href="/panel/profile/" class="btn bg-success"><i class="icon-image2 ml-2"></i> ДОБАВИТЬ</a>
                    <?else:?>
                        <i class="icon-checkmark icon-2x text-success border-success border-3 rounded-round p-3 mb-3"></i>
                        <p class="mb-3">Аватар загружен</p>
                    <?endif;?>




                </div>


            </div>


            <div class="col-sm-6 col-xl-3 border">


                <div class="card-body">

                    <h5 class="card-title">Аудио презентация</h5>

                    <? if($statuscall['audio'] === false):?>
                        <i class="icon-cross2 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3"></i>
                        <p class="mb-3">Запишите аудио презентацию</p>
                        <a href="/panel/profile/" class="btn bg-success"><i class="icon-mic2 ml-2"></i> ЗАПИСАТЬ</a>
                    <?else:?>
                        <i class="icon-checkmark icon-2x text-success border-success border-3 rounded-round p-3 mb-3"></i>
                        <p class="mb-3">Аудио презентация загружена</p>
                    <?endif;?>





                </div>


            </div>
        </div>
<hr>


<?php
}


function countoperators($company, $type){


    $countfinal = 0;

    $count = json_decode($company['operators'], true);

    if (empty($count)) $count = [];

    foreach ($count as $key=>$val){

        if ($val == 1 && $type == "new") $countfinal++;
        if ($val == 2 && $type == "all") $countfinal++;
    }
    return $countfinal;


}






function obrezanie ($text, $symbols){

   $result = mb_strimwidth($text, 0, $symbols, "...");

    return $result;

}


function ticketstatus ($status){
    if ($status=="1") return '<span class="badge badge-success">ОТКРЫТ</span>';
    if ($status=="2") return '<span class="badge badge-secondary">ЗАКРЫТ</span>';
}



function rendercontactinfo ($DATA){

?>

    <b>ИМЯ: </b> <?=(!empty($DATA['name'])) ?  $DATA['name'] : "не заполнено"?><br>
    <b>ТЕЛЕФОН: </b> <?=(!empty($DATA['tel'])) ?  $DATA['tel'] : "не заполнено"?><br>
    <b>КОМПАНИЯ: </b> <?=(!empty($DATA['companyname'])) ?  $DATA['companyname'] : "не заполнено"?><br>
    <b>САЙТ: </b> <?=(!empty($DATA['site'])) ?  $DATA['site'] : "не заполнено"?><br>
    <b>КОММЕНТАРИЙ: </b> <?=(!empty($DATA['comment'])) ?  $DATA['comment'] : "не заполнено"?><br>


    <?php



  return true;

}


function renderresult ($DATA){

    $DATA = json_decode($DATA, true);

    foreach ($DATA as $key=>$val){
        echo "<b>".$val['NAME'].": </b>".$val['VAL']."<br>";
    }



    return true;

}





function rendertypeaccount($type){
    if ($type == "O") return "Оператор";
    if ($type == "R") return "Рекламодатель";
}


function renderresultform($DATA){
    $FORM = json_decode($DATA, true);



    foreach ($FORM as $key=>$val){

        if ($val['TYPE'] == 1){
            ?>
            <div class="form-group">
                <label><?=$val['NAME']?><span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" name="customresult<?=$key?>" class="form-control" placeholder="<?=$val['NAME']?>">
                </div>
            </div>
            <?php
        }

        if ($val['TYPE'] == 2){
            ?>
            <div class="form-group">
                <label><?=$val['NAME']?><span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="date"  name="customresult<?=$key?>" class="form-control" >
                </div>
            </div>

        <?php

        }

        if ($val['TYPE'] == 3){
            ?>
            <div class="form-group">
                <label><?=$val['NAME']?><span class="text-danger">*</span></label>
                <div class="input-group">
                    <textarea rows="3" cols="3" name="customresult<?=$key?>" class="form-control" placeholder="Описание"></textarea>
                </div>
            </div>
        <?php

        }







    }





}


function renderform ($FORMRESULT, $idc){

    foreach ($FORMRESULT as $key=>$val){


        if ($val['TYPE'] == 1){
            ?>
            <div class="form-group">

                <label><?=$val['NAME']?><span class="text-danger">*</span></label>
                <div class="input-group">
                <input type="text" disabled class="form-control" placeholder="<?=$val['NAME']?>">
                    <a href="/project/resultform/?id=<?=$idc?>&action=delete&element=<?=$key?>" class="btn btn-danger btn-icon"><i class="icon-trash"></i></a>
                </div>

            </div>
            <?php
        }

        if ($val['TYPE'] == 2){
            ?>
            <div class="form-group">


                <label><?=$val['NAME']?><span class="text-danger">*</span></label>

                <div class="input-group">
                <input type="date" disabled class="form-control" placeholder="<?=$val['NAME']?>">
                    <a href="/project/resultform/?id=<?=$idc?>&action=delete&element=<?=$key?>" class="btn btn-danger btn-icon"><i class="icon-trash"></i></a>
                </div>

            </div>
            <?php
        }


        if ($val['TYPE'] == 3){
            ?>
            <div class="form-group">
                <label><?=$val['NAME']?><span class="text-danger">*</span></label>


            <div class="input-group">
                <textarea rows="3" cols="3" disabled class="form-control" placeholder="<?=$val['NAME']?>"></textarea>
                <a href="/project/resultform/?id=<?=$idc?>&action=delete&element=<?=$key?>" class="btn btn-danger btn-icon"><i class="icon-trash"></i></a>
            </div>

            </div>
            <?php
        }







    }








}





function paystatus ($status){

    if  ($status == 0) return "<span class='badge badge-warning'>В ПРОЦЕССЕ</span>";
    if  ($status == 1) return "<span class='badge badge-success'>ИСПОЛНЕН</span>";

}


function camstatus ($status, $id ){
	if ($status=="1"){
		return '<div id="stat'.$id.'" class="badge badge-success">РАБОТАЕТ</div>';
	}
	if ($status=="2"){
		return '<div id="stat'.$id.'" class="badge badge-danger">НЕ РАБОТАЕТ</div>';
	}
	if ($status=="3" || $status == "4"){
		return '<div id="stat'.$id.'" class="badge badge-info">НЕ РАБОЧЕЕ ВРЕМЯ</div>';
	}
	if ($status=="5"){
		return '<div id="stat'.$id.'" class="badge badge-info">ДОСТИГНУТ ДНЕВНОЙ ЛИМИТ</div>';
	}
	if ($status=="6"){
		return '<div id="stat'.$id.'" class="badge badge-info">КОНЧИЛИСЬ КОНТАКТЫ</div>';
	}
}
// ВЫВОД МАССИВА ЧТОБЫ ОТОБРАЗИТЬ ФОРМУ С РЕЗУЛЬТАТОМ
function showmass ($par, $ch){
	foreach ($par as $key => $val){
		if ($ch){
			if ($val['TYPE']==2){ $dt = "(Д)"; }
			else{
				$dt="";
			}
			echo '
          <div id="polosa'.$key.'"  >
            <label class="col-md-3 control-label">'.$val['NAME'].'<span class="required" aria-required="true"> * </span></label>
               <div class="form-inline">
               <input title="rezt" name="'.$key.'" ttype="'.$val['TYPE'].'" tname="'.$val['NAME'].'" readonly="" type="text" class="form-control" placeholder="'.$dt.''.$val['NAME'].'" maxlength="50">
                <button class="btn btn-danger" kto="'.$key.'"  onclick="delc('.$key.')" ><i class="fa fa-trash"></i></button>
               </div>
          </div>
		';
		} else {
			if ($val['TYPE']==1){ //ТЕКСТОВОЕ ПОЛЕ
				echo '
          <div id="polosa'.$key.'" class="form-group">
            <label class="col-md-3 control-label">'.$val['NAME'].'<span class="required" aria-required="true"> * </span></label>
               <div class="form-inline">
<input title="rezt" name="'.$key.'" ttype="'.$val['TYPE'].'" tname="'.$val['NAME'].'" type="text" class="form-control"  placeholder="'.$val['NAME'].'" maxlength="50">
               </div>
          </div>
		';
			} //ТЕКСТОВОЕ ПОЛЕ
			if ($val['TYPE']==2){ // ДАТА
				echo '
         <div id="polosa'.$key.'" class="form-group">
         <label class="col-md-3 control-label">'.$val['NAME'].'<span class="required" aria-required="true"> * </span></label>
         <<div class="form-inline">
            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+1d">
                <span class="input-group-btn">
                <button class="btn default" type="button"> <i class="fa fa-calendar"></i></button>
                </span>
                <input title="rezt" name="'.$key.'" ttype="'.$val['TYPE'].'" tname="'.$val['NAME'].'" type="text" class="form-control" readonly="">
           </div>
		</div>
		</div>
		';
			} // ДАТА
			if ($val['TYPE']==3){ // EMAIL
				echo '
            <div id="polosa'.$key.'" class="form-group">
            <label class="col-md-3 id="tname" control-label">'.$val['NAME'].' <span class="required" aria-required="true"> * </span>  </label>
              <div class="form-inline">
                 <div class="input-group">
				     <input title="rezt" name="'.$key.'" ttype="'.$val['TYPE'].'" tname="'.$val['NAME'].'"  type="text" class="form-control" placeholder="'.$val['NAME'].'"> </div>
                  </div>
            </div>
		';
			} // EMAIL


		}
	}
}
// ВЫВОД МАССИВА ЧТОБЫ ОТОБРАЗИТЬ ФОРМУ С РЕЗУЛЬТАТОМ
// Проверка на ограничение
function pole_valid ($pole,$num,$type) {




	if ($type == "i"){
        if (!$pole) return ['error' => 'Поле пустое и не заполненно.'];
		$pole = intval($pole);
		if (strlen($pole) > $num) return ['error' => 'Текст '.strlen($pole).' символов слишком большой. Нужно не больее '.$num.' '];
	}
	if ($type == "s"){
        if (!$pole) return ['error' => 'Поле пустое и не заполненно.'];
		if (strlen($pole) > $num) return ['error' => 'Текст '.strlen($pole).' символов слишком большой. Нужно не больее '.$num.''];
		$pole = trim($pole);
		$pole = strip_tags($pole);
		$pole = htmlspecialchars($pole);
		iconv_strlen($pole, 'UTF-8');
	}
	if ($type == "u"){
        if (!$pole) return ['error' => 'Поле пустое и не заполненно.'];
		if (strlen($pole) > $num) ['error' => 'Текст '.strlen($pole).' символов слишком большой. Нужно не больее '.$num.''];
		$pole = trim($pole);
		$pole = strip_tags($pole);
		$pole = htmlspecialchars($pole);
		iconv_strlen($pole, 'UTF-8');
	}


    if ($type == "smax"){
        if (strlen($pole) > $num) return ['error' => 'Текст '.strlen($pole).' символов слишком большой. Нужно не больее '.$num.''];
        $pole = trim($pole);
        $pole = strip_tags($pole);
        $pole = htmlspecialchars($pole);
        iconv_strlen($pole, 'UTF-8');
    }

    if ($type == "imax"){
        $pole = intval($pole);
        if (strlen($pole) > $num) return ['error' => 'Текст '.strlen($pole).' символов слишком большой. Нужно не больее '.$num.' '];
    }




	return $pole;
}
// Проверка на ограничение


?>