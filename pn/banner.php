<?
	session_start();
	Header("Content-Type: text/html;charset=UTF-8");
	include $_SERVER['DOCUMENT_ROOT']."/pn/classSimpleImage.php";		
	include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
	$title = "Баннер";
	include $_SERVER['DOCUMENT_ROOT']."/pn/header.html";
	if (!isset($_SESSION["user_id"]))
	{
		?></br><p align="center"><font color="red">Вы не вошли под своим именем</font></p><?
		include $_SERVER['DOCUMENT_ROOT']."/pn/footer.html";
		exit;
	}
	$table = 'banner';
	$page_url = 'banner';
	$title_page = $title;
		
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
	
	$SQL = "SELECT * FROM `".$table."`";
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
			$date = mysql_result($result, 0, 'date');
			$img = mysql_result($result, 0, 'img');
			$url = mysql_result($result, 0, 'url');
			$text = mysql_result($result, 0, 'text');
			$type = mysql_result($result, 0, 'type');
			$mutator = mysql_result($result, 0, 'mutator');
			$reg_pokaz = mysql_result($result, 0, 'reg_pokaz');
			
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
		  <div class="col-md-4">
		
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane active in" id="home">
			  <form id="tab" action="/pn/<?echo $page_url;?>.php" method="post"  enctype="multipart/form-data">
				<div class="form-group">
				<label>Название</label>
				<input type="text" value="<?echo $name;?>" name="name" class="form-control">
				</div>
				<div class="form-group">
				<label>Тип</label>
				<select name="type"  class="form-control">
					<option <?if ($type == 0) {?>selected<?}?> value="0">1 слайдер</option>
					<option <?if ($type == 1) {?>selected<?}?> value="1">2 слайдер</option>
				</select>
				</div>
				<div class="form-group">
				<label>Ссылка</label>
				<input type="text" value="<?echo $url;?>" name="url" class="form-control">
				</div>
				<div class="form-group">
				<label>Картинка</label>
				<p><img src="/images/banner/<?echo $img;?>" width="300px;"></p>
				<input type="file" name="img" class="form-control">
				</div>
				<div class="form-group" >
				<label>Текст</label>
				<textarea type="text" name="text" class="form-control"><?echo $text;?></textarea>
				</div>
				<div class="form-group">
				<label>Мутатор</label>
				<input type="text" value="<?echo $mutator;?>" name="mutator" class="form-control">
				</div>
				<div class="form-group">
				<label>Регион показа (1-Чер,2-Вол,0-Везде)</label>
				<input type="text" value="<?echo $reg_pokaz;?>" name="reg_pokaz" class="form-control">
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
			<?
			
		}
		else
		{
				if (isset($_GET['add']))
				{
					//include $_SERVER['DOCUMENT_ROOT']."/pn/editor.php";
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
		  <div class="col-md-4">
		
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane active in" id="home">
			  <form id="tab" action="/pn/<?echo $page_url;?>.php" method="post" enctype="multipart/form-data">
						<div class="form-group">
				<label>Название</label>
				<input type="text" value="<?echo $name;?>" name="name" class="form-control">
				</div>
				<div class="form-group">
				<label>Тип</label>
				<select name="type"  class="form-control">
					<option value="0">1 слайдер</option>
					<option value="1">2 слайдер</option>
				</select>
				</div>
				<div class="form-group">
				<label>Ссылка</label>
				<input type="text" value="<?echo $url;?>" name="url" class="form-control">
				</div>
				<div class="form-group">
				<label>Картинка</label>
				<input type="file" name="img" class="form-control">
				</div>
				<div class="form-group" >
				<label>Текст</label>
				<textarea type="text" name="text" class="form-control"><?echo $text;?></textarea>
				</div>
				<div class="form-group">
				<label>Мутатор</label>
				<input type="text" value="<?echo $mutator;?>" name="mutator" class="form-control">
				</div>
				<div class="form-group">
				<label>Регион показа (1-Чер,2-Вол)</label>
				<input type="text" value="<?echo $reg_pokaz;?>" name="reg_pokaz" class="form-control">
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
						$img = '';
						if (basename($_FILES['img']['name']) != '')
						{
							$path_info = pathinfo(basename($_FILES['img']['name']));
							$img = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
							move_uploaded_file($_FILES['img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$img);	
						}
						
						$SQL = "INSERT INTO `".$table."`(
						`id` , 
						`name` ,
						`text` ,
						`url`,
						`img`,
						`type`,
						`mutator`,
						`reg_pokaz`
						)
						VALUES (
						NULL ,  '".mysql_real_escape_string($_POST['name'])."', '".mysql_real_escape_string($_POST['text'])."', '".mysql_real_escape_string($_POST['url'])."', '".$img."', '".mysql_real_escape_string($_POST['type'])."', '".mysql_real_escape_string($_POST['mutator'])."', '".mysql_real_escape_string($_POST['reg_pokaz'])."');";
					
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
						$img = '';
						if (basename($_FILES['img']['name']) != '')
						{
							$path_info = pathinfo(basename($_FILES['img']['name']));
							$img = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
							move_uploaded_file($_FILES['img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$img);
							$img = "`img`='".$img."', ";
						}
						
						$SQL = "UPDATE ".$table." SET
						".$img."
						`name`= '".mysql_real_escape_string($_POST['name'])."',
						`url`= '".mysql_real_escape_string($_POST['url'])."',
						`type`= '".mysql_real_escape_string($_POST['type'])."',
						`text`= '".mysql_real_escape_string($_POST['text'])."',
						`mutator`= '".mysql_real_escape_string($_POST['mutator'])."',
						`reg_pokaz`= '".mysql_real_escape_string($_POST['reg_pokaz'])."'
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
					$img = mysql_result($result, $i, 'img');		
		  ?>
		  
			<tr>
			  <td><?echo $id;?></td>
			  <td><?echo $name;?></td>
			  <td><img src="/images/banner/<?echo $img;?>" style="width: 150px;"></td>

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