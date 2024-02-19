<?
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
$search = "";
//if (isset($_COOKIE['city'])){
//	$search = " and `id`=".$_COOKIE['city']."";
//}
//$result = mysql_query("SELECT * FROM `city` WHERE 1 ".$search." LIMIT 1");
//$count = mysql_num_rows($result);
//if ($count > 0) {
//	$city = mysql_fetch_array($result);
//}
//if ($city['id'] == 1) {
//	$table = "prod";
//} else if ($city['id'] == 2) {
//	$table = "prod_vologda";
//}

$table = "prod";
$arr = array();
$sort = "";
$search = "";
$size = "";
$color = "";
$brand_strength = "";
$producer = "";
$content = '';
$id_category = "";
$elemets = "";

if ($_POST['category'] != "" && $_POST['parentId'] == "")
{
	$_elements = mysql_query("SELECT id_prod FROM link_cats WHERE id_category = ".$_POST['category']);
	while ($cat = mysql_fetch_assoc($_elements)) $elemets .= " OR `prod`.`id` = ".$cat["id_prod"];
	$search .= " and (`".$table."`.`id_category`=".$_POST['category'].$elemets.')';
//	echo $search;
	$id_category = $_POST['category'];
}
if ($_POST['category'] != "" && $_POST['parentId'] == "0"){
	$search .= " and (`category`.`parentId`=".$_POST['category']." or `".$table."`.`id_category`=".$_POST['category'].") ";
//	$get_from_link_cats = true;
	$id_category = $_POST['category'];
}

// Сортировка
if ($_POST['sort'] != "")
{
	$data = explode("/", $_POST['sort']);
	if (count($data) != 0)
	{
		switch ($data[0])
		{
			case 1: $field = 'price';
				break;
            case 2: $field = 'id';
                break;
		}

        switch ($data[1])
        {
            case 1: $type = 'ASC';
                break;
            case 2: $type = 'DESC';
                break;
        }

        $sort = " ORDER BY `".$table."`.`".$field."` ".$type;
	}
	else
	{
        $sort = " ORDER BY `".$table."`.`sort` ASC";
	}
}
else
{
	$sort = " ORDER BY `".$table."`.`sort` ASC"; // Сортировка по полю sort
}

if ($_POST['priceMin'] != "0" && $_POST['priceMin'] != "") {
	//$search .= " and `".$table."`.`price`>='".$_POST['priceMin']."'";
}
if ($_POST['priceMax'] != "0" && $_POST['priceMax'] != "") {
	//$search .= " and `".$table."`.`price`<='".$_POST['priceMax']."'";
}
$result = mysql_query("SELECT * FROM `producer` ORDER BY `id` DESC");
$count = mysql_num_rows($result);
if ($count > 0) {
	$catalog = mysql_fetch_array($result);
	do {
		if ($_POST['producer_'.$catalog['id']] != "") {
			$producer .= " or `".$table."`.`id_manufacturer`=".$_POST['producer_'.$catalog['id']]."";
		}
	} while($catalog = mysql_fetch_array($result));
	if ($producer != "") {
		$producer = " and (".mb_substr($producer, 3).")";
	}
}
$result = mysql_query("SELECT * FROM `color` ORDER BY `id` DESC");
$count = mysql_num_rows($result);
if ($count > 0) {
	$catalog = mysql_fetch_array($result);
	do {
		if ($_POST['color_'.$catalog['id']] != "") {
			$color .= " or `".$table."`.`id_color`=".$_POST['color_'.$catalog['id']]."";
		}
	} while($catalog = mysql_fetch_array($result));
	if ($color != "") {
		$color = " and (".mb_substr($color, 3).")";
	}
}
$result = mysql_query("SELECT * FROM `size` ORDER BY `id` DESC");
$count = mysql_num_rows($result);
if ($count > 0) {
	$catalog = mysql_fetch_array($result);
	do {
		if ($_POST['size_'.$catalog['id']] != "") {
			$size .= " or `".$table."`.`id_size`=".$_POST['size_'.$catalog['id']]."";
		}
	} while($catalog = mysql_fetch_array($result));
	if ($size != "") {
		$size = " and (".mb_substr($size, 3).")";
	}
}
$result = mysql_query("SELECT * FROM `brand_strength` ORDER BY `id` DESC");
$count = mysql_num_rows($result);
if ($count > 0) {
	$catalog = mysql_fetch_array($result);
	do {
		if ($_POST['brand_strength_'.$catalog['id']] != "") {
			$brand_strength .= " or `".$table."`.`id_brand_strength`=".$_POST['brand_strength_'.$catalog['id']]."";
		}
	} while($catalog = mysql_fetch_array($result));
	if ($brand_strength != "") {
		$brand_strength = " and (".mb_substr($brand_strength, 3).")";
	}
}

$search .= $producer.$color.$size.$brand_strength;
$arr['search'] = $search;
$query = "FROM `".$table."`
LEFT JOIN `category`
ON `category`.`id`=`".$table."`.`id_category`
LEFT JOIN `category` as `cat_parent`
ON `cat_parent`.`id`=`category`.`parentId`
LEFT OUTER JOIN `color` 
ON `color`.`id`=`".$table."`.`id_color`
LEFT OUTER JOIN `size` 
ON `size`.`id`=`".$table."`.`id_size`
LEFT OUTER JOIN `producer` 
ON `producer`.`id`=`".$table."`.`id_manufacturer`
LEFT OUTER JOIN `brand_strength` 
ON `brand_strength`.`id`=`".$table."`.`id_brand_strength`
WHERE `".$table."`.`enable`=1 ".$search."";

