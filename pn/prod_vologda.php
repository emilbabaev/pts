<?
	session_start();
	Header("Content-Type: text/html;charset=UTF-8");
	include $_SERVER['DOCUMENT_ROOT']."/pn/classSimpleImage.php";	
	include $_SERVER['DOCUMENT_ROOT']."/pn/url_translit.php";	
	include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
	$title = "Каталог";
	include $_SERVER['DOCUMENT_ROOT']."/pn/header.html";
	if (!isset($_SESSION["user_id"]))
	{
		?></br><p align="center"><font color="red">Вы не вошли под своим именем</font></p><?
		include $_SERVER['DOCUMENT_ROOT']."/pn/footer.html";
		exit;
	}
	$table = 'prod_vologda';
	$page_url = 'prod_vologda';
	$title_page = $title;
	if (isset($_GET['price']))
	{
		$name = '';
		if (basename($_FILES['name']['name']) != '')
		{
			$name = basename($_FILES['name']['name']);
			move_uploaded_file($_FILES['name']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/load/catalog-vologda.csv');
		}
		$SQL = "UPDATE `files` SET `name`='".$name."' WHERE `id`=1";
		$result = mysql_query($SQL);
		$handle = fopen($_SERVER['DOCUMENT_ROOT']."/load/catalog-vologda.csv", "r");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$res = mysql_query("SELECT `id` FROM `color` WHERE `name` LIKE '".iconv("Windows-1251", "UTF-8", $data[7])."'");
			$color = "";$id_color = 0;
			if (mysql_num_rows($res) > 0) {
				$color = ", `id_color`=".mysql_result($res, 0, "id")."";
				$id_color = mysql_result($res, 0, "id");
			}
			$res = mysql_query("SELECT `id` FROM `size` WHERE `name` LIKE '".iconv("Windows-1251", "UTF-8", $data[2])."'");
			$size = "";$id_size = 0;
			if (mysql_num_rows($res) > 0) {
				$size = ", `id_size`=".mysql_result($res, 0, "id")."";
				$id_size = mysql_result($res, 0, "id");
			}
			$res = mysql_query("SELECT `id` FROM `brand_strength` WHERE `name` LIKE '".iconv("Windows-1251", "UTF-8", $data[6])."'");
			$brand_strength = "";$id_brand_strength = 0;
			if (mysql_num_rows($res) > 0) {
				$brand_strength = ", `id_brand_strength`=".mysql_result($res, 0, "id")."";
				$id_brand_strength = mysql_result($res, 0, "id");
			}
			$res = mysql_query("SELECT `id` FROM `producer` WHERE `name` LIKE '".iconv("Windows-1251", "UTF-8", $data[4])."'");
			$producer = "";$id_manufacturer = 0;
			if (mysql_num_rows($res) > 0) {
				$producer = ", `id_manufacturer`=".mysql_result($res, 0, "id")."";
				$id_manufacturer = mysql_result($res, 0, "id");
			}
			if ($data[0] == '') {
				$id_category = 0;
				if (isset($data[10])){
					$res = mysql_query("SELECT `id` FROM `category` WHERE `name` LIKE '".iconv("Windows-1251", "UTF-8", $data[10])."'");
					if (mysql_num_rows($res) > 0) {
						$id_category = mysql_result($res, 0, "id");
					}
				}
				$text = '';
				if (isset($data[9])){
					$text = $data[9];
				}
				$SQL = "INSERT INTO `".$table."` (`id`, `id_category`, `id_manufacturer`, `id_size`, `id_brand_strength`, `id_color`, `name`, `text`, `price`, `img`, `weight`, `count_pallet`, `status`, `url`, `enable`) VALUES (NULL, '".$id_category."', '".$id_manufacturer."', '".$id_size."', '".$id_brand_strength."', '".$id_color."', '".mysql_real_escape_string(iconv("Windows-1251", "UTF-8", $data[1]))."', '".mysql_real_escape_string(iconv("Windows-1251", "UTF-8", $text))."', '".(double)str_replace(",", ".", $data[8])."', '', '".(double)str_replace(",", ".", $data[5])."', '".(double)str_replace(",", ".", $data[3])."', '0', '', '1');";
				$result = mysql_query($SQL);	
			} else {
				mysql_query("UPDATE `prod_vologda` SET `name`='".mysql_real_escape_string(iconv("Windows-1251", "UTF-8", $data[1]))."', `price`='".(double)str_replace(",", ".", $data[8])."', `weight`='".(double)str_replace(",", ".", $data[5])."', `count_pallet`='".(double)str_replace(",", ".", $data[3])."' ".$color.$size.$brand_strength.$producer." WHERE `id`=".$data[0]."");
			}
			//echo "<p>UPDATE `prod` SET `name`='".mysql_real_escape_string(iconv("Windows-1251", "UTF-8", $data[1]))."', `price`='".(double)str_replace(",", ".", $data[8])."', `weight`='".(double)str_replace(",", ".", $data[5])."', `count_pallet`='".(double)str_replace(",", ".", $data[3])."' ".$color.$size.$brand_strength.$producer." WHERE `id`=".$data[0]."</p>";
		}
		fclose($handle);
	}	
	if (!is_dir($_SERVER['DOCUMENT_ROOT']."/images/".$page_url))
	{
		mkdir($_SERVER['DOCUMENT_ROOT']."/images/".$page_url, 0777);
	}
	if (isset($_GET['del']))
	{
		$sql = "DELETE FROM `".$table."` WHERE `id` = ".$_GET['del']."";
		mysql_query($sql);
	}

	if (isset($_GET['page']))
	{
		$page = $_GET['page'];
	}
	else
	{
		$page = 0;
	}
	$count_data = $page * 20;
	
	$search = "";
	$search_str = "";
	if (isset($_GET['name']) && $_GET['name'] != "") {
		$search_str .= " and (`prod_vologda`.`name` LIKE '%".$_GET['name']."%') ";
		
	}
	if (isset($_GET['id_category']) && $_GET['id_category'] != "") {
		$search_str .= " and (`prod_vologda`.`id_category`=".$_GET['id_category']." or `category`.`parentId`=".$_GET['id_category'].") ";
	}
	$SQL = "SELECT * FROM `".$table."`, `category` WHERE `category`.`id`=`prod_vologda`.`id_category` ".$search_str."";
	$result = mysql_query($SQL);

	$count_base = mysql_num_rows($result);
	$count_page = ceil($count_base / 20);
	
