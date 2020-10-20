<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">ВЫВОД СРЕДСТВ ПОЛЬЗОВАТЕЛЯМИ</h5>
    </div>

    <div class="card card-body">

        <table  class="table datatable-basic text-center">
            <thead>
            <tr>
                <th>#</th>
                <th>Дата</th>
                <th>Пользователь</th>
                <th>Комментарий</th>
                <th>Сумма</th>
                <th>Действие</th>


            </tr>
            </thead>
            <tbody>

            <?php
            $allsum = 0;
            foreach ($balancelogout as $key=>$val):
                $allsum = $allsum + $val['sum'];
                ?>

                <tr>
                    <td><?=$val['id']?></td>
                    <td>

                        <?=$val['date']?>

                    </td>

                    <td class="text-center">

                        <?=$val->users['username']?>

                    </td>
                    <td class="text-center"><?=$val['comment']?></td>
                    <td class="text-center"><?=$val['sum']?></td>

                    <td class="text-center">

                        <a href="/panel/payout/?id=<?=$val['id']?>" class="btn bg-danger"> ОТПРАВИТЬ</a>

                    </td>

                </tr>
            <?php endforeach;?>








            </tbody>
        </table>

        <b>ОБЩЕЕ:</b> <?=$allsum?>



    </div>



</div>
