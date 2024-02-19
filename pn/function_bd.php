<?php
function db_connect($host, $user, $pass, $dbname) //create connection
{
    $r = mysqli_connect($host, $user, $pass, $dbname);
    if (!$r) {
        die('Не удалось подключиться: ' . mysqli_error($r));
    }
    if(preg_match('/^5\./', mysqli_get_server_info($r))) {
        db_query($r, 'SET SESSION sql_mode=0');
    }
    return $r;
}

function db_query($link, $s) //database query
{
    return mysqli_query($link, $s);
}

function db_fetch_row($q) //row fetching
{
    return mysqli_fetch_row($q);
}

function db_insert_id($link)
{
    return mysqli_insert_id($link);
}

function db_error($link) //database error message
{
    return mysqli_error($link);
}
?>
