<? session_start();

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
class EnigmaShifrator {
	private $key;
	private $sourceText;
	public $outText = '';
	public $out = '';
	public $source = '';
	private $rotorOne = array(	1 => 2,
								2 => 6,
								3 => 12,
								4 => 22,
								5 => 11,
								6 => 25,
								7 => 16,
								8 => 21,
								9 => 1,
								10 => 17,
								11 => 20,
								12 => 10,
								13 => 14,
								14 => 24,
								15 => 4,
								16 => 15,
								17 => 23,
								18 => 8,
								19 => 3,
								20 => 13,
								21 => 19,
								22 => 9,
								23 => 18,
								24 => 5,
								25 => 0,
								0 => 7
								);
	private $rotorTwo = array(	1 => 4,
								2 => 1,
								3 => 11,
								4 => 22,
								5 => 17,
								6 => 0,
								7 => 10,
								8 => 12,
								9 => 21,
								10 => 3,
								11 => 16,
								12 => 9,
								13 => 25,
								14 => 24,
								15 => 8,
								16 => 15,
								17 => 18,
								18 => 2,
								19 => 13,
								20 => 20,
								21 => 7,
								22 => 23,
								23 => 14,
								24 => 19,
								25 => 6,
								0 => 5
								);
	private $rotorThree = array(	1 => 2,
								2 => 4,
								3 => 6,
								4 => 8,
								5 => 10,
								6 => 12,
								7 => 14,
								8 => 16,
								9 => 18,
								10 => 20,
								11 => 22,
								12 => 24,
								13 => 0,
								14 => 25,
								15 => 23,
								16 => 21,
								17 => 19,
								18 => 17,
								19 => 15,
								20 => 13,
								21 => 11,
								22 => 9,
								23 => 7,
								24 => 5,
								25 => 3,
								0 => 1
								);
	private $reflector = array(	1 => 5,
								2 => 18,
								3 => 10,
								4 => 6,
								5 => 1,
								6 => 4,
								7 => 23,
								8 => 16,
								9 => 11,
								10 => 3,
								11 => 9,
								12 => 13,
								13 => 12,
								14 => 0,
								15 => 20,
								16 => 8,
								17 => 22,
								18 => 2,
								19 => 25,
								20 => 15,
								21 => 24,
								22 => 17,
								23 => 7,
								24 => 21,
								25 => 19,
								0 => 14
								);
								
	private $j1 = 0, $j2 = 0, $j3 = 0; // повороты роторов
								
	
	function __construct($key1, $key2, $key3, $text) {
		$this->key = $key1.$key2.$key3;
		// устанавливаем начальные повороты ротора
		$this->j1 = ord(strtoupper($key1)) - 65;
		$this->j2 = ord(strtoupper($key2)) - 65;
		$this->j3 = ord(strtoupper($key3)) - 65;
		// исходный текст
		$this->sourceText = $text;
		
		$this->PrepareText();
		$this->DoIt();
		$this->EditText();
		
		$this->out = $this->outText;
		$this->source = $this->sourceText;
	}
	
	// подготовка текста
	private function PrepareText() {
		$this->key = strtoupper($this->key);
		$this->sourceText = strtoupper($this->sourceText);
		// запятые меняем на ZZ
		$this->sourceText = preg_replace("#,#", "ZZ", $this->sourceText);
		// не латиницу меняем на X
		$this->sourceText = preg_replace("#[^A-Z]#", "X", $this->sourceText);
	}
	
	// финальная обработка текста для вывода
	private function EditText() {
		$this->outText = preg_replace("#X#", "x", $this->outText);
		$this->outText = preg_replace("#ZZ#", "zz", $this->outText);
		// разбиваем на группы
		/*for ($i = strlen($this->outText) - 1; $i > 0; $i--) {
			if ($i % 5 == 0) {
				$this->outText = substr_replace($this->outText, " ", $i, 0);
			}
		}*/
	}
	
