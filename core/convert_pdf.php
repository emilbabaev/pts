<?
session_start();
header('Content-disposition: attachment; filename=catalog.doc');
header('Content-type: text/plain');
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
//require_once($_SERVER['DOCUMENT_ROOT']."/dompdf/dompdf_config.inc.php");
$search = "";
if (isset($_COOKIE['city'])){
	$search = " and `id`=".$_COOKIE['city']."";
}
$result = mysql_query("SELECT * FROM `city` WHERE 1 ".$search." LIMIT 1");
$count = mysql_num_rows($result);
if ($count > 0) {
	$city = mysql_fetch_array($result);
}
if ($city['id'] == 1) {
	$table = "prod";
} else if ($city['id'] == 2) {
	$table = "prod_vologda";
}
if ($_POST["search"] != "") {
	$search = $_POST["search"];
}
$query = "SELECT `".$table."`.`id`, `".$table."`.`name`, `".$table."`.`text`, `".$table."`.`img`, `".$table."`.`price`, `".$table."`.`weight`, `".$table."`.`count_pallet`, `color`.`text` as `code_color`, `brand_strength`.`name` as `brand_strength_name`, `color`.`name` as `color_name`, `size`.`name` as `size_name`, `producer`.`name` as `producer_name`, `category`.`url`, `category`.`parentId`, `cat_parent`.`url` as `url_parent`
FROM `".$table."`
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
WHERE `".$table."`.`enable`=1 ".$search." ORDER BY `".$table."`.`id_category`";
$result = mysql_query($query);
$count = mysql_num_rows($result);
$content .= "<p style='text-align:center;'><img src='http://kirpich-cherepovets.ru/img/print-header.jpg' width='628' height='163'></p>";
if ($count > 0) {
	$catalog = mysql_fetch_array($result);
	$content .= '<table><thead><tr><th></th><th align="center">наименование</th><th align="center">размер, мм</th><th align="center">колличество в поддоне</th><th align="center">производитель</th><th align="center">вес, кг</th><th>марка прочности</th><th align="center">цена руб./шт</th></tr></thead><tbody><tr><td colspan="8"><h2>'.$catalog['category_name'].'</h2></td></tr>';
	$category = $catalog['category_name'];
	do {
		$img = "";
		if ($category != $catalog['category_name']){
			$category = $catalog['category_name'];
			$content .= '<tr><td colspan="8"><h2>'.$catalog['category_name'].'</h2></td></tr>';
		}
		$height = "";
		if ($catalog["img"] != "") {
			$size = getimagesize($_SERVER['DOCUMENT_ROOT'].'/images/prod/s'.$catalog["img"]);
			$h = round(($size[1]*120)/$size[0]);
			$height = "style='height:".($h+40)."px'";
			$img = '<img width="120" height="'.$h.'" src="http://kirpichnyi-dvorik.local/images/prod/s'.$catalog["img"].'" alt="'.$catalog["name"].'"/>';
		}
		if ($catalog["price"] != 0){$price = $catalog["price"];}else{$price = "-";}
		$content .= '<tr '.$height.' id="prod-'.$catalog["id"].'" '.$active.'>
						<td valign="middle" width="130">'.$img.'</td>
						<td>'.$catalog["name"].'</td>
						<td align="center">'.$catalog["size_name"].'</td>
						<td align="center">'.$catalog["count_pallet"].'</td>
						<td align="center">'.$catalog["producer_name"].'</td>
						<td align="center">'.str_replace(".", ",", $catalog["weight"]).'</td>
						<td align="center">'.$catalog["brand_strength_name"].'</td>
						<td align="center">'.str_replace(".", ",", $price).'</td>
						
					</tr>';
	} while($catalog = mysql_fetch_array($result));
	$content .= '</tbody></table>';
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
//$html = str_replace("&nbsp;", "", $html);
//$dompdf = new DOMPDF();
//$dompdf->load_html($html);
//$dompdf->render();
//$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
//exit(0);
?>