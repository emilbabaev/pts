<?
session_start();
$title = "Лента новостей компании «Кирпич на Гоголя 51»";
$description = "Новости компании «Кирпич на Гоголя 51», последняя свежая информация о новых поступления продукции и товара.";
$keywords = "";
include $_SERVER['DOCUMENT_ROOT'] . "/pn/bd.php";
if (isset($param)) {
    $result = mysql_query("SELECT * FROM `news` WHERE `url`='" . $param . "'");
    $count = mysql_num_rows($result);
    if ($count > 0) {
        $catalog = mysql_fetch_array($result);
        $id_news = $catalog['id'];
        $title = $catalog['name'];
    } else {
        header("Location: /404/");
    }
}
include $_SERVER['DOCUMENT_ROOT'] . "/data/header.html";
//if (!isset($param)) {
?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 breadcrumbs">
                <a href="/">Главная</a><span>Новости</span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="title-main">Новости</h2>
            </div>

            <div class="col-xs-12 col-md-5 col-lg-4 block-slider-news" id="sidebar">
                <div class="slider-news">
                    <?
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

                    $result = mysql_query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT " . $count_data . ", 10");
                    $count = mysql_num_rows($result);
                    if ($count > 0) {
                        $catalog = mysql_fetch_array($result);
                        do { ?>
                            <div id="news-<?= $catalog['id'] ?>">
                                <a href="javascript:load_news(<?= $catalog['id'] ?>)" class="block-news">
                                    <p><?= date_format(date_create($catalog['date']), 'd/m/Y') ?></p>
                                    <span><?= $catalog['about'] ?></span>
                                </a>
                            </div>
                        <? } while ($catalog = mysql_fetch_array($result));
                    }
                    ?>
                </div>
                <span class="arrow-slick-prev">
                    <img src="/img/svg/arrow-news-top.svg">
                </span>
                <span class="arrow-slick-next">
                    <img src="/img/svg/arrow-news-bottom.svg">
                </span>
            </div>

            <div class="col-xs-12 col-md-7 col-lg-8 block-text-news" id="news_detail">

            </div>



        </div>
    </div>

    <script>
        <?if (isset($param)) {?>
        location.href = "#news-<?=$id_news?>";
        <?}?>
    </script>

<?
include $_SERVER['DOCUMENT_ROOT'] . "/data/footer.html";
?>

<? if (isset($_GET["id"]) && $_GET["id"] != 0): ?>
    <script>
        jQuery(document).ready(function () {
            $("#news-"+<?=$_GET["id"]?>).find(".block-news").addClass("active");
            load_news(<?=$_GET["id"]?>);
        });
    </script>
<? endif; ?>
