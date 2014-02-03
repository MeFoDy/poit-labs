<?

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

// вычитание строк
function str_minus($str1, $str2) {
	$minus = "";
	if (strnatcmp($str1, $str2) < 0) {
		$temp = $str1;
		$str1 = $str2;
		$str2 = $temp;
		$minus = "-";
	}
	
	// перевод строк в массив чисел
	$length = max(strlen($str1), strlen($str2)) + 1;
	$sl1 = array();
	for ($i=0; $i<$length - strlen($str1); $i++) {
		array_push($sl1, 0);
	}
	for ($i=0; $i<strlen($str1); $i++) {
		array_push($sl1, intval($str1[$i]));
	}
	
	$sl2 = array();
	for ($i=0; $i<$length - strlen($str2); $i++) {
		array_push($sl2, 0);
	}
	for ($i=0; $i<strlen($str2); $i++) {
		array_push($sl2, intval($str2[$i]));
	}
	// собственно вычитание массивов
	for ($i=0; $i<$length; $i++) {
		$w[$i] = 0;
	}
	$j=$length-1; 
	$k=0;
	while ($j>0) {
		$w[$j] = $sl1[$j] - $sl2[$j] - $k;
		if ($w[$j] < 0) {
			$w[$j] += 10;
			$k = 1;
		}
		else {
			$k = 0;
		}
		$j--;
	}
	$w[0] = $k;
	// если впереди незначащий 0
	$i = 0;
	while ($w[$i] == 0 && $i>0) {
		unset($w[$i++]);
	}
	
	return $minus.implode($w);
}

// сложение строк
function str_plus($str1, $str2) {	
	$minus = "";
	if ($str1[0] == "-" && $str2[0] != "-") {
		return str_minus($str2, substr($str1, 1, strlen($str1)));
	}
	if ($str1[0] != "-" && $str2[0] == "-") {
		return str_minus($str1, substr($str2, 1, strlen($str2)));
	}
	if ($str1[0] == "-" && $str2[0] == "-") {
		$str1 = substr($str1, 1, strlen($str1));
		$str2 = substr($str2, 1, strlen($str2));
		$minus = "-";
	}
	
	// перевод строк в массив чисел
	$length = max(strlen($str1), strlen($str2)) + 1;
	$sl1 = array();
	for ($i=0; $i<$length - strlen($str1); $i++) {
		array_push($sl1, 0);
	}
	for ($i=0; $i<strlen($str1); $i++) {
		array_push($sl1, intval($str1[$i]));
	}
	
	$sl2 = array();
	for ($i=0; $i<$length - strlen($str2); $i++) {
		array_push($sl2, 0);
	}
	for ($i=0; $i<strlen($str2); $i++) {
		array_push($sl2, intval($str2[$i]));
	}
	
	// собственно сложение массивов
	/*ADD(u, v, n) 
	j := 0; k := 0; 
	while j < n 
	   do wj := uj + vj + k 
		 if wj >= b 
		  then wj := wj – b 
		   k := 1 
		  else k := 0 
		 j := j + 1 
	wn := k 
	return (wn,... ,w0)
	*/
	for ($i=0; $i<$length; $i++) {
		$w[$i] = 0;
	}
	$j=$length-1; 
	$k=0;
	while ($j>0) {
		$w[$j] = $sl1[$j] + $sl2[$j] + $k;
		if ($w[$j] > 9) {
			$w[$j] -= 10;
			$k = 1;
		}
		else {
			$k = 0;
		}
		$j--;
	}
	$w[0] = $k;
	// если впереди незначащий 0
	$i = 0;
	while ($w[$i] == 0 && $i>0) {
		unset($w[$i++]);
	}
	
	return $minus.implode($w);
		
}

// умножение строк
function str_mult($str1, $str2) {
	$minus = "";
	if ($str1[0] == "-" && $str2[0] != "-") {
		$str1 = substr($str1, 1, strlen($str1));
		$minus = "-";
	}
	if ($str1[0] == "-" && $str2[0] == "-") {
		$str1 = substr($str1, 1, strlen($str1));
		$str2 = substr($str2, 1, strlen($str2));
	}
	if ($str1[0] != "-" && $str2[0] == "-") {
		$str2 = substr($str2, 1, strlen($str2));
		$minus = "-";
	}
	
	// создание массивов, цифры в обратном порядке
	$m1 = array();
	for ($i=strlen($str1)-1; $i>=0; $i--) {
		array_push($m1, intval($str1[$i]));
	}
	$m2 = array();
	for ($i=strlen($str2)-1; $i>=0; $i--) {
		array_push($m2, intval($str2[$i]));
	}
	
	// умножение
	for ($j=0; $j<strlen($str1); $j++) {
		$w[$j] = 0;
	}
	$j=0;
	while ($j<strlen($str2)) {
		if ($m2[$j] > 0) {
			$i = $k = 0;
			while ($i<strlen($str1)) {
				$t = $m1[$i]*$m2[$j] + $w[$i+$j] + $k;
				$w[$i+$j] = $t % 10;
				$k = intval($t / 10);
				$i++;
			}
			$w[$j + strlen($str1)] = $k;
		}
		else {
			$w[$j+strlen($str1)] = 0;
		}
		$j++;
	}
	
	$i = count($w) - 1;
	while ($w[$i] == 0 && $i>0) {
		unset($w[$i--]);
	}
	
	$res = strrev(implode($w));
	return $minus.$res;
}

