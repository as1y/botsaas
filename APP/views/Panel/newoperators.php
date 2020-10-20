<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">НОВЫЕ ОПЕРАТОРЫ</h5>

    </div>

    <div class="card-body">

        <h1>ВОРОНКА ОПЕРАТОРОВ С ПЛАТНЫХ КАНАЛОВ</h1>
        Всего зарегистрировано операторов с рекламы: <b> <?=$operatorsfunnel['ADV']?></b><br>
        Совершили больше 1 звонка: <b><?=$operatorsfunnel['ADVwork']?></b><br>
        <hr>



        <table  class="table datatable-basic text-center">
            <thead>
            <tr>
                <th>Дата регистрации</th>
                <th>Имя Фамилия</th>
                <th>e-mail</th>
                <th>Контакт</th>
                <th>Действие</th>

            </tr>
            </thead>
            <tbody>

            <?php
            foreach ($operators as $key=>$val):?>

                <tr>
                    <td><?=$val['datareg']?></td>
                    <td>
                        <img src="<?=$val['avatar']?>" width="38" height="38" class="rounded-circle" alt=""><br>
                        <?=$val['username']?></td>

                    <td class="text-center"><?=$val['email']?></td>
                    <td class="text-center"><?=$val['contact']?></td>

                    <td class="text-center">

                        <a href="/panel/newoperators/?id=<?=$val['id']?>"   class="btn btn-info">РАЗГОВОР ПРОВЕДЕН</a>

                    </td>


                </tr>
            <?php endforeach;?>








            </tbody>
        </table>









    </div>



</div>


<script>


    function generatekeywords() {

        let  company = "";
        let coupon = "";

        company = $('select[name=company]').val();
        coupon = $('select[name=coupon]').val();

        str =  '&company=' + company + '&coupon=' + coupon + '&type=generatekeywords';

        $.ajax(
            {
                url : "/panel/addflow/",
                type: 'POST',
                data: str,
                cache: false,
                success: function( keywords ) {

                    $("#keywords").val(keywords);


                }
            }
        );




    }

    function generateads() {

        let  company = "";
        let keywords = "";
        let traffictype = "";

        traffictype = $('select[name=traffictype]').val();

        company = $('select[name=company]').val();
        keywords = $('#keywords').val();

        if (company === ""){
            alert("Выберите компанию");
            return false;
        }

        if (traffictype === ""){
            alert("Выберите типа трафика");
            return false;
        }


        if (keywords === ""){
            alert("Заполните ключевые слова");
            return false;
        }




        str =  '&company=' + company + '&keywords=' + keywords + '&traffictype=' + traffictype + '&type=generateads';


        $.ajax(
            {
                url : "/panel/addflow/",
                type: 'POST',
                data: str,
                cache: false,
                success: function( ads ) {

                    $("#ads").append(ads);
                    $("#go").show();

                }
            }
        );




    }




</script>