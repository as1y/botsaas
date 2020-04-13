<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">РЕЗУЛЬТАТ НА ПРОВЕРКЕ</h5>

            </div>

            <div class="card-body">

                <table  class="table datatable-basic text-center">
                    <thead>
                    <tr>
                        <th><b>ID</b></th>
                        <th><b>Дата</b></th>
                        <th><b>Оператор</b></th>
                        <th><b>ИСХОДНЫЕ ДАННЫЕ</b></th>
                        <th><b>РЕЗУЛЬТАТ</b></th>
                        <th><b>ЗАПИСЬ</b></th>
                        <th><b>ДЕЙСТВИЯ</b></th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    foreach ( $company->ownResultList as $key=>$val):
                        if ($val['id'] == 0) continue;

                        ?>
                        <tr>
                            <td>
                                #<?=$val['id']?>
                            </td>
                            <td class="text-center">Дата</td>
                            <td class="text-center">Оператор</td>
                            <td class="text-center">ИСХОДНЫЕ ДАННЫЕ</td>
                            <td class="text-center">РЕЗУЛЬТАТ</td>
                            <td class="text-center">ЗАПИСЬ</td>
                            <td class="text-center">

                                <a href="/project/operator/?id=<?=$company['id']?>&idresult=<?=$val['id']?>&action=accept" type="button" class="btn btn-success">ПОДТВЕРДИТЬ</a>
                                <a href="/project/operator/?id=<?=$company['id']?>&idresult=<?=$val['id']?>&action=reject" type="button" class="btn btn-danger">ОТКЛОНИТЬ</a>

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
ГОТОВЫЕ РЕЗУЛЬТАТЫ

    </div>



</div>


