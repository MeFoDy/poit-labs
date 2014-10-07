<?php

class Fksistagram {

	private $imagePath;
	private $img;
	private $data;

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
		$g = ($y - $this->data['fmin']) / $params['deltaF'] * $params['deltaG']+$params['gmin'];
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
			$iterator->syncIterator();
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
			$iterator->syncIterator();
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

}
