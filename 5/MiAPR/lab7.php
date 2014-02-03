<!DOCTYPE html>
<?	
	ini_set('memory_limit', '512M');
	ini_set("max_execution_time", "3600");
//================================ FUNCTIONS
//функция отображения элемента для отладки
function print_otlad($elem) {
	echo "<pre>";
	print_r($elem);
	echo "</pre>";
}

// заполнение пустых ячеек массива mas значением str
function fill_blank_array($mas, $str) {
	foreach ($mas as $key => $value) {
		if (is_blank($value)) {
			$mas[$key] = $str;
		}
	}
	return $mas;
}
// ======================================= PAGE

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<meta http-equiv="Pragma" content="no-cache">
<head>
	<title>МиАПР №7</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="script-7.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №7 по МиАПР</h1>
	<a href="#new" id="set-new"><h2>Рисование домика</h2></a>
	<form action="" id="new" method="post">
		
		<canvas id="canvas" style="float:left; margin-right:10px; border:1px solid #aaa;"></canvas>
		
		<label><input type="radio" id="tool1" checked name="tool" value="wall"> Стены</label><br>
		<label><input type="radio" id="tool2" name="tool" value="wind"> Окна</label><br>		
		<label><input type="radio" id="tool5" name="tool" value="door"> Дверь</label><br>
		<label><input type="radio" id="tool4" name="tool" value="roof"> Крыша</label><br>
		<label><input type="radio" id="tool3" name="tool" value="tube"> Флюгер</label><br><br>
		<!--<label><input type="radio" id="tool6" name="tool" value="Pencil"> Pencil</label><br><br>-->
		
		<input type="button" name="accept" value="Сгенерировать" class="button" id="gener" /> <input type="button" class="button" value="Очистить" id="clearCanvas"> <input type="button" name="accept" value="Анализировать" class="button" id="resh" />
		<br style="clear:both">
	</form><br>
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>
</html>