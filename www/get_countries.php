<?php
$url = 'https://api.hh.ru/areas';
$data = file_get_contents($url);
header('Content-Type: application/json');
echo $data;
?>