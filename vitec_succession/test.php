<?php
$content = "some text here";
$fp = fopen("/var/www/html/crontest1.txt","wb");
fwrite($fp,$content);
fclose($fp); 
?>