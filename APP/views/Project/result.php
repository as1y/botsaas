<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h5 class="card-title">РЕЗУЛЬТАТ НА ПРОВЕРКЕ</h5>

            </div>

            <div class="card-body">

                <table  class="table datatable-basic">
                    <thead>
                    <tr>
                        <th><b>#ID</b></th>
                        <th><b>ОПЕРАТОР</b></th>
                        <th><b>ИСХОДНЫЕ ДАННЫЕ</b></th>
                        <th><b>РЕЗУЛЬТАТ</b></th>
                        <th><b>ЗАПИСИ</b></th>
                        <th><b>ДЕЙСТВИЯ</b></th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    foreach ( $contactresult as $key=>$val):

                        $userinfo = $val->users;
                        $company = $val->company;

                        ?>
                        <tr>
                            <td class="text-center">

                                <?=$val['id']?>
                            </td>


                            <td class="text-center">

                                <img src="<?=$userinfo['avatar']?>" width="38" height="38" class="rounded-circle" alt=""><br>
                                <?=$userinfo['username']?>


                            </td>


                            <td>

                                <?php
                                rendercontactinfo($val);
                                ?>


                            </td>
                            <td>

                                <?php
                                renderresult($val['resultmass']);
                                ?>

                            </td>
                            <td>
                                <?= raskladkazapisi($allzapis[$val['id']]['data'])?></td>
                            <td >

                                <a href="/project/result/?id=<?=$company['id']?>&idresult=<?=$val['id']?>&action=accept" type="button" class="btn btn-success">ПОДТВЕРДИТЬ</a><br><br>
                                <button type="button" onclick="$('#idresult').val(<?=$val['id']?>)" class="btn btn-warning" data-toggle="modal"  data-target="#modal_form_horizontal">ДОРАБОТКА</button> <br><br>

                                <button type="button" onclick="$('#idresultreject').val(<?=$val['id']?>)" class="btn btn-danger" data-toggle="modal"  data-target="#modal_reject">ОТКЛОНИТЬ</button> <br><br>

<!--                                <a href="/project/result/?id=--><?//=$company['id']?><!--&idresult=--><?//=$val['id']?><!--&action=reject" type="button" class="btn btn-danger">ОТКЛОНИТЬ</a><br><br>-->


                            </td>


                        </tr>
                    <?php endforeach;?>




                    </tbody>
                </table>
            </div>



        </div>

    </div>
</div>


<div class="row">
    <div class="col-md-12">


        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h5 class="card-title">СТАТИСТИКА ОПЕРАТОРОВ</h5>

            </div>

            <div class="card-body">

                <table  class="table datatable-basic">
                    <thead>
                    <tr>
                        <th class="text-center"><b>ЗВОНКОВ</b></th>
                        <th class="text-center"><b>% ОДОБРЕННЫХ</b></th>
                        <th class="text-center"><b>РЕЗУЛЬТАТ</b></th>
                        <th class="text-center"><b>% ОТКЛОНЕННЫХ</b></th>
                        <th class="text-center"><b>ОТКАЗ</b></th>
                        <th class="text-center"><b>ОПЕРАТОР</b></th>
                        <th class="text-center"><b>ИТОГ</b></th>



                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    foreach ( $statoperator['USERMASS'] as $val):


                        ?>
                        <tr>

                            <td class="text-center">
                                <?=$statoperator['CALLSU'][$val['id']]?>
                            </td>

                            <td class="text-center">
                                <?php
                                if (empty($statoperator['MASSACEPT'][$val['id']])) $statoperator['MASSACEPT'][$val['id']] = 0;
                                $convert = ($statoperator['MASSACEPT'][$val['id']]/$statoperator['CALLSU'][$val['id']])*100;
                                    $convert = round($convert, 2);
                                ?>
                                <?=$convert?> %
                            </td>


                            <td class="text-center">
                                <?=$statoperator['MASSACEPT'][$val['id']]?>
                            </td>

                            <td class="text-center">
                                <?php
                                if (empty($statoperator['MASSREJECT'][$val['id']])) $statoperator['MASSREJECT'][$val['id']] = 0;
                                $convertreject = ($statoperator['MASSREJECT'][$val['id']]/$statoperator['CALLSU'][$val['id']])*100;
                                $convertreject = round($convertreject, 2);
                                ?>
                                <?=$convertreject?> %
                            </td>




                            <td class="text-center">
                                <?php
                                if (empty($statoperator['MASSREJECT'][$val['id']])) $statoperator['MASSREJECT'][$val['id']] = 0;
                                echo $statoperator['MASSREJECT'][$val['id']];
                                ?>
                            </td>


                            <td class="text-center">
                                <img src="<?=$val['avatar']?>" width="38" height="38" class="rounded-circle" alt=""><br>
                                <?=$val['username']?>
                            </td>

                            <td class="text-center">
                                <?php
                                $rashodzvonki =$statoperator['CALLSU'][$val['id']] * 1.5;
                                $rashodoplata = $statoperator['MASSACEPT'][$val['id']] * 150;

                                $rashodbonus = ($statoperator['CALLSU'][$val['id']]/100);
                                $rashodbonus = floor($rashodbonus) * 200;

                                $itogo = $rashodzvonki+$rashodoplata+$rashodbonus;

                                ?>
                                ЗВ:  <?=$rashodzvonki ?><br>
                                ОП: <?=$rashodoplata?> <br>
                                БО: <?= $rashodbonus ?> <br>
                                <b>ИТОГО: <?= $itogo?></b>
