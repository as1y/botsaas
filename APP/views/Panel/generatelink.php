<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">ГЕНЕРАТОР ССЫЛОК</h5>

    </div>

    <div class="card-body">


        <form action="/panel/generatelink/" method="post" data-fouc>

                <div class="row">


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ИСТОЧНИК ТРАФИКА: <span class="text-danger">*</span> </label>
                            <select name="traffictype" data-placeholder="Источник ТРАФИКА" class="form-control form-control-select2 required" data-fouc>
                                <option></option>
                                <option value="googlesearch">Google Adwords Search</option>
                                <option value="yandexsearch">Яндекс.Директ Поиск</option>
                            </select>
                        </div>
                    </div>


                    <button id="go" type="submit" class="btn btn-success btn-labeled btn-labeled-left btn-lg">
                        <b><i class="icon-notification2"></i></b>
                        ПОЛУЧИТЬ ССЫЛКУ
                    </button>

                    <hr>



                    <?php if (!empty($link)) :?>

                        <script>
                            function copytext() {
                                /* Get the text field */
                                var copyText = document.getElementById("myInput");

                                /* Select the text field */
                                copyText.select();

                                /* Copy the text inside the text field */
                                document.execCommand("copy");

                            }
                        </script>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ссылка для объявления: </label>
                                <input type="text" onclick="copytext()"  name="link" class="form-control" id="myInput" value="<?=$link?>">
                            </div>
                        </div>
                    <?php endif;?>



                </div>









        </form>







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