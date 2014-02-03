<?

$dest = "sometext.txt.enc";
$file = fopen($dest, "wb");
//11fb, ed2b,0198,6de5
fwrite($file, chr(0x11));
fwrite($file, chr(0xfb));
fwrite($file, chr(0xed));
fwrite($file, chr(0x2b));
fwrite($file, chr(0x01));
fwrite($file, chr(0x98));
fwrite($file, chr(0x6d));
fwrite($file, chr(0xe5));
/*fwrite($file, chr(0));
fwrite($file, chr(4));
fwrite($file, chr(0));
fwrite($file, chr(5));
fwrite($file, chr(0));
fwrite($file, chr(6));
fwrite($file, chr(0));
fwrite($file, chr(7));
fwrite($file, chr(0));
fwrite($file, chr(8));*/

fclose($file);