	// шифрование
	private function DoIt() {
		for ($i = 0; $i<strlen($this->sourceText); $i++) {
			
			// шифрование
			$m = ord($this->sourceText[$i]) - 65;
			
			/*echo "<table style='display: inline-block; margin: 15px; background-color: yellow;'>";
				for ($j=0; $j<26; $j++) {
					echo "<tr>";
					echo "<td>", chr($j - $this->j1 + 65), "</td><td style='border-right:1px black solid;'>", chr($this->RotOne($this->rotorOne[$j]) + 65), "</td>";
					
					echo "<td>", chr($j + 65), "</td><td style='border-right:1px black solid;'>", chr($this->RotTwo($this->rotorTwo[$j]) + 65), "</td>";
					
					echo "<td>", chr($j + 65), "</td><td style='border-right:1px black solid;'>", chr($this->RotThree($this->rotorThree[$j]) + 65), "</td>";
					
					echo "<td>", chr($j + 65), "</td><td style='border-right:1px black solid;'>", chr($this->reflector[$j] + 65), "</td>";
					echo "</tr>";
				}
			echo "</table>";*/
			
			$c = $this->RotOne( $this->RotTwo( $this->RotThree( $this->reflector[ $this->RotThree( $this->RotTwo( $this->RotOne($m)))], true), true), true);
			$c = $this->RotOne( $this->reflector[ $this->RotOne($m) ], true);
			$c = $this->RotOne( $this->RotTwo( $this->RotThree( $this->reflector[ $this->RotThree($this->RotTwo($this->RotOne($m))) ], true), true), true);
			$this->outText .= chr($c+65);
			
			// вращения роторов
			$this->j1++;
			$this->j1 %= 26;
			if (($i+1) % 26 == 0 && $i > 1) {
				$this->j2++;
				$this->j2 %= 26;
			}
			if (($i+1) % (26*26) == 0 && $i > 1) {
				$this->j3++;
				$this->j3 %= 26;
			}
		}
	}
	
	private function RotOne($m, $isReverse = false) {
		if ($isReverse) {
			$rotorOne = array_flip($this->rotorOne);
			return ($rotorOne[($m + $this->j1) % 26] + $this->j1) % 26;
		}
		else {
			$rotorOne = $this->rotorOne;
			return ($rotorOne[($m - $this->j1 + 26) % 26] - $this->j1 + 26) % 26;
		}
	}
	
	private function RotTwo($m, $isReverse = false) {
		if ($isReverse) {
			$rotorTwo = array_flip($this->rotorTwo);
			return ($rotorTwo[($m + $this->j2) % 26] + $this->j2) % 26;
		}
		else {
			$rotorTwo = $this->rotorTwo;
			return ($rotorTwo[($m - $this->j2 + 26) % 26] - $this->j2 + 26) % 26;
		}
	}
	
	private function RotThree($m, $isReverse = false) {
		if ($isReverse) {
			$rotorThree = array_flip($this->rotorThree);
			return ($rotorThree[($m + $this->j3) % 26] + $this->j3) % 26;
		}
		else {
			$rotorThree = $this->rotorThree;
			return ($rotorThree[($m - $this->j3 + 26) % 26] - $this->j3 + 26) % 26;
		}
	}
	
	
}

class ModificatedEnigma {
	
	public $source = ''; // исходный файл 
	public $out = ''; //выходной файл
	private $lfsrForRotor; // 8-битный LFSR для генерации таблиц роторов
	private $longLFSR; // LFSR для RCB
	private $reflector; // таблица рефлектора
	private $rotor1, $rotor2, $rotor3; // таблицы роторов
	private $j1, $j2, $j3; // начальные позиции роторов
	private $pov1, $pov2, $pov3; // позиции флагов поворотов роторов в длинном LFSR
	private $c1 = 0, $c2 = 0, $c3 = 0; // предыдущие зашифрованные значения
	private $rezh; // режим работы: 1 - шифрование, 0 - дешифрирование
	
	function __construct() {
		define("LENGTH", 256);
		// сохраняем содержимое файла
		$filename = $_FILES['sourcefile']['tmp_name'];
		$destination = "text/".$_FILES['sourcefile']['name'].".enc";
		$str = $_SERVER['SCRIPT_FILENAME'];
		$str = str_replace("lab3.php", "", $str);
		
		if (file_exists($filename)) {
			copy($filename,$str.$destination);
			$file = fopen($destination, "rb");
			// считываем побайтово
			while (!feof($file)) {
				$buf = fread($file, 1);
				$this->source .= $buf;
			}
			fclose($file);
			
			$this->rezh = intval($_POST['type']);
			// обработка
			$this->GenKey($_POST['key']);
			$this->DoIt();
			// записываем в файл
			$file = fopen($destination,"wb");
			fwrite($file, $this->out);
			fclose($file);
		
			
		}
		else echo "<p class='red'>Файл не может быть открыт</p>";
	}
	