function str_karatsuba($str1, $str2) {
	$minus = "";
	if ($str1[0] == "-" && $str2[0] != "-") {
		$str1 = substr($str1, 1, strlen($str1));
		$minus = "-";
	}
	elseif ($str1[0] != "-" && $str2[0] == "-") {
		$str2 = substr($str2, 1, strlen($str2));
		$minus = "-";
	}
	elseif ($str1[0] == "-" && $str2[0] == "-") {
		$str1 = substr($str1, 1, strlen($str1));
		$str2 = substr($str2, 1, strlen($str2));
	}
	
	
	if (strlen($str1)<5 && strlen($str2)<5) {
		$val1 = intval($str1);
		$val2 = intval($str2);
		return strval($val1 * $val2);
	}
	
	$l = min(strlen($str1), strlen($str2));
	$n = intval($l / 2) + ($l%2);
	
	$u0 = substr($str1, $n);
	$u1 = substr($str1, 0, $n);
	
	$v0 = substr($str2, $n);
	$v1 = substr($str2, 0, $n);
	
	//echo "<br>",$u1, " ", $u0, " <br>", $v1," " ,$v0,"<br>";
	
	$c0 = str_karatsuba($u1, $v1);
	$c1 = str_karatsuba($u0, $v0);
	$c2 = str_karatsuba(str_plus($u0, $u1), str_plus($v0,$v1));
	
	$temp = str_plus($c2, "-".$c1);
	$temp = str_plus($temp, "-".$c0);
	
	for ($i=0; $i<2*$n; $i++) {
		$c0 .= '0';
	}
	for ($i=0; $i<$n; $i++) {
		$temp .= '0';
	}
	//echo $c0," ",$temp," ", $c1," ";
	$res = str_plus($c0, $c1);
	$res = str_plus($res, $temp);
	
	
	return $minus.$res;
}

// деление строк
function str_div($str1, $str2) {
	$minus = "";
	if ($str1[0] == "-" && $str2[0] != "-") {
		$str1 = substr($str1, 1, strlen($str1));
		$minus = "-";
	}
	elseif ($str1[0] != "-" && $str2[0] == "-") {
		$str2 = substr($str2, 1, strlen($str2));
		$minus = "-";
	}
	elseif ($str1[0] == "-" && $str2[0] == "-") {
		$str1 = substr($str1, 1, strlen($str1));
		$str2 = substr($str2, 1, strlen($str2));
	}
	
	$res = "";
	
	$buf = substr($str1, 0, strlen($str2));
	for ($i=strlen($str2); $i<=strlen($str1); $i++) {
		if (strlen($buf)>strlen($str2)) {
			$r1 = intval($buf[0].$buf[1]);
			$r2 = intval($str2[0]);
			$x = intval($r1 / $r2) - 1;
		}
		else {
			$r1 = intval($buf[0]);
			$r2 = intval($str2[0]);
			$x = intval($r1 / $r2) - 1;
		}
		while (true) {
			$mult = str_mult($str2, strval($x+1));
			$s = str_minus($buf, $mult);
			if ($s[0] !== '-') {
				$x++;
			}
			else 
				break;
		}
		$res .= strval($x);
		$buf = str_minus($buf, str_mult(strval($x), $str2));
		$buf .= $str1[$i];
	}
	
	if ($res[0] == "0") {
		$res = substr($res,1);
	}
	
	return $minus.$res;
}
	


// ======================================= PAGE

