<?php
$Existe = 'Desafios Iniciais PHP.txt'; // This is the file that already exists
$link = 'uploads';
symlink($Existe, $link);

echo readlink($link);
?>