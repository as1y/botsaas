

<?php



?>


<div class="row">

    <div class="col-md-6">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">ЗАЯВКИ В ПРОЕКТ</h5>

            </div>

            <div class="card-body">

                <table  class="table datatable-basic text-center">
                    <thead>
                    <tr>
                        <th>Имя Фамилия</th>
                        <th>Аватар</th>
                        <th>Звонков</th>
                        <th>Информация</th>
                        <th>Приветствие</th>
                        <th>Действие</th>

                    </tr>
                    </thead>


                    <tbody>


                    <?php


                    foreach ($operators['OperatoriNaModeracii'] as $key=>$val):?>
                        <tr>
                            <td><?=$val['username']?></td>
                            <td class="text-center">
                                <img src="<?=$val['avatar']?>" width="38" height="38" class="rounded-circle" alt="">
                            </td>
                            <td class="text-center"><?=$val['totalcall']?></td>
                            <td class="text-center"><?=$val['aboutme']?></td>
                            <td class="text-center">""</td>

                            <td class="text-center">Пропустить/Отклонить</td>


                        </tr>

                    <?php endforeach;?>








                    </tbody>
                </table>
            </div>



        </div>



    </div>





    <div class="col-md-6">

        ОПЕРАТОРЫ НА ПРОЕКТЕ


    </div>


</div>