	// генерация начальных значений и позиций роторов и LFSR-в
	private function GenKey($key) {
		// ===генерация роторных таблиц
		
		// первый ротор
		$this->j1 = $this->lfsrForRotor = crc32($key) & 0xFF;
		$a = array();
		for ($i=1; $i<256; $i++) {
			$this->NextLFSR();
			array_push($a, $this->lfsrForRotor);
		}
		array_push($a, 0);
		$this->rotor1 = $a;
		
		// второй ротор
		$this->j2 = $this->lfsrForRotor = (crc32($key) >> 8) & 0xFF;
		$a = array();
		for ($i=1; $i<256; $i++) {
			$this->NextLFSR();
			array_push($a, $this->lfsrForRotor);
		}
		array_push($a, 0);
		$this->rotor2 = $a;
		
		// третий ротор
		$this->j3 = $this->lfsrForRotor = (crc32($key) >> 16) & 0xFF;
		$a = array();
		for ($i=1; $i<256; $i++) {
			$this->NextLFSR();
			array_push($a, $this->lfsrForRotor);
		}
		array_push($a, 0);
		$this->rotor3 = $a;
		
		// рефлектор
		$a = array();
		for ($i=0; $i<256; $i++) {
			$a[$i] = 255 - $i;
		}
		$this->reflector = $a;
		
		// ===генерация начального значения LFSR и RCB
		
		// заполнения значениями каждой части LFSR'а
		$this->longLFSR = array();
		$rand = crc32(sha1($key)) & 0xFF;
		for ($i=0; $i<10; $i++) {
			array_push($this->longLFSR, $rand);
			$rand = crc32($rand) & 0xFF;
		}
		
		// генерация I, J, K
		$this->pov1 = (crc32(md5($key)) & 0xFF) % 80;
		$this->pov2 = (crc32(($key)) & 0xFF) % 80;
		$this->pov3 = (crc32(sha1($key)) & 0xFF) % 80;
		// обеспечение уникальности I, J, K
		if ($this->pov1 == $this->pov2) {
			$this->pov2 = ($this->pov2 + 3) % 80;
		}
		if ($this->pov3 == $this->pov2) {
			$this->pov3 = ($this->pov3 + 5) % 80;
		}
		if ($this->pov3 == $this->pov1) {
			$this->pov1 = ($this->pov1 + 7) % 80;
		}
		if ($this->pov1 == $this->pov2) {
			$this->pov2 = ($this->pov2 + 3) % 80;
		}
		if ($this->pov3 == $this->pov2) {
			$this->pov3 = ($this->pov3 + 5) % 80;
		}
		if ($this->pov1 == $this->pov2) {
			$this->pov2 = ($this->pov2 + 3) % 80;
		}
				
	}
	
	// генерация нового значения LFSR
	private function NextLFSR() {
		// #0 1 5 6 8
		$bit = (($this->lfsrForRotor >> 0) & 1) ^ (($this->lfsrForRotor >> 4) & 1) ^ (($this->lfsrForRotor >> 5) & 1) ^ (($this->lfsrForRotor >> 7) & 1);
		$this->lfsrForRotor <<= 1;
		$this->lfsrForRotor |= $bit;
		
		$bit = (($this->lfsrForRotor >> 8) & 1);
		$this->lfsrForRotor &= 0xFF;
		return $bit;
	}
	
	// генерация нового значения RCB
	private function NextLongLFSR() {
		// #0 42 43 79 80
		$bit = (($this->longLFSR[5] >> 1) & 1) ^ (($this->longLFSR[5] >> 2) & 1) ^ (($this->longLFSR[9] >> 6) & 1) ^ (($this->longLFSR[9] >> 7) & 1);
		for ($i=0; $i<10; $i++) {
			$this->longLFSR[$i] <<= 1;
			$this->longLFSR[$i] |= $bit;
			$bit = ($this->longLFSR[$i] >> 8) & 1;
			$this->longLFSR[$i] &= 0xFF;
		}
		return $bit;
	}
	