?>
<head>
	<title>ТИ №5</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="script.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №5 по ТИ</h1>
	<a href="#shifr" id="set-shifr"><h2>Сложение</h2></a>
	<a href="#deshifr" id="set-deshifr"><h2 style="border-bottom-color:#036;">Умножение</h2></a>
	<a href="#analise" id="set-analise"><h2 style="border-bottom-color:#036;">Деление</h2></a>
	<div id="shifr">
		<div class="accept">
			<center>
			<form action="" id="form-shifr" method="post">
				<label for="slozh-num">Количество цифр: </label>
				<input type="number" value="1000" id="slozh-num" name="slozh-num">
				<input type="button" value="Сгенерировать" class="button" id="gen-slozh">
				<input type="button" value="Очистить" class="button" id="clear-slozh"><br><br>
				<textarea name="first" cols="120" rows="10" id="first-slozh"><?=$_POST['first']?></textarea><br>
				<div style="font-size:42px">+</div>
				<textarea name="second" cols="120" rows="10" id="second-slozh"><?=$_POST['second']?></textarea><br>
				<div style="font-size:42px">=</div>
				<textarea id="slozh-result" disabled cols="120" rows="10"><?
					if (isset($_POST['accept'])) {
						$start_time = microtime(true);
						$str = str_plus($_POST['first'], $_POST['second']);
						echo $str;
						$exec_time = microtime(true) - $start_time;
						
					}
				?>
				</textarea><br>
				<input type="submit" name="accept" value="Сложить" class="button">
				<? if (isset($_POST['accept'])) {echo "<br><br><b>Затраченное время:</b> ", $exec_time, " сек";}?>
			</form>
			</center>
		</div>
	</div>
	<div id="deshifr" style="display:none;">
		<div class="accept">
			<?
				if (isset($_POST['accept-deshifr'])) {
					
					
										
				}
			?>
			<center>
			<form action="" id="form-deshifr" method="post">
				<label for="mult-num">Количество цифр: </label>
				<input type="number" value="1000" id="mult-num" name="mult-num">
				<input type="button" value="Сгенерировать" class="button" id="gen-mult">
				<input type="button" value="Очистить" class="button" id="clear-mult"><br><br>
				<textarea name="first" cols="120" rows="10" id="first-mult"><?=$_POST['first']?></textarea><br>
				<div style="font-size:42px">*</div>
				<textarea name="second" cols="120" rows="10" id="second-mult"><?=$_POST['second']?></textarea><br>
				<div style="font-size:42px">=</div>
				<textarea id="mult-result" disabled cols="120" rows="10"><?
					if (isset($_POST['accept-deshifr'])) {
						$start_time = microtime(true);
						$str = str_mult($_POST['first'], $_POST['second']);
						echo $str;
						$exec_time = microtime(true) - $start_time;
						
					}
				?>
				</textarea><br>
				<input type="submit" name="accept-deshifr" value="Умножить" class="button">
				<? if (isset($_POST['accept-deshifr'])) {
						echo "<br><br><b>Затраченное время на умножение столбиком:</b> ", $exec_time, " сек";
					$start_time = microtime(true);
					$str = str_karatsuba($_POST['first'], $_POST['second']);
					$exec_time = microtime(true) - $start_time;
					echo "<br><br><b>Затраченное время на умножение методом Карацубы:</b> ", $exec_time, " сек";
				}?>
			</form>
			</center>
		</div>
		<?
			if (isset($_POST['accept-deshifr'])) {
				?>
				<script>
				$('#set-shifr h2').css("border-bottom-color", "#036");
				$('#set-deshifr h2').css("border-bottom-color", "white");
				$('#shifr').hide();
				$('#deshifr').show();
				</script>
				<?
			}
		?>
	</div>
	<div id="analise" style="display:none;">
		<div class="accept">
			<?
				if (isset($_POST['accept-del'])) {
					
					
										
				}
			?>
			<center>
			<form action="" id="form-div" method="post">
				<label for="div-num">Количество цифр: </label>
				<input type="number" value="200" id="div-num" name="div-num">
				<input type="button" value="Сгенерировать" class="button" id="gen-div">
				<input type="button" value="Очистить" class="button" id="clear-div"><br><br>
				<textarea name="first" cols="120" rows="10" id="first-div"><?=$_POST['first']?></textarea><br>
				<div style="font-size:42px">/</div>
				<textarea name="second" cols="120" rows="10" id="second-div"><?=$_POST['second']?></textarea><br>
				<div style="font-size:42px">=</div>
				<textarea id="div-result" disabled cols="120" rows="10"><?
					if (isset($_POST['accept-div'])) {
						$start_time = microtime(true);
						$str = str_div($_POST['first'], $_POST['second']);
						echo $str;
						$exec_time = microtime(true) - $start_time;
						
					}
				?>
				</textarea><br>
				<input type="submit" name="accept-div" value="Разделить" class="button">
				<? if (isset($_POST['accept-div'])) {
						echo "<br><br><b>Затраченное время на деление:</b> ", $exec_time, " сек";
					}?>
			</form>
			</center>
			<?
			if (isset($_POST['accept-div'])) {
				?>
				<script>
				$('#set-shifr h2').css("border-bottom-color", "#036");
				$('#set-analise h2').css("border-bottom-color", "white");
				$('#shifr').hide();
				$('#analise').show();
				</script>
				<?
			}
		?>
		</div>
	</div>
	<br>
	
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>