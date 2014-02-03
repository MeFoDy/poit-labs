<?
class EnigmaShifrator {
	private $key;
	private $sourceText;
	public $outText = '';
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
			
			//$c = $this->RotOne( $this->reflector[ $this->RotOne($m) ], true);
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


$obj = new EnigmaShifrator($_POST['k1'], $_POST['k2'], $_POST['k3'], $_POST['input']);
echo $obj->outText[strlen($obj->outText) - 1];