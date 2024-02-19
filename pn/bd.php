<?php
$dbms = 'mysqli';
$dbhost = 'localhost';
$dbport = '';
$dbname = 'u0424317_default';
$dbuser = 'root';
$dbpasswd = '';
@define('PHPBB_INSTALLED', true);
include $_SERVER['DOCUMENT_ROOT']."/pn/function_bd.php";
$link = db_connect($dbhost,$dbuser,$dbpasswd, $dbname) or die (db_error($link));
mysqli_set_charset($link, 'utf8');
?>
