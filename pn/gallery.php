<?
	session_start();
	Header("Content-Type: text/html;charset=UTF-8");
	include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
	include $_SERVER['DOCUMENT_ROOT']."/pn/classSimpleImage.php";
	include $_SERVER['DOCUMENT_ROOT']."/pn/url_translit.php";
	$title = "Галерея";
	include $_SERVER['DOCUMENT_ROOT']."/pn/header.html";
	if (!isset($_SESSION["user_id"]))
	{
		?></br><p align="center"><font color="red">Вы не вошли под своим именем</font></p><?
		include $_SERVER['DOCUMENT_ROOT']."/pn/footer.html";
		exit;
	}
	$table = 'gallery';
	$page_url = 'gallery';
	$title_page = $title;
	if (!is_dir($_SERVER['DOCUMENT_ROOT']."/images/".$page_url)) {
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
	
	$SQL = "SELECT * FROM `".$table."`";
	$result = mysql_query($SQL);

	$count_base = mysql_num_rows($result);
	$count_page = ceil($count_base / 20);
	
?>

        <?
		if (isset($_GET['edit']))
		{
			include $_SERVER['DOCUMENT_ROOT']."/pn/editorFull.php";
			$SQL = "SELECT * FROM `".$table."` WHERE `id`=".$_GET['edit']."";
	
			$result = mysql_query($SQL);
			$id = mysql_result($result, 0, 'id');
			$name = mysql_result($result, 0, 'name');
			$imgs = explode("\n", trim(mysql_result($result, 0, 'imgs'), "\n"));
			$title = explode("\n", trim(mysql_result($result, 0, 'title'), "\n"));
			$text = mysql_result($result, 0, 'text');
			$email = mysql_result($result, 0, 'email');
			$tel = mysql_result($result, 0, 'tel');
			$status = mysql_result($result, 0, 'status');
			$category_id = mysql_result($result, 0, 'category_id');
			$city_id = mysql_result($result, 0, 'city_id');
			
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
		  <div class="col-md-12">
		
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane active in" id="home">
			  <form id="tab" action="/pn/<?echo $page_url;?>.php" method="post"  enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						<label>ФИО</label>
						<input type="text" value="<?echo $name;?>" name="name" class="form-control">
						</div>
						<div class="form-group">
						<label>Email</label>
						<input type="text" value="<?echo $email;?>" name="email" class="form-control">
						</div>
						<div class="form-group">
						<label>Телефон</label>
						<input type="text" value="<?echo $tel;?>" name="tel" class="form-control">
						</div>
						
						<div class="form-group">
						<label>Категория</label>
						<select name="category_id" class="form-control">
							<option value="0">Выберите категорию</option>
							<?
							$SQL = "SELECT * FROM `gallery_category` ";
							$result_cat = mysql_query($SQL);
							$count = mysql_num_rows($result_cat);
							for ($i = 0; $i < $count; ++$i)
							{
								$id_category = mysql_result($result_cat, $i, 'id');
								$name_category = mysql_result($result_cat, $i, 'name');
								?>
								<option <?if ($category_id == $id_category) {?>selected<?}?> value="<?echo $id_category;?>"><?echo $name_category;?></option>
								<?
							}
							?>	
						</select>
						</div>
						<div class="form-group">
							<label>Город</label>
							<select name="city_id" class="form-control">
								<?
								$SQL = "SELECT * FROM `city` ";
								$result_cat = mysql_query($SQL);
								$count = mysql_num_rows($result_cat);
								for ($i = 0; $i < $count; ++$i)
								{
									$id_city = mysql_result($result_cat, $i, 'id');
									$name_city = mysql_result($result_cat, $i, 'name');
									?>
									<option <?if ($city_id == $id_city) {?>selected<?}?> value="<?echo $id_city;?>"><?echo $name_city;?></option>
									<?
								}
								?>
							</select>
						</div>
						<div class="form-group">
						<label>Картинки</label>
							<p>
							 <?if ($imgs[0] != '') {
									for ($i = 0; $i < count($imgs); ++$i)
									{
										?><div id="imgs_<?echo $i;?>" class="img_edit_Element">
										<img  src="<?='/images/gallery/s'.basename($imgs[$i]);?>" width="70" >
										<a href="javascript:void(0)" onClick="delete_element_img('imgs','<?echo $id;?>','<?echo $i;?>')">Удалить</a>
										<input type="hidden" value="<?echo $title[$i];?>" name="title_<?=$i?>" placeholder="TITLE" class="form-control">
										</div><?
									}
								}?>
							</p>
							<input type="hidden" value="<?=count($imgs)?>" name="count_img" >
							<input type="file" value="" name="imgs[]" multiple class="form-control">
						</div>
						<div class="form-group">
						<label style="vertical-align:top;line-height:2.2;">Статус</label>
						<input type="checkbox" value="1" <?if ($status == '1') {?>checked<?}?>  name="status" class="" style="width:24px;height:24px;">
						</div>
					
						<div class="form-group">
						<label>Текст</label>
						<textarea name="text" class="form-control"><?echo $text;?></textarea>
						</div>
					</div>
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
					include $_SERVER['DOCUMENT_ROOT']."/pn/editorFull.php";
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
		  <div class="col-md-12">
		
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane active in" id="home">
			  <form id="tab" action="/pn/<?echo $page_url;?>.php" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						<label>ФИО</label>
						<input type="text" value="" name="name" class="form-control">
						</div>
						<div class="form-group">
						<label>Email</label>
						<input type="text" value="" name="email" class="form-control">
						</div>
						<div class="form-group">
						<label>Телефон</label>
						<input type="text" value="" name="tel" class="form-control">
						</div>
						
						<div class="form-group">
						<label>Категория</label>
						<select name="category_id" class="form-control">
							<option value="0">Выберите категорию</option>
							<?
							$SQL = "SELECT * FROM `gallery_category` ";
							$result_cat = mysql_query($SQL);
							$count = mysql_num_rows($result_cat);
							for ($i = 0; $i < $count; ++$i)
							{
								$id_category = mysql_result($result_cat, $i, 'id');
								$name_category = mysql_result($result_cat, $i, 'name');
								?>
								<option value="<?echo $id_category;?>"><?echo $name_category;?></option>
								<?
							}
							?>	
						</select>
						</div>
						<div class="form-group">
							<label>Город</label>
							<select name="city_id" class="form-control">
								<?
								$SQL = "SELECT * FROM `city` ";
								$result_cat = mysql_query($SQL);
								$count = mysql_num_rows($result_cat);
								for ($i = 0; $i < $count; ++$i)
								{
									$id_city = mysql_result($result_cat, $i, 'id');
									$name_city = mysql_result($result_cat, $i, 'name');
									?>
									<option value="<?echo $id_city;?>"><?echo $name_city;?></option>
									<?
								}
								?>
							</select>
						</div>
						<div class="form-group">
						<label>Картинки</label>
							<input type="file" value="" name="imgs[]" multiple class="form-control">
						</div>
						<div class="form-group">
						<label style="vertical-align:top;line-height:2.2;">Статус</label>
						<input type="checkbox" value="1"   name="status" class="" style="width:24px;height:24px;">
						</div>
					
						<div class="form-group">
						<label>Текст</label>
						<textarea name="text" class="form-control"><?echo $text;?></textarea>
						</div>
					</div>
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
						$imgs = '';
						if(count($_FILES['imgs'])) { 
							foreach ($_FILES['imgs']['name'] as $key => $value) {
								if ($value != '') {
									$path_info = pathinfo(basename($value));
									$upload_file = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
									move_uploaded_file($_FILES['imgs']['tmp_name'][$key], $_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
									$imgs = $imgs.$upload_file."\n";
									$image = new SimpleImage();
									$image->load($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
									$image->resizeToHeight(1024);
									$image->save($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
									$image = new SimpleImage();
									$image->load($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
									$image->resizeToWidth(500);
									$image->save($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/s'.$upload_file);
								}
							}
						}
						$SQL = "INSERT INTO ".$table."(
						`id` , 
						`name`,
						`email`,
						`tel`,
						`imgs`,
						`title`,
						`text`,
						`status`,
						`category_id`,
						`city_id`
						)
						VALUES (
						NULL ,  '".mysql_real_escape_string($_POST['name'])."',  '".mysql_real_escape_string($_POST['email'])."', '".mysql_real_escape_string($_POST['tel'])."', '".$imgs."', '', '".mysql_real_escape_string($_POST['text'])."', '".mysql_real_escape_string($_POST['status'])."', '".mysql_real_escape_string($_POST['category_id'])."', '".mysql_real_escape_string($_POST['city_id'])."'
						);";
						
						$result = mysql_query($SQL);
						if ($result)
						{
							echo "<p>Данные добавлены</p>";
						}
						else
						{
							echo "<p>Ошибка при добавлении данных</p>";
						}
					}
					if (isset($_POST['edit_data']))
					{
						$result = mysql_query("SELECT * FROM `".$table."` WHERE `id`=".$_POST['edit_data']."");
						$imgs = mysql_result($result, 0, 'imgs');
						if(count($_FILES['imgs'])) { 
							foreach ($_FILES['imgs']['name'] as $key => $value) {
								if ($value != '') {
									$path_info = pathinfo(basename($value));
									$upload_file = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
									move_uploaded_file($_FILES['imgs']['tmp_name'][$key], $_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
									$imgs = $imgs.$upload_file."\n";
									$image = new SimpleImage();
									$image->load($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
									$image->resizeToHeight(3000);
									$image->save($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
									$image = new SimpleImage();
									$image->load($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
									$image->resizeToWidth(500);
									$image->save($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/s'.$upload_file);
									
								}
							}
						}
						$title = "";
						for ($i = 0; $i < $_POST['count_img']; ++$i) {
							$title .= $_POST['title_'.$i]."\n";
						}
					
						$SQL = "UPDATE ".$table." SET
						`category_id`='".$_POST['category_id']."',
						`city_id`='".$_POST['city_id']."',
						`title`='".$title."',
						`imgs`='".$imgs."',
						`email`='".mysql_real_escape_string($_POST['email'])."', 
						`tel`='".mysql_real_escape_string($_POST['tel'])."',
						`status`='".mysql_real_escape_string($_POST['status'])."',
						`name`='".mysql_real_escape_string($_POST['name'])."',
						`text`='".mysql_real_escape_string($_POST['text'])."'
						WHERE `id`=".$_POST['edit_data'].";";
				
						$result = mysql_query($SQL);
						if ($result)
						{
							echo "<p>Данные изменены</p>";
						}
						else
						{
							echo "<p>Ошибка при изменении данных</p>";
						}
					}
			$SQL = "SELECT * FROM `".$table."` ORDER BY `id` DESC LIMIT ".$count_data.", 20";
			$result = mysql_query($SQL);

			$count = mysql_num_rows($result);
				?>
				
		<div class="btn-toolbar list-toolbar">
			<button class="btn btn-primary" onClick="location.href='/pn/<?echo $page_url;?>.php?add'"><i class="fa fa-plus"></i> Добавить данные</button>
		  <div class="btn-group">
		  </div>
		</div>
		<table class="table">
		  <thead>
			<tr>
			  <th>#</th>
			  <th>Название</th>
			  <th>Картинка</th>
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
					$imgs = explode("\n", mysql_result($result, $i, 'imgs'));
		  ?>
		  
			<tr>
			  <td><?echo $id;?></td>
			  <td><?echo $name;?></td>
			  <td><?if ($imgs[0] != ""){?><img src="/images/gallery/<?echo $imgs[0];?>" width="300" alt="<?=$name?>" /><?}?></td>
	
			  <td>
				  <a href="/pn/<?echo $page_url;?>.php?edit=<?echo $id;?>"><i class="fa fa-pencil"></i></a>
			  </td>
			  <td>
				  <a href="/pn/<?echo $page_url;?>.php?page=<?echo $page;?>&del=<?echo $id;?>"><i class="fa fa-trash-o"></i></a>
			  </td>
			</tr>
			<?}?>
		   </tbody>
		</table>

		<ul class="pagination">
		  <li><a href="/pn/<?echo $page_url;?>.php?page=<?if ($page > 0) {echo ($page-1);} else {echo '0';}?>">&laquo;</a></li>
		  <?
			for ($i = 0; $i < $count_page; ++$i)
			{
				?><li><a href="/pn/<?echo $page_url;?>.php?page=<?echo $i;?>"><?if ($i == $page) {echo "<b>".($i+1)."</b>";}else{echo ($i+1);}?></a></li>
			<?
			}
			?>
		  <li><a href="/pn/<?echo $page_url;?>.php?page=<?if ($page < ($count_page-1)) {echo ($page+1);} else {echo ($count_page-1);}?>">&raquo;</a></li>
		</ul>
		<?}
		}?>

	  
<?
	
	include $_SERVER['DOCUMENT_ROOT']."/pn/footer.html";
?>