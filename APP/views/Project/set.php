<!-- Table components -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">НАСТРОЙКИ <?=$company['name']?></h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        Table below contains different examples of components that can be used in the table: form components, interface components, buttons, list of actions etc. All of them are adapted for different cases, such as multiple elements in the same table cell. These components support all available sizes and styles. Charts are also supported, but in certain sizes.
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-lg">
            <tbody>

            <tr>
                <td class="wmin-md-300">Control links</td>
                <td class="wmin-md-350">
                    <div class="list-icons">
                        <a href="#" class="list-icons-item"><i class="icon-pencil7"></i></a>
                        <a href="#" class="list-icons-item"><i class="icon-trash"></i></a>
                        <a href="#" class="list-icons-item"><i class="icon-cog6"></i></a>
                    </div>
                </td>
                <td>Basic table row control buttons. These links appear as a list of links with icons</td>
            </tr>
            <tr>
                <td>Colored links</td>
                <td>
                    <div class="list-icons">
                        <a href="#" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                        <a href="#" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                        <a href="#" class="list-icons-item text-teal-600"><i class="icon-cog6"></i></a>
                    </div>
                </td>
                <td>Control links support different colors: default Bootstrap contextual colors and custom text colors from the custom color system. To use these colors add <code>.text-*</code> class to the parent <code>&lt;li></code> element</td>
            </tr>
            
            </tbody>
        </table>
    </div>
</div>
<!-- /table components -->




<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">ОБЩАЯ ИНФОРМАЦИЯ <?=$company['name']?></h3>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<tr>
						<td><b>ID:</b></td>
						<td>
							# <span id="idc"><?=$company['id']?></span> 
							<?=camstatus($company['status'],$company['id'] )?>
						</td>
					</tr>
					<tr>
						<td><b>Название:</b></td>
						<td><?=$company['name']?></td>
					</tr>
					<tr>
						<td><b>ТИП:</b></td>
						<td><?=companytype($company['type'])?></td>
					</tr>

                    <tr>
                        <td><b>ОПЛАТА ЗА РЕЗУЛЬТАТ:</b></td>
                        <td>
                            <div class="row">
                                <div class="col-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-xsmall" id="cfc"  value="<?=$company['cfc']?>">
                                        <span class="input-group-addon">РУБ</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>



					<?if(!empty($company['manager'])):?>
					<tr>
						<td><b>Ваш менеджер:</b></td>
						<td><?=$company['manager']?></td>
					</tr>
					<?endif;?>
					<tr>
						<td><b>ЛИМИТ:</b></td>
						<td>
							<div class="row">
								<div class="col-4">
									<div class="input-group">
										<span class="input-group-addon">В ДЕНЬ</span>
										<input type="text" class="form-control input-xsmall" id="daylimit" value="<?=$company['daylimit']?>">
									</div>
								</div>
							</div>
						</td>
					</tr>


					<tr>
						<td><b>Ограничение количества<br> операторов на проекте:</b></td>
						<td>
							<div class="row">
								<div class="col-4">
									<div class="input-group">
										<input type="text" class="form-control input-xsmall" id="count_operator" placeholder="по умолчанию: 20" value="<?=$company['countoperator']?>">
									</div>
								</div>
							</div>
						</td>
					</tr>



					<tr>
						<td><b>ДОПУСК ОПЕРАТОРОВ НА ПРОЕКТ:</b></td>
						<td>
							<label class="css-control css-control-danger css-radio">
								<input type="radio" class="css-control-input" name="moder" value="rumgo" <?=$company['moder'] == "rumgo" ? 'checked' : '';?>>
								<span class="css-control-indicator"></span> 
								<?=NAME?> (рекомендуется)
							</label>
							<label class="css-control css-control-danger css-radio">
								<input type="radio" class="css-control-input" name="moder" value="self"  <?=$company['moder'] == "self" ? 'checked' : '';?> >
								<span class="css-control-indicator"></span> 
								Самостоятельно
							</label>
							<label class="css-control css-control-danger css-radio">
								<input type="radio" class="css-control-input" name="moder" value="closed"  <?=$company['moder'] == "closed" ? 'checked' : '';?> >
								<span class="css-control-indicator"></span> 
								Набор закрыт
							</label>
						</td>
					</tr>
					<tr>
						<td><b>ДНИ НЕДЕЛИ:</b></td>
						<td>
							<?$dni= json_decode($company['dni'],TRUE);?>
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="PN" name="PN" <?=$dni['PN'] == "on" ? 'checked' : '';?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">ПН</span>
							</label>
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="VT" name="VT" <?=$dni['VT'] == "on" ? 'checked' : '';?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">ВТ</span>
							</label>
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="SR" name="SR" <?=$dni['SR'] == "on" ? 'checked' : '';?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">СР</span>
							</label>
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="CHT" name="CHT" <?=$dni['CHT'] == "on" ? 'checked' : '';?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">ЧТ</span>
							</label>
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="PT" name="PT" <?=$dni['PT'] == "on" ? 'checked' : '';?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">ПТ</span>
							</label>
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="SB" name="SB" <?=$dni['SB'] == "on" ? 'checked' : '';?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">СБ</span>
							</label>
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="VS" name="VS" <?=$dni['VS'] == "on" ? 'checked' : '';?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">ВС</span>
							</label>
						</td>
					</tr>
					<tr>
						<td><b>ВРЕМЯ ЗВОНКОВ:</b></td>
						<td>
							<div class="row">
								<div class="col-md-12">
									<select class="form-control" id="timecall" name="timecall">
										<option value="standart" <?=$company['timecall'] == "standart" ? 'selected' : '';?> >Рабочее время (09:00-19:00)</option>
										<option value="maximum" <?=$company['timecall'] == "maximum" ? 'selected' : '';?> >Расширенное время (09:00-21:00)</option>
									</select>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td><b>E-MAIL:</b></td>
						<td>
							<div class="input-group">
								<input type="text" class="form-control input-xsmall" id="company_email" value="<?=$company['email']?>">
							</div>
