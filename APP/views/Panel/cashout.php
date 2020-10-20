<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">ЗАЯВКА НА ВЫВОД</h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">
                <form action="/panel/cashout/?action=viplata" method="post">
                К выводу доступно <b><?=\APP\core\base\Model::getBal()?></b> рублей <br>
                <hr>

                <div class="form-group">
                    <label>СУММА <span class="text-danger">*</span></label>
                    <input type="text" name="summa" placeholder="Сумма на вывод" class="form-control">
                </div>

                <div class="form-group">
                    <label>Способ вывода: <span class="text-danger">*</span> </label>
                    <select data-placeholder="Выберите способ вывода" name="sposob" class="form-control form-control-select2 required" data-fouc>

                        <?php

                        foreach ($requis as $key=>$val){

                            if (empty($val)) continue;

                            if ($key == "qiwi") $name = "QIWI";
                            if ($key == "yamoney") $name = "Яндекс.Деньги";
                            if ($key == "cardvisa") $name = "Карта банка VISA";
                            if ($key == "cardmaster") $name = "Карта банка MASTERCARD";
                            if ($key == "cardmir") $name = "Карта банка MIR";
                            if ($key == "cardukr") $name = "Карта Украинского банка";
                            ?>

                            <option  value="<?=$key?>" ><?=$name."-".$val?></option>

                        <?php


                        }

                            ?>









                    </select>

                </div>

                <button type="submit"  class="btn btn-success"><i class="icon-credit-card mr-2"></i>ЗАКАЗАТЬ ВЫВОД</button>
                </form>
            </div>




            <div class="col-md-6">
                <h2>МОИ РЕКВИЗИТЫ</h2>
                <span class="bg-warning">Внимание! Изменение реквезитов возможно только запрос в тех. поддержку</span>
                <form action="/panel/cashout/?action=changerequis" method="post">
                <div class="form-group">
                    <label>QIWI РФ (Комиссия 1.99%)</label>
                    <input type="text" name="qiwi" value="<?=(empty($requis['qiwi'])) ? "" : $requis['qiwi'] ?>" placeholder="Введите ваш QIWI" class="form-control">
                </div>

                <div class="form-group">
                    <label>Яндекс.Деньги РФ (Комиссия 1.99%)</label>
                    <input type="text"  name="yamoney" value="<?=(empty($requis['yamoney'])) ? "" : $requis['yamoney'] ?>" placeholder="Введите ваш Яндекс.Деньги" class="form-control">
                </div>

                <div class="form-group">
                    <label>Карта VISA РФ (RUB 1.99% + 45.00р.)</label>
                    <input type="text"  name="cardvisa" value="<?=(empty($requis['card'])) ? "" : $requis['card'] ?>"  placeholder="Введите ваш Номер карты" class="form-control">
                </div>

                    <div class="form-group">
                        <label>Карта MASTERCARD РФ (RUB 1.99% + 45.00р.)</label>
                        <input type="text"  name="cardmaster" value="<?=(empty($requis['card'])) ? "" : $requis['card'] ?>"  placeholder="Введите ваш Номер карты" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Карта MIR РФ (RUB 1.99% + 45.00р. )</label>
                        <input type="text"  name="cardmir" value="<?=(empty($requis['card'])) ? "" : $requis['card'] ?>"  placeholder="Введите ваш Номер карты" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Карта Украинского Банка (RUB 3% + 45.00р. )</label>
                        <input type="text"  name="cardukr" value="<?=(empty($requis['card'])) ? "" : $requis['card'] ?>"  placeholder="Введите ваш Номер карты" class="form-control">
                    </div>



                <button  type="submit" class="btn btn-warning"><i class="icon-checkmark mr-2"></i>СОХРАНИТЬ РЕКВИЗИТЫ</button>


                </form>

            </div>


        </div>





    </div>



</div>