<hr>
                                ЗАР: <?= $statoperator['MASSACEPT'][$val['id']] * 400?> <br>



                            </td>




                        </tr>
                    <?php endforeach;?>


                    </tbody>
                </table>


            </div>



        </div>

    </div>
</div>



<div class="row">

    <div class="col-md-12">

        <div class="card">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h5 class="card-title">ПОДТВЕРЖДЕННЫЕ РЕЗУЛЬТАТЫ</h5>

            </div>

            <div class="card-body">

                <table  class="table datatable-basic">
                    <thead>
                    <tr>
                        <th><b>ДАТА</b></th>
                        <th><b>ОПЕРАТОР</b></th>
                        <th><b>РЕЗУЛЬТАТ</b></th>
                        <th><b>ЗАПИСИ</b></th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    foreach ( $companyresult as $key=>$val):

                        if ($val['id'] == 0) continue;

                        $operator = $val->users;
                        $idcontact = $val->contact_id;

                        ?>
                        <tr>

                            <td>    <?=$val['date']?></td>

                            <td>

                                <img src="<?=$operator['avatar']?>" width="38" height="38" class="rounded-circle" alt=""><br>
                                <?=$operator['username']?>


                            </td>



                            <td>

                                <?php


                                renderresult($val['dataresult']);
                                ?>

                            </td>
                            <td>


                                <?= raskladkazapisi($allzapis[$val['contact_id']]['data'])?>




                            </td>



                        </tr>
                    <?php endforeach;?>




                    </tbody>
                </table>
            </div>



        </div>



    </div>

</div>


<div id="modal_form_horizontal" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ДОРАБОТКА</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <form action="/project/result/?id=<?=$company['id']?>" method="post" class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="idresult" id="idresult" value="">
                    <div class="form-group mb-0">
                        <label>Комментарий:<span class="text-danger">*</span></label>
                        <textarea rows="3" cols="3" class="form-control" name="comment" placeholder="Что необходимо доработать"></textarea>
                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ЗАКРЫТЬ</button>
                    <button type="submit" class="btn btn-warning">ОТПРАВИТЬ НА ДОРАБОТКУ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal_reject" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ОТКАЗ</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <form action="/project/result/?id=<?=$company['id']?>&action=reject" method="post" class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="idresultreject" id="idresultreject" value="">
                    <div class="form-group mb-0">
                        <label>Комментарий:<span class="text-danger">*</span></label>
                        <textarea rows="3" cols="3" class="form-control" name="comment" placeholder="Укажите причину отказа"></textarea>
                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ЗАКРЫТЬ</button>
                    <button type="submit" class="btn btn-danger">ОТКАЗ</button>
                </div>
            </form>
        </div>
    </div>
</div>
