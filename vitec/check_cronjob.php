<?php

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <no-reply@nytthem.se>' . "\r\n";
mail('php.freak6@gmail.com','Error Alarm',$mail_content,$headers);