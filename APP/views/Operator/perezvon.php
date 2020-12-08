<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">ПЕРЕЗВОНЫ</h5>

    </div>

    <div class="card-body">

        <table  class="table datatable-basic">
            <thead>
            <tr>
                <th>ID</th>
                <th>ПРОЕКТ</th>
                <th>КОММЕНТАРИЙ</th>
                <th>ЗАПИСЬ РАЗГОВОРА</th>
                <th>ДАТА ПЕРЕЗВОНА</th>
                <th>ДЕЙСТВИЕ</th>
            </tr>
            </thead>


            <tbody>

            <?
            foreach ($contactperezvon as $row):
            unset($data);
            $today = date("d-m-Y");
            $data = $row['dataperezvona'];

            if (strtotime($today) > strtotime($data)) $data = "<div class='alert alert-warning'>Вы забыли перезвонить <br><b>".$data."</b></div>";
            if ($today == $data) $data = "$data<br><span class='label label-info'> СЕГОДНЯ !!! </span>";
            // if(empty($company['name'])) $company['name'] = "Вы уже не работаете в компании";
            ?>



            <tr>
                <td><?=$row['id'];?></td>
                <td><?=json_decode($row['company'], true)['company'];?></td>
                <td><?=$row['operatorcomment'];?></td>

                <td>
                    <?php
                    $datazapis = $allzapis[$row['id']]['data'];
                    ?>
                    <?= raskladkazapisi($datazapis)?>

                </td>

                <td><?=$data;?></td>

                <td>
                    <a class='btn btn-danger' href='/operator/call/?id=<?=json_decode($row['company'], true)['id']?>&perezvon=<?=$row['id'];?>'> ПЕРЕЗВОНИТЬ</a>
                </td>


            </tr>


                <?endforeach;?>





            </tbody>


        </table>

    </div>


</div>



