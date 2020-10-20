
<div class="row">

    <div class="col-md-12">

        <div class="card">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h5 class="card-title">РЕЙТИНГ ОПЕРАТОРОВ - ТОП 100</h5>

            </div>

            <div class="card-body">

                <table  class="table datatable-basic text-center">
                    <thead>
                    <tr>
                        <th>Звонков</th>
                        <th>Имя Фамилия</th>
                        <th>Информация</th>
                        <th>Рейтинг</th>
                        <th>Действие</th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($operators as $key=>$val):?>

                        <tr>
                            <td class="text-center"><?= (empty($val['totalcall'])) ? 0 : $val['totalcall']  ?></td>
                            <td>
                                <img src="<?=$val['avatar']?>" width="38" height="38" class="rounded-circle" alt=""><br>
                                <?=$val['username']?></td>

                            <td class="text-center"><?=$val['aboutme']?></td>
                            <td class="text-center"><?= (empty($val['totalresult'])) ? 0 : $val['totalresult']  ?></td>

                            <td class="text-center">

                                <a href="<?=generateprofilelink($val)?>" target="_blank"  class="btn btn-info">ПРОФИЛЬ</a>

                            </td>


                        </tr>
                    <?php endforeach;?>








                    </tbody>
                </table>
            </div>



        </div>



    </div>




</div>