	// собственно шифрование
	private function DoIt() {
		// шифруем побайтово
		for ($i = 0; $i<strlen($this->source); $i++) {
			// сохраним текущий байт
			$m = ord($this->source[$i]);
			// и обработаем его
			if ($this->rezh) {
				$c = $this->RotThree($this->RotTwo($this->RotOne($m))) ;
				//$c = $this->RotTwo($this->RotOne($m));
				$c = $this->RotOne($m);
				$this->out .= chr($c);
				// установим новые состояния роторов
				$this->c1 = $this->RotOne($m);
				$this->c2 = $this->RotTwo($this->RotOne($m));
				$this->c3 = $this->RotThree($this->RotTwo($this->RotOne($m)));
				//echo $this->c2, " ";
				
			}
			else {
				$c = $this->RotOne($this->RotTwo($this->RotThree($m, true), true), true) ;
				//$c = $this->RotOne($this->RotTwo($m, true), true) ;
				$c = $this->RotOne($m, true);
				$this->out .= chr($c);
				// установим новые состояния роторов
				$this->c1 = ($m);
				$this->c2 = ($this->RotThree($m, true)); 
				$this->c3 = ($this->RotTwo($this->RotThree($m, true), true));
				//echo $this->c2, " ";
				
			}
			
			$this->NextLongLFSR();
			
			$this->j1 += $this->c1 + $this->GetLFSRPos($this->pov1);
			$this->j2 += $this->c2 + $this->GetLFSRPos($this->pov2);
			$this->j3 += $this->c3 + $this->GetLFSRPos($this->pov3);
			$this->j1 %= LENGTH;
			$this->j2 %= LENGTH;
			$this->j3 %= LENGTH;
		}
	}
	
	// выбор значения из LFSR
	private function GetLFSRPos($k) {
		$i = intval($k / 8);
		$j = $k % 8;
		return (($this->longLFSR[$i] >> $j) & 1);
	}
	
	private function RotOne($m, $isReverse = false) {
		$j = $this->j1;
		if ($isReverse) {
			$rotor = array_flip($this->rotor1);
			$ans = ($rotor[($m + $j) % LENGTH] + $j) % LENGTH;
		}
		else {
			$rotor = $this->rotor1;
			$ans = ($rotor[($m - $j + LENGTH) % LENGTH] - $j + LENGTH) % LENGTH;
		}
		return $ans;
	}
	private function RotTwo($m, $isReverse = false) {
		$j = $this->j2;
		if ($isReverse) {
			$rotor = array_flip($this->rotor2);
			$ans = ($rotor[($m + $j) % LENGTH] + $j) % LENGTH;
		}
		else {
			$rotor = $this->rotor2;
			$ans = ($rotor[($m - $j + LENGTH) % LENGTH] - $j + LENGTH) % LENGTH;
		}
		return $ans;
	}
	private function RotThree($m, $isReverse = false) {
		$j = $this->j3;
		if ($isReverse) {
			$rotor = array_flip($this->rotor3);
			$ans = ($rotor[($m + $j) % LENGTH] + $j) % LENGTH;
		}
		else {
			$rotor = $this->rotor3;
			$ans = ($rotor[($m - $j + LENGTH) % LENGTH] - $j + LENGTH) % LENGTH;
		}
		return $ans;
	}
	
}

class Statistic {
	function __construct($shifr) {
		$elem = array();
		for ($i=0; $i<256; $i++) {
			$elem[$i][elem] = $i;
		}
		for ($i=0; $i<strlen($shifr->source); $i++) {
			$elem[ord($shifr->source[$i])][percent]++;
		}
		for ($i=0; $i<256; $i++) {
			$elem[$i][percent] /= strlen($shifr->source);
		}
		$_SESSION[one][compos] = $elem;
		$elem = array();
		
		for ($i=0; $i<256; $i++) {
			$elem[$i][elem] = $i;
		}
		for ($i=0; $i<strlen($shifr->out); $i++) {
			$elem[ord($shifr->out[$i])][percent]++;
		}
		for ($i=0; $i<256; $i++) {
			$elem[$i][percent] /= strlen($shifr->out);
		}
		$_SESSION[two][compos] = $elem;
		$_SESSION[two_compos] = true;
		?>
		<img src="image-compos.php?<?=rand()?>">
		<?
	}
}


// ======================================= PAGE

