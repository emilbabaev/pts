<?
	session_start();
	Header("Content-Type: text/html;charset=UTF-8");
	include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
	$title = "Заказы";
	include $_SERVER['DOCUMENT_ROOT']."/pn/header.html";
	if (!isset($_SESSION["user_id"]))
	{
		?></br><p align="center"><font color="red">Вы не вошли под своим именем</font></p><?
		include $_SERVER['DOCUMENT_ROOT']."/pn/footer.html";
		exit;
	}
	$table = 'order';
	$page_url = 'order';
	$title_page = $title;
	
	
	if (isset($_GET['del']))
	{
			$sql = "DELETE FROM `".$table."` WHERE `id` = ".$_GET['del']."";
			mysql_query($sql);
	}
	if (isset($_GET['status']))
	{
			$sql = "UPDATE `".$table."` SET `status`=1 WHERE `id` = ".$_GET['status']."";
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

      
						<div class="header">
					
					<h1 class="page-title"><?echo $title_page;?></h1>
							<ul class="breadcrumb">
					<li><a href="/pn/">Главная</a> </li>
					<li class="active"><?echo $title_page;?></li>
				</ul>

				</div>
				<div class="main-content">
				
				<?
				
					
			$SQL = "SELECT `order`.`fio`, `order`.`tel`, `order`.`email`, `order`.`about`, `order`.`id`, `order`.`sum`, `order`.`date` FROM `".$table."` ORDER BY `id` DESC LIMIT ".$count_data.", 20";
			$result = mysql_query($SQL);
			$count = mysql_num_rows($result);
				?>
	
		<table class="table">
		  <thead>
			<tr>
			  <th>#</th>
			  <th>Иформация о заказчике</th>
			  <th>Заказ</th>
			  <th class="text-center">Дата заказа</th>
		
			  <th style="width: 3.5em;"></th>
			</tr>
		  </thead>
		  <tbody>
		  
		  <?
				for ($i = 0; $i < $count; ++$i)
				{
					$id = mysql_result($result, $i, 'id');
					$name = mysql_result($result, $i, 'fio');
					$email = mysql_result($result, $i, 'email');
					$tel = mysql_result($result, $i, 'tel');
					$about = mysql_result($result, $i, 'about');
					$sum = mysql_result($result, $i, 'sum');
					$date = mysql_result($result, $i, 'date');
					
		  ?>
		  
			<tr>
			  <td><?echo $id;?></td>
			  <td><?echo $name."<br>".$tel."<br>".$email;?></td>
			  <td><?
				$res = mysql_query("SELECT * FROM `order_prod`, `prod` WHERE `order_prod`.`id_prod`=`prod`.`id` and `order_prod`.`id_order`=".$id."");
				$count_p = mysql_num_rows($res);
				if ($count_p > 0) {
					?><table class="table-inside"><tr><th>Название</th><th class="text-center">Кол-во</th><th class="text-center">Цена (р.)</th><th class="text-center">Сумма (р.)</th></tr><?
					for ($j = 0; $j < $count_p; ++$j)
					{
						$name_prod = mysql_result($res, $j, 'name');
						$count_prod = mysql_result($res, $j, 'count');
						$price_prod = mysql_result($res, $j, 'price');
						$sum_prod = (int)$count_prod * (double)$price_prod;
						?>
						<tr><td><?echo $name_prod;?></td><td class="text-center"><?echo $count_prod;?></td><td class="text-center"><?echo $price_prod;?></td><td class="text-center"><?echo $sum_prod;?></td></tr>
						<?
					}
					?></table><?
				}
				echo "<p>Общая сумма: ".$sum."</p>";

			  ?></td>
			 
			  <td class="text-center"><?echo $date;?></td>
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


	  
<?
	
	include $_SERVER['DOCUMENT_ROOT']."/pn/footer.html";
?>