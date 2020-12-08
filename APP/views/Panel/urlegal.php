
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h5 class="card-title">ЮРИДИЧЕСКАЯ ИНФОРМАЦИЯ</h5>

            </div>

            <div class="card-body">

                <div class="form-group">


                            <form action="/panel/urlegal/?action=baseinfo" method="post" data-fouc>
                                <div class="form-group">
                                    <label>Название компании: <span class="text-danger">*</span></label>
                                    <input type="text" name="company" value="<?=$urlegal['company']?>" class="form-control required" placeholder="Название компании">
                                </div>

                                <div class="form-group">
                                    <label>САЙТ: <span class="text-danger">*</span></label>
                                    <input type="text" name="site" value="<?=$urlegal['site']?>" class="form-control required" placeholder="САЙТ">
                                </div>

                                <div class="form-group">
                                    <label>Юридическое лицо: <span class="text-danger">*</span></label>
                                    <input type="text" name="urlico" value="<?=$urlegal['urlico']?>" class="form-control required" placeholder="Юридическое лицо">
                                </div>

                                <div class="form-group">
                                    <label>ОГРН: <span class="text-danger">*</span></label>
                                    <input type="text" name="ogrn" value="<?=$urlegal['ogrn']?>" class="form-control required" placeholder="ОГРН">
                                </div>

                                <div class="form-group">
                                    <label>Почтовый адрес: <span class="text-danger">*</span></label>
                                    <input type="text" name="postadress"  value="<?=$urlegal['postadress']?>" class="form-control required" placeholder="Почтовый адрес">
                                </div>

                                <div class="form-group">
                                    <label>Телефон: <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" value="<?=$urlegal['phone']?>" class="form-control required" placeholder="Телефон">
                                </div>

                                <div class="form-group">
                                    <label>Юридический адрес: <span class="text-danger">*</span></label>
                                    <input type="text" name="uradres" value="<?=$urlegal['uradres']?>" class="form-control required" placeholder="Юридический адрес">
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-warning"><i class="icon-pencil mr-2"></i>Сохранить</button>
                                </div>

                            </form>







                </div>





                </form>
            </div>
        </div>

    </div>


    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h5 class="card-title">БАНКОВСКИЕ РЕКВИЗИТЫ</h5>

            </div>

            <div class="card-body">

                <div class="form-group">


                            <form action="/panel/urlegal/?action=payinfo" method="post" data-fouc>
                                <div class="form-group">
                                    <label>ИНН: <span class="text-danger">*</span></label>
                                    <input type="text" name="inn" value="<?=$payurinfo['inn']?>" class="form-control required" placeholder="ИНН">
                                </div>


                                <div class="form-group">
                                    <label>КПП: <span class="text-danger">*</span></label>
                                    <input type="text" name="kpp" value="<?=$payurinfo['kpp']?>"  class="form-control required" placeholder="КПП">
                                </div>

                                <div class="form-group">
                                    <label>БИК: <span class="text-danger">*</span></label>
                                    <input type="text" name="bic" value="<?=$payurinfo['bic']?>"  class="form-control required" placeholder="БИК">
                                </div>

                                <div class="form-group">
                                    <label>Р\С: <span class="text-danger">*</span></label>
                                    <input type="text" name="rs" value="<?=$payurinfo['rs']?>" class="form-control required" placeholder="Р\С">
                                </div>

                                <div class="form-group">
                                    <label>Кор.Счет: <span class="text-danger">*</span></label>
                                    <input type="text" name="kor" value="<?=$payurinfo['kor']?>" class="form-control required" placeholder="Кор.Счет">
                                </div>

                                <div class="form-group">
                                    <label>Название банка: <span class="text-danger">*</span></label>
                                    <input type="text" name="bank" value="<?=$payurinfo['bank']?>" class="form-control required" placeholder="Москва, Варшавское шоссе дом 1">
                                </div>

                                <div class="form-group">
                                    <label>Ф.И.О. контактного лица: <span class="text-danger">*</span></label>
                                    <input type="text" name="fio" value="<?=$payurinfo['fio']?>" class="form-control required" placeholder="Ф.И.О. контактного лица:">
                                </div>




                                <div class="text-left">
                                    <button type="submit" class="btn btn-warning"><i class="icon-pencil mr-2"></i>Сохрнаить</button>
                                </div>


                            </form>







                </div>





                </form>
            </div>
        </div>

    </div>


</div>


