<div class="card">
    <div class="card-header bg-white header-elements-inline">
        <h5 class="card-title"><a href="/project/base/?id=<?=$idc?>" class="btn btn-light"><i class="icon-square-left mr-2"></i> НАЗАД</a>ОПРЕДЕЛЕНИЕ ПОЛЕЙ</h5>
        <div class="header-elements">
            <button onclick="bazaload('<?=$idc?>','<?=$path?>','<?=$company['client_id']?>')" class="btn btn-warning"><i class="icon-database-insert mr-2"></i>ДОБАВИТЬ КОНТАКТЫ</button>
        </div>
    </div>

    <div class="card-body justify-content-center">



        <table class="table table-bordered table-responsive">




            <?

            if (($fp = fopen($filename, "r")) !== FALSE) {
                while (($data = fgetcsv($fp, 0, ";")) !== FALSE) {
                    $list[]  = $data;
                }
                fclose($fp);
            }

//            $list = mb_convert_encoding($list, 'WINDOWS-1251');

            $strok = count($list);
            $stolb = count($list['0']);

            if ($strok <= 10) echo("Должно быть не менее 10 записей");


            echo "<b>СТРОК</b> : ".count($list)." |";
            echo "<b>СТОЛБЦОВ:</b> ".count($list['0'])."  ";
            /*
            echo "<b>#ID компании:</b> <span id='idc'>$idc</span>";
            echo "<b># Путь к базе</b> <span id='bazaload'>$path</span> <br><br>";
            */

            // ВЫВОД ШАПКИ
            echo "<tr>";
            for ($i = 0; $i < $stolb; $i++){
                echo '<td> 
	
<select id="stolbc" title="'.$i.'" style="width: 200px" class="form-control">
  <option value="none" selected>НЕ ИМПОРТИРОВАТЬ</option>
  <option value="name">ИМЯ</option>
  <option value="tel">ТЕЛЕФОН</option>
  <option value="mob">МОБ.ТЕЛ</option>  
  <option value="company">КОМПАНИЯ</option>
  <option value="site">САЙТ</option>
  <option value="comment">КОММЕНТАРИЙ</option>

</select> 	
	
</td>';

            }
            echo "</tr>";
            // ВЫВОД ШАПКИ



            // ВЫВОД ТЕЛА КОНТЕНТА
            for ($i = 0; $i <= 10; $i++){

                echo "<tr>";
                foreach ($list[$i] as $v){
                    echo "<td>$v</td>";
                }
                echo "</tr>";
// ВЫВОД ТЕЛА КОНТЕНТА



            }


            //show($list);




            ?>


        </table>






    </div>

</div>











<script>

$('[id = "stolbc"]').click(function(){
		
var a = $(this).val();
var b = $("option:selected",this).text(); //Текст выбранного селекта


 	});
 	
 	
$('[id = "stolbc"]').change(function(){	
var a = $(this).val();
var b = $("option:selected",this).text(); //Текст выбранного селекта

/*
if (a != "none"){
	$('#stolbc option[value="'+a+'"]').remove(); // Удаляем у всех выбранный тут элемент
	$(this).prepend( $('<option value="'+a+'" selected>'+b+'</option>')); //Добавляем в существующий выбранный элемент
	
} 
*/
 	});











</script>