?>

        <?
		if (isset($_GET['edit']))
		{
			$SQL = "SELECT * FROM `".$table."` WHERE id=".$_GET['edit']."";
			$result = mysql_query($SQL);
			$id = mysql_result($result, 0, 'id');
			$name = mysql_result($result, 0, 'name');
			$id_category = mysql_result($result, 0, 'id_category');
			$id_size = mysql_result($result, 0, 'id_size');
			$id_manufacturer = mysql_result($result, 0, 'id_manufacturer');
			$id_color = mysql_result($result, 0, 'id_color');
			$id_brand_strength = mysql_result($result, 0, 'id_brand_strength');
			$price = mysql_result($result, 0, 'price');
			$img = mysql_result($result, 0, 'img');
			$weight = mysql_result($result, 0, 'weight');
			$count_pallet = mysql_result($result, 0, 'count_pallet');
			$text = mysql_result($result, 0, 'text');
			$status = mysql_result($result, 0, 'status');
			$url = mysql_result($result, 0, 'url');
			$new = mysql_result($result, 0, 'new');
			$new_price = mysql_result($result, 0, 'new_price');
			$special = mysql_result($result, 0, 'special');
			?>
			
			<div class="header">
            
            <h1 class="page-title"><?echo $title_page;?></h1>
                    <ul class="breadcrumb">
            <li><a href="/pn/">Главная</a> </li>
			<li><a href="/pn/<?echo $page_url;?>.php"><?echo $title_page;?></a> </li>
            <li class="active">Изменить</li>
        </ul>

        </div>
        <div class="main-content">
			<div class="row">
		  <div class="col-md-6">
		
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane active in" id="home">
			  <form id="tab" action="/pn/<?echo $page_url;?>.php?page=<?=$_GET['page'];?><?if (isset($_GET["name"])) {echo "&id_category=".$_GET["id_category"]."&name=".$_GET["name"];}?>" method="post"  enctype="multipart/form-data">
				<div class="form-group">
				<label>Название</label>
				<input type="text" value="<?echo $name;?>" name="name" class="form-control">
				</div>
				<div class="form-group">
				<label>Ссылка</label>
				<input type="text" value="<?echo $url;?>" name="url" class="form-control">
				</div>
				<div class="form-group">
				<label>Категория</label>
				<select name="id_category" class="form-control">
					<option value="0"></option>
					<?
						$res = mysql_query("SELECT * FROM `category`");
						$count = mysql_num_rows($res);
						for ($i = 0; $i < $count; ++$i){
							$id_res = mysql_result($res, $i, 'id');
							$name_res = mysql_result($res, $i, 'name');
							?>
							<option <?if ($id_res == $id_category) {?>selected<?}?> value="<?echo $id_res;?>"><?echo $name_res;?></option>
							<?
						}
					?>
				</select>
				</div>
				<div class="form-group">
				<label>Размер</label>
				<select name="id_size" class="form-control">
					<option value="0"></option>
					<?
						$res = mysql_query("SELECT * FROM `size`");
						$count = mysql_num_rows($res);
						for ($i = 0; $i < $count; ++$i){
							$id_res = mysql_result($res, $i, 'id');
							$name_res = mysql_result($res, $i, 'name');
							?>
							<option <?if ($id_res == $id_size) {?>selected<?}?> value="<?echo $id_res;?>"><?echo $name_res;?></option>
							<?
						}
					?>
				</select>
				</div>
				<div class="form-group">
				<label>Производитель</label>
				<select name="id_manufacturer" class="form-control">
					<option value="0"></option>
					<?
						$res = mysql_query("SELECT * FROM `producer`");
						$count = mysql_num_rows($res);
						for ($i = 0; $i < $count; ++$i){
							$id_res = mysql_result($res, $i, 'id');
							$name_res = mysql_result($res, $i, 'name');
							?>
							<option <?if ($id_res == $id_manufacturer) {?>selected<?}?> value="<?echo $id_res;?>"><?echo $name_res;?></option>
							<?
						}
					?>
				</select>
				</div>
				<div class="form-group">
				<label>Цвет</label>
				<select name="id_color" class="form-control">
					<option value="0"></option>
					<?
						$res = mysql_query("SELECT * FROM `color`");
						$count = mysql_num_rows($res);
						for ($i = 0; $i < $count; ++$i){
							$id_res = mysql_result($res, $i, 'id');
							$name_res = mysql_result($res, $i, 'name');
							?>
							<option <?if ($id_res == $id_color) {?>selected<?}?> value="<?echo $id_res;?>"><?echo $name_res;?></option>
							<?
						}
					?>
				</select>
				</div>
				<div class="form-group">
				<label>Марка прочности</label>
				<select name="id_brand_strength" class="form-control">
					<option value="0"></option>
					<?
						$res = mysql_query("SELECT * FROM `brand_strength`");
						$count = mysql_num_rows($res);
						for ($i = 0; $i < $count; ++$i){
							$id_res = mysql_result($res, $i, 'id');
							$name_res = mysql_result($res, $i, 'name');
							?>
							<option <?if ($id_res == $id_brand_strength) {?>selected<?}?> value="<?echo $id_res;?>"><?echo $name_res;?></option>
							<?
						}
					?>
				</select>
				</div>
				<div class="form-group">
				<label>Цена</label>
				<input type="text" value="<?echo $price;?>" name="price" class="form-control">
				</div>
				<div class="form-group">
				<label>Старая цена</label>
				<input type="text" value="<?echo $new_price;?>" name="new_price" class="form-control">
				</div>
				<div class="form-group">
				<label>Фото</label>
				<p><img src="/images/prod/<?echo $img;?>" width="300px;"></p>
				<input type="file" name="img" class="form-control">
				</div>
				
				<div class="form-group">
				<label>Вес</label>
				<input type="text" value="<?echo $weight;?>" name="weight" class="form-control">
				</div>
				<div class="form-group">
				<label>Колличество в поддоне</label>
				<input type="text" value="<?echo $count_pallet;?>" name="count_pallet" class="form-control">
				</div>
				<div class="form-group">
				<label style="vertical-align:top;line-height:2.2;">Лучшее предложение</label>
				<input type="checkbox" value="1" <?if ($status == '1') {?>checked<?}?> name="status" style="width:24px;height:24px;">
				</div>
				<div class="form-group">
				<label style="vertical-align:top;line-height:2.2;">Спецпредложение</label>
				<input type="checkbox" value="1" <?if ($special == '1') {?>checked<?}?> name="special" style="width:24px;height:24px;">
				</div>
				<div class="form-group">
				<label style="vertical-align:top;line-height:2.2;">Новинка</label>
				<input type="checkbox" value="1" <?if ($new == '1') {?>checked<?}?> name="new" style="width:24px;height:24px;">
				</div>
				<div class="form-group">
				<label>Описание</label>
				<textarea name="text" class="form-control"><?echo $text;?></textarea>
				</div>
				
			  </div>
			</div>

			<div class="btn-toolbar list-toolbar">
			  <input type="submit" class="btn btn-primary" value="Изменить">
			  <a href="/pn/<?echo $page_url;?>.php" class="btn btn-danger">Отмена</a>
					  <input type="hidden" name="edit_data" value="<?echo $id;?>">
			   </form>
			</div>
		  </div>
		</div>
		<script>
					function delete_element_img(img, id, number){
						document.getElementById(img+'_'+number).style.display='none';
						$.ajax({
							url: "/pn/delete_element_img.php", 
							type: "POST",       
							data: {"img": img, "id": id, "number": number, "table": '<?echo $table;?>'},
							cache: false,			
							success: function(response){
								if(response == 0){} else{
										
									}
								}
							});
					}
		</script>
			<?
			
		}
		else
		{
				if (isset($_GET['add']))
				{
					
					?>
							<div class="header">
					
					<h1 class="page-title"><?echo $title_page;?></h1>
							<ul class="breadcrumb">
					<li><a href="/pn/">Главная</a> </li>
					<li><a href="/pn/<?echo $page_url;?>.php"><?echo $title_page;?></a> </li>
					<li class="active">Добавить данные</li>
				</ul>

				</div>
				<div class="main-content">
					<div class="row">
		  <div class="col-md-6">
		
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane active in" id="home">
			  <form id="tab" action="/pn/<?echo $page_url;?>.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
				<label>Название</label>
				<input type="text" value="<?echo $name;?>" name="name" class="form-control">
				</div>
				<div class="form-group">
				<label>Ссылка</label>
				<input type="text" value="<?echo $url;?>" name="url" class="form-control">
				</div>
				<div class="form-group">
				<label>Категория</label>
				<select name="id_category" class="form-control">
				
					<?
						$res = mysql_query("SELECT * FROM `category`");
						$count = mysql_num_rows($res);
						for ($i = 0; $i < $count; ++$i){
							$id_res = mysql_result($res, $i, 'id');
							$name_res = mysql_result($res, $i, 'name');
							?>
							<option value="<?echo $id_res;?>"><?echo $name_res;?></option>
							<?
						}
					?>
				</select>
				</div>
				<div class="form-group">
				<label>Размер</label>
				<select name="id_size" class="form-control">
					<option value="0"></option>
					<?
						$res = mysql_query("SELECT * FROM `size`");
						$count = mysql_num_rows($res);
						for ($i = 0; $i < $count; ++$i){
							$id_res = mysql_result($res, $i, 'id');
							$name_res = mysql_result($res, $i, 'name');
							?>
							<option value="<?echo $id_res;?>"><?echo $name_res;?></option>
							<?
						}
					?>
				</select>
				</div>
				<div class="form-group">
				<label>Производитель</label>
				<select name="id_manufacturer" class="form-control">
					<option value="0"></option>
					<?
						$res = mysql_query("SELECT * FROM `producer`");
						$count = mysql_num_rows($res);
						for ($i = 0; $i < $count; ++$i){
							$id_res = mysql_result($res, $i, 'id');
							$name_res = mysql_result($res, $i, 'name');
							?>
							<option value="<?echo $id_res;?>"><?echo $name_res;?></option>
							<?
						}
					?>
				</select>
				</div>
				<div class="form-group">
				<label>Цвет</label>
				<select name="id_color" class="form-control">
					<option value="0"></option>
					<?
						$res = mysql_query("SELECT * FROM `color`");
						$count = mysql_num_rows($res);
						for ($i = 0; $i < $count; ++$i){
							$id_res = mysql_result($res, $i, 'id');
							$name_res = mysql_result($res, $i, 'name');
							?>
							<option value="<?echo $id_res;?>"><?echo $name_res;?></option>
							<?
						}
					?>
				</select>
				</div>
				<div class="form-group">
				<label>Марка прочности</label>
				<select name="id_brand_strength" class="form-control">
					<option value="0"></option>
					<?
						$res = mysql_query("SELECT * FROM `brand_strength`");
						$count = mysql_num_rows($res);
						for ($i = 0; $i < $count; ++$i){
							$id_res = mysql_result($res, $i, 'id');
							$name_res = mysql_result($res, $i, 'name');
							?>
							<option value="<?echo $id_res;?>"><?echo $name_res;?></option>
							<?
						}
					?>
				</select>
				</div>
				<div class="form-group">
				<label>Цена</label>
				<input type="text" value="<?echo $price;?>" name="price" class="form-control">
				</div>
				<div class="form-group">
				<label>Старая цена</label>
				<input type="text" value="<?echo $new_price;?>" name="new_price" class="form-control">
				</div>
				<div class="form-group">
				<label>Фото</label>
				<input type="file" name="img" class="form-control">
				</div>
				
				<div class="form-group">
				<label>Вес</label>
				<input type="text" value="<?echo $weight;?>" name="weight" class="form-control">
				</div>
				<div class="form-group">
				<label>Колличество в поддоне</label>
				<input type="text" value="<?echo $count_pallet;?>" name="count_pallet" class="form-control">
				</div>
				<div class="form-group">
				<label style="vertical-align:top;line-height:2.2;">Лучшее предложение</label>
				<input type="checkbox" value="1" name="status" style="width:24px;height:24px;">
				</div>
				<div class="form-group">
				<label style="vertical-align:top;line-height:2.2;">Спецпредложение</label>
				<input type="checkbox" value="1" name="special" style="width:24px;height:24px;">
				</div>
				<div class="form-group">
				<label style="vertical-align:top;line-height:2.2;">Новинка</label>
				<input type="checkbox" value="1" name="new" style="width:24px;height:24px;">
				</div>
				<div class="form-group">
				<label>Описание</label>
				<textarea name="text" class="form-control"><?echo $text;?></textarea>
				</div>
			  </div>
			</div>

			<div class="btn-toolbar list-toolbar">
			  <input type="submit" class="btn btn-primary" value="Добавить">
			  <a href="/pn/<?echo $page_url;?>.php" class="btn btn-danger">Отмена</a>
			  	<input type="hidden" name="add_data">
			   </form>
			</div>
		  </div>
		</div>
					<?
			
				}
				else
				{

				?>
						<div class="header">
					
					<h1 class="page-title"><?echo $title_page;?></h1>
							<ul class="breadcrumb">
					<li><a href="/pn/">Главная</a> </li>
					<li class="active"><?echo $title_page;?></li>
				</ul>

				</div>
				<div class="main-content">
				
				<?
				
					if (isset($_POST['add_data']))
					{
						$img = "";
						if ($_POST['url'] == "") {
							$url = str2url($_POST['name']);
						} else {
							$url = $_POST['url'];
						}
						if (basename($_FILES['img']['name']) != '')
						{
							$path_info = pathinfo(basename($_FILES['img']['name']));
							$img = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
							move_uploaded_file($_FILES['img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/images/prod/'.$img);
							$image = new SimpleImage();
							$image->load($_SERVER['DOCUMENT_ROOT'].'/images/prod/'.$img);
							$image->resizeToWidth(450);
							$image->save($_SERVER['DOCUMENT_ROOT'].'/images/prod/s'.$img);
						}
							
							
						$SQL = "INSERT INTO `".$table."` (`id`, `id_category`, `id_manufacturer`, `id_size`, `id_brand_strength`, `id_color`, `name`, `text`, `price`, `img`, `weight`, `count_pallet`, `status`, `url`, `enable`, `new`, `special`, `new_price`) VALUES (NULL, '".$_POST['id_category']."', '".$_POST['id_manufacturer']."', '".$_POST['id_size']."', '".$_POST['id_brand_strength']."', '".$_POST['id_color']."', '".mysql_real_escape_string($_POST['name'])."', '".mysql_real_escape_string($_POST['text'])."', '".(double)($_POST['price'])."', '".$img."', '".(double)($_POST['weight'])."', '".(double)($_POST['count_pallet'])."', '".$_POST['status']."', '".$url."', '1', '".(int)($_POST['new'])."', '".(int)($_POST['special'])."', '".(double)($_POST['new_price'])."');";
						$result = mysql_query($SQL);	
						if ($result){echo "<p>Данные добавлены</p>";}else{echo "<p>Ошибка при добавлении данных</p>";}
					}
					if (isset($_POST['edit_data']))
					{
						$img = "";
						if ($_POST['url'] == "") {
							$url = str2url($_POST['name']);
						} else {
							$url = $_POST['url'];
						}
						if (basename($_FILES['img']['name']) != '')
						{
							$path_info = pathinfo(basename($_FILES['img']['name']));
							$img = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
							move_uploaded_file($_FILES['img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/images/prod/'.$img);
							$image = new SimpleImage();
							$image->load($_SERVER['DOCUMENT_ROOT'].'/images/prod/'.$img);
							$image->resizeToWidth(450);
							$image->save($_SERVER['DOCUMENT_ROOT'].'/images/prod/s'.$img);
							$img = "`img`='".$img."', ";
						}
						
						$SQL = "UPDATE ".$table." SET
							".$img."
							`url`='".$url."', 
							`id_category`='".$_POST['id_category']."', 
							`id_manufacturer`='".$_POST['id_manufacturer']."', 
							`id_size`='".$_POST['id_size']."', 
							`id_brand_strength`='".$_POST['id_brand_strength']."', 
							`id_color`='".$_POST['id_color']."', 
							`status`='".$_POST['status']."', 
							`new`='".$_POST['new']."', 
							`special`='".$_POST['special']."', 
							`name`='".mysql_real_escape_string($_POST['name'])."', 
							`text`='".mysql_real_escape_string($_POST['text'])."',
							`price`='".(double)($_POST['price'])."', 
							`new_price`='".(double)($_POST['new_price'])."', 
							`weight`='".(double)($_POST['weight'])."', 
							`count_pallet`='".(double)($_POST['count_pallet'])."'
							WHERE `id`=".$_POST['edit_data'].";";
				
						$result = mysql_query($SQL);
						if ($result){echo "<p>Данные изменены</p>";}else{echo "<p>Ошибка при изменении данных</p>";}
						
					}
			$SQL = "SELECT `prod_vologda`.`id`, `prod_vologda`.`name`, `prod_vologda`.`img` FROM `".$table."`, `category` WHERE `category`.`id`=`prod_vologda`.`id_category` ".$search_str." ORDER BY `prod_vologda`.`id` DESC LIMIT ".$count_data.", 20";
			$result = mysql_query($SQL);
			
			$count = mysql_num_rows($result);
				?>
				
		<div class="btn-toolbar list-toolbar">
			<form action="/pn/<?echo $page_url;?>.php?price" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">				
						<div class="form-group">

						<?$result_ = mysql_query("SELECT * FROM `files` LIMIT 1");
						$file = mysql_fetch_array($result_);?>
						<p><?=$file['name']?></p>
						<input type="file" name="name" class="form-control" required>
						</div>
						<div class="btn-toolbar list-toolbar">
							<input type="submit" class="btn btn-primary" value="Загрузить каталог"> 
							<input type="button" class="btn btn-primary" value="Скачать каталог" onClick="loadCsv();"> 
							<button type="button" class="btn btn-primary" onClick="location.href='/pn/<?echo $page_url;?>.php?add'"><i class="fa fa-plus"></i> Добавить данные</button>
						</div>
					</div>
				</div>
			</form>
		  <div class="btn-group">
		  </div>
		</div>
		<div class="row">
			<div class="col-md-12">
			<form name="formSearch" id="formSearch" action="/pn/<?echo $page_url;?>.php" method="GET">
				<div class="form-group">
					<select style="width: 20%;float: left;margin-left: 10px;" name="id_category" class="form-control">
						<option value="">Все объекты</option>
						<?$result_cat = mysql_query("SELECT * FROM `category`");
						$count_cat = mysql_num_rows($result_cat);
						for ($i = 0; $i < $count_cat; ++$i) {
							$id = mysql_result($result_cat, $i, 'id');
							$name = mysql_result($result_cat, $i, 'name');?>
						<option <?if (isset($_GET["id_category"]) && $_GET["id_category"] == $id) {?>selected<?}?> value="<?=$id?>"><?=$name?></option>
						<?}?>
					</select>
					<input style="width: 20%;float: left;margin-left: 10px;" type="text" name="name" class="form-control" value="<?echo $_GET['name'];?>" placeholder="Свободный поиск"/>
				
					<button style="margin-left: 10px;" class="btn btn-default" type="submit">Поиск</button>
				</div>
			</form>
			</div>
		</div>
		<table class="table">
		  <thead>
			<tr>
				<th>#</th>
				<th>Картинка</th>
				<th>Название</th>
				<th style="width: 3.5em;"></th>
				<th style="width: 3.5em;"></th>
			</tr>
		  </thead>
		  <tbody>
		  
		  <?
				for ($i = 0; $i < $count; ++$i)
				{
					$id = mysql_result($result, $i, 'id');
					$name = mysql_result($result, $i, 'name');
					$img = mysql_result($result, $i, 'img');
		  ?>
		  
			<tr>
			  <td><?echo $id;?></td>
			  <td><img src="/images/prod/<?echo $img;?>" style="width: 150px;"></td>
			  <td><?echo $name;?></td>
			 
			  <td><a href="/pn/<?echo $page_url;?>.php?page=<?echo $page;?>&edit=<?echo $id;?><?if (isset($_GET["name"])) {echo "&id_category=".$_GET["id_category"]."&name=".$_GET["name"];}?>"><i class="fa fa-pencil"></i></a></td>
			  <td><a href="/pn/<?echo $page_url;?>.php?page=<?echo $page;?>&del=<?echo $id;?><?if (isset($_GET["name"])) {echo "&id_category=".$_GET["id_category"]."&name=".$_GET["name"];}?>"><i class="fa fa-trash-o"></i></a></td>
			  </td>
			</tr>
			<?}?>
		   </tbody>
		</table>

		<ul class="pagination">
		  <li><a href="/pn/<?echo $page_url;?>.php?page=<?if ($page > 0) {echo ($page-1);} else {echo '0';}?><?if (isset($_GET["name"])) {echo "&id_category=".$_GET["id_category"]."&name=".$_GET["name"];}?>">&laquo;</a></li>
		  <?
			for ($i = 0; $i < $count_page; ++$i)
			{
				?><li><a href="/pn/<?echo $page_url;?>.php?page=<?echo $i;?><?if (isset($_GET["name"])) {echo "&id_category=".$_GET["id_category"]."&name=".$_GET["name"];}?>"><?if ($i == $page) {echo "<b>".($i+1)."</b>";}else{echo ($i+1);}?></a></li>
			<?
			}
			?>
		  <li><a href="/pn/<?echo $page_url;?>.php?page=<?if ($page < ($count_page-1)) {echo ($page+1);} else {echo ($count_page-1);}?><?if (isset($_GET["name"])) {echo "&id_category=".$_GET["id_category"]."&name=".$_GET["name"];}?>">&raquo;</a></li>
		</ul>
		<?}
		}?>

		<script>
		function loadCsv(){
			$.ajax({
				url: "/pn/load_csv_vol.php", 
				type: "POST",       
				data: {},
				cache: false,			
				success: function(response){
					location.href = "/load/catalog-vologda.csv";
				}
			});
		}
	</script>	  
<?
	
	include $_SERVER['DOCUMENT_ROOT']."/pn/footer.html";
?>