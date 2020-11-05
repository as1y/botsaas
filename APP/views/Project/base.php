<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">ЗАГРУЗИТЬ БАЗУ</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
            </div>
        </div>
    </div>

    <div class="card-body justify-content-center">
        <div class="alert alert-info alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold">
                1. Файл необходимо загружать в формате .CSV с разделителем " <b>;</b> "<br>
                2. Пример загружаемого файла можно посмотреть <a href="/assets/examplebase.csv" target="_blank"><b>тут</b></a><br>
                3. Если в поле "ТЕЛЕФОН" несколько номеров несколько, то будет загружен только первый номер.<br>
                4. В базе обязательно должны быть поля "ТЕЛЕФОН" или "МОБИЛЬНЫЙ ТЕЛЕФОН". Приоритет звонка будет отдан номеру в поле "МОБИЛЬНЫЙ ТЕЛЕФОН"<br>
        </div>

        <form enctype="multipart/form-data" action="/project/base/?id=<?=$company['id']?>" method="POST"  data-fouc>

        <div class="form-group row">

            <label class="col-form-label col-lg-2">Загрузите файл:</label>
            <div class="col-lg-6">

                <input type="file" multiple accept=".csv" name="file" class="form-control-uniform-custom" data-fouc>
                <span class="form-text text-muted">Формат .CSV Не более 3MB</span>

            </div>
        </div>

        <input type="hidden" name="idc"  value="<?=$company['id']?>">
        <button type="submit" class="btn btn-warning"><i class="icon-file-upload2 mr-2"></i> НАЧАТЬ ЗАГРУЗКУ</button>

        </form>



    </div>

</div>



<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">БАЗА КОНТАКТОВ</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
            </div>
        </div>
    </div>

    <div class="card-body justify-content-center">


        <div class="table-responsive">
            <table class="table  table-bordered">
                <tbody>
                <tr>
                    <td class="wmin-md-100"><b>ВСЕГО ЗАГРУЖЕННО:</b></td>
                    <td class="wmin-md-350"><?=$contact['all']?></td>
                </tr>
                <tr>
                    <td class="wmin-md-100"><b>СВОБОДНЫХ:</b></td>
                    <td class="wmin-md-350"><?=$contact['free']?></td>
                </tr>
                <tr>
                    <td class="wmin-md-100"><b>ОБРАБОТАННО:</b></td>
                    <td class="wmin-md-350"><?=$contact['ready']?></td>
                </tr>
                <tr>
                    <td class="wmin-md-100">ПЕРЕЗВОНИТЬ ПОЗЖЕ:</td>
                    <td class="wmin-md-350"><?=$contact['perezvon']?></td>
                </tr>
                <tr>
                    <td class="wmin-md-100">ОТКАЗ:</td>
                    <td class="wmin-md-350"><?=$contact['otkaz']?> <a href href="/project/base/?id=<?=$idc?>&action=switchotkaz" class='btn btn-success'  > <i class='icon-database-refresh'></i> Обработать повтороно <i class='fa fa-refresh'></i></a></td>

                </tr>

                <tr>
                    <td class="wmin-md-100">ТЕЛЕФОН НЕ ДОСТУПЕН:</td>
                    <td class="wmin-md-350"><?=$contact['bezdostupa']?> <a href="/project/base/?id=<?=$idc?>&action=switcnedostup" class='btn btn-success' > <i class='icon-database-refresh'></i> Обработать повторно <i class='fa fa-refresh'></i></a></td>
                </tr>
                <tr>
                    <td class="wmin-md-100">ДУБЛИ:</td>
                    <td class="wmin-md-350"><a href="/project/base/?id=<?=$idc?>&action=dubli" class='btn btn-danger'  > <i class='icon-database-remove'></i> УДАЛИТЬ ДУБЛИ <i class='fa fa-refresh'></i></a></td>
                </tr>

                <tr>
                    <td class="wmin-md-100">УСПЕШНО ВСЕГО:</td>
                    <td class="wmin-md-350"><?=$result['all']?></td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

