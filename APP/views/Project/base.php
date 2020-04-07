
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">ЗАГРУЗИТЬ БАЗУ</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
            </div>
        </div>
    </div>

    <div class="card-body justify-content-center">

        <form enctype="multipart/form-data" action="/project/base/?id=<?=$company['id']?>" method="post"  data-fouc>

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Загрузите файл:</label>
            <div class="col-lg-10">

                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                <input type="file" multiple accept=".csv" name="file" class="form-control-uniform-custom" data-fouc>
                <span class="form-text text-muted">Формат .CSV Не более 1MB</span>

            </div>
        </div>

        <input type="hidden" name="idc"  value="<?=$company['id']?>">
        <button type="submit" class="btn btn-primary"><i class="icon-file-upload2 mr-2"></i> НАЧАТЬ ЗАГРУЗКУ</button>

        </form>



    </div>

</div>



<div class="card">
    <div class="card-header header-elements-inline">
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
                    <td class="wmin-md-350"><?=$contact['late']?></td>
                </tr>
                <tr>
                    <td class="wmin-md-100">ОТКАЗ:</td>
                    <td class="wmin-md-350"><?=$contact['otkaz']?> <button class='btn btn-success' onclick="switchotkaz('<?=$idc?>')" > <i class='icon-database-refresh'></i> Обработать повтороно <i class='fa fa-refresh'></i></button></td>

                </tr>

                <tr>
                    <td class="wmin-md-100">ТЕЛЕФОН НЕ ДОСТУПЕН:</td>
                    <td class="wmin-md-350"><?=$contact['bezdostupa']?> <button class='btn btn-success' onclick="switcnedostup('<?=$idc?>')" > <i class='icon-database-refresh'></i> Обработать повторно <i class='fa fa-refresh'></i></button></td>
                </tr>
                <tr>
                    <td class="wmin-md-100">ДУБЛИ:</td>
                    <td class="wmin-md-350"><button class='btn btn-danger' onclick="dubli('<?=$idc?>')" > <i class='icon-database-remove'></i> УДАЛИТЬ ДУБЛИ <i class='fa fa-refresh'></i></button></td>
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