<? if ($company['uvedomlenie'] == 'true'):?>
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" checked="" id="uvedomlenie">
									<span class="custom-control-indicator"></span> 
									<span class="custom-control-description">Уведомлять</span>
								</label>
							</div>
<?else:?>
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input"  id="uvedomlenie">
									<span class="custom-control-indicator"></span> 
									<span class="custom-control-description">Уведомлять</span>
								</label>
							</div>
<?endif;?>
						</td>
					</tr>
					<tr>
						<td><b>SMS клиенту:</b></td>
						<td>
							<div class="input-group">
								<input type="text" class="form-control input-xsmall" id="company_sms_text" placeholder="Шаблон текста смс для клиента" value="<?=$company['sms_text']?>">
							</div>
<?if ($company['sms'] == '1'):?>
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" checked="" id="company_sms">
									<span class="custom-control-indicator"></span> 
									<span class="custom-control-description">Уведомлять</span>
								</label>
							</div>
<?else:?>
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input"  id="company_sms">
									<span class="custom-control-indicator"></span> 
									<span class="custom-control-description">Уведомлять</span>
								</label>
							</div>
<?endif;?>
						</td>
					</tr>
					<tr>
						<td><b>О КОМПАНИИ:</b></td>
						<td>
							<p><textarea  class="form-control" rows="10" cols="100" id="information"><?=$company['information']?></textarea></p>
						</td>
					</tr>
					<tr>
						<td><b>ТРЕБОВАНИЯ К РАЗГОВОРУ:</b></td>
						<td>
							<div class="input-group input-xlarge">
								<input type="text" class="form-control" id="NAME" placeholder="Раскрывать клиента">
								<span class="input-group-btn">
									<button class="btn btn-success" id="addcrit">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</button>
								</span>
							</div>
							<hr>
							<div id="formb" class="form-body">
								<?$crit = json_decode($company['criteriy'],TRUE);?>
