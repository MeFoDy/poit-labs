<?php 
require_once ('HuffmanDictionnary.php');

class Huffman
{
	private	$dictionnary = null;

	public function	setDictionnary(HuffmanDictionnary $dictionnary)
	{
		$this->dictionnary = $dictionnary;
	}

	public function	getDictionnary()
	{
		return $this->dictionnary;
	}

	public function	unsetDictionnary()
	{
		$this->dictionnary = null;
	}

	public function	encode($data)
	{
		if (!is_string($data))
			$data = serialize($data);
		if (empty($data))
			return '';
		if ($this->dictionnary === null)
			$this->generateDictionnary($data);
		$binaryString = '';
		for ($i = 0; isset($data[$i]); ++$i)
			$binaryString .= $this->dictionnary->get($data[$i]);
		$splittedBinaryString = str_split('1'.$binaryString.'1', 8);
		$binaryString = '';
		foreach ($splittedBinaryString as $i => $c)
		{
			while (strlen($c) < 8)
				$c .= '0';
			$binaryString .= chr(bindec($c));
		}
		return $binaryString;
	}

	public function	decode($data)
	{
		if (!is_string($data))
			throw new Exception('The data must be a string.');
		if (empty($data))
			return '';
		if ($this->dictionnary === null)
			throw new Exception('The dictionnary has not been set.');
		$binaryString = '';
		$dataLenght = strlen($data);
		$uncompressedData = '';
		for ($i = 0; $i < $dataLenght; ++$i)
		{
			$decbin = decbin(ord($data[$i]));
			while (strlen($decbin) < 8)
				$decbin = '0'.$decbin;
			if (!$i)
				$decbin = substr($decbin, strpos($decbin, '1') + 1);
			if ($i + 1 == $dataLenght)
				$decbin = substr($decbin, 0, strrpos($decbin, '1'));
			$binaryString .= $decbin;
			while (($c = $this->dictionnary->getEntry($binaryString)) !== null)
				$uncompressedData .= $c;
		}
		return $uncompressedData;
	}

	public function	generateDictionnary($data)
	{
		if (!is_string($data))
			$data = serialize($data);
		$occurences = array();
		while (isset($data[0]))
		{
			$occurences[] = array(substr_count($data, $data[0]), $data[0]);
			$data = str_replace($data[0], '', $data);
		}
		sort($occurences);
		while (count($occurences) > 1)
		{
			$row1 = array_shift($occurences);
			$row2 = array_shift($occurences);
			$occurences[] = array($row1[0] + $row2[0], array($row1, $row2));
			sort($occurences);
		}
		$this->dictionnary = new HuffmanDictionnary();
		$this->fillDictionnary(is_array($occurences[0][1]) ? $occurences[0][1] : $occurences);
	}

	private function fillDictionnary($data, $value = '')
	{
		if (!is_array($data[0][1]))
			$this->dictionnary->set($data[0][1], $value.'0');
		else
			$this->fillDictionnary($data[0][1], $value.'0');
		if (isset($data[1]))
		{
			if (!is_array($data[1][1]))
				$this->dictionnary->set($data[1][1], $value.'1');
			else
				$this->fillDictionnary($data[1][1], $value.'1');
		}
	}
}
?>