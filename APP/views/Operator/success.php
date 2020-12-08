<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">ГОТОВО</h5>

    </div>

    <div class="card-body">

        <table  class="table datatable-basic">
            <thead>
            <tr>
                <th><b>ПРОЕКТ</b></th>
                <th><b>ИСХОДНЫЕ ДАННЫЕ</b></th>
                <th><b>РЕЗУЛЬТАТ</b></th>
                <th><b>ОПЛАТА</b></th>
                <th><b>ЗАПИСЬ</b></th>
            </tr>
            </thead>
            <tbody>

            <?php

            foreach ($resultuser as $key=>$val):

                if ($val['id'] == 0) continue;


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
                        rendercontactinfo($val['contactinfo']);
                        ?>


                    </td>
                    <td>
                        <b>ДАТА: </b><?=$val['date']?><br>
                        <?php
                        renderresult($val['dataresult']);
                        ?>

                    </td>
                    <td >

                        <h3><?=$company['priceresult']?> </h3>

                    </td>





                </tr>
            <?php endforeach;?>




            </tbody>
        </table>
    </div>



</div>


