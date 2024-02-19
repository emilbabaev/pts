<?
    $dbms = 'mysqli';
    $dbhost = 'localhost';
    $dbport = '';
    //$dbname = 'kirpichnyi-dvorik';
    //$dbuser = 'root';
    //$dbpasswd = '';
    $dbname = 'test1';
    $dbuser = 'test';
    $dbpasswd = 'wCwQkKCA';
    @define('PHPBB_INSTALLED', true);
    include $_SERVER['DOCUMENT_ROOT']."/pn/function_bd.php";
    db_connect($dbhost,$dbuser,$dbpasswd) or die (db_error());
    db_select_db($dbname) or die (db_error());
    mysql_set_charset('utf8');
?>