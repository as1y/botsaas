<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">ВСЕ ПРОЕКТЫ</h5>
    </div>

    <div class="card-body">

        <div class="alert alert-info alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            Подайте заявку на проекты в которых хотите совершать звонки
        </div>


<!-- <i class="icon-target2 mr-2" data-popup="tooltip" title="ЛИД"></i>-->
<!--<i class="icon-people mr-2" data-popup="tooltip" title="ВСТРЕЧА"></i>-->
<!--<i class="icon-price-tag mr-2" data-popup="tooltip" title="УЧАСТИЕ В АКЦИИ"></i>-->
<!--<i class="icon-theater mr-2" data-popup="tooltip" title="ПРИГЛАШЕНИЕ"></i>-->
<!--<i class="icon-magazine mr-2" data-popup="tooltip" title="АНКЕТА"></i>-->
<!--<i class="icon-info3 mr-2" data-popup="tooltip" title="ИНФОРМИРОВАНИЕ"></i>-->


        <table  class="table datatable-basic text-center">
            <thead>
            <tr>
                <th>Компания</th>
                <th>Продукт</th>
                <th>Цель</th>
                <th>Требование</th>
                <th>Оплата</th>
                <th>Действие</th>

            </tr>
            </thead>


            <tbody>


            <?php foreach ($allcompanies as $key=>$val):?>

                <tr>
                    <td>
                        <img src="<?=$val['logo']?>" width="100" >
                        <br>
                        <?=$val['company']?>
                    </td>
                    <td>
                        <b>  <?=tematika($val['tematika'])?></b><br>
                        <?=obrezanie($val['nameproduct'], 70)?> <br>
                    </td>
                    <td>

                        <?=companytype($val['type'])?>

                    </td>

                    <td>

                        <?php if (empty($val['trebovanie'])) $val['trebovanie'] = "Нет";?>
                         <?=obrezanie($val['trebovanie'], 70)?>

                    </td>
                    <td>

                        <h5><span class="badge badge-success">+ <?=$val['priceoperator']?> руб. </span></h5>


                    </td>

                    <?php
                    $mystatus = \APP\models\Operator::mystatusincompany($val);
                    $add = "";
                    if ($mystatus == 1) $add = "bg-secondary";

                    ?>

                    <td class="<?=$add?>">



                        <?php renderstatus($mystatus, $val['id']) ?>



                    </td>
                </tr>


            <?php endforeach;?>








            </tbody>
        </table>
    </div>


</div>