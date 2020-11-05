<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">БАЛАНС</h5>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-3">


                    <div class="card card-body">
                        <div class="media">
                            <div class="mr-3 align-self-center">
                                <i class="icon-wallet icon-3x text-success-400"></i>
                            </div>

                            <div class="media-body text-right">
                                <h3 class="font-weight-semibold mb-0"><?=\APP\core\base\Model::getBal()?></h3>
                                <span class="text-uppercase font-size-sm text-muted">РУБЛЕЙ</span>
                            </div>
                        </div>
                    </div>



            </div>

            <?php if ($_SESSION['ulogin']['role'] == "R"):?>
            <div class="col-md-3">
                <form method="post" target="_blank" action="/pay/redirect">
                    <div class="form-group">
                        <input type="text" name="summa" placeholder="Сумма" value="20000"  class="form-control">
                    </div>
                    <input type="hidden" name="paymethod" value="Unitpay">

                    <button type="submit" class="btn btn-success"><i class="icon-plus-circle2 mr-2"></i>ПОПОЛНИТЬ ONLINE</button>
                </form>
            </div>

            <div class="col-md-3">
                <form method="post" target="_blank" action="/pay/redirect">
                    <div class="form-group">
                        <input type="text" name="summa" placeholder="Сумма" value="20000"  class="form-control">
                    </div>
                    <input type="hidden" name="paymethod" value="Beznal">

                    <button type="submit" class="btn btn-success"><i class="icon-file-text mr-2"></i>ВЫСТАВИТЬ СЧЕТ</button>
                </form>

            </div>

            <?php endif;?>


        <?php if ($_SESSION['ulogin']['role'] == "O"):?>

            <div class="col-md-3">
                <a href="/panel/cashout/" type="button" class="btn btn-warning"><i class="icon-credit-card mr-2"></i>Вывести средства</a>
            </div>
            <?php endif;?>



        </div>


        <h2>Выставленные счета:</h2>
        <?php foreach ($invoicelog as $key=>$val):?>

        <?php if ($val['paymethod'] == "Beznal"): ?>
                Счет № <?=$val['id']?> | Сумма: <?=$val['summa']?> | Ссылка: <a href="<?=$val['path']?>" target="_blank">ПОСМОТРЕТЬ</a> |  <a href="/panel/balance/?idinvoice=<?=$val['id']?>&action=delinvoice">УДАЛИТЬ</a><br> <br>

        <?php endif;?>


        <?php endforeach; ?>


        <hr>

        <h2>Движение средств:</h2>
        <table  class="table datatable-basic ">
            <thead>
            <tr>
                <th>ДАТА</th>
                <th>СУММА</th>
                <th>ТИП</th>
                <th>КОММЕНТАРИЙ</th>
                <th>СТАТУС</th>

            </tr>
            </thead>


            <tbody>


            <?php foreach ($balancelog as $key=>$val):?>

                <tr>
                    <td><?=$val['date']?></td>
                    <td><b><?=$val['sum']?></b></td>
                    <td><?=$val['type']?></td>
                    <td><?=$val['comment']?></td>
                    <td ><?=paystatus($val['status'])?></td>
                </tr>


            <?php endforeach;?>








            </tbody>
        </table>
    </div>



</div>
