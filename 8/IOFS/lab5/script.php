<?php

function lengthcmp($a, $b) {
	if (strlen($a) == strlen($b)) {
        return 0;
    }
    return (strlen($a) > strlen($b)) ? -1 : 1;
}

if ($_REQUEST['words'] == '') exit;

$words = explode(',', $_REQUEST['words']);
foreach ($words as $key => $value) {
	$words[$key] = trim($value);
}
usort($words, 'lengthcmp');

$rules = Array();
$start = Array();
$end = Array();
foreach ($words as $i => $term) {
	array_push($start, $term[0]);
	array_push($end, $term[strlen($term) - 1]);
	for ($j = 0; $j < strlen($term) - 1; $j++) {
		if (!isset($rules["{$term[$j]}"]))
			$rules["{$term[$j]}"] = Array();
		array_push($rules["{$term[$j]}"], $term[$j+1]);
	}
	if (!isset($rules[$term[strlen($term) - 1]]))
		$rules[$term[strlen($term) - 1]] = Array();
}

foreach ($rules as $key => $value) {
	$rules[$key] = array_unique($value);
}
$start = array_unique($start);
$end = array_unique($end);

$output = Array();
for ($i=0; $i<10; $i++) {
	$output[$i] = '';
	$current = $start[array_rand($start)];
	$output[$i] .= $current;
	while (!is_over($current) || strlen($output[$i]) == 1) {
		$current = $rules[$current][array_rand($rules[$current])];
		$output[$i] .= $current;
	}
}

function is_over($current) {
	global $end, $rules;
	if (in_array($current, $end)) {
		if (rand(0, 10) < 2 || count($rules[$current]) == 0) 
			return true;
	}
	return false;
}

foreach ($output as $value) {
	echo "<p>$value</p>";
}