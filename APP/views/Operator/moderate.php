<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">НА МОДЕРАЦИИ</h5>

    </div>

    <div class="card-body">

        <table  class="table datatable-basic">
            <thead>
            <tr>
                <th><b>ПРОЕКТ</b></th>
                <th><b>ИСХОДНЫЕ ДАННЫЕ</b></th>
                <th><b>РЕЗУЛЬТАТ</b></th>
                <th><b>ЗАПИСИ</b></th>
                <th><b>ОПЛАТА</b></th>

            </tr>
            </thead>
            <tbody>

            <?php
            foreach ($contactmoderate as $key=>$val):
                $userinfo = $val->users;
                $company = $val->company;
                $idcontact = $val->contact_id;
                ?>

                <tr>
                    <td class="text-center">

                        <?=$company['company']?>


                    </td>


                    <td>

                        <?php
                        rendercontactinfo($val);
                        ?>


                    </td>
                    <td>
                        <b>ДАТА: </b><?=$val['datacall']?><br>
                        <?php
                        renderresult($val['resultmass']);
                        ?>

                    </td>
                    <td>
                        <?php
                        $datazapis = $allzapis[$val['id']]['data'];
                        ?>
                        <?= raskladkazapisi($datazapis)?>

                    </td>
                    <td >

                        <h3><?=$company['priceoperator']?> </h3>



                    </td>


                </tr>

            <?php endforeach;?>






            </tbody>
        </table>
    </div>



</div>


