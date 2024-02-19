<?
header('Content-disposition: attachment; filename=catalog.doc');
header('Content-type: text/plain');
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
if (isset($_COOKIE["prod"])) {
	$myProd = explode('#', $_COOKIE["prod"]);
	$prod = "";
	$sum = 0;
	$generalCount = 0;
	$generalSum = 0;
	$content = "";
	if (count($myProd) > 0 && $myProd[0] != "") {
			$content .= '<p style="text-align:center;"><img src="http://kirpich-cherepovets.ru/img/print-header.jpg" width="628" height="163"></p>
									<table style="text-align:left;width:100%;border:1px solid #000;border-spacing: 0px;border-collapse: collapse;" border="0"><thead><tr><th></th><th align="center">наименование</th><th align="center">размер, мм</th><th align="center">колличество в поддоне</th><th align="center">производитель</th><th align="center">вес, кг</th><th align="center">марка прочности</th><th align="center">цена руб./шт</th><th align="center">Количество и общая стоимость</th></tr></thead><tbody>';
					
					for ($i = 0; $i < count($myProd); ++$i) {
						$temp = explode(',',$myProd[$i]);
						$myId = $temp[0];
						$myColor = $temp[1];
						$myCount = $temp[2];
						$myStatus = $temp[3];
						if ($myStatus == 0) {
							$result = mysql_query("SELECT `prod`.`id`, `prod`.`name`, `prod`.`text`, `prod`.`img`, `prod`.`price`, `prod`.`weight`, `prod`.`count_pallet`, `color`.`text` as `code_color`, `brand_strength`.`name` as `brand_strength_name`, `color`.`name` as `color_name`, `size`.`name` as `size_name`, `producer`.`name` as `producer_name`, `category`.`url`, `category`.`name` as `category_name`, `category`.`parentId`, `cat_parent`.`url` as `url_parent`
							FROM `prod`
							LEFT JOIN `category` 
							ON `category`.`id`=`prod`.`id_category`
							LEFT JOIN `category` as `cat_parent`
							ON `cat_parent`.`id`=`category`.`parentId`
							LEFT OUTER JOIN `color` 
							ON `color`.`id`=`prod`.`id_color`
							LEFT OUTER JOIN `size` 
							ON `size`.`id`=`prod`.`id_size`
							LEFT OUTER JOIN `producer` 
							ON `producer`.`id`=`prod`.`id_manufacturer`
							LEFT OUTER JOIN `brand_strength` 
							ON `brand_strength`.`id`=`prod`.`id_brand_strength`
							WHERE  `prod`.`id`=".$myId."");
							$catalog = mysql_fetch_array($result);
							$sum += (double)$catalog['price']*(double)$myCount;
						
							$generalCount += $myCount;
							$height = "";
							$size = getimagesize($_SERVER['DOCUMENT_ROOT'].'/images/prod/s'.$catalog["img"]);
							$h = round(($size[1]*120)/$size[0]);
							$height = "style='height:".($h+40)."px'";
							$content .= '<tr '.$height.'>
								<td width="130"><div class="color-name">'.$catalog["color_name"].'</div><img width="120" height="'.$h.'" src="http://'.$_SERVER['SERVER_NAME'].'/images/prod/s'.$catalog["img"].'" alt="'.$catalog["name"].'"></td>
								<td>'.$catalog["name"].'</td>
								<td align="center">'.$catalog["size_name"].'</td>
								<td align="center">'.$catalog["count_pallet"].'</td>
								<td align="center">'.$catalog["producer_name"].'</td>
								<td align="center">'.str_replace(".", ",", $catalog["weight"]).'</td>
								<td align="center">'.$catalog["brand_strength_name"].'</td>
								<td align="center">'.str_replace(".", ",", $catalog["price"]).'
								</td>
								<td align="left">
									'.$myCount.'<br>
									Стоимость: '.number_format((double)$catalog['price']*(double)$myCount, 2, ',', ' ').'
								</td>
							</tr>';
						} 
					}
			$content .= '</tbody></table><p align="right">Итого: '.str_replace(".", ",", $sum).' руб.</p>';
	}
}
	$html = '<html>
		<head>
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
			<style>td, th{
					border:1px solid #000;  border-spacing: 0px;border-collapse: collapse;vertical-align:top;padding: 5px;vertical-align: middle;
					}
					table td img{margin-top:10px;}
					p, table{width: 100%;}</style>
		</head>
		<body style="margin:0px;padding:0;margin-left:0px;width:100%">'.$content.'</body></html>';
	echo $html
?>