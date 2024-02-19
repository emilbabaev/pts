<?
//Header("Content-Type: text/html;charset=UTF-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/pn/bd.php";
if (isset($_COOKIE["prod"])) {
    $myProd = explode('#', $_COOKIE["prod"]);
    $prod = "";
    $sum = 0;
    $generalCount = 0;
    if (count($myProd) > 0 && $myProd[0] != "") { ?>

        <div class="col-xs-12 table-basket">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>ФОТО</td>
                        <td>НАИМЕНОВАНИЕ</td>
                        <td>ПРОИЗВОДИТЕЛЬ</td>
                        <td>ЦЕНА</td>
                        <td>КОЛИЧЕСТВО</td>
                        <td>СУММА</td>
                        <td></td>
                    </tr>
                    <?
                    for ($i = 0; $i < count($myProd); ++$i) {
                        $temp = explode(',', $myProd[$i]);
                        $myId = $temp[0];
                        $myColor = $temp[1];
                        $myCount = $temp[2];
                        $myStatus = $temp[3];
                        if ($myStatus == 0) {
                            $result = mysql_query("SELECT `" . $table . "`.`id`, `" . $table . "`.`name`, `" . $table . "`.`img`, `" . $table . "`.`price`, `" . $table . "`.`weight`, `" . $table . "`.`count_pallet`, `color`.`text` as `code_color`, `brand_strength`.`name` as `brand_strength_name`, `color`.`name` as `color_name`, `size`.`name` as `size_name`, `producer`.`name` as `producer_name`, `category`.`url` as `category_url`   FROM `" . $table . "`
							LEFT JOIN `category` 
							ON `category`.`id`=`" . $table . "`.`id_category`
							LEFT OUTER JOIN `color` 
							ON `color`.`id`=`" . $table . "`.`id_color`
							LEFT OUTER JOIN `size` 
							ON `size`.`id`=`" . $table . "`.`id_size`
							LEFT OUTER JOIN `producer` 
							ON `producer`.`id`=`" . $table . "`.`id_manufacturer`
							LEFT OUTER JOIN `brand_strength` 
							ON `brand_strength`.`id`=`" . $table . "`.`id_brand_strength`
							WHERE `" . $table . "`.`id`=" . $myId . "");
                            $catalog = mysql_fetch_array($result);
                            $sum += (double)$catalog['price'] * (double)$myCount;
                            $generalCount += $myCount;
                            $price_sum = '-';
                            $price = '-';
                            if ($catalog['price'] != 0) {
                                $price_sum = number_format((double)$catalog['price'] * (double)$myCount, 2, ',', ' ');
                                $price = $catalog["price"];
                            }
                            $content = '
                            <tr id="item-' . $catalog["id"] . '" ' . $active . '>
                                <td><a href="/'.$catalog["category_url"].'/prod/'.$catalog["id"].'"><div style="background: url(/images/prod/s' . $catalog["img"] . ')" class="img-table"></div></a></td>
                                
                                <td><a href="/'.$catalog["category_url"].'/prod/'.$catalog["id"].'" class="link-product">' . $catalog["name"] . '</a></td>
                                
                                <td>' . $catalog["producer_name"] . '</td>
                                
                                <td><span class="price-table"><span class="price-number">' . $price . '</span><img src="/img/svg/rubl-table.svg"></span></td>
                               
                                <td>
                                    <input type="text" class="form-control countAddProd" onkeyup="this.value=parseInt(this.value) | 0" name="countAddProd" value="'.$myCount.'" onChange="update_cart('.$catalog["id"].');"><span class="count-table">шт.</span>
                                </td>
                                
                                <td>
                                    <span class="price-table"><span class="price-sum">' . $price_sum . '</span><img src="/img/svg/rubl-table.svg"></span>
                                </td>
                                
                                <td>
                                    <div class="delete" id="cart-icon-'.$catalog["id"].'">
										<a href="javascript: void(0);" onclick="delete_cart('.$catalog["id"].');"><img src="/img/svg/delet.svg"></a>
								    </div>
                                </td>
                            </tr>';
                            echo $content;
                        }
                    }
                    ?>
                </table>
            </div>
            <div class="total-basket">
                <span class="total-basket-info">Итого:</span><span class="total-basket-price"><span class="cart-sum"><? echo number_format($sum, 2, ',', ' '); ?></span><img src="/img/svg/rubl-big-3.svg"></span>
            </div>
        </div>

        <?
    } else {
        ?>
        <div class="col-xs-12">
            <h2 style="text-align: center; margin: 0; padding-top: 50px; padding-bottom: 50px;">Ваша корзина пуста.</h2>
        </div>
        <?
    }
} else {
    ?>
    <div class="col-xs-12">
        <h2 style="text-align: center; margin: 0; padding-top: 50px; padding-bottom: 50px;">Ваша корзина пуста.</h2>
    </div>
    <?
}
?>