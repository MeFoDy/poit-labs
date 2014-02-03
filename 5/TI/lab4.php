<? 

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

//=============================== CLASS_SHIFR
class Shifrator {
	private $source;
	private $out;	
	private $rezh;
	private $keys;
	private $k;
	
	function __construct() {
		// сохраняем содержимое файла
		$filename = $_FILES['sourcefile']['tmp_name'];
		$destination = "text/".$_FILES['sourcefile']['name'].".enc";
		$str = $_SERVER['SCRIPT_FILENAME'];
		$str = str_replace("lab4.php", "", $str);
				
		$this->rezh = intval($_POST['type']);
		
		if (file_exists($filename)) {
			
			if ($this->rezh !== 0) {
				copy($filename, $str.$destination);
			}
			$file = fopen($destination, "rb");
			// считываем побайтово
			while (!feof($file)) {
				$buf = fread($file, 1);
				$this->source .= $buf;
			}
			fclose($file);
			
			
			$keyfilename = $_FILES['keyfile']['tmp_name'];
			$keyfile = fopen($keyfilename, "rb");
			// считываем побайтово
			while (!feof($keyfile)) {
				$buf = fread($keyfile, 1);
				$this->keys .= $buf;
			}
			fclose($keyfile);
			
			
			// обработка
			$this->DoIt();
			// записываем в файл
			
			if ($this->rezh === 0) {
				
				$this->out = $this->source;
			}
			else {			
			
				$file = fopen($destination,"wb");
				fwrite($file, $this->out);
				fclose($file);
				
			}			
			echo "<p class='green'>Шифрование прошло успешно</p>";
			echo "<a href='$destination' target='_blank' class='button'>Скачать зашифрованный файл</a>";
		}
		else echo "<p class='red'>Файл не может быть открыт</p>";

	}
	
	private function DoIt() {
		
		$this->GenerateKeys();
		// если дешифрирование
		if ($this->rezh == 0) {
			$this->ChangeKeys();
		}
		
		/*for ($i=0; $i<10; $i++) {
			for ($j=0; $j<6; $j++) {
				printf("%04x ",$this->k[$i*6 + $j]);
			}
			echo "<br>";
		}
		echo "<br><br>";*/
		
		// приводим исходный текст к кратному 64 битам виду
		$sourceLength = strlen($this->source);
		while (strlen($this->source) % 8 != 0) {
			$this->source .= chr(0);
		}
		
		// шифруем блоками по 8 байт
		for ($i=0; $i<strlen($this->source); $i += 8) {
			$x = array();
			$x[0] = ((ord($this->source[$i + 0]) << 8) | (ord($this->source[$i + 1]))) & 0xFFFF;
			$x[1] = ((ord($this->source[$i + 2]) << 8) | (ord($this->source[$i + 3]))) & 0xFFFF;
			$x[2] = ((ord($this->source[$i + 4]) << 8) | (ord($this->source[$i + 5]))) & 0xFFFF;
			$x[3] = ((ord($this->source[$i + 6]) << 8) | (ord($this->source[$i + 7]))) & 0xFFFF;
			
			// первые 8 раундов
			$k = $this->k;
			for ($j = 0; $j < 8; $j++) {
				$keys = array($k[$j*6], $k[$j*6 + 1], $k[$j*6 + 2], $k[$j*6 + 3], $k[$j*6 + 4], $k[$j*6 + 5]);
				$x = $this->FirstRound($x, $keys);
				//printf("%04x %04x %04x %04x <br>",$x[0], $x[1], $x[2], $x[3]);
			}
						
			// 9й раунд
			$keys = array($k[48], $k[49], $k[50], $k[51]);
			$x = $this->NinthRound($x, $keys);
			//printf("%04x %04x %04x %04x <br>",$x[0], $x[1], $x[2], $x[3]);
			
			// сохранение результата шифрования
			for ($j=0; $j<count($x); $j++) {
				$this->out .= chr( ($x[$j] >> 8) & 0xFF );
				$this->out .= chr( $x[$j] & 0xFF );
				//printf("%016b ", $x[$j]);
			}
			//echo "<br>";
		}
		
	}
	
	// генерация набора ключей
	private function GenerateKeys() {
		$k = array();
		$keys = $this->keys;
		
		$k[0] = ((ord($keys[0]) << 8) | (ord($keys[1]))) & 0xFFFF;
		$k[1] = ((ord($keys[2]) << 8) | (ord($keys[3]))) & 0xFFFF;
		$k[2] = ((ord($keys[4]) << 8) | (ord($keys[5]))) & 0xFFFF;
		$k[3] = ((ord($keys[6]) << 8) | (ord($keys[7]))) & 0xFFFF;
		$k[4] = ((ord($keys[8]) << 8) | (ord($keys[9]))) & 0xFFFF;
		$k[5] = ((ord($keys[10]) << 8) | (ord($keys[11]))) & 0xFFFF;
		$k[6] = ((ord($keys[12]) << 8) | (ord($keys[13]))) & 0xFFFF;
		$k[7] = ((ord($keys[14]) << 8) | (ord($keys[15]))) & 0xFFFF;
		
		for ($i = 1; $i < 8; $i++) {
			
			for ($j=0; $j<8; $j++) {
				$k[$i*8 + $j] = (($k[($i-1)*8 + (($j + 1) % 8)] << 9) | ( ($k[($i-1)*8 + (($j + 2) % 8)] >> 7) )) & 0xFFFF ;
			}
		}
		
		/*for ($i=0; $i<8; $i++) {
			
			for ($j=0; $j<8; $j++) {
				printf("%016b ", $k[$i*8 + $j]);
			}
			echo "<br>";
		}*/
		for ($i=52; $i<64; $i++) {
			unset($k[$i]);
		}
		$this->k = $k;
	}
	
