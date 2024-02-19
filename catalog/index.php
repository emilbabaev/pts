<?
session_start();
$title = "Каталог";
$description = "";
$keywords = "";
$categoryParent = 0;
if (!isset($brand) && !isset($category) && !isset($prod)) {
    header("Location: /404/");
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/pn/bd.php";
if (isset($category)) {
    $search = "";
    if (!isset($uri_parts[1])) {
        $search = " and `parentId`=0 ";
    }
    $result = mysql_query("SELECT * FROM `category` WHERE `url`='" . $category . "' " . $search . "");
    $count = mysql_num_rows($result);
    if ($count > 0) {
        $catalog = mysql_fetch_array($result);
        $categoryParent = $catalog['parentId'];
        $title = $catalog['title'];
        $description = $catalog['description'];
        $keywords = $catalog['keywords'];
        $catalog_name = $catalog['name'];
        $id_category = $catalog['id'];
        $catalog_text = $catalog['text'];
        //if ($categoryParent != 0 || $id_category == 4 || $id_category == 5 || $id_category == 6) {
        $loadCatalog = true;
        //}
    } else {
        header("Location: /404/");
    }
}
if (isset($prod)) {
    $search = "";
    if (isset($_COOKIE['city'])) {
        $search = " and `id`=" . $_COOKIE['city'] . "";
    }
    $result = mysql_query("SELECT * FROM `city` WHERE 1 " . $search . " LIMIT 1");
    $count = mysql_num_rows($result);
    if ($count > 0) {
        $city = mysql_fetch_array($result);
    }
    if ($city['id'] == 1) {
        $table = "prod";
    } else if ($city['id'] == 2) {
        $table = "prod_vologda";
    }
    $result = mysql_query("SELECT `" . $table . "`.`id`, `" . $table . "`.`name`, `" . $table . "`.`text`, `" . $table . "`.`id_category`, `" . $table . "`.`img`, `" . $table . "`.`price`, `" . $table . "`.`new_price`, `" . $table . "`.`weight`, `" . $table . "`.`count_pallet`, `color`.`text` as `code_color`, `brand_strength`.`name` as `brand_strength_name`, `color`.`name` as `color_name`, `size`.`name` as `size_name`, `producer`.`name` as `producer_name`, `category`.`url`, `category`.`parentId`, `cat_parent`.`url` as `url_parent`, `cat_parent`.`name` as `name_parent`, `category`.`name` as `cat_name`
	FROM `" . $table . "`
	LEFT JOIN `category` 
	ON `category`.`id`=`" . $table . "`.`id_category`
	LEFT JOIN `category` as `cat_parent`
	ON `cat_parent`.`id`=`category`.`parentId`
	LEFT OUTER JOIN `color` 
	ON `color`.`id`=`" . $table . "`.`id_color`
	LEFT OUTER JOIN `size` 
	ON `size`.`id`=`" . $table . "`.`id_size`
	LEFT OUTER JOIN `producer` 
	ON `producer`.`id`=`" . $table . "`.`id_manufacturer`
	LEFT OUTER JOIN `brand_strength` 
	ON `brand_strength`.`id`=`" . $table . "`.`id_brand_strength`
	WHERE `" . $table . "`.`id`=" . $prod . "");

    $count = mysql_num_rows($result);
    if ($count > 0) {
        $catalog = mysql_fetch_array($result);
        $str_name = '';
        $str_name_end = '';
        if ($catalog['id_category'] == 61): $str_name = 'Клинкерная плитка ';
            $str_name_end = " " . $catalog['producer_name']; endif;
        if ($catalog['id_category'] == 62): $str_name = 'Тротуарный клинкерный кирпич ';
            $str_name_end = " " . $catalog['producer_name']; endif;
        $title = $catalog['name'];
        if (iconv_strlen($catalog['name'], "UTF-8") < 20) {
            $title .= " Череповец";
        }
        $description = $catalog['cat_name'] . " производитель " . $catalog['producer_name'] . ". Размер, мм " . $catalog['size_name'] . ". Вес, кг " . $catalog['weight'] . ". Марка прочности " . $catalog['brand_strength_name'] . ". Цена " . $catalog['price'] . " руб./шт, купить в Череповце.";
    } else {
        header("Location: /404/");
    }
}
if (isset($brand)) {
    $result = mysql_query("SELECT * FROM `producer` WHERE `producer`.`url`='" . $brand . "'");
    $count = mysql_num_rows($result);
    if ($count > 0) {
        $catalog = mysql_fetch_array($result);
        $title = $catalog['title'];
        $description = $catalog['description'];
        $keywords = $catalog['keywords'];
        $id_brand = $catalog['id'];
        $loadCatalog = true;
    } else {
        header("Location: /404/");
    }
}

include $_SERVER['DOCUMENT_ROOT'] . "/data/header.html";
?>
    <style>
        @media only screen and (max-width: 768px) {
            .catalog-list table td:nth-child(9), .catalog-list table th:nth-child(9) {
                display: none;
            }
        }
    </style>
<!--карточка товара-->
    <div class="container">
        <div class="row">
            <?
            if (isset($prod)) {
            ?>
            <style>
                .catalog-list table td:nth-child(1), .catalog-list table th:nth-child(1), .catalog-list table td:nth-child(2), .catalog-list table th:nth-child(2) {
                    display: none !important;
                }

                .catalog-list table td:nth-child(3), .catalog-list table th:nth-child(3), .catalog-list table td:nth-child(5), .catalog-list table th:nth-child(5), .catalog-list table td:nth-child(6), .catalog-list table th:nth-child(6) {
                    display: table-cell !important;
                }
            </style>
            <? if ($catalog['table'] == 1) { ?>
                <style>
                    .catalog-list table td:nth-child(3), .catalog-list table th:nth-child(3), .catalog-list table td:nth-child(4), .catalog-list table td:nth-child(6), .catalog-list table th:nth-child(6), .catalog-list table th:nth-child(4), .catalog-list table td:nth-child(7), .catalog-list table th:nth-child(7) {
                        display: none !important;
                    }
                </style>
            <? } ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 breadcrumbs">
                        <a href="/">Главная</a>
                        <? if ($catalog['parentId'] != 0) { ?>
                            <a href="/<?= $catalog['url_parent'] ?>"><?= $catalog['name_parent'] ?></a>
                            <a href="/<?= $catalog['url_parent'] ?>/<?= $catalog['url'] ?>"><?= $catalog['cat_name'] ?></a>
                        <? } else { ?>
                            <a href="/<?= $catalog['url'] ?>"><?= $catalog['cat_name'] ?></a>
                        <? } ?>
                        <span><?= $catalog['name'] ?></span>
                    </div>
                </div>
            </div>
            <?
            $price = "";
            if ($catalog['new_price'] != 0) {
                $price = '<span class="price-product-small">' . $catalog['new_price'] . '<img src="/img/svg/rubl-small-2.svg"></span>';
                $price .= '<span class="price-product-big">' . $catalog['price'] . '<img class="rubl-big-2" src="/img/svg/rubl-big-2.svg"><img class="arrow-bottom-price" src="/img/svg/arrow-bottom.svg"></span>';
            } else {
//                $price .= '<span class="price-product-big">' . $catalog['price'] . '<img class="rubl-big-2" src="/img/svg/rubl-big-2.svg"></span>';
//

                if ($catalog['price'] == 0)
                    $price .= '<span class="price-product-big" style="font-size: 25px; height: 37px;">Цена по запросу</span>';
                else
                    $price .= '<span class="price-product-big">'.$catalog['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"></span>';
            }
            ?>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="title-main"><?= $catalog['name'] ?></h2>
                    </div>

                    <div class="col-xs-12 card-product" id="prod-<?= $catalog['id'] ?>">
                        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4 photo-product">
                            <a href="/images/prod/<?= $catalog['img'] ?>" data-fancybox="group">
                                <img src="/images/prod/s<?= $catalog['img'] ?>">
                                <span data-toggle="tooltip-1" data-placement="" title="Приблизить"></span>
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-7 col-lg-5 features-product">
                            <p>Характеристики</p>
                            <table class="table">
                                <tr>
                                    <td>РАЗМЕР, ММ</td>
                                    <td><?= $catalog['size_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>КОЛ-ВО В ПОДДОНЕ</td>
                                    <td><?= $catalog['count_pallet'] ?></td>
                                </tr>
                                <tr>
                                    <td>ПРОИЗВОДИТЕЛЬ</td>
                                    <td><?= $catalog['producer_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>ВЕС, КГ</td>
                                    <td><?= $catalog['weight'] ?></td>
                                </tr>
                                <tr>
                                    <td>МАРКА</td>
                                    <td><?= $catalog['brand_strength_name'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-3 col-lg-offset-0 price-product">
                            <div class="price-product-info">
                                <?= $price ?>
                            </div>
                            <div class="count-product">
                                <span>Количество (шт.)<br>*если известно</span>
                                <input type="number" class="form-control" id="multiplier" placeholder="1000" value="1" min="1" max="1000000" onchange="reCount(this.value, <?= $catalog['price'] ?>)">
                            </div>
                            <div class="total-price">
                                <span class="total-price-text">Итого:</span>
                                <span class="total-price-info">
                                        <span id="newPrice"><?= $catalog["price"] ?></span>
                                        <img src="/img/svg/rubl-big-3.svg">
                                    </span>
                            </div>
                            <div class="btn-price-product">
                                <button class="btn animated-button btn-yellow" onclick="addToCart(<?= $catalog['id'] ?>, 0, document.getElementById('multiplier').value, this);"><span>В корзину</span></button>
                            </div>
                        </div>
                        <script>
                            function reCount(value, price) {
                                if (value <= 0) {
                                    $('#multiplier').val(1);
                                    reCount(1, price);
                                }
                                else if (value >= 1000000) {
                                    $('#multiplier').val(999999);
                                    reCount(999999, price);
                                }
                                else
                                    $('#newPrice').empty().append(value * price);
                            }
                        </script>
                    </div>

                    <div class="col-xs-12">
                        <div style="margin-bottom: 30px">
                            <?=$catalog["text"]?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?if (!isset($brand)) {include $_SERVER['DOCUMENT_ROOT']."/core/best.php";}?>

<? } else if (isset($categoryParent) && $categoryParent == 0 && !isset($brand)) { ?>
    <? if ($catalog['table'] == 1) { ?>
        <style>
            .catalog-list table td:nth-child(3), .catalog-list table th:nth-child(3), .catalog-list table td:nth-child(4), .catalog-list table th:nth-child(4), .catalog-list table td:nth-child(6), .catalog-list table th:nth-child(6), .catalog-list table td:nth-child(7), .catalog-list table th:nth-child(7) {
                display: none;
            }
        </style>
    <? } ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 breadcrumbs">
                <a href="/">Главная</a>
                <span><?= $catalog['name'] ?></span>
            </div>
        </div>
    </div>
    <!-- Плиточки -->
    <div class="col-xs-12 top-main-filter">
        <div class="row">
            <?
            $SQL = "SELECT * FROM `category` WHERE `parentId`=" . $catalog['id'] . " ORDER BY `id`";
            $result_category = mysql_query($SQL);
            $count = mysql_num_rows($result_category);
            if ($count > 0) { ?>
                <div class="col-xs-12 bottom-filter"><?
                $category = mysql_fetch_array($result_category);
                $i = 1;
                do { ?>
                    <a href="/<?= $catalog['url'] ?>/<?= $category['url'] ?>/" class="label">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-name"><?= $category['name'] ?></span>
                        <img src="/images/category/<?= $category['img'] ?>">
                    </a>
                    <? $i++;
                } while ($category = mysql_fetch_array($result_category));
                ?></div><?
            } ?>
        </div>
    </div>
    <!-- Каталог -->
    <? include $_SERVER['DOCUMENT_ROOT'] . "/core/catalog.php"; ?>

<? } else {
    $result = mysql_query("SELECT * FROM `category` WHERE `id`='" . $categoryParent . "'");
    $category_parent = mysql_fetch_array($result); ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 breadcrumbs">
                <a href="/">Главная</a>
                <?
                if (!isset($brand)) { ?>
                    <a href="/<?= $category_parent['url'] ?>/"><?= $category_parent['name'] ?></a>
                    <?
                } ?>
                <span><?= $catalog['name'] ?></span>
            </div>
        </div>
    </div>

    <?
    include $_SERVER['DOCUMENT_ROOT'] . "/core/catalog.php"; ?>
    <?
}
?>
    </div>
    </div>
    <script>

        window.onload = function () {
            load_Data(1);
        };
    </script>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/data/footer.html";
?>