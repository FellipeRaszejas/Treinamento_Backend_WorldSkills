<?php

$hex = bin2hex(random_bytes(3));

var_dump($hex);
var_dump(hex2bin($hex));
?>