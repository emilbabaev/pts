<?
//Header("Content-Type: text/html;charset=UTF-8");
require_once $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
if (isset($_COOKIE["comp"])) {
	$myProd = explode('#', $_COOKIE["comp"]);
	$prod = "";
	if (count($myProd) > 0 && $myProd[0] != "") {?>
		<br/>
		<div class="catalog-list">
			<table><thead><tr><th></th><th>наименование</th><th>размер, мм</th><th>колличество в поддоне</th><th>производитель</th><th>вес, кг</th><th>марка прочности</th><th>цена руб./шт</th></tr></thead><tbody>
					<?
					for ($i = 0; $i < count($myProd); ++$i) {
						$temp = explode(',',$myProd[$i]);
						$myId = $temp[0];
						$myStatus = $temp[1];
						if ($myStatus == 0) {
							$result = mysql_query("SELECT `".$table."`.`id`, `".$table."`.`name`, `".$table."`.`img`, `".$table."`.`price`, `".$table."`.`weight`, `".$table."`.`count_pallet`, `color`.`text` as `code_color`, `brand_strength`.`name` as `brand_strength_name`, `color`.`name` as `color_name`, `size`.`name` as `size_name`, `producer`.`name` as `producer_name` FROM `".$table."`
							LEFT JOIN `category` 
							ON `category`.`id`=`".$table."`.`id_category`
							LEFT OUTER JOIN `color` 
							ON `color`.`id`=`".$table."`.`id_color`
							LEFT OUTER JOIN `size` 
							ON `size`.`id`=`".$table."`.`id_size`
							LEFT OUTER JOIN `producer` 
							ON `producer`.`id`=`".$table."`.`id_manufacturer`
							LEFT OUTER JOIN `brand_strength` 
							ON `brand_strength`.`id`=`".$table."`.`id_brand_strength`
							WHERE `".$table."`.`id`=".$myId."");
							$catalog = mysql_fetch_array($result);
							$sum += (double)$catalog['price']*(double)$myCount;
							$generalCount += $myCount;
							$content = '<tr id="item-compare-'.$catalog["id"].'" '.$active.'>
								<td><span class="figure" style="border-left: 10px solid '.$catalog["code_color"].';border-top: 10px solid '.$catalog["code_color"].';"></span><div class="color-name">'.$catalog["color_name"].'</div><img width="120" src="/images/prod/s'.$catalog["img"].'" alt="'.$catalog["name"].'"><a class="zoom-img" data-lightbox="example-set" data-title="" href="/images/prod/'.$catalog["img"].'"><i class="icon-10"></i></a></td>
								<td>'.$catalog["name"].'</td>
								<td>'.$catalog["size_name"].'</td>
								<td>'.$catalog["count_pallet"].'</td>
								<td>'.$catalog["producer_name"].'</td>
								<td>'.$catalog["weight"].'</td>
								<td>'.$catalog["brand_strength_name"].'</td>
								<td><span class="price-number">'.$catalog["price"].'</span><div class="delete" id="compare-icon-'.$catalog["id"].'">
										<a class="btn-delete" href="javascript: void(0);" onclick="delete_compare('.$catalog["id"].');"><i class="icon-9"></i></a>
									</div>
								</td>
								
							</tr>';
							echo $content;
						} 
					}
					?>
			</tbody></table>
		</div>
		<?
	} else {
		?><h1>Нет данных для сравнения</h1><?
	}
} else {
	?><h1>Нет данных для сравнения</h1><?
}
?>