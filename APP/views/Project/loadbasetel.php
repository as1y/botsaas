

<table class="table table-bordered " >

	


<?

if (($fp = fopen($filename, "r")) !== FALSE) {
	while (($data = fgetcsv($fp, 0, ";")) !== FALSE) {
		$list[] = $data;
	}
	fclose($fp);
}


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
	
<select id="stolbc" title="'.$i.'" class="form-control">
  <option value="none" selected>НЕ ИМПОРТИРОВАТЬ</option>
  <option value="name">ИМЯ</option>
  <option value="tel">ТЕЛЕФОН</option>
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


<button onclick="bazaload('<?=$idc?>','<?=$path?>','<?=$clientid?>')" class="btn btn-success">ПОЕХАЛИ</button>





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
