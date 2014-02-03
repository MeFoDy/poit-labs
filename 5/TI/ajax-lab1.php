<?
$lang = $_POST['language'];
$file = file("declaration-$lang.txt");
$str = '';

for ($i = 0; $i < 10; $i++) {
	$r = rand(1, count($file));
	$str .= $file[$r];
}

$str = preg_replace("/\s/", " ", $str);
$str = preg_replace('/ +/',' ' , $str);
echo $str;