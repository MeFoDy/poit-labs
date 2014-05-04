<?php

require_once ('Huffman.php');

$huffman = new Huffman();
$string = $_REQUEST['string'];
$encodedString = $huffman->encode($string);
$decodedString = $huffman->decode($encodedString);

$output = Array(
	'original' 	=> $string,
	'encoded' 	=> $encodedString,
	'decoded' 	=> $decodedString,
	'orLength' 	=> strlen($string),
	'encLength' => strlen($encodedString),
	'percent'	=> strlen($encodedString) > 0 ? (100 - (100 * (strlen($encodedString) / strlen($string)))) : 0
	);

echo <<<EOF
<p><strong>Код Хаффмана:</strong><br>{$output['encoded']}</p>
<p><strong>Декодированное сообщение:</strong><br>{$output['decoded']}</p>
<p><strong>Длина оригинала:</strong><br>{$output['orLength']}</p>
<p><strong>Длина кода:</strong><br>{$output['encLength']}</p>
<p><strong>Процент сжатия:</strong><br>{$output['percent']}</p>
EOF;
