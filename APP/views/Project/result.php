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
                        <th><b>ДАТА</b></th>
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

                                <?=$val['datacall']?>
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
                                <a href="/project/result/?id=<?=$company['id']?>&idresult=<?=$val['id']?>&action=reject" type="button" class="btn btn-danger">ОТКЛОНИТЬ</a><br><br>


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

                    foreach ( $companyresult->ownResultList as $key=>$val):

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