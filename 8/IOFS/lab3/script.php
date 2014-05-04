<?php

// ============================================
// ###    CLASSES   ###########################
// ============================================

class Timer {

   var $start     = 0;
   var $stop      = 0;
   var $elapsed   = 0;

   # Constructor
   function Timer( $start = true ) {
      if ( $start )
         $this->start();
   }

   # Start counting time
   function start() {
      $this->start = $this->_gettime();
   }

   # Stop counting time
   function stop() {
      $this->stop    = $this->_gettime();
      $this->elapsed = $this->_compute();
   }

   # Get Elapsed Time
   function elapsed() {
      if ( !$this->elapsed )
         $this->stop();

      return $this->elapsed;
   }

   function reset() {
      $this->start   = 0;
      $this->stop    = 0;
      $this->elapsed = 0;
   }

   #### PRIVATE METHODS ####

   # Get Current Time
   function _gettime() {
      $mtime = microtime();
      $mtime = explode( " ", $mtime );
      return $mtime[1] + $mtime[0];
   }

   # Compute elapsed time
   function _compute() {
      return $this->stop - $this->start;
   }
}

interface IData {
	public function insert($key);
	public function remove($key);
	public function search($key);
}

class PlainData implements IData {
	private $data = Array();
	private $length;

	function PlainData( $length = 1000 ) {
		$this->length = $length;
	}

	public function search($key) {
		foreach ($this->data as $value) {
			if ($value == $key) {
				return true;
			}
		}
		return false;
	}

	public function insert($key) {
		array_push($this->data, $key);
	}

	public function remove($key) {
		foreach ($this->data as $k => $v) {
			if ($v == $key) {
				unset($this->data[$k]);
				return true;
			}
		}
		return false;
	}

	public function generate() {
		$this->data = Array();
		$numbers = range(0, $this->length);
		shuffle($numbers);
		$this->data = $numbers;
	}
}

class HashData implements IData {
	private $data = Array();
	private $length;
	private $delimeter = 1009;

	function HashData( $length = 1000 ) {
		$this->length = $length;
	}

	public function search($key) {
		$h = $this->h($key);
		foreach ($this->data[$h] as $value) {
			if ($value == $key)
				return true;
		}
		return false;
	}

	public function insert($key) {
		if (!$this->search($key)) {
			array_push($this->data[ $this->h($key) ], $key);
			return true;
		}
		return false;
	}

	public function remove($key) {
		$h = $this->h($key);
		foreach ($this->data[$h] as $k => $value) {
			if ($value == $key) {
				unset($this->data[$h][$k]);
				return true;
			}
		}
		return false;
	}

	public function generate() {
		for ($i = 0; $i < $this->delimeter; $i++) {
			$this->data[$i] = Array();
		}
		$numbers = range(0, $this->length);
		shuffle($numbers);
		foreach ($numbers as $value) {
			$this->insert($value);
		}
	}

	private function h( $input ) {
		return $input % $this->delimeter;
	}
}

require('btree.php');
class BTreeData implements IData {
	private $btree;
	private $length;

	function BTreeData( $length = 1000 ) {
		$this->length = $length;
		$handle = fopen ('my.tree', 'w+');
		fclose($handle);
		$this->btree = btree::open('my.tree');
	}

	public function search($key) {
		if ($this->btree->get($key))
			return true;
		return false;
	}

	public function insert($key) {
		if ($this->btree->set($key, $key)) 
			return true;
		return false;
	}

	public function remove($key) {
		$this->btree->set($key, NULL);
	}

	public function generate() {
		$numbers = range(0, $this->length);
		shuffle($numbers);
		foreach ($numbers as $value) {
			$this->btree->set($value, $value);
		}
	}
}

// ============================================
// ###    TEST   ##############################
// ============================================

// Returns elapsed time for $obj->$func execution
function test( $obj, $func ) {
	global $count;
	$timer = new Timer();
	$timer->start();
	for ($i=0; $i < $count; $i++) { 
		$obj->$func(rand(0, $count * 10));
	}
	return round($timer->elapsed(), 6);
}

$count = 10000;
$output = Array();

// PLAIN DATA
$plainData = new PlainData();
$plainData->generate();
array_push($output, Array(
	'id' => 'bos-insert', 
	'value' => test($plainData, 'insert')
	));
array_push($output, Array(
	'id' => 'bos-search', 
	'value' => test($plainData, 'search')
	));
array_push($output, Array(
	'id' => 'bos-delete', 
	'value' => test($plainData, 'remove')
	));

// HASHED DATA
$hashData = new HashData();
$hashData->generate();
array_push($output, Array(
	'id' => 'hash-insert', 
	'value' => test($hashData, 'insert')
	));
array_push($output, Array(
	'id' => 'hash-search', 
	'value' => test($hashData, 'search')
	));
array_push($output, Array(
	'id' => 'hash-delete', 
	'value' => test($hashData, 'remove')
	));

// B-TREE DATA
$treeData = new BTreeData();
$treeData->generate();
array_push($output, Array(
	'id' => 'b-insert', 
	'value' => round(test($treeData, 'insert') / 30, 6)
	));
array_push($output, Array(
	'id' => 'b-search', 
	'value' => round(test($treeData, 'search') / 30, 6)
	));
array_push($output, Array(
	'id' => 'b-delete', 
	'value' => round(test($treeData, 'remove') / 30, 6)
	));

echo json_encode($output);