?>
<head>
	<title>ТИ №3</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<link rel="stylesheet" href="style3.css" />
	<script src="jquery.min.js"></script>
	<script src="script-3.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №3 по ТИ</h1>
	<a href="#shifr" id="set-enigm"><h2>Энигма</h2></a>
	<a href="#deshifr" id="set-mod"><h2 style="border-bottom-color:#036;">Модифицированная Энигма</h2></a>
	<a href="#analise" id="set-analise"><h2 style="border-bottom-color:#036;">Статистический анализ</h2></a>
	<div id="enigm">
		<div class="accept">
			<?
				if (isset($_POST['accept-enigm'])) {
					$shifr = new EnigmaShifrator($_POST['key-left'],$_POST['key-center'],$_POST['key-right'], $_POST['text']);
				}
			?>
			<form action="" id="enigmaMachine" method="post">
				<div id="enigma-image">
					<div id="enigma-key">
						<select name="key-left" id="k1">
						<?
						for ($i = 'A'; $i<'Z'; $i++) {
							echo "<option ";
							if ($i == 'K') {
								echo "selected";	
							}
							echo ">$i</option>";
						}
						echo "<option>Z</option>";
						?>
						</select>
						<select name="key-center" id="k2">
						<?
						for ($i = 'A'; $i<'Z'; $i++) {
							echo "<option ";
							if ($i == 'E') {
								echo "selected";	
							}
							echo ">$i</option>";
						}
						echo "<option>Z</option>";
						?>
						</select>
						<select name="key-right" id="k3">
						<?
						for ($i = 'A'; $i<'Z'; $i++) {
							echo "<option ";
							if ($i == 'Y') {
								echo "selected";	
							}
							echo ">$i</option>";
						}
						echo "<option>Z</option>";
						?>
						</select>
					</div>
					<center><img src="enigma-logo.png" width="150px"></center>
					<div id="enigma-keybord">
						<a>Q</a>
						<a>W</a>
						<a>E</a>
						<a>R</a>
						<a>T</a>
						<a>Y</a>
						<a>U</a>
						<a>I</a>
						<a>O</a>
						<a>P</a><br>
						<a>A</a>
						<a>S</a>
						<a>D</a>
						<a>F</a>
						<a>G</a>
						<a>H</a>
						<a>J</a>
						<a>K</a>
						<a>L</a><br>
						<a>Z</a>
						<a>X</a>
						<a>C</a>
						<a>V</a>
						<a>B</a>
						<a>N</a>
						<a>M</a>
						<a>*</a>
					</div>
				</div>
				
				<hr width="190px" style="float:right; margin-top:80px; color:#6af;">
				<div id="shifr-text" style="float:right; text-align:center; border:2px solid #069; border-radius:15px; padding:10px 5px; background-color:#6af; color:white;">
					<p><strong>Введите текст для шифрования:</strong></p>
					<textarea name="text" id="text" class="text" style="width:400px; height:100px;" required></textarea>
					<br>
					<input type="button" class="text-generate-eng" value="Сгенерировать английский текст">
					<input type="submit" name="accept-enigm" value="Зашифровать" class="button">
				</div>
				<hr width="190px" style="float:right; margin-top:120px; color:#C30;">
				<div id="deshifr-text" style="float:right; text-align:center; border:2px solid #900; border-radius:15px; padding:10px 5px; background-color:#C30; color:white; margin-top:10px;">
					<p><strong>Зашифрованный текст:</strong></p>
					<textarea name="de-text" id="desource-text" style="width:400px; height:150px;"><? if (isset($_POST['de-text'])) echo $shifr->outText;?></textarea>
					<br>
					<input type="button" class="button" value="Поменять с исходным текстом" id="copy">
				</div>
			</form>
			
			<div style="clear:both"></div>
		</div>
	</div>
	<div id="mod" style="display:none;">
		<div class="accept">
			<?
				if (isset($_POST['accept-mod'])) {
					$shifr = new ModificatedEnigma;
					?>
					<hr>
					<?
				}
			?>
			<form enctype="multipart/form-data" method="post" action="">
				<strong>Шифруемый файл: </strong>
				<input type="file" name="sourcefile" required><br><br>
				<strong>Ключ: </strong><input type="text" required name="key" value="KEY"><br><br>
				<input type="radio" name="type" id="type1" value="1" checked><label for="type1">Зашифровать</label><br>
				<input type="radio" name="type" id="type2" value="0"><label for="type2">Расшифровать</label><br><br>
				<input type="hidden" name="accept-mod">
				<input type="submit" class="button" value="Обработать">
			</form>
		</div>
		<?
			if (isset($_POST['accept-mod'])) {
				?>
				<script>
				$('#set-enigm h2').css("border-bottom-color", "#036");
				$('#set-mod h2').css("border-bottom-color", "white");
				$('#enigm').hide();
				$('#mod').show();
				</script>
				<?
			}
		?>
	</div>
	<div id="analise" style="display:none;">
		<div class="accept">
			<?
			if (isset($_POST['accept-mod'])) {
				$stat = new Statistic($shifr);
			}
			if (isset($_POST['accept-enigm'])) {
				$stat = new Statistic($shifr);
			}
			?>
		</div>
	</div>
	<br>
	
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>