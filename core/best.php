<?
$search = "";
if (isset($id_category)) {
    $search = " and (`category`.`parentId`=" . $id_category . " or `category`.`id`=" . $id_category . ")";
}
$result = mysql_query("SELECT `" . $table . "`.`id`, `" . $table . "`.`name`, `" . $table . "`.`status`, `" . $table . "`.`new`, `" . $table . "`.`special`, `" . $table . "`.`new_price`, `" . $table . "`.`img`, `" . $table . "`.`price`, `category`.`url`, `producer`.`name` as `name_manufacturer`, `category`.`parentId`, `cat_parent`.`url` as `url_parent` FROM `" . $table . "`
LEFT JOIN `category` 
ON `category`.`id`=`" . $table . "`.`id_category`	
LEFT JOIN `category` as `cat_parent`
ON `cat_parent`.`id`=`category`.`parentId`
LEFT OUTER JOIN `producer` 
ON `producer`.`id`=`" . $table . "`.`id_manufacturer`
WHERE `" . $table . "`.`status`=1 " . $search . " ORDER BY `" . $table . "`.`id` asc LIMIT 0, 10");

$count = mysql_num_rows($result);
if ($count > 0) {
$catalog = mysql_fetch_array($result);
?>

<?
$price = "";
if ($catalog['new_price'] != 0) {
    $price = '<p class="price-small">' . $catalog['new_price'] . '<img src="/img/svg/rubl-small.svg"></p>';
    $price .= '<p class="price-big">' . $catalog['price'] . '<img class="rubl-big" src="/img/svg/rubl-big.svg"><img class="arrow-bottom" src="/img/svg/arrow-bottom.svg"></p>';
} else {
    $price .= '<p class="price-big">' . $catalog['price'] . '<img class="rubl-big" src="/img/svg/rubl-big.svg"></p>';
}
?>

<div class="container-fluid bg-gray-slider">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-12">
                        <h2>Вам также может пригодиться</h2>
                    </div>

                    <div class="col-xs-12">
                        <div class="additionally-slider owl-carousel owl-theme"><?
                            do {
                                $url = "";
                                if ($catalog['parentId'] == 0) {
                                    $url = "/" . $catalog['url'] . "/prod/" . $catalog["id"] . "/";
                                } else {
                                    $url = "/" . $catalog['url_parent'] . "/" . $catalog['url'] . "/prod/" . $catalog["id"] . "/";
                                } ?>

                                <div id="item-<?= $catalog["id"] ?>">
                                    <div class="col-xs-12 main-block-products">
                                        <div class="main-block-products-info">
                                            <a href="<?= $url ?>">
                                                <div class="text-center">
                                                    <div style="background: url(/images/prod/s<?= $catalog['img'] ?>)" class="img-prod-catalog"></div>
                                                </div>
                                                <div class="main-block-products-text">
                                                    <p><? if (mb_strlen($catalog["name"], "UTF-8") > 80) {
                                                            echo mb_substr($catalog["name"], 0, 80, "UTF-8") . "...";
                                                        } else {
                                                            echo $catalog["name"];
                                                        } ?> <span class="hidden"><?= $catalog["name_manufacturer"] ?></span></p>
                                                </div>
                                                <div class="main-block-products-price">
                                                    <?= $price ?>
                                                </div>
                                            </a>
                                            <div class="main-block-products-btn">
                                                <a href="<?= $url ?>" class="btn animated-button btn-gray-two"><span>Подробнее</span></a>
                                                <button class="btn animated-button btn-yellow" onclick="addToCart(<?= $catalog['id'] ?>, 0, 1, this);"><span><img src="/img/svg/basket-gray.svg">В корзину</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <? } while ($catalog = mysql_fetch_array($result));
                            ?></div><?
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
