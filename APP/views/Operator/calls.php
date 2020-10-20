<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h5 class="card-title">РАЗГОВОРЫ</h5>

            </div>

            <div class="card-body">

                <table  class="table datatable-basic">
                    <thead>
                    <tr>
                        <th><b>#ID</b></th>
                        <th><b>ТЕЛЕФОН</b></th>
                        <th><b>ДАТА</b></th>
                        <th><b>РЕЗУЛЬТАТ</b></th>
                        <th><b>КОММЕНТАРИЙ</b></th>
                        <th><b>ЗАПИСЬ</b></th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    foreach ( $mycalls as $key=>$val):

                        $idcontact = $val->contact_id;


                        if (isset($_GET['status']))




                            ?>
                            <tr>

                            <td>

                        <?=$val['id']?>
                        </td>

                        <td>
                            <?=$val['tel']?>
                        </td>

                        <td>
                            <?=$val['datacall']?>
                        </td>



                        <td>

                            <?=contactstatus($val['status'])?>

                        </td>


                        <td width="30%"> <?=$val['operatorcomment']?> </td>
                        <td >


                            <?php
                            $zapis = [];
                            if (!empty($allzapis[$val['id']]['data'])) $zapis = $allzapis[$val['id']]['data'];
                            ?>


                            <?= raskladkazapisi($zapis)?>


                        </td>


                        </tr>
                    <?php endforeach;?>




                    </tbody>
                </table>
            </div>



        </div>



    </div>
</div>







