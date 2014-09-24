<?php

class Fksistagram {
	
	private $imagePath;
	private $img;
	private $data;

	public function __construct( $path ) {
		$this->imagePath = getcwd() . '/images/lenna.png';
		if (file_exists($path)) {
		    $this->imagePath = $path;
		}
		$this->img = new Imagick( $this->imagePath );
		$this->data = array();
	}

	private function iterate( $method, $params ) {
		$iterator = $this->img->getPixelIterator();
		foreach ( $iterator as $row => $pixels ) {
			foreach ( $pixels as $col => $pixel ) {
				$this->$method( $pixel, $params );
			}
			$iterator->syncIterator();
		}
	}

	public function out() {
		header('Content-type: ' . $this->img->getFormat());
		echo $this->img->getimageblob();
	}
	// ====== ПОЭЛЕМЕНТНАЯ ОБРАБОТКА ИЗОБРАЖЕНИЙ ======
	// ------ Гистограмма
	private function hist_prepare( $pixel ) {
		$color = $pixel->getColor();
	    $r = $color['r'];
	    $g = $color['g'];
	    $b = $color['b'];
	    $y = 0.3 * $r + 0.59 * $g + 0.11 * $b;
	    $this->data[$y]['y']++;
	    $this->data[$r]['r']++;
	    $this->data[$g]['g']++;
	    $this->data[$b]['b']++;
	}
	public function histogramm() {
		for ($i=0; $i < 256; $i++) { 
			$this->data[$i] = array('r'=>0, 'g'=>0, 'b'=>0, 'y'=>0);
		}
		$this->iterate( 'hist_prepare', array() );
		$maxPixelCount = 0;
		foreach ($this->data as $k => $v) {
			$maxPixelCount = max($maxPixelCount, $v['r'], $v['g'], $v['b'], $v['y']);
		}
		$this->img->newImage(256, 256, new ImagickPixel('white'));
		$this->img->setImageFormat('png');
		$draw = new ImagickDraw();
		for ($i=1; $i < 257; $i++) {
			$draw->setStrokeColor( '#ff0000' );
			$draw->line( $i, 256, $i, 256 - $this->data[$i-1]['r'] / $maxPixelCount * 256 );
			$draw->setStrokeColor( '#00ff00' );
			$draw->line( $i, 256, $i, 256 - $this->data[$i-1]['g'] / $maxPixelCount * 256 );
			$draw->setStrokeColor( '#0000ff' );
			$draw->line( $i, 256, $i, 256 - $this->data[$i-1]['b'] / $maxPixelCount * 256 );
			$draw->setStrokeColor( '#aaaaaa' );
			$draw->line( $i, 256, $i, 256 - $this->data[$i-1]['y'] / $maxPixelCount * 256 );
		}
		$this->img->drawImage( $draw );
	}
	
	// ------ Гамма-коррекция
	private function gammaCorrection( $pixel, $params ) {
		$color = $pixel->getColor();
		$br = array('r' => $color['r'], 
							'g' => $color['g'], 
							'b' => $color['b'], 
							'y' => 0.3 * $color['r'] + 0.59 * $color['g'] + 0.11 * $color['b']);
		$c = $params['c'];
		$q = $params['q'];
		$br['r'] = pow( $br['r'], $q ) * $c;
		$br['g'] = pow( $br['g'], $q ) * $c;
		$br['b'] = pow( $br['b'], $q ) * $c;
		$pixel->setColor("rgb({$br['r']},{$br['g']},{$br['b']})");
		return $br;
	}
	public function gammaCorrect($q, $c) {
		$this->iterate( 'gammaCorrection', array('q' => $q, 'c' => $c) );
	}

	// ------ Линейное контрастирование
	private function lineContrastCorrectionStep1( $pixel, $params ) {
		$color = $pixel->getColor();
		$br = array('r' => $color['r'], 
							'g' => $color['g'], 
							'b' => $color['b'], 
							'y' => 0.3 * $color['r'] + 0.59 * $color['g'] + 0.11 * $color['b']);
		$c = $params['c'];
		$q = $params['q'];
		$br['r'] = pow( $br['r'], $q ) * $c;
		$br['g'] = pow( $br['g'], $q ) * $c;
		$br['b'] = pow( $br['b'], $q ) * $c;
		return $br;
	}
	public function lineContrastCorrect($gmin, $gmax) {
		$this->iterate( 'lineContrastCorrectionStep1', array('q' => $q, 'c' => $c) );
	}

}