//echo $query;
$result = mysql_query("SELECT COUNT(*) AS `count` ".$query."");
$count = mysql_result($result, 0, 'count');
$limit = $_POST['limit'];
$page = $_POST['page'];
$id_prod = 0;
if ($_POST['id_prod'] != "")
{
	$id_prod = $_POST['id_prod'];
	$result = mysql_query("SELECT COUNT(*) AS `count` ".$query." and `".$table."`.`id`>=".$id_prod." ".$sort."");
	$count_prod = mysql_result($result, 0, 'count');
	$page = ceil($count_prod/$limit);
}

if ($count > 0) { $total_pages = ceil($count/$limit); } else {$total_pages = 0;}
if ($page > $total_pages) $page=$total_pages;
if ($limit<0) $limit = 0;
$start = $limit*$page - $limit; 
if ($start<0) $start = 0;
$query = "SELECT `".$table."`.`id`, `".$table."`.`new`, `".$table."`.`id_category`, `".$table."`.`special`, `".$table."`.`new_price`, `".$table."`.`name`, `".$table."`.`text`, `".$table."`.`img`, `".$table."`.`price`, `".$table."`.`weight`, `".$table."`.`count_pallet`, `color`.`text` as `code_color`, `brand_strength`.`name` as `brand_strength_name`, `color`.`name` as `color_name`, `size`.`name` as `size_name`, `producer`.`name` as `producer_name`, `category`.`url`, `category`.`parentId`, `cat_parent`.`url` as `url_parent` ".$query." ".$sort." LIMIT ".$start.", ".$limit."";
$result = mysql_query($query);

if ($count > 0) {
	$content .= ''; // !!!!!!!!!!!!!!!!!!!!!!!!
	$catalog = mysql_fetch_array($result);
	do {
		$active = "";
		$img = "";
		$url = "";
		if ($catalog['parentId'] == 0) {
			$url = "/".$catalog['url']."/prod/".$catalog["id"]."/";
		} else {
			$url = "/".$catalog['url_parent']."/".$catalog['url']."/prod/".$catalog["id"]."/";
		}
		if ($id_prod == $catalog["id"]) {
			$active = 'class="active"';
		}
		if ($catalog["img"] != "") {
			$img = '/images/prod/'.$catalog["img"];
		}
		$spec = '<div class="label-prod">';
		if ($catalog['special'] != 0){$spec .= '<div class="special">Спецпредложение</div>';}
		if ($catalog['new'] != 0){$spec .= '<div class="new">Новинка</div>';}
		$spec .= '</div>';

		$str_name = '';
		if ($catalog['id_category'] == 61) $str_name = 'Клинкерная плитка ';
		if ($catalog['id_category'] == 62) $str_name = 'Тротуарный клинкерный кирпич ';

		// ЦЕНЫ
        $price = "";
        if ($catalog['new_price'] != 0)
        {
            $price = '<p class="price-small">'.$catalog['new_price'].'<img src="/img/svg/rubl-small.svg"></p>';
            $price .= '<p class="price-big">'.$catalog['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"><img class="arrow-bottom" src="/img/svg/arrow-bottom.svg"></p>';
        }
        else
        {
			if ($catalog['price'] == 0)
				$price .= '<p class="price-big" style="font-size: 15px; height: 37px; padding-top: 7px;">Цена по запросу</p>';
			else
            	$price .= '<p class="price-big">'.$catalog['price'].'<img class="rubl-big" src="/img/svg/rubl-big.svg"></p>';

        }

		$content .= '
        <div class="col-xs-12 col-md-6 col-lg-4 main-block-products" id="prod-'.$catalog["id"].'">
            <div class="main-block-products-info">
                <a href="'.$url.'">
                    <div class="text-center">
                        <div style="background: url('.$img.')" class="img-prod-catalog"></div>
                    </div>
                    <div class="main-block-products-text">
                        <p>'.$str_name.$catalog["name"].'</p>
                    </div>
                    <div class="main-block-products-price">
                        '.$price.'
                    </div>
                </a>
                <div class="main-block-products-btn">
                    <a href="'.$url.'" class="btn animated-button btn-gray-two"><span>Подробнее</span></a>
                    <a href="javascript:addToCart('.$catalog["id"].', 0, 1, this);" class="btn animated-button btn-yellow"><span><img src="/img/svg/basket-gray.svg">В корзину</span></a>
                </div>
            </div>
        </div>';
	} while($catalog = mysql_fetch_array($result));
	$content .= ''; // !!!!!!!!!!!!!!!!!!!!!!!!!!!
}
if ($id_prod != 0){
	$content .= '<script>location.href="#prod-'.$id_prod.'";</script>';
}
$arr['page'] = (int)$page;
$arr['total'] = (int)$total_pages;
$arr['records'] = (int)$count;
$arr['content'] = $content;
header('Pragma: no-cache');
header('Content-type: application/json');
echo json_encode($arr);
?>