<?
/*
$CRIT[] = 'Раскрывать клиента. Задавать встречные вопросы';
$CRIT[] = 'Произвести презентацию';
$CRIT[] = 'Обозначить стоимость услуги';
$CRIT[] = 'Разговор ТОЛЬКО с ЛПР';
*/
?>
<?if (isset($crit)):?>
	<?foreach ($crit as $key => $val):?>
								<div id="polosa<?=$key?>" class="form-group">
									<span title = "rezt" class="label label-info"> <?=$val?> </span>
									<button class="btn btn-danger btn-sm" kto="<?=$key?>" onclick="delcrit('<?=$key?>')">
										<i class="fa fa-trash"></i>
									</button>
								</div>
	<?endforeach;?>
<?endif;?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<b>Интеграция с amoCRM:</b>
							<div class=""><img src="/assets/img/logo/amocrm-logo-white.png" class="img-avatar img-avatar128"></div>
						</td>
						<td>
							<div class="row form-group">
								<div class="col-6">
									<div class="input-group">
										<span class="input-group-addon">E-mail</span>
										<input type="text" class="form-control input-xsmall" id="amoCRM_email" value="<?if(isset($amoDB['email'])) echo($amoDB['email']);?>" placeholder="mail@example.ru">
									</div>
								</div>
								<div class="col-6">
									<div class="input-group">
										<span class="input-group-addon">Домен <i style="margin-left: 5px;" data-toggle="popover" title="" data-placement="top" data-content="формат: example.amocrm.ru" class="fa fa-question-circle"></i></span>
										<input type="text" class="form-control input-xsmall" id="amoCRM_domain" value="<?if(isset($amoDB['domain'])) echo($amoDB['domain']);?>" placeholder="example.amocrm.ru">
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-12">
									<div class="input-group">
										<span class="input-group-addon">API-ключ</span>
										<input type="text" class="form-control input-xsmall" id="amoCRM_apikey" value="<?if(isset($amoDB['apikey'])) echo($amoDB['apikey']);?>">
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
				<p align="right">
					<button class="btn btn-info" onclick="changeinformation()" >Изменить информацию</button>
				</p>
			</div>
		</div>
	</div>
</div>   
<script>
$("#addcrit").click(function() {
	var NAME = $("#NAME").val();
	var url = 'wform';
	var name = 'addcrit';
	var idc = <?=$idc?>;
	var bd = $('[title = "rezt"]').length;
	if (NAME.length < 2) {
		alert('В поле должно быть более 2-х символов');
		return;
	}
	var str = '&idc=' + idc + '&NAME=' + NAME
	$.ajax(
		{
			url: '/' + url,
			type: 'POST',
			data: name + '_f=1' + str,
			cache: false,
			success: function(result) {
				obj = jQuery.parseJSON(result);
				if (obj.message == "done") {
					$("#NAME").val('');
					$("#formb").append('<div id="polosa' + bd + '" class="form-group"><span title = "rezt" class="label label-info">' + NAME + '</span><button class="btn btn-danger btn-sm" kto="' + bd + '"  onclick="delcrit(' + bd + ')" ><i class="fa fa-trash"></i></button></div>');
				} else {
					alert(obj.message);
				}
			}
		}
	);
});

function delcrit(kto) {
	var bd = $('[title = "rezt"]').length;
	var url = 'wform';
	var name = 'delcrit';
	var idc = <?=$idc?>;
	if (bd < 2) {
		alert('Должно остатся хотябы 1 поле');
		exit();
	}
	var str = '&idc=' + idc + '&kto=' + kto
	$.ajax(
		{
			url: '/' + url,
			type: 'POST',
			data: name + '_f=1' + str,
			cache: false,
			success: function(result) {
				obj = jQuery.parseJSON(result);
				if (obj.message == "done") {
					$("#polosa" + kto).remove();
				} else {
					alert(obj.message);
				}
			}
		}
	);
}
</script> 