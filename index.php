<?
session_start();
$title = "Продажа кирпича в Череповце. Купить кирпич от 12 рублей. Тел. 8 (8202) 52-90-93 ";
$description = "Купите кирпич по низким ценам от 12 рублей за штуку. Также предлагаем купить смеси, цемент, клинкер и прочие строительные материалы. Доставка по Череповцу и области. Продажа кирпича оптом и в розницу. Высокое качество продукции. Тел. +7 (8202) 52-90-93";
$keywords = "продажа кирпича, купить кирпич, купить газобетон";
include $_SERVER['DOCUMENT_ROOT'] . "/pn/bd.php";
include $_SERVER['DOCUMENT_ROOT'] . "/data/header.html";
?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="slider-main owl-carousel owl-theme">
                    <?
                    $SQL = "SELECT * FROM `banner` WHERE `type`=0 " . $reg_id_ . "ORDER BY `date` desc";
                    //echo $SQL;
                    $result = mysql_query($SQL);
                    $count = mysql_num_rows($result);
                    for ($i = 0; $i < $count; ++$i) {
                        $id = mysql_result($result, $i, 'id');
                        $name = mysql_result($result, $i, 'name');
                        $img = mysql_result($result, $i, 'img');
                        $text = str_replace("\n", "<br>", mysql_result($result, $i, 'text'));
                        $url = mysql_result($result, $i, 'url');
                        $mutator = mysql_result($result, $i, 'mutator');
                        ?>
                        <div class="slider-bg" style="background: url(/images/banner/<? echo $img; ?>)">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-12 col-md-7 col-lg-6 slider-info">
                                        <h2><? echo $name; ?></h2>
                                        <p><? echo $text; ?></p>
                                        <?
                                        if ($url != "") { ?><a class="btn animated-button btn-yellow" href='<?
                                        echo $url; ?>' target="_blank" rel='nofollow'><span>Подробнее</span></a><?
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-12 col-sm-6 col-lg-4 title-block-products">
                    <h2>Кирпич</h2>
                    <p>Рядовой, печной, облицовочный</p>
                    <a href="/kirpich/" class="btn animated-button btn-gray"><span>Весь каталог</span></a>
                </div>

                <?
                $SQL = "SELECT * FROM prod WHERE id_category = 1 ORDER BY RAND() LIMIT 5";
                $result = mysql_query($SQL);
                $count = mysql_num_rows($result);
                if ($count > 0):
                    while ($item = mysql_fetch_assoc($result)):
                        $price = "";
                        if ($item['new_price'] != 0)
                        {
                            $price = '<p class="price-small">'.$item['new_price'].'<img src="/img/svg/rubl-small.svg"></p>';
                            $price .= '<p class="price-big">'.$item['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"><img class="arrow-bottom" src="/img/svg/arrow-bottom.svg"></p>';
                        }
                        else
                        {
//                            $price .= '<p class="price-big">'.$item['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"></p>';
                            if ($item['price'] == 0)
                                $price .= '<span class="price-big" style="font-size: 13px; height: 37px;">Цена по запросу</span>';
                            else
                                $price .= '<span class="price-big">'.$item['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"></span>';
                        }
                        ?>
                        <div class="col-xs-12 col-sm-6 col-lg-4 block-products">
                            <div class="block-products-info">
                                <a href="<?="/kirpich/prod/".$item["id"]."/"?>">
                                    <div class="text-center">
                                        <div style="background: url(<?='/images/prod/'.$item["img"]?>)" class="img-prod-catalog"></div>
                                    </div>
                                    <div class="block-products-text">
                                        <p><?=$item["name"]?></p>
                                    </div>
                                    <div class="block-products-price">
                                        <?=$price?>
                                    </div>
                                </a>
                                <div class="block-products-btn">
                                    <a href="<?="/kirpich/prod/".$item["id"]."/"?>" class="btn animated-button btn-gray-two"><span>Подробнее</span></a>
                                    <a href="javascript:addToCart(<?=$item["id"]?>, 0, 1, this);" class="btn animated-button btn-yellow"><span><img src="/img/svg/basket-gray.svg">В корзину</span></a>
                                </div>
                            </div>
                        </div>
                    <?
                    endwhile;
                endif;
                ?>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-12 col-sm-6 col-lg-4 title-block-products">
                    <h2>Жаропрочный бетон</h2>
                    <a href="/zharoprochnyy-beton/" class="btn animated-button btn-gray"><span>Весь каталог</span></a>
                </div>
                <?
                $SQL = "SELECT * FROM prod WHERE id_category = 80 ORDER BY RAND() LIMIT 5";
                $result = mysql_query($SQL);
                $count = mysql_num_rows($result);
                if ($count > 0):
                    while ($item = mysql_fetch_assoc($result)):
                        $price = "";
                        if ($item['new_price'] != 0)
                        {
                            $price = '<p class="price-small">'.$item['new_price'].'<img src="/img/svg/rubl-small.svg"></p>';
                            $price .= '<p class="price-big">'.$item['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"><img class="arrow-bottom" src="/img/svg/arrow-bottom.svg"></p>';
                        }
                        else
                        {
                            if ($item['price'] == 0)
                                $price .= '<span class="price-big" style="font-size: 13px; height: 37px;">Цена по запросу</span>';
                            else
                                $price .= '<span class="price-big">'.$item['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"></span>';
                        }
                        ?>
                        <div class="col-xs-12 col-sm-6 col-lg-4 block-products">
                            <div class="block-products-info">
                                <a href="<?="/izdeliya-iz-kirpicha/prod/".$item["id"]."/"?>">
                                    <div class="text-center">
                                        <div style="background: url(<?='/images/prod/'.$item["img"]?>)" class="img-prod-catalog"></div>
                                    </div>
                                    <div class="block-products-text">
                                        <p><?=$item["name"]?></p>
                                    </div>
                                    <div class="block-products-price">
                                        <?=$price?>
                                    </div>
                                </a>
                                <div class="block-products-btn">
                                    <a href="<?="/izdeliya-iz-kirpicha/prod/".$item["id"]."/"?>" class="btn animated-button btn-gray-two"><span>Подробнее</span></a>
                                    <a href="javascript:addToCart(<?=$item["id"]?>, 0, 1, this);" class="btn animated-button btn-yellow"><span><img src="/img/svg/basket-gray.svg">В корзину</span></a>
                                </div>
                            </div>
                        </div>
                        <?
                    endwhile;
                endif;
                ?>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-12 col-sm-6 col-lg-4 title-block-products">
                    <h2>Печное литьё</h2>
                    <a href="/pechnoe-lit-e/" class="btn animated-button btn-gray"><span>Весь каталог</span></a>
                </div>
                <?
                $SQL = "SELECT * FROM prod WHERE id_category = 81 ORDER BY RAND() LIMIT 5";
                $result = mysql_query($SQL);
                $count = mysql_num_rows($result);
                if ($count > 0):
                    while ($item = mysql_fetch_assoc($result)):
                        $price = "";
                        if ($item['new_price'] != 0)
                        {
                            $price = '<p class="price-small">'.$item['new_price'].'<img src="/img/svg/rubl-small.svg"></p>';
                            $price .= '<p class="price-big">'.$item['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"><img class="arrow-bottom" src="/img/svg/arrow-bottom.svg"></p>';
                        }
                        else
                        {
                            if ($item['price'] == 0)
                                $price .= '<span class="price-big" style="font-size: 13px; height: 37px;">Цена по запросу</span>';
                            else
                                $price .= '<span class="price-big">'.$item['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"></span>';
                        }
                        ?>
                        <div class="col-xs-12 col-sm-6 col-lg-4 block-products">
                            <div class="block-products-info">
                                <a href="<?="/klinker-trotuarnyy/prod/".$item["id"]."/"?>">
                                    <div class="text-center">
                                        <div style="background: url(<?='/images/prod/'.$item["img"]?>)" class="img-prod-catalog"></div>
                                    </div>
                                    <div class="block-products-text">
                                        <p><?=$item["name"]?></p>
                                    </div>
                                    <div class="block-products-price">
                                        <?=$price?>
                                    </div>
                                </a>
                                <div class="block-products-btn">
                                    <a href="<?="/klinker-trotuarnyy/prod/".$item["id"]."/"?>" class="btn animated-button btn-gray-two"><span>Подробнее</span></a>
                                    <a href="javascript:addToCart(<?=$item["id"]?>, 0, 1, this);" class="btn animated-button btn-yellow"><span><img src="/img/svg/basket-gray.svg">В корзину</span></a>
                                </div>
                            </div>
                        </div>
                        <?
                    endwhile;
                endif;
                ?>
            </div>
            
            
             <div class="col-xs-12">
                <div class="col-xs-12 col-sm-6 col-lg-4 title-block-products">
                    <h2>Сэндвич трубы и комплектующие</h2>
                    <a href="/sendvich-truby-i-komplektuyuschie/" class="btn animated-button btn-gray"><span>Весь каталог</span></a>
                </div>
                <?
                $SQL = "SELECT * FROM prod WHERE id_category = 95 ORDER BY RAND() LIMIT 5";
                $result = mysql_query($SQL);
                $count = mysql_num_rows($result);
                if ($count > 0):
                    while ($item = mysql_fetch_assoc($result)):
                        $price = "";
                        if ($item['new_price'] != 0)
                        {
                            $price = '<p class="price-small">'.$item['new_price'].'<img src="/img/svg/rubl-small.svg"></p>';
                            $price .= '<p class="price-big">'.$item['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"><img class="arrow-bottom" src="/img/svg/arrow-bottom.svg"></p>';
                        }
                        else
                        {
                            if ($item['price'] == 0)
                                $price .= '<span class="price-big" style="font-size: 13px; height: 37px;">Цена по запросу</span>';
                            else
                                $price .= '<span class="price-big">'.$item['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"></span>';
                        }
                        ?>
                        <div class="col-xs-12 col-sm-6 col-lg-4 block-products">
                            <div class="block-products-info">
                                <a href="<?="sendvich-truby-i-komplektuyuschie/prod/".$item["id"]."/"?>">
                                    <div class="text-center">
                                        <div style="background: url(<?='/images/prod/'.$item["img"]?>)" class="img-prod-catalog"></div>
                                    </div>
                                    <div class="block-products-text">
                                        <p><?=$item["name"]?></p>
                                    </div>
                                    <div class="block-products-price">
                                        <?=$price?>
                                    </div>
                                </a>
                                <div class="block-products-btn">
                                    <a href="<?="sendvich-truby-i-komplektuyuschie/prod/".$item["id"]."/"?>" class="btn animated-button btn-gray-two"><span>Подробнее</span></a>
                                    <a href="javascript:addToCart(<?=$item["id"]?>, 0, 1, this);" class="btn animated-button btn-yellow"><span><img src="/img/svg/basket-gray.svg">В корзину</span></a>
                                </div>
                            </div>
                        </div>
                        <?
                    endwhile;
                endif;
                ?>
            </div>

        </div>
    </div>

    <div class="container-fluid bg-gray-main">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 about">
                        <div class="col-xs-12 col-md-8 about-info">
                            <h2>О компании</h2>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 icon-about-info">
                                    <span style="background: url('/img/svg/about-icon1.svg')"></span>
                                    <p>Кирпич всегда<br>в наличии на складе</p>
                                </div>
                                <div class="col-xs-12 col-sm-4 icon-about-info">
                                    <span style="background: url('/img/svg/about-icon2.svg')"></span>
                                    <p>Продажа<br>от одной штуки</p>
                                </div>
                                <div class="col-xs-12 col-sm-4 icon-about-info">
                                    <span style="background: url('/img/svg/about-icon3.svg')"></span>
                                    <p>Минимальное время выписки документов<br>и отгрузки</p>
                                </div>
                                <div class="col-xs-12 col-sm-4 icon-about-info">
                                    <span style="background: url('/img/svg/about-icon4.svg')"></span>
                                    <p>Бесплатное<br>хранение</p>
                                </div>
                                <div class="col-xs-12 col-sm-4 icon-about-info">
                                    <span style="background: url('/img/svg/about-icon5.svg')"></span>
                                    <p>Бесплатная<br>упаковка</p>
                                </div>
                                <div class="col-xs-12 col-sm-4 icon-about-info">
                                    <span style="background: url('/img/svg/about-icon6.svg')"></span>
                                    <p>Помощь в предоставлении<br>транспортных услуг</p>
                                </div>
                                <div class="col-xs-12 text-about-info">
<!--                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>-->
<!--                                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4 news-bg">
                            <h2>Новости</h2>
                            <div class="row">
                                <? $SQL = "SELECT * FROM `news` ORDER BY `date` DESC";
                                $result = mysql_query($SQL);
                                $count_base = mysql_num_rows($result);
                                $count_page = ceil($count_base / 10);
                                $SQL = "SELECT * FROM `news` ORDER BY `date` DESC LIMIT 0, 5";
                                $result = mysql_query($SQL);
                                $count = mysql_num_rows($result);
                                if ($count > 0) {
                                    ?><?
                                    $catalog = mysql_fetch_array($result);
                                    do { ?>
                                        <div class="col-xs-12 col-sm-6 col-md-12 news-min-element">
                                            <p><?= date_format(date_create($catalog['date']), 'd.m.Y') ?></p>
                                            <a href="/news/?id=<?= $catalog['id'] ?>"><?= $catalog['about'] ?></a>
                                        </div>
                                    <? } while ($catalog = mysql_fetch_array($result));
                                    ?><?
                                } ?>
                            </div>
                            <a href="/news/" class="btn animated-button btn-gray"><span>Все новости</span></a>
                        </div>
                    </div>

                    <? include $_SERVER['DOCUMENT_ROOT'] . "/core/producer.php"; ?>
                </div>
            </div>
        </div>
    </div>

<?
include $_SERVER['DOCUMENT_ROOT'] . "/data/footer.html";
?>