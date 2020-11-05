
<div class="row">
    <div class="col-md-12">
<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h6 class="card-title">ДОБАВЛЕНИЕ ПРОЕКТА</h6>



    </div>

    <form class="wizard-form steps-validation" action="/master/add/" method="post" data-fouc>
        <h6>Компания</h6>
        <fieldset>


            <div class="row">


                <div class="col-md-6">
                    <div class="form-group">
                        <label>Компания: <span class="text-danger">*</span></label>
                        <input type="text" name="company" class="form-control required" placeholder="Пример: IVC PROJECT">
                        <span class="form-text text-muted">Пример: IVC PROJECT</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>ТРАНСКРИПЦИЯ: <span class="text-danger">*</span></label>
                        <input type="text" name="transkr" class="form-control required" placeholder="ТранскрипциЯ">
                        <span class="form-text text-muted">Операторы точно произносить название компании. Пример: "ЭЙ ВИ СИ ПРОДЖЭКТ"</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>URL сайта: <span class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control required" placeholder="URL сайта">
                        <span class="form-text text-muted">Пример: www.site.ru</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Адрес нахождения: <span class="text-danger">*</span></label>
                        <input type="text" name="adress" class="form-control required" placeholder="Москва, Орликов переулок дом 1">
                        <span class="form-text text-muted">Клиенты иногда спрашивают точное местонахождение.</span>

                    </div>
                </div>

                <div class="col-md-6">


                    <div class="form-group">
                        <label>Сфера деятельности: <span class="text-danger">*</span> </label>
                        <select name="tematika" data-placeholder="Выберете направление" class="form-control form-control-select2 required" data-fouc>
                            <option></option>
                            <option value="1">Digital</option>
                            <option value="2">Медицина</option>
                            <option value="3">Банковский сектр</option>
                            <option value="4">Страховка</option>
                        </select>

                        <span class="form-text text-muted">Укажите сферу деятельности, чтобы привлечь операторов с релевантным опытом</span>

                    </div>


                </div>




                <div class="col-md-12">
                    <div class="form-group">
                        <label>О компании: <span class="text-danger">*</span></label>
                        <textarea rows="5" cols="5" name="aboutcompany" class="form-control required"  placeholder="О компани"></textarea>
                        <span class="form-text text-muted">Короткие и важные факты о компании.</span>
                    </div>
                </div>




            </div>
        </fieldset>

        <h6>Продукт</h6>
        <fieldset>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Название продукта: <span class="text-danger">*</span></label>
                        <input type="text" name="nameproduct" placeholder="Название продукта" class="form-control required">
                        <span class="form-text text-muted">Название продукта который планируется предлагать</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-group">
                            <label>Минимальная ценовая планка:</label>
                            <input type="text" name="minimumprice" placeholder="Например: от 10.000" class="form-control">
                            <span class="form-text text-muted">Минимальная цена сделки или контракта</span>
                        </div>
                    </div>
                </div>



            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label>Описание продукта: <span class="text-danger">*</span></label>
                        <textarea rows="5" cols="5" name="aboutproduct" class="form-control required"  placeholder="Продукт для малого бизнеса. ЛПР владельцы ИП"></textarea>
                        <span class="form-text text-muted">Целевая аудитория продукта. Кто ЛПР.</span>
                    </div>

                </div>





            </div>


        </fieldset>

        <h6>Оффер</h6>
        <fieldset>
            <h2>Сколько и за что платить оператору</h2>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">Выберите цель звонка<span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <select name="type" size="6" class=" form-control">
                                <option value="1" selected="">ЛИД</option>
                                <option value="2">ВСТРЕЧА</option>
                                <option value="4">ПРИГЛАШЕНИЕ</option>
                                <option value="5">АНКЕТИРОВАНИЕ</option>
                                <option value="6">ИНФОРМИРОВАНИЕ</option>
                                <option value="7">ДРУГОЕ</option>
                            </select>

                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Оплата за достижение цели:<span class="text-danger">*</span></label>
                        <div class="input-group">
											<span class="input-group-prepend">
												<span class="input-group-text">РУБ.</span>
											</span>
                            <input type="text" name="priceresult" placeholder="500" class="form-control required">
                        </div>

                        <span class="form-text text-muted">Сколько вы готовы платить оператору за достижение цели</span>


                    </div>

<!--                    <div class="form-group row">-->
<!---->
<!--                        <div class="col-md-6">-->
<!--                            <label>Мин. кол-во звонков за смену:<span class="text-danger">*</span></label>-->
<!---->
<!--                            <div class="input-group">-->
<!--											<span class="input-group-prepend">-->
<!--												<span class="input-group-text">-->
<!--                                              <i class="icon-phone"></i>-->
<!--                                                </span>-->
<!--											</span>-->
<!--                                <input type="text" name="mincall" placeholder="100" value="100" class="form-control required">-->
<!--                            </div>-->
<!---->
<!---->
<!---->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-6">-->
<!--                            <label>Вознаграждение:<span class="text-danger">*</span></label>-->
<!--                            <div class="input-group">-->
<!--											<span class="input-group-prepend">-->
<!--												<span class="input-group-text">РУБ.</span>-->
<!--											</span>-->
<!--                                <input type="text" name="bonuscall" placeholder="500" class="form-control required">-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
<!---->
<!--                        <span class="form-text text-muted">Для мотивации рекомендуем поставить вознаграждение за совершения минимально кол-ва звонков</span>-->
<!---->
<!---->
<!--                    </div>-->




                </div>


            </div>





        </fieldset>

        <h6>Настройки</h6>
        <fieldset>


            <div class="row">

                <div class="col-md-6">

                    <label>Время звонков</label>
                    <select name="timecall" class="form-control form-control-select2" data-fouc>
                        <option value="standart">Будние дни, рабочее время (09:00-19:00)</option>
                        <option value="maximum">Будние дни, расширенное время (09:00-21:00)</option>
                        <option value="ultra">Будни + выходные, расширенное время (09:00-21:00)</option>
                    </select>

                    <span class="form-text text-muted">В какое время разрешено звонить по проекту</span>

                </div>




                <div class="col-md-6">
                    <label>E-mail: <span class="text-danger">*</span></label>
                    <input type="text" name="email" class="form-control required email" placeholder="E-mail" value="<?=$_SESSION['ulogin']['email']?>">
                    <span class="form-text text-muted">На который будут приходить уведомления и результаты</span>

                </div>



            </div>

            <div class="row text-center">
                <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success btn-labeled btn-labeled-left btn-lg">
                        <b><i class="icon-checkmark"></i></b>
                        Создать проект
                    </button>
                    <br>
                    <h2>СОЗДАТЬ ПРОЕКТ</h2>
                </div>
                <div class="col-md-4">
                </div>


            </div>





        </fieldset>



    </form>




</div>


    </div>
</div>