	// изменение набора ключей для дешифрирования
	private function ChangeKeys() {
		$k = $this->k;
		$t = array();
		
		for ($i=0; $i<8; $i++) {
			$t[$i*6 + 0] = $this->MultInv($k[(8-$i)*6 + 0]);
			$t[$i*6 + 1] = $this->AddInv($k[(8-$i)*6 + 2]);
			$t[$i*6 + 2] = $this->AddInv($k[(8-$i)*6 + 1]);
			$t[$i*6 + 3] = $this->MultInv($k[(8-$i)*6 + 3]);
			$t[$i*6 + 4] = ($k[(7-$i)*6 + 4]);
			$t[$i*6 + 5] = ($k[(7-$i)*6 + 5]);
		}
				
		$t[1] = $this->AddInv($k[49]);
		$t[2] = $this->AddInv($k[50]);
		
		$t[48] = $this->MultInv($k[0]);
		$t[49] = $this->AddInv($k[1]);
		$t[50] = $this->AddInv($k[2]);
		$t[51] = $this->MultInv($k[3]);
		
		$this->k = $t;
	}
	
	// мультипликативная инверсия
	private function MultInv($x) {
		$d = 1;
		while (true) {
			if ($this->BitMultiply($d, $x) == 1) {
				return $d;
			}
			else {
				$d++;
			}
		}
	}
	// аддитивная инверсия
	private function AddInv($x) {
		$d = 1;
		while (true) {
			if ($this->BitPlus($d, $x) == 0) {
				return $d;
			}
			else {
				$d++;
			}
		}
	}
	
	// побитное сложение по модулю 2
	private function BitXor($first, $second) {
		return ($first ^ $second) & 0xFFFF;
	}
	// сложение по модулю 2^16
	private function BitPlus($first, $second) {
		return (($first + $second) % pow(2,16)) & 0xFFFF;
	}
	// умножение по модулю 2^16+1
	private function BitMultiply($first, $second) {
		$first = $first == 0 ? pow(2,16) : $first;
		$second = $second == 0 ? pow(2,16) : $second;
		return (($first * $second) % (pow(2,16) + 1)) & 0xFFFF;
	}
	// мультипликативно-аддитивная структура
	private function BitMA($f1, $f2, $z5, $z6) {
		$left = $this->BitMultiply($f1, $z5);
		$right = $this->BitPlus($f2, $left);
		
		$right = $this->BitMultiply($right, $z6);
		$left = $this->BitPlus($left, $right);
		
		return array($left, $right);
	}
	
	// первый раунд
	private function FirstRound($input, $keys) {
		$z1 = $keys[0];
		$z2 = $keys[1];
		$z3 = $keys[2];
		$z4 = $keys[3];
		$z5 = $keys[4];
		$z6 = $keys[5];
		
		$x1 = $input[0];
		$x2 = $input[1];
		$x3 = $input[2];
		$x4 = $input[3];
		
		$i11 = $this->BitMultiply($x1, $z1);
		$i12 = $this->BitPlus($x2, $z2);
		$i13 = $this->BitPlus($x3, $z3);
		$i14 = $this->BitMultiply($x4, $z4);
		
		$tempArray = $this->BitMA($this->BitXor($i11, $i13), $this->BitXor($i12, $i14), $z5, $z6);
		$MAL = $tempArray[0];
		$MAR = $tempArray[1];
		
		$w11 = $this->BitXor($MAR, $i11);
		$w13 = $this->BitXor($i12, $MAL);
		$w12 = $this->BitXor($i13, $MAR);
		$w14 = $this->BitXor($i14, $MAL);
		
		return array($w11, $w12, $w13, $w14);
	}
	
	// девятый раунд
	private function NinthRound($input, $keys) {
		$w1 = $input[0];
		$w2 = $input[1];
		$w3 = $input[2];
		$w4 = $input[3];
		
		$z49 = $keys[0];
		$z50 = $keys[1];
		$z51 = $keys[2];
		$z52 = $keys[3];
		
		$y1 = $this->BitMultiply($w1, $z49);
		$y2 = $this->BitPlus($w3, $z50);
		$y3 = $this->BitPlus($w2, $z51);
		$y4 = $this->BitMultiply($w4, $z52);
		
		return array($y1, $y2, $y3, $y4);
	}
	
}


// ======================================= PAGE

?>
<head>
	<title>ТИ №4</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<link rel="stylesheet" href="style3.css" />
	<script src="jquery.min.js"></script>
	<script src="script-4.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №4 по ТИ</h1>
	<a href="#shifr" id="set-enigm"><h2>Шифратор IDEA</h2></a>
	<div id="shifr">
		<div class="accept">
			<?
				if (isset($_POST['accept'])) {
					$shifr = new Shifrator();
					?>
					<hr>
					<?
				}
			?>
			<form enctype="multipart/form-data" method="post" action="">
				<strong>Шифруемый файл: </strong>
				<input type="file" name="sourcefile" required><br><br>
				<strong>Ключ: </strong><input type="file" name="keyfile" required><br><br>
				<input type="radio" name="type" id="type1" value="1" checked><label for="type1">Зашифровать</label><br>
				<input type="radio" name="type" id="type2" value="0"><label for="type2">Расшифровать</label><br><br>
				<input type="hidden" name="accept">
				<input type="submit" class="button" value="Обработать">
			</form>
		</div>
		
	</div>
	
	<br>
	
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>