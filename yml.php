<?header('Content-type: application/xml');
header("Content-Type: text/xml; charset=utf-8");
$fname = $_SERVER['DOCUMENT_ROOT']."/yandex.xml";
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";

	#########################
# Начинаем генерировать XML
# переменные для заголовка
$cdate = date("Y-m-d H:i",time());
$csite = "http://kirpichnyi-dvorik.local/";
$cname = "ООО «Кирпич на Гоголя 51»";
$csite2 = "http://kirpichnyi-dvorik.local/";
$cname2 = $cname;
$cdesc = "Компания «Кирпич на Гоголя 51» была создана в 2010 году. Основное направление деятельности нашей компании – продажа кирпича, газобетона, керамических блоков оптом и в розницу. Мы предлагаем продукцию ведущих производителей кирпича и газобетона. В демонстрационном зале нашей фирмы представлены наиболее популярные образцы кирпича. Индивидуальный подход к каждому клиенту, а также широкий ассортимент и низкие цены приятно удивят Вас!";
#----------------------------------------------
$yandex=<<<END
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="$cdate">
<shop>
<name>$cname</name>
<company>$cdesc</company>
<url>$csite</url>
<agency>Кирпич на Гоголя 51</agency>
<email>mail@kirpichnyi-dvorik.ru</email>
<currencies>
    <currency id="RUR" rate="1"/>
</currencies>

END;
	
$arr_cats=array();
#----------------------------------------------
    # для Яндекса выводим все подкатегории
        $yandex .= "\n\n<categories>\n";
        $tmp="SELECT * FROM `category` ORDER BY `id` ASC, `parentId` ASC";

        $res = mysql_query($tmp);
        while ($rezzzz = mysql_fetch_array($res)){
                #экранируем спецсимволы

                $rezzzz['name']=htmlspecialchars(strip_tags($rezzzz['name']));
                $fftt = "<category id=\"".$rezzzz['id']."\"";
                if($rezzzz['parentId']>0)        $fftt .= " parentId=\"".$rezzzz['parentId']."\"";
                $fftt.= ">".strip_tags($rezzzz['name'])."</category>\n";
                $yandex .= $fftt;

                $arr_cats[$rezzzz['id']]=$rezzzz;
        }

        //$yandex .= $fftt;
               
        $yandex .= "</categories>\n";
		
#----------------------------------------------
$yandex .="<local_delivery_cost>0</local_delivery_cost>\n<offers>\n";

#----- YANDEX ------
$tmp="
        SELECT
            `prod`.`id`, `prod`.`new`, `prod`.`id_category`, `prod`.`special`, `prod`.`new_price`, `prod`.`name`, `prod`.`text`, `prod`.`img`, `prod`.`price`, `prod`.`weight`, `prod`.`count_pallet`, `color`.`text` as `code_color`, `brand_strength`.`name` as `brand_strength_name`, `color`.`name` as `color_name`, `size`.`name` as `size_name`, `producer`.`name` as `producer_name`, `category`.`url`, `category`.`parentId`, `cat_parent`.`url` as `url_parent`
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
		WHERE `prod`.`enable`=1 and `prod`.`price`<>0 ORDER BY `id` ASC";

$res = mysql_query($tmp);

while ($tovar = mysql_fetch_array($res)) {
		$url = "";
		if ($tovar['parentId'] == 0) {
			$url = "/".$tovar['url']."/prod/".$tovar["id"]."/";
		} else {
			$url = "/".$tovar['url_parent']."/".$tovar['url']."/prod/".$tovar["id"]."/";
		}
		
        $valuta="RUR";//изменить на нужную валюту
        $price=$tovar["price"];

        $price=intval($price);
		if ($price == 0) {
			$price = 1;
		}
		$description = "<description>".$tovar['cat_name']." производитель ".$tovar['producer_name'].". Размер, мм ".$tovar['size_name'].". Вес, кг ".$tovar['weight'].". Марка прочности ".$tovar['brand_strength_name'].". Цена ".$tovar['price']." руб./шт, купить в Череповце.</description>";
		$status_catalog = "";
		$available = "true";

        $tovar['name'] = htmlspecialchars($tovar['name']);

        #фотография
        if ($tovar['img'] != "") {
			$img_catalog = $tovar['img'];
        $src_file = $csite2."/images/prod/".$img_catalog;
        $ppy = "<picture>".$src_file."</picture>";
        } else {
                $ppy = "";
        }
		$text = "";
		if ($tovar['producer_name'] != "") {
			$text .= "<vendor>".$tovar['producer_name']."</vendor>";
		}
		if ($tovar['size_name'] != "") {
			$text .= '<param unit="мм" name="размер">'.$tovar['size_name'].'</param>';
		}
		if ($tovar['count_pallet'] != "") {
			$text .= '<param name="кол-во в поддоне">'.$tovar['count_pallet'].'</param>';
		}
		if ($tovar['weight'] != "") {
			$text .= '<param unit="кг" name="вес">'.$tovar['weight'].'</param>';
		}
		if ($tovar['count_pallet'] != "") {
			$text .= '<param name="марка прочности">'.$tovar['brand_strength_name'].'</param>';
		}

#----------------------------------------------
$yandex.=<<<END
    <offer id="$tovar[id]" available="$available" type="vendor.model">
      <url>{$csite2}$url</url>
      <price>$price</price>
      <currencyId>$valuta</currencyId>
      <categoryId>$tovar[id_category]</categoryId>
          $ppy
      <model>$tovar[name]</model>
	  <delivery>false</delivery>
	  $vendor
	  $status_catalog
      $description
	  $text
    </offer>
END;
}

$yandex .= "</offers>\n</shop>\n</yml_catalog>\n";
//file_put_contents($fname, $yandex); 
#выводим, что нагенерили
echo $yandex;

?>	