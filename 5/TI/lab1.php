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
class shifratorDeshifrator {
	private $method; //вызываемый метод шифрования
	public $source; //исходный текст
	private $key; //ключ
	private $alphabet; //исходный алфавит
	private $lang = 'eng'; //язык текста
	private $size; //размер алфавита
	private $replTable; //таблицы подстановки
	public $encrypted; //зашифрованный текст
	private $frequency; //частотность символов
	private $keyLength;
		
	function __construct() {
		$this->prepare();
		if (method_exists("shifratorDeshifrator", $this->method)) {
			$method = $this->method;
			$this->$method();
		}
		else {
			echo "<p class='red'>Некорректное задание метода</p>";
		}
	}
	
	// подготовка
	private function prepare() {		
		$this->key = $_POST['key'];
		$this->method = $_POST['method'];
		$this->source = strtolower($_POST['text']);
		// определяем язык шифротекста и задаем алфавит
		for ($i=0; $i<strlen($this->source); $i++) {
			// русский
			if ($this->source[$i] <= 'я' && $this->source[$i] >= 'а') {
				$this->lang = 'rus';
				$this->alphabet = array('а','б','в','г','д','е','ё','ж','з','и'
										,'й','к','л','м','н','о','п','р','с','т'
										,'у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я');
				$this->frequency = array(0.07821, 0.01732, 0.04491, 0.01698, 0.03103, 0.08567, 0.0007, 0.01082, 0.01647, 0.06777, 0.01041, 0.03215, 0.04813, 0.03139, 0.0685, 0.11394, 0.02754, 0.04234, 0.05382, 0.06443, 0.02882, 0.00132, 0.00833, 0.00333, 0.01645, 0.00775, 0.00331, 0.00023, 0.01854, 0.02106, 0.0031, 0.00544, 0.01979);
				break;
			}
			// английский
			elseif ($this->source[$i] <= 'z' && $this->source[$i] >= 'a') {
				$this->lang = 'eng';		
				$this->alphabet = array('a','b','c','d','e','f','g','h','i'
									,'j','k','l','m','n','o','p','q','r'
									,'s','t','u','v','w','x','y','z');	
				$this->frequency = array(0.08167, 0.01492, 0.02782, 0.04253, 0.12702, 0.0228, 0.02015, 0.06094, 0.06966, 0.00153, 0.00772, 0.04025, 0.02406, 0.06749, 0.07507, 0.01929, 0.00095, 0.05987, 0.06327, 0.09056, 0.02758, 0.00978, 0.0236, 0.0015, 0.01974, 0.00074);
				break;
			}
		}
		$this->size = count($this->alphabet);
	}
	
	// метод Цезаря
	private function method_caesar() {
		// по сути метод Цезаря - тот же метод Вижинера, только с однобуквенным ключом
		$this->key = $this->alphabet[$this->key % count($this->alphabet)];
		$this->method_viginer();
	}
	
	// метод Вижинера
	private function method_viginer($flag = true) {
		$this->replTable = array();
		// генерация таблиц подстановки
		for ($i=0; $i<strlen($this->key); $i++) {
			$byteStr = $this->key[$i];
			$indI = array_search($byteStr, $this->alphabet);
			if ($indI === false) {
				$indI = 0;
			}
			for ($j = 0; $j<$this->size; $j++) {
				$this->replTable[$i][$this->alphabet[$j]] = $this->alphabet[($indI+$j) % $this->size];
			}
		}
		// шифрование текста
		for ($i=0; $i<strlen($this->source); $i++) {
			if (array_search($this->source[$i], $this->alphabet) === false) {
				$this->encrypted[$i] = $this->source[$i];
			}
			else
				$this->encrypted[$i] = $this->replTable[$i % count($this->replTable)][$this->source[$i]];
		}
		// печать текста
		?>
		<h4>Зашифрованный текст:</h4>
		<p>
		<? for ($i=0; $i<count($this->encrypted); $i++) {echo $this->encrypted[$i];}?>
		</p>
		<? if ($flag) {?>
		<input type="button" class="button" value="Показать исходный текст" id="show-source-but"><br>
		<div id="show-source" style="display:none"><br>
			<h4>Исходный текст:</h4>
			<p><i>Ключ: <?=$this->key?></i></p>
			<p>
			<?=$this->source?>
			</p>
		</div>
		<hr>
		<? } 
	}
	
	// расшифровка
	private function method_deshifr() {
		$this->keyLength = $this->kasiski();
		?>
		<h4>Предполагаемая длина ключа: <?=$this->keyLength?></h4>
		<?
		$this->key = $this->getKey();
		?>
		<p>Предполагаемый ключ по Вижинеру: <strong><?=$this->key?></strong></p>
		<?
		
		
		$this->keyReverse();
		$this->method_viginer(false);
		
		if ($this->keyLength != 1) {
			$this->keyLength = 1;
			$this->key = $this->getKey();
			?>
			<p>Предполагаемый ключ по Цезарю: <strong><?=$this->key?></strong></p>
			<?
			$this->keyReverse();
			$this->method_viginer(false);
		}
	}
	
	// нахождение длины ключа методом Касиски
	private function kasiski() {
		$prime = array();
		
		$text = $this->source;
		for ($i=0; $i<strlen($this->source) - 3; $i++) {
			$rast = array();
			$substr = substr($this->source, $i, 3);
			if (substr_count($substr, ' ') == 0 && substr_count($this->source, $substr) > 1) {
				$sm = $i + 3;
				while (($k = strpos($this->source, $substr, $sm)) !== false) {
					array_push($rast, $k+3 - $sm);
					$sm = $k + 3;
				}
			}
			for ($j=1; $j<count($rast); $j++) {
				$rast[$j] = $this->nod($rast[$j], $rast[$j-1]);
			}
			if ($rast[count($rast) - 1])
				array_push($prime, $rast[count($rast) - 1]);
		}
				
		for ($i=1; $i<count($prime); $i++) {
			if (($prime[$i] % $prime[$i-1] == 0 || $prime[$i-1] % $prime[$i] == 0) && min($prime[$i], $prime[$i-1]) >= 3) {
				$prime[$i] = $prime[$i-1] = min($prime[$i], $prime[$i-1]);
			}
		}
		
		$res = array_count_values($prime);
		if ($res) {
			$max = max($res);
			$ind = array_search($max, $res);
		}
		else $ind = 1;
		
		return $ind;
	}
	
	// реверс ключа для дешифрирования
	private function keyReverse() {
		$key = $this->key;
		for ($i = 0; $i<strlen($key); $i++) {
			$ind = array_search($key[$i], $this->alphabet);
			$key[$i] = $this->alphabet[$this->size - $ind];
		}
		$this->key = $key;
	}
	
	// подбор ключа
	private function getKey() {
		$key = '';
		
		for ($i = 0; $i<$this->keyLength; $i++) {
			// считаем частоты символов
			for ($j=0; $j<$this->size; $j++) {
				$freq[$this->alphabet[$j]] = 0;
			}
			
			for ($j=$i; $j<strlen($this->source); $j = $j + $this->keyLength) {
				if (in_array($this->source[$j], $this->alphabet)) {
					$freq[$this->source[$j]]++;
				}
			}
			$arrSum = array_sum($freq);
			for ($j=0; $j<$this->size; $j++) {
				if ($arrSum)
					$freq[$this->alphabet[$j]] /= $arrSum;
			}
			
			// перебираем все таблицы подстановки для поиска оптимальной
			$minDelta = 1000;
			for ($j = 0; $j<$this->size; $j++) {
				$delta = 0.0;
				for ($k=0; $k<$this->size; $k++) {
					$delta += abs($this->frequency[$k] - $freq[$this->alphabet[($k + $j) % $this->size]]);
				}
				if ($delta < $minDelta) {
					$key[$i] = $this->alphabet[$j];
					$minDelta = $delta;
				}
			}			
		}
		
		return implode($key);
	}
	
	// признак простого числа
	private function is_prime ($a)	{
		$half = $a / 2;
		for ($i=2; $i<=$half; $i++)
			if ($a % $i == 0) 
				return false;   
		return true;
	} 
	
	// НОД
	private function nod($a, $b) {
		while ($a != $b)
			if ($a>$b)
				$a -= $b;
			else
				$b -= $a;
		return $a;
	}
	
	
}


// ======================================= PAGE

?>
<head>
	<title>ТИ №1</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="script.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №1 по ТИ</h1>
	<a href="#shifr" id="set-shifr"><h2>Шифрование текста</h2></a>
	<a href="#deshifr" id="set-deshifr"><h2 style="border-bottom-color:#036;">Дешифрирование текста</h2></a>
	<a href="#analise" id="set-analise"><h2 style="border-bottom-color:#036;">Анализ алгоритма</h2></a>
	<div id="shifr">
		<div class="accept">
			<?
				if (isset($_POST['accept'])) {
					$shifr = new shifratorDeshifrator;
				}
			?>
			<form action="" id="form-shifr" method="post">
				<strong>Выберите метод шифрования:</strong>
				<select name="method" id="method">
					<option value="method_caesar" selected>1. Шифр Цезаря</option>
					<option value="method_viginer">2. Алгоритм Вижинера</option>
				</select><br>
				<p><strong id="label-key">Введите ключ шифрования: </strong><input type="number" name="key" id="key" value="3" min="1"></p>
				<p><strong>Введите текст для шифрования:</strong></p>
				<textarea name="text" id="text" style="width:100%; height:200px;" required></textarea>
				<br>
				<input type="button" id="text-generate-rus" value="Сгенерировать русский текст">
				<input type="button" id="text-generate-eng" value="Сгенерировать английский текст">
				<br><br>
				<input type="hidden" name="type" value="shifr">
				<input type="submit" name="accept" value="Зашифровать" class="button">
			</form>
		</div>
	</div>
	<div id="deshifr" style="display:none;">
		<div class="accept">
			<?
				if (isset($_POST['accept-deshifr'])) {
					$shifr = new shifratorDeshifrator;
					?>
					<hr>
					<?
				}
			?>
			<form action="" id="form-deshifr" method="post">
				<input type="hidden" name="method" value="method_deshifr">
				<p><strong>Введите текст для дешифрирования:</strong></p>
				<textarea name="text" id="text" style="width:100%; height:200px;" required><? if (isset($_POST['accept'])) {						
						echo implode($shifr->encrypted);
					}
					elseif (isset($_POST['accept-deshifr'])) {
						echo $shifr->source;
					}?></textarea>
				<br><br>
				<input type="submit" name="accept-deshifr" value="Расшифровать" class="button"><br>
			</form>
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
			
		</div>
	</div>
	<br>
	
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>