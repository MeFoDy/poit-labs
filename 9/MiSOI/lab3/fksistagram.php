<?php

define("_COUNT", 3);

class Fksistagram {

	private $imagePath;
	private $img;
	private $data;
	private $comparator;

	public function __construct($path) {
		$this->imagePath = getcwd() . '/images/img/lenna.png';
		if (file_exists($path)) {
			$this->imagePath = $path;
		}
		$this->img = new Imagick($this->imagePath);
		$this->data = array();
	}

	private function iterate($method, $params = array()) {
		$iterator = $this->img->getPixelIterator();
		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$this->$method($pixel, $params);
			}
			$iterator->syncIterator();
		}
	}

	private function getBrightness($pixel) {
		$g = 0.3 * $pixel['r']+0.59 * $pixel['g']+0.11 * $pixel['b'];
		return $g >= 0 ? $g < 256 ? $g : 255:0;
	}

	public function src() {
		return true;
	}

	public function out() {
		header('Content-type: ' . $this->img->getFormat());
		echo $this->img->getimageblob();
	}

	private function debug($data) {
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
	}

	// ====== ПОЭЛЕМЕНТНАЯ ОБРАБОТКА ИЗОБРАЖЕНИЙ ======
	// ------ Гистограмма
	private function hist_prepare($pixel) {
		$color = $pixel->getColor();
		$y = $this->getBrightness($color);
		$this->data[$y]['y']++;
		$this->data[$color['r']]['r']++;
		$this->data[$color['g']]['g']++;
		$this->data[$color['b']]['b']++;
	}
	public function histogram() {
		for ($i = 0; $i <= 256; $i++) {
			$this->data[$i] = array('r' => 0, 'g' => 0, 'b' => 0, 'y' => 0);
		}
		$this->iterate('hist_prepare');
		$maxPixelCount = 0;
		foreach ($this->data as $k => $v) {
			$maxPixelCount = max($maxPixelCount, $v['r'], $v['g'], $v['b'], $v['y']);
		}
		$this->img->newImage(512, 512, new ImagickPixel('white'));
		$this->img->setImageFormat('png');
		$draw = new ImagickDraw();
		for ($i = 0; $i < 257; $i++) {
			$draw->setStrokeColor('#ff0000');
			$draw->line($i * 2, 512, $i * 2, 512 - $this->data[$i]['r'] / $maxPixelCount * 512);
			$draw->setStrokeColor('#00ff00');
			$draw->line($i * 2, 512, $i * 2, 512 - $this->data[$i]['g'] / $maxPixelCount * 512);
			$draw->setStrokeColor('#0000ff');
			$draw->line($i * 2, 512, $i * 2, 512 - $this->data[$i]['b'] / $maxPixelCount * 512);
			$draw->setStrokeColor('#aaaaaa');
			$draw->line($i * 2, 512, $i * 2, 512 - $this->data[$i]['y'] / $maxPixelCount * 512);
		}
		$this->img->drawImage($draw);
	}

	// ------ Гамма-коррекция
	private function gammaCorrection($pixel, $params) {
		$color = $pixel->getColor();
		$br = array(
			'r' => $color['r'],
			'g' => $color['g'],
			'b' => $color['b'],
			'y' => $this->getBrightness($color));
		$c = $params['c'];
		$q = $params['q'];
		$br['r'] = pow($br['r'], $q) * $c;
		$br['g'] = pow($br['g'], $q) * $c;
		$br['b'] = pow($br['b'], $q) * $c;
		$pixel->setColor("rgb({$br['r']},{$br['g']},{$br['b']})");
		return $br;
	}
	public function gammaCorrect($q, $c) {
		$this->iterate('gammaCorrection', array('q' => $q, 'c' => $c));
	}

	// ------ Grayscale
	private function grayscaleCorrection($pixel, $params) {
		$color = $pixel->getColor();
		$br = array(
			'r' => $color['r'],
			'g' => $color['g'],
			'b' => $color['b'],
			'y' => $this->getBrightness($color));
		$pixel->setColor("rgb({$br['y']},{$br['y']},{$br['y']})");
		return $br;
	}
	public function toGrayscale() {
		$this->iterate('grayscaleCorrection');
	}

	// ------ Логарифмическая коррекция
	private function logCorrection($pixel, $params) {
		$color = $pixel->getColor();
		$br = array(
			'r' => $color['r'],
			'g' => $color['g'],
			'b' => $color['b']);
		$c = $params['c'];
		$br['r'] = log(1 + $br['r']) * $c;
		$br['g'] = log(1 + $br['g']) * $c;
		$br['b'] = log(1 + $br['b']) * $c;
		$pixel->setColor("rgb({$br['r']},{$br['g']},{$br['b']})");
		return $br;
	}
	public function logCorrect($c) {
		$this->iterate('logCorrection', array('c' => $c));
	}

	// ------ Линейное контрастирование
	private function lineContrastCorrectionStep1($pixel) {
		$color = $pixel->getColor();
		$y = $this->getBrightness($color);
		$this->data['fmin'] = $y < $this->data['fmin'] ? $y : $this->data['fmin'];
		$this->data['fmax'] = $y > $this->data['fmax'] ? $y : $this->data['fmax'];
	}
	private function lineContrastCorrectionStep2($pixel, $params) {
		$color = $pixel->getColor();
		$y = $this->getBrightness($color);
		$pixel->setColor("rgb({$this->getLineContrastModification($color['r'], $params)}, "
			. "{$this->getLineContrastModification($color['g'], $params)}, "
			. "{$this->getLineContrastModification($color['b'], $params)})");
	}
	private function getLineContrastModification($y, $params) {
		$g = ($y - $this->data['fmin']) / (float) $params['deltaF'] * $params['deltaG']+$params['gmin'];
		return $g >= 0 ? $g < 256 ? $g : 255:0;
	}
	public function lineContrastCorrect($gmin, $gmax) {
		$this->data['fmax'] = 0;
		$this->data['fmin'] = 256;
		$this->iterate('lineContrastCorrectionStep1');
		$deltaF = $this->data['fmax']-$this->data['fmin'];
		$deltaG = abs($gmax - $gmin);
		$this->iterate('lineContrastCorrectionStep2', array(
			'gmin' => $gmin > $gmax ? $gmax : $gmin,
			'gmax' => $gmax > $gmin ? $gmax : $gmin,
			'deltaG' => $deltaG,
			'deltaF' => $deltaF));
	}

	// ------ Высокочастотный фильтр
	private function filter9($w, $c = 1) {
		$this->data['old'] = array();
		$iterator = $this->img->getPixelIterator();

		$height = $this->img->getImageHeight();
		$width = $this->img->getImageWidth();

		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$color = $pixel->getColor();
				$this->data[$row][$col] = $color;
			}
		}
		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				if ($row == 0 || $row == $height - 1 || $col == 0 || $col == $width - 1) {
					continue;
				}

				$r = $c * ($this->data[$row - 1][$col - 1]['r'] * $w[1]+$this->data[$row - 1][$col]['r'] * $w[2]+$this->data[$row - 1][$col + 1]['r'] * $w[3]
					+$this->data[$row][$col - 1]['r'] * $w[4]+$this->data[$row][$col]['r'] * $w[5]+$this->data[$row][$col + 1]['r'] * $w[6]
					+$this->data[$row + 1][$col - 1]['r'] * $w[7]+$this->data[$row + 1][$col]['r'] * $w[8]+$this->data[$row + 1][$col + 1]['r'] * $w[9]);
				$g = $c * ($this->data[$row - 1][$col - 1]['g'] * $w[1]+$this->data[$row - 1][$col]['g'] * $w[2]+$this->data[$row - 1][$col + 1]['g'] * $w[3]
					+$this->data[$row][$col - 1]['g'] * $w[4]+$this->data[$row][$col]['g'] * $w[5]+$this->data[$row][$col + 1]['g'] * $w[6]
					+$this->data[$row + 1][$col - 1]['g'] * $w[7]+$this->data[$row + 1][$col]['g'] * $w[8]+$this->data[$row + 1][$col + 1]['g'] * $w[9]);
				$b = $c * ($this->data[$row - 1][$col - 1]['b'] * $w[1]+$this->data[$row - 1][$col]['b'] * $w[2]+$this->data[$row - 1][$col + 1]['b'] * $w[3]
					+$this->data[$row][$col - 1]['b'] * $w[4]+$this->data[$row][$col]['b'] * $w[5]+$this->data[$row][$col + 1]['b'] * $w[6]
					+$this->data[$row + 1][$col - 1]['b'] * $w[7]+$this->data[$row + 1][$col]['b'] * $w[8]+$this->data[$row + 1][$col + 1]['b'] * $w[9]);
				$pixel->setColor("rgb({$r},{$g},{$b})");
			}
			$iterator->syncIterator();
		}
	}

	private function medianFilter($size = 3) {
		$this->data['old'] = array();
		$iterator = $this->img->getPixelIterator();

		$height = $this->img->getImageHeight();
		$width = $this->img->getImageWidth();

		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$color = $pixel->getColor();
				$this->data[$row][$col] = $color;
			}
		}
		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				if ($row < $size || $row > $height - $size - 1 || $col < $size || $col > $width - $size - 1) {
					continue;
				}
				$median = array('r' => array(), 'g' => array(), 'b' => array());
				for ($i = $row - $size; $i < $row + $size + 1; $i++) {
					for ($j = $col - $size; $j < $col + $size + 1; $j++) {
						array_push($median['r'], $this->data[$i][$j]['r']);
						array_push($median['g'], $this->data[$i][$j]['g']);
						array_push($median['b'], $this->data[$i][$j]['b']);
					}
				}
				sort($median['r']);
				$r = $median['r'][sizeof($median['r']) / 2 + sizeof($median['r']) % 2];
				sort($median['g']);
				$g = $median['g'][sizeof($median['g']) / 2 + sizeof($median['g']) % 2];
				sort($median['b']);
				$b = $median['b'][sizeof($median['b']) / 2 + sizeof($median['b']) % 2];
				$pixel->setColor("rgb({$r},{$g},{$b})");
			}
			$iterator->syncIterator();
		}
	}

	private function medianFilterGray($size = 3) {
		$this->data['old'] = array();
		$iterator = $this->img->getPixelIterator();

		$height = $this->img->getImageHeight();
		$width = $this->img->getImageWidth();

		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$color = $pixel->getColor();
				$this->data[$row][$col] = $color;
			}
		}
		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				if ($row < 1 || $row > $height - 1 || $col < 1 || $col > $width - 1) {
					continue;
				}
				$median = array();
				for ($i = $row - $size; $i < $row + $size + 1; $i++) {
					for ($j = $col - $size; $j < $col + $size + 1; $j++) {
						array_push($median, isset($this->data[$i][$j]['r']) ? $this->data[$i][$j]['r'] : 0);
					}
				}
				sort($median);
				$y = $median[sizeof($median) / 2 + sizeof($median) % 2];
				$pixel->setColor("rgb({$y},{$y},{$y})");
			}
			$iterator->syncIterator();
		}
	}

	private function meanValue_prepare($pixel) {
		$color = $pixel->getColor();
		$y = $color['r'];
		$this->data[$y]++;
	}
	public function meanValueGray() {
		$this->data = array();
		for ($i = 0; $i <= 256; $i++) {
			$this->data[$i] = 0;
		}
		$this->iterate('meanValue_prepare');
		$pixelCount = 0;
		foreach ($this->data as $v) {
			$pixelCount += $v;
		}
		$m = 0;
		foreach ($this->data as $k => $v) {
			$m += $v / $pixelCount * $k;
		}
		return $m;
	}

	private function thresholdGray($m = 127) {
		$iterator = $this->img->getPixelIterator();

		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$color = $pixel->getColor();
				$y = $color['r'];
				$y = $y < $m ? 0 : 255;
				$pixel->setColor("rgb({$y},{$y},{$y})");
			}
			$iterator->syncIterator();
		}
	}

	public function hfFilter() {
		$w = array(
			1 => -1, 2 => -1, 3 => -1,
			4 => -1, 5 => 9, 6 => -1,
			7 => -1, 8 => -1, 9 => -1);
		$this->filter9($w);
	}

	// ------ Низкочастотный фильтр
	public function lfFilter() {
		$w = array(
			1 => 1, 2 => 1, 3 => 1,
			4 => 1, 5 => 1, 6 => 1,
			7 => 1, 8 => 1, 9 => 1);
		$this->filter9($w, 1.0 / 9.0);
	}

	public function growFilter() {
		$w = array(
			1 => 5, 2 => 0, 3 => 5,
			4 => 0, 5 => 0, 6 => 0,
			7 => 5, 8 => 0, 9 => 5);
		$this->filter9($w, 1.0 / 25.0);
	}
	// ------ Оператор Робертса
	private function roberts($c = 1) {
		$this->data['old'] = array();
		$iterator = $this->img->getPixelIterator();

		$height = $this->img->getImageHeight();
		$width = $this->img->getImageWidth();

		$h1 = array(
			1 => 0, 2 => 1,
			3 => -1, 4 => 0);
		$h2 = array(
			1 => 1, 2 => 0,
			3 => 0, 4 => -1);

		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$color = $pixel->getColor();
				$this->data[$row][$col] = $color;
			}
		}
		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				if ($row == 0 || $row == $height || $col == 0 || $col == $width) {
					continue;
				}
				$r1 = ($this->data[$row - 1][$col - 1]['r'] * $h1[1]+$this->data[$row - 1][$col]['r'] * $h1[2]
					+$this->data[$row][$col - 1]['r'] * $h1[3]+$this->data[$row][$col]['r'] * $h1[4]);
				$r2 = ($this->data[$row - 1][$col - 1]['r'] * $h2[1]+$this->data[$row - 1][$col]['r'] * $h2[2]
					+$this->data[$row][$col - 1]['r'] * $h2[3]+$this->data[$row][$col]['r'] * $h2[4]);
				$r = sqrt($r1 * $r1 + $r2 * $r2);

				$g1 = ($this->data[$row - 1][$col - 1]['g'] * $h1[1]+$this->data[$row - 1][$col]['g'] * $h1[2]
					+$this->data[$row][$col - 1]['g'] * $h1[3]+$this->data[$row][$col]['g'] * $h1[4]);
				$g2 = ($this->data[$row - 1][$col - 1]['g'] * $h2[1]+$this->data[$row - 1][$col]['g'] * $h2[2]
					+$this->data[$row][$col - 1]['g'] * $h2[3]+$this->data[$row][$col]['g'] * $h2[4]);
				$g = sqrt($g1 * $g1 + $g2 * $g2);

				$b1 = ($this->data[$row - 1][$col - 1]['b'] * $h1[1]+$this->data[$row - 1][$col]['b'] * $h1[2]
					+$this->data[$row][$col - 1]['b'] * $h1[3]+$this->data[$row][$col]['b'] * $h1[4]);
				$b2 = ($this->data[$row - 1][$col - 1]['b'] * $h2[1]+$this->data[$row - 1][$col]['b'] * $h2[2]
					+$this->data[$row][$col - 1]['b'] * $h2[3]+$this->data[$row][$col]['b'] * $h2[4]);
				$b = sqrt($b1 * $b1 + $b2 * $b2);

				$pixel->setColor("rgb({$r},{$g},{$b})");
			}
			$iterator->syncIterator();
		}
	}
	public function robertsFilter() {
		$this->roberts();
	}

	private function Fill($x, $y, $L, $width, $height) {
		if (!isset($this->data[$x][$y])) {
			return;
		}
		if (($this->data['label'][$x][$y] == 0) && ($this->data[$x][$y]['r'] == 255)) {
			$this->data['label'][$x][$y] = $L;
			$this->data['l'] = $L;
			$this->data['flag'] = true;
			if ($x > 0) {
				$this->Fill($x - 1, $y, $L, $width, $height);
			}
			if ($x < $height - 1) {
				$this->Fill($x + 1, $y, $L, $width, $height);
			}
			if ($y > 0) {
				$this->Fill($x, $y - 1, $L, $width, $height);
			}
			if ($y < $width - 1) {
				$this->Fill($x, $y + 1, $L, $width, $height);
			}
		}
	}

	private function labeling($count = _COUNT) {
		$this->data = array();
		$iterator = $this->img->getPixelIterator();

		$height = $this->img->getImageHeight();
		$width = $this->img->getImageWidth();

		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$color = $pixel->getColor();
				$this->data[$row][$col] = $color;
				$this->data['label'][$row][$col] = 0;
			}
		}

		$L = 1;
		for ($y = 0; $y < $width; $y++) {
			for ($x = 0; $x < $height; $x++) {
				$this->data['flag'] = false;
				$this->Fill($x, $y, $L, $width, $height);
				if ($this->data['flag']) {
					$L++;
				}
			}
		}

		$this->data['colors'] = array();
		$redPlus = 61;
		$greenPlus = 154;
		$bluePlus = 91;
		for ($i = 0; $i <= $this->data['l']; $i++) {
			$this->data['colors'][$i]['r'] = $i * 1 * $redPlus % 256;
			$this->data['colors'][$i]['g'] = $i * 1 * $greenPlus % 256;
			$this->data['colors'][$i]['b'] = $i * 1 * $bluePlus % 256;

			$this->data['colors'][$i]['square'] = 0;
			$this->data['colors'][$i]['perim'] = 0;
			$this->data['colors'][$i]['x'] = 0;
			$this->data['colors'][$i]['y'] = 0;
			$this->data['colors'][$i]['m20'] = 0;
			$this->data['colors'][$i]['m02'] = 0;
			$this->data['colors'][$i]['m11'] = 0;

			$this->data['colors'][$i]['xmin'] = $width + 1;
			$this->data['colors'][$i]['ymin'] = $height + 1;
			$this->data['colors'][$i]['xmax'] = 0;
			$this->data['colors'][$i]['ymax'] = 0;

		}
		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$y = $this->data['label'][$row][$col];
				$r = $this->data['colors'][$y]['r'];
				$g = $this->data['colors'][$y]['g'];
				$b = $this->data['colors'][$y]['b'];
				$pixel->setColor("rgb({$r},{$g},{$b})");

				$this->data['colors'][$y]['square'] += 1;
				$this->data['colors'][$y]['x'] += $col;
				$this->data['colors'][$y]['y'] += $row;
				if ((isset($this->data['label'][$row][$col + 1]) && $y != $this->data['label'][$row][$col + 1])
					 || (isset($this->data['label'][$row][$col - 1]) && $y != $this->data['label'][$row][$col - 1])
					 || (isset($this->data['label'][$row - 1][$col]) && $y != $this->data['label'][$row - 1][$col])
					 || (isset($this->data['label'][$row + 1][$col]) && $y != $this->data['label'][$row + 1][$col])
				) {
					$this->data['colors'][$y]['perim'] += 1;
				}
			}
			$iterator->syncIterator();
		}

		for ($i = 0; $i <= $this->data['l']; $i++) {
			$this->data['colors'][$i]['x'] /= $this->data['colors'][$i]['square'];
			$this->data['colors'][$i]['y'] /= $this->data['colors'][$i]['square'];
			$this->data['colors'][$i]['comp'] = $this->data['colors'][$i]['perim'] * $this->data['colors'][$i]['perim'] / $this->data['colors'][$i]['square'];
		}

		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$y = $this->data['label'][$row][$col];
				if ($this->data['colors'][$y]['square'] < 25) {
					$this->data['label'][$row][$col] = -1;
					$this->data['colors'][$y]['square'] = 0;
				}
			}
		}

		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$y = $this->data['label'][$row][$col];
				if ($y < 0) {
					continue;
				}

				$this->data['colors'][$y]['m20'] += pow($col - $this->data['colors'][$y]['x'], 2);
				$this->data['colors'][$y]['m02'] += pow($row - $this->data['colors'][$y]['y'], 2);
				$this->data['colors'][$y]['m11'] += ($row - $this->data['colors'][$y]['y']) * ($col - $this->data['colors'][$y]['x']);
			}
		}

		for ($i = 0; $i <= $this->data['l']; $i++) {
			$point = $this->data['colors'][$i];
			$m20 = $point['m20'];
			$m02 = $point['m02'];
			$m11 = $point['m11'];
			if (($m20 + $m02 - sqrt(pow($m20 - $m02, 2) + 4 * $m11 * $m11)) == 0) {
				$this->data['colors'][$i]['elongation'] = 999999999;
			} else {
				$this->data['colors'][$i]['elongation'] = ($m20 + $m02 + sqrt(pow($m20 - $m02, 2) + 4 * $m11 * $m11)) / ($m20 + $m02 - sqrt(pow($m20 - $m02, 2) + 4 * $m11 * $m11));
			}
		}

		$objects = array();
		for ($i = 1; $i <= $this->data['l']; $i++) {
			$point = $this->data['colors'][$i];
			$objects[$i]['params'] = array(0 => $point['square'], 1 => $point['perim'], 2 => $point['comp'], 3 => $point['elongation']);
		}

		$COUNT = $count;

		$cores = array();
		for ($i = 0; $i < $this->data['l']; $i++) {
			if ($objects[$i + 1]['params'][0] == 0) {
				continue;
			}
			array_push($cores, $i + 1);
			if (sizeof($cores) == $COUNT) {
				break;
			}
		}

		$flag = true;
		while ($flag) {
			$flag = false;
			$oldCores = $cores;

			for ($i = 1; $i <= $this->data['l']; $i++) {
				$ind = -1;
				$min = 999999999999;
				for ($j = 0; $j < $COUNT; $j++) {
					$rast = $this->evklRast($objects[$i]['params'], $objects[$cores[$j]]['params']);
					if ($rast < $min) {
						$min = $rast;
						$ind = $j;
					}
				}
				if ($ind != -1) {
					$objects[$i]['core'] = $ind;
				}
				if ($objects[$i]['params'][0] == 0) {
					$objects[$i]['core'] = -1;
				}
			}

			for ($j = 0; $j < $COUNT; $j++) {
				$klaster = array();
				for ($i = 1; $i <= $this->data['l']; $i++) {
					if ($objects[$i]['core'] == $j) {
						array_push($klaster, $objects[$i]['params']);
						$ind = $i;
					}
				}
				$min = 999999999999;
				$ind = -1;
				$median = $this->getMedian($klaster);
				for ($i = 1; $i <= $this->data['l']; $i++) {
					if ($objects[$i]['core'] == $j) {
						$rast = $this->evklRast($objects[$i]['params'], $median);
						if ($rast < $min) {
							$min = $rast;
							$ind = $i;
						}
					}
				}
				if ($ind != $cores[$j] && $ind != -1) {
					$flag = true;
					$cores[$j] = $ind;
				}
			}
		}

		//file_put_contents("log.txt", var_export($objects, TRUE));
		//file_put_contents("log.txt", var_export($cores, TRUE), FILE_APPEND);

		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$y = $this->data['label'][$row][$col];
				if ($y != 0) {
					if ($y < 0) {
						$klaster = 0;
					} else {
						$klaster = $objects[$y]['core']+1;

						if ($this->data['colors'][$y]['xmin'] > $col) {
							$this->data['colors'][$y]['xmin'] = $col;
						}
						if ($this->data['colors'][$y]['ymin'] > $row) {
							$this->data['colors'][$y]['ymin'] = $row;
						}
						if ($this->data['colors'][$y]['xmax'] < $col) {
							$this->data['colors'][$y]['xmax'] = $col;
						}
						if ($this->data['colors'][$y]['ymax'] < $row) {
							$this->data['colors'][$y]['ymax'] = $row;
						}
					}
					$color = $this->data['colors'][$klaster];
					$r = $color['r'];
					$g = $color['g'];
					$b = $color['b'];
					$pixel->setColor("rgb({$r},{$g},{$b})");
				}
			}
			$iterator->syncIterator();
		}

		$this->img = new Imagick($this->imagePath);
		for ($i = 1; $i <= $this->data['l']; $i++) {
			$point = $this->data['colors'][$i];
			$color = $this->data['colors'][$objects[$i]['core']+1];
			$this->drawRect($point['xmin'], $point['ymin'], $point['xmax'], $point['ymax'], "rgb({$color['r']}, {$color['g']}, {$color['b']})");
		}
	}

	private function drawRect($x1, $y1, $x2, $y2, $color) {
		$draw = new \ImagickDraw();
		$strokeColor = new \ImagickPixel($color);
		$fillColor = new \ImagickPixel("rgba(0,0,0,0)");

		$draw->setStrokeColor($strokeColor);
		$draw->setFillColor($fillColor);
		$draw->setStrokeOpacity(1);
		$draw->setStrokeWidth(3);

		$draw->rectangle($x1, $y1, $x2, $y2);

		$this->img->drawImage($draw);
	}

	private function getMedian($objects) {
		$median = array();
		$params = array();
		for ($i = 0; $i < sizeof($objects[0]); $i++) {
			for ($j = 0; $j < sizeof($objects); $j++) {
				$params[$i][$j] = $objects[$j][$i];
			}
			sort($params[$i]);
		}

		for ($i = 0; $i < sizeof($objects[0]); $i++) {
			if (sizeof($params[$i]) == 1) {
				$median[$i] = $params[$i][0];
			} else {
				$median[$i] = $params[$i][sizeof($params[$i]) / 2 + sizeof($params[$i]) % 2];
			}
		}
		return $median;
	}

	private function evklRast($obj1, $obj2) {
		$rast = 0;
		for ($i = 0; $i < sizeof($obj1); $i++) {
			$rast += pow($obj1[$i]-$obj2[$i], 2);
		}
		return sqrt($rast);
	}

	public function klaster($count, $grey) {
		// При необходимости выполнить коррекцию яркости изображения (см. лаб. работу №1).
		$this->toGrayscale();
		$this->lineContrastCorrect(0, 255);
		$this->growFilter();
		$this->medianFilterGray(3);
		// Перевести цветное изображение в бинарное изображение (см. лаб. работу №1).
		// Реализовать пороговую бинаризацию изображения (см. лаб. работу №1).
		//$m = $this->meanValueGray();
		$this->thresholdGray($grey);
		// Выделить связные области на изображении (рекурсивный алгоритм).
		// Определить свойства объектов, вычислить систему признаков для объектов, представленных на изображении (площадь, периметр, компактность, вытянутость, статистические моменты). Вычисление всех признаков обязательно. Проанализировать, какие из признаков являются наиболее информативными.
		// Используя алгоритм k-medians, определить принадлежность объекта к одному из кластеров (классов). Реализация данного алгоритма обязательна.
		$this->labeling($count);
	}

	// =====================================================================
	// ============================= LAB 3 =================================
	// =====================================================================
	private function compare($first, $second) {
		if ($this->comparator > 0) {
			return $first >= $second;
		} else {
			return $first <= $second;
		}
	}

	private function gs_imageToGrayscaleArray() {
		$iterator = $this->img->getPixelIterator();
		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$color = $pixel->getColor();
				$this->data['matrix'][$col][$row] = $this->getBrightness($color);
			}
		}
	}

	private function gs_arrayToGrayscaleImage($data) {
		$iterator = $this->img->getPixelIterator();
		foreach ($iterator as $row => $pixels) {
			foreach ($pixels as $col => $pixel) {
				$y = $data[$col][$row];
				$pixel->setColor("rgb({$y},{$y},{$y})");
			}
			$iterator->syncIterator();
		}
	}

	private function generateNewton($count) {
		$newton = array();
		$newton[0] = array(1);
		for ($i = 1; $i < $count; $i++) {

			$newton[$i] = $newton[$i - 1];
			$newton[$i][$i] = 1;
			for ($j = 1; $j < $i; $j++) {

				$newton[$i][$j] = $newton[$i - 1][$j]+$newton[$i - 1][$j - 1];
			}
		}
		$this->newton = $newton;
	}

	private function generateGaussianArray() {
		$newton = $this->newton;
		$g = array();
		for ($i = 0; $i < sizeof($newton); $i++) {
			for ($j = 0; $j < sizeof($newton[$i]); $j++) {

				for ($k = 0; $k < sizeof($newton[$i]); $k++) {

					$g[$i][$j][$k] = $newton[$i][$k] * $newton[$i][$j];
				}
			}
		}

		$this->gaussianArray = $g;
	}

	private function generateGaussian($sigma) {
		$g = array();
		$r = ceil($sigma);
		for ($x = -$r; $x <= $r; $x++) {

			for ($y = -$r; $y <= $r; $y++) {
				$g[$x][$y] = 1 / (2 * pi() * $sigma * $sigma) * exp(-($x * $x + $y * $y) / (2 * $sigma * $sigma));
			}
		}
		return $g;
	}

	private function applyGaussian($target, $g, $sigma) {
		$new = array();
		$xMax = sizeof($target);
		$yMax = sizeof($target[0]);
		$r = ceil($sigma);
		for ($x = 0; $x < $xMax; $x++) {
			for ($y = 0; $y < $yMax; $y++) {
				$sum = 0;
				for ($i = -$r; $i <= $r; $i++) {
					if ($x + $i < 0 || $x + $i >= $xMax) {
						$xCur = $x - $i;
					} else {
						$xCur = $x + $i;
					}
					for ($j = -$r; $j <= $r; $j++) {
						if ($y + $j < 0 || $y + $j >= $yMax) {
							$yCur = $y - $j;
						} else {
							$yCur = $y + $j;
						}
						$sum += $g[$i][$j] * $target[$xCur][$yCur];
					}
				}
				$new[$x][$y] = $sum;
			}
		}
		return $new;
	}

	private function gs_filterGaussian($count) {

		$source = $this->data['matrix'];
		$target = array();
		$sigma = array();
		$min = exp(0.5);
		$max = exp(2.5);
		$dif = ($max - $min) / $count;

		$counter = 0;
		for ($i = $min; $i < $min+($dif * $count); $i += $dif) {
			$g = $this->generateGaussian($i);
			$tmp = $this->applyGaussian($source, $g, $i);
			array_push($target, $tmp);
			array_push($sigma, $i);
		}

		$this->data['gaussian'] = $target;
		$this->data['sigma'] = $sigma;
	}

	private function gs_findDifferences() {
		$g = $this->data['gaussian'];
		$new = array();
		$width = sizeof($g[0]);
		$height = sizeof($g[0][0]);
		for ($i = 1; $i < sizeof($g); $i++) {
			for ($x = 0; $x < $width; $x++) {
				for ($y = 0; $y < $height; $y++) {
					$res = $g[$i - 1][$x][$y]-$g[$i][$x][$y];
					$new[$i - 1][$x][$y] = $res > 0 ? $res : 0;
				}
			}
		}
		$this->data['dif'] = $new;
	}

	private function gs_findLocalMinMax() {
		$dif = $this->data['dif'];
		$sigma = $this->data['sigma'];
		$isExtr = array();

		$width = sizeof($dif[0]);
		$height = sizeof($dif[0][0]);
		for ($i = 1; $i < sizeof($dif) - 1; $i++) {

			$difPrev = $dif[$i - 1];
			$difCur = $dif[$i];
			$difNext = $dif[$i + 1];

			for ($x = 0; $x < $width; $x++) {
				for ($y = 0; $y < $height; $y++) {
					if ($x == 0 || $x == $width - 1 || $y == 0 || $y == $height - 1) {
						$isExtr[$i][$x][$y] = false;
						continue;
					}

					$yCur = $difCur[$x][$y];
					if (
						$yCur >= $difCur[$x - 1][$y - 1]
						 && $yCur >= $difCur[$x][$y - 1]
						 && $yCur >= $difCur[$x + 1][$y - 1]
						 && $yCur >= $difCur[$x - 1][$y]
						 && $yCur >= $difCur[$x + 1][$y]
						 && $yCur >= $difCur[$x - 1][$y + 1]
						 && $yCur >= $difCur[$x][$y + 1]
						 && $yCur >= $difCur[$x + 1][$y + 1]

						 && $yCur >= $difPrev[$x - 1][$y - 1]
						 && $yCur >= $difPrev[$x][$y - 1]
						 && $yCur >= $difPrev[$x + 1][$y - 1]
						 && $yCur >= $difPrev[$x - 1][$y]
						 && $yCur >= $difPrev[$x][$y]
						 && $yCur >= $difPrev[$x + 1][$y]
						 && $yCur >= $difPrev[$x - 1][$y + 1]
						 && $yCur >= $difPrev[$x][$y + 1]
						 && $yCur >= $difPrev[$x + 1][$y + 1]

						 && $yCur >= $difNext[$x - 1][$y - 1]
						 && $yCur >= $difNext[$x][$y - 1]
						 && $yCur >= $difNext[$x + 1][$y - 1]
						 && $yCur >= $difNext[$x - 1][$y]
						 && $yCur >= $difNext[$x][$y]
						 && $yCur >= $difNext[$x + 1][$y]
						 && $yCur >= $difNext[$x - 1][$y + 1]
						 && $yCur >= $difNext[$x][$y + 1]
						 && $yCur >= $difNext[$x + 1][$y + 1]
					) {
						$isExtr[$i][$x][$y] = true;
					} else {
						$isExtr[$i][$x][$y] = false;
					}
				}
			}
			//$this->debug($isExtr);
		}

		$extr = array();
		for ($i = 1; $i <= sizeof($isExtr); $i++) {
			//$sigmaCur = ceil(1.5 * $sigma[$i]);
			$sigmaCur = ceil($sigma[$i]);
			for ($x = 0; $x < $width; $x++) {
				for ($y = 0; $y < $height; $y++) {
					if (isset($isExtr[$i][$x][$y]) && $isExtr[$i][$x][$y]) {
						array_push($extr, array('x' => $x, 'y' => $y, 'sigma' => $sigmaCur, 'is' => true, 'br' => $dif[$i][$x][$y]));
					}
				}
			}
		}
		$this->data['extr'] = $extr;
	}

	private function gs_clearLocalMinMax() {
		//$this->debug($this->data['extr']);

		$extr = $this->data['extr'];
		for ($i = 0; $i < sizeof($extr); $i++) {

			$cur = $extr[$i];
			if ($cur['is'] == false) {
				continue;
			}
			for ($j = 0; $j < sizeof($extr); $j++) {
				$next = $extr[$j];

				if ($i == $j || $next['is'] == false) {
					continue;
				}
				if (
					abs($cur['x']-$next['x']) <= $cur['sigma']+$next['sigma']
					 && abs($cur['y']-$next['y']) <= $cur['sigma']+$next['sigma']
				) {
					if ($cur['br'] < $next['br']) {
						$extr[$i]['is'] = false;
						break;
					} else {
						$extr[$j]['is'] = false;

					}
				}
			}
		}

		//$this->debug($extr);

		$newExtr = array();
		for ($i = 0; $i < sizeof($extr); $i++) {
			if ($extr[$i]['is']) {
				array_push($newExtr, $extr[$i]);
			}
		}
		//$this->debug($newExtr);
		$this->data['extr'] = $newExtr;
	}

	private function gs_displayCircles() {
		$this->img = new Imagick($this->imagePath);
		$draw = new \ImagickDraw();

		$strokeColor = new \ImagickPixel("rgb(210,0,0)");
		$fillColor = new \ImagickPixel("rgba(0,0,0,0)");

		$draw->setStrokeColor($strokeColor);
		$draw->setFillColor($fillColor);

		$draw->setStrokeWidth(1);

		for ($i = 0; $i < sizeof($this->data['extr']); $i++) {
			$p = $this->data['extr'][$i];
			$draw->circle($p['x'], $p['y'], $p['x']+$p['sigma'] * 1.5, $p['y']);
		}
		$this->img->drawImage($draw);
	}

	public function gaussian($minMax) {
		if ($minMax < 0) {
			$this->comparator = -1;
		} else {
			$this->comparator = 1;
		}
		$this->data = array();

		$this->gs_imageToGrayscaleArray();

		$this->gs_filterGaussian(20);
		$this->gs_findDifferences();
		$this->gs_findLocalMinMax();
		$this->gs_clearLocalMinMax();

		$this->gs_displayCircles();

		//$this->gs_arrayToGrayscaleImage($this->data['dif'][0]);
	}
}
