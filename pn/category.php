<?
	session_start();
	Header("Content-Type: text/html;charset=UTF-8");
	include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
	include $_SERVER['DOCUMENT_ROOT']."/pn/classSimpleImage.php";
	include $_SERVER['DOCUMENT_ROOT']."/pn/url_translit.php";
	$title = "Категории";
	include $_SERVER['DOCUMENT_ROOT']."/pn/header.html";
	if (!isset($_SESSION["user_id"]))
	{
		?></br><p align="center"><font color="red">Вы не вошли под своим именем</font></p><?
		include $_SERVER['DOCUMENT_ROOT']."/pn/footer.html";
		exit;
	}
	$table = 'category';
	$page_url = 'category';
	$title_page = $title;
	if (!is_dir($_SERVER['DOCUMENT_ROOT']."/images/".$page_url)) {
		mkdir($_SERVER['DOCUMENT_ROOT']."/images/".$page_url, 0777);
	}
if (isset($_GET['del'])) {
    $sql = "DELETE FROM `" . $table . "` WHERE `id` = " . $_GET['del'] . "";
    mysqli_query($link, $sql); // Используйте $link вместо $sql
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

$SQL = "SELECT * FROM `" . $table . "`";
$result = mysqli_query($link, $SQL);

$count_base = mysqli_num_rows($result);
$count_page = ceil($count_base / 20);
	
?>
<?php
       if (isset($_GET['edit']))
{
    include $_SERVER['DOCUMENT_ROOT'] . "/pn/editorFull.php";
    $SQL = "SELECT * FROM `" . $table . "` WHERE `id`=" . $_GET['edit'] . "";

$result = mysqli_query($link, $SQL); // Используйте $link вместо $SQL
mysqli_data_seek($result, 0);
$row = mysqli_fetch_assoc($result);

$id = $row['id'];
$name = $row['name'];
$img =$row['img'];
$img_hover = $row['img_hover'];
$text = $row['text'];
$parentId =$row['parentId'];
$title = $row['title'];
$description = $row['$description'];
$keywords =$row['keywords'];
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
						<label>Название</label>
						<input type="text" value="<?echo $name;?>" name="name" class="form-control">
						</div>
						<div class="form-group">
						<label>Заголовок</label>
						<input type="text" value="<?echo $title;?>" name="title" class="form-control">
						</div>
						<div class="form-group">
						<label>Описание</label>
						<input type="text" value="<?echo $description;?>" name="description" class="form-control">
						</div>
						<div class="form-group">
						<label>Ключевые слова</label>
						<input type="text" value="<?echo $keywords;?>" name="keywords" class="form-control">
						</div>
						<div class="form-group">
						<label>Категория</label>
						<select name="parentId" class="form-control">
							<option <?if ($parentId == '0') {?>selected<?}?> value="0">Главная категория</option>
							<?
							$SQL = "SELECT * FROM `".$table."` WHERE `parentId`=0";
							$result_cat = mysqli_query($SQL);
							$count = mysqli_num_rows($result_cat);
							for ($i = 0; $i < $count; ++$i)
							{
								$id_category = mysqli_result($result_cat, $i, 'id');
								$name_category = mysqli_result($result_cat, $i, 'name');
								?>
								<option <?if ($parentId == $id_category) {?>selected<?}?> value="<?echo $id_category;?>"><?echo $name_category;?></option>
								<?
							}
							?>	
						</select>
						</div>
						<div class="form-group">
						<label>Картинка</label>
						<p><img src="/images/category/<?echo $img;?>" width="300px;"></p>
						<input type="file" name="img" class="form-control">
						</div>
						<div class="form-group">
						<label>Картинка при наведении</label>
						<p><img src="/images/category/<?echo $img_hover;?>" width="300px;"></p>
						<input type="file" name="img_hover" class="form-control">
						</div>
					</div>
				</div>
				<div class="form-group">
				<label>Описание</label>
				<textarea name="text" class="form-control mceEditor"><?echo $text;?></textarea>
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
						<label>Название</label>
						<input type="text" value="<?echo $name;?>" name="name" class="form-control">
						</div>
						<div class="form-group">
						<label>Заголовок</label>
						<input type="text" value="" name="title" class="form-control">
						</div>
						<div class="form-group">
						<label>Описание</label>
						<input type="text" value="<?echo $description;?>" name="description" class="form-control">
						</div>
						<div class="form-group">
						<label>Ключевые слова</label>
						<input type="text" value="<?echo $keywords;?>" name="keywords" class="form-control">
						</div>
						<div class="form-group">
						<label>Категория</label>
						<select name="parentId" class="form-control">
							<option value="0">Главная категория</option>
							<?
							$SQL = "SELECT * FROM `".$table."` WHERE `parentId`=0";
							$result_cat = mysqli_query($SQL);
							$count = mysqli_num_rows($result_cat);
							for ($i = 0; $i < $count; ++$i)
							{
								$id_category = mysqli_result($result_cat, $i, 'id');
								$name_category = mysqli_result($result_cat, $i, 'name');
								?>
								<option value="<?echo $id_category;?>"><?echo $name_category;?></option>
								<?
							}
							?>	
						</select>
						</div>
						<div class="form-group">
						<label>Картинка</label>
						<input type="file" name="img" class="form-control">
						</div>
						<div class="form-group">
						<label>Картинка при наведении</label>
						<input type="file" name="img_hover" class="form-control">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Описание</label>
					<textarea name="text" class="form-control mceEditor"><?echo $text;?></textarea>
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
				
				<?if (isset($_POST['add_data']))
                {
                    $url = str2url($_POST['name']);
                    $img = '';
                    if (basename($_FILES['img']['name']) != '')
                    {
                        $path_info = pathinfo(basename($_FILES['img']['name']));
                        $img = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
                        move_uploaded_file($_FILES['img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$img);
                    }
                    $img_hover = '';
                    if (basename($_FILES['img_hover']['name']) != '')
                    {
                        $path_info = pathinfo(basename($_FILES['img_hover']['name']));
                        $img_hover = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
                        move_uploaded_file($_FILES['img_hover']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$img_hover);
                    }
                    $SQL = "INSERT INTO ".$table."(
    `id` ,
    `name`,
    `parentId`,
    `img`,
    `img_hover`,
    `url`,
    `text`,
    `title`,
    `description`,
    `keywords`
    )
    VALUES (
    NULL ,  '".mysqli_real_escape_string($link, $_POST['name'])."',  '".$_POST['parentId']."', '".$img."', '".$img_hover."', '".$url."',  '".mysqli_real_escape_string($link, $_POST['text'])."', '".mysqli_real_escape_string($link, $_POST['title'])."', '".mysqli_real_escape_string($link, $_POST['description'])."', '".mysqli_real_escape_string($link, $_POST['keywords'])."'
    );";
                    
                    $result = mysqli_query($link, $SQL); // Используйте $link вместо $SQL
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
                    $url = str2url($_POST['name']);
                    $img = '';
                    if (basename($_FILES['img']['name']) != '')
                    {
                        $path_info = pathinfo(basename($_FILES['img']['name']));
                        $img = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
                        move_uploaded_file($_FILES['img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$img);
                        $img = "`img`='".$img."', ";
                    }
                    $img_hover = '';
                    if (basename($_FILES['img_hover']['name']) != '')
                    {
                        $path_info = pathinfo(basename($_FILES['img_hover']['name']));
                        $img_hover = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
                        move_uploaded_file($_FILES['img_hover']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$img_hover);
                        $img_hover = "`img_hover`='".$img_hover."', ";
                    }
                    $SQL = "UPDATE ".$table." SET
    ".$img."".$img_hover."
    `parentId`='".$_POST['parentId']."',
    `url`='".$url."',
    `title`='".mysqli_real_escape_string($link, $_POST['title'])."',
    `description`='".mysqli_real_escape_string($link, $_POST['description'])."',
    `keywords`='".mysqli_real_escape_string($link, $_POST['keywords'])."',
    `name`='".mysqli_real_escape_string($link, $_POST['name'])."',
    `text`='".mysqli_real_escape_string($link, $_POST['text'])."'
    WHERE `id`=".$_POST['edit_data'].";";
                    
                    $result = mysqli_query($link, $SQL); // Используйте $link вместо $SQL
                    if ($result)
                    {
                        echo "<p>Данные изменены</p>";
                    }
                    else
                    {
                        echo "<p>Ошибка при изменении данных</p>";
                    }
                }
                $SQL = "SELECT * FROM `" . $table . "` ORDER BY `id` DESC LIMIT " . $count_data . ", 20";
                $result = mysqli_query($link, $SQL); // Используйте $link вместо $SQL
                
                $count = mysqli_num_rows($result);
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
          for ($i = 0; $i < $count; ++$i) {
              mysqli_data_seek($result, $i);
              $row = mysqli_fetch_assoc($result);
              $id = $row['id'];
              $name = $row['name'];
              $img = $row['img'];
		  ?>
		  
			<tr>
			  <td><?echo $id;?></td>
			  <td><?echo $name;?></td>
			  <td><?if ($img != ""){?><img src="/images/category/<?echo $img;?>" width="300" alt="<?=$name?>" /><?}?></td>
	
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