<?
if (isset($_POST['id']))
{
    $id=$_POST['id'];

    include $_SERVER['DOCUMENT_ROOT'] . "/pn/bd.php";
    if (isset($number)) {
        $page = $number - 1;
    } else {
        $page = 0;
    }
    $count_data = $page * 10;
    $SQL = "SELECT * FROM `news`";
    $result = mysql_query($SQL);
    $count_base = mysql_num_rows($result);
    $count_page = ceil($count_base / 10);

    $result = mysql_query("SELECT * FROM `news` WHERE `id`=".$id);
    $count = mysql_num_rows($result);
    if ($count > 0) {
        $catalog = mysql_fetch_array($result);
        do { ?>

            <?if ($catalog['img'] != "") {?><img class="img-news" src="/images/news/s<?=$catalog['img']?>" alt="<?=$catalog['name']?>"><?}?>
            <p class="date-news"><?= date_format(date_create($catalog['date']), 'd/m/Y') ?></p>
            <h2 class="title-news"><?= $catalog['about'] ?></h2>
            <p><?=$catalog['text']?></p>

        <? } while ($catalog = mysql_fetch_array($result));
    }
}
?>