<?
require_once $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
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
if (isset($_COOKIE["comp"])) {
	$myProd = explode('#', $_COOKIE["comp"]);
	if (count($myProd) > 0 && $myProd[0] != "") {?>
		<a href="/compare" class="name"><i class="icon-14"></i><span>сравнить</span><i class="icon-5"></i></a>
		<table>
			<?
			for ($i = 0; $i < count($myProd); ++$i) {
				$temp = explode(',',$myProd[$i]);
				$myId = $temp[0];
				$myStatus = $temp[1];
				if ($myStatus == 0) {
					$result = mysql_query("SELECT * FROM `".$table."` WHERE `id`='".$myId."'");
					$catalog_cart = mysql_fetch_array($result);
					?><tr id="item-compare-<?=$catalog_cart['id']?>"><td><img src="/images/prod/s<?=$catalog_cart['img']?>" alt="<?=$catalog_cart['name']?>" width="60"></td><td><?=$catalog_cart['name']?><div class="del" id="compare-icon-<?=$catalog_cart['id']?>"><a class="btn-delete" href="javascript: void(0);" onClick="delete_compare(<?=$catalog_cart["id"]?>);"><i class="icon-9"></i></a></div></td></tr><?
				}
			}?>
		</table>
	<?}
}?>