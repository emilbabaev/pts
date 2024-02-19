<?
	session_start();
	Header("Content-Type: text/html;charset=UTF-8");
	$title = "Панель администратора";
	include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
	include $_SERVER['DOCUMENT_ROOT']."/pn/header.html";
	if (!isset($_SESSION["user_id"]))
	{
		?><script>location.href = "/pn/sign-in.php";</script><?
	}
	
	
	
	?>
	
						<div class="main-content">
						<?
						
						if (isset($_POST['log_change']))
						{
							$SQL = "SELECT * FROM `admin` WHERE name='".$_POST['name_old']."' and pass='".md5($_POST['pass_old'])."'";
							$result = mysql_query($SQL);
							$count = mysql_num_rows($result);
							if ($count > 0)
							{
								$SQL = "UPDATE `admin` SET
											`name`='".$_POST['name_new']."',
											`pass`='".md5($_POST['pass_new'])."'
											WHERE `id`=".$_SESSION["user_id"].";";
											$result = mysql_query($SQL);
											if ($result)
											{
												?><p>Логин и пароль администратора изменены</p><?
											}
											else
											{
												?><p>Логин и пароль администратора не изменены</p><?
											}
							}
							else	
							{
								?><p>Логин или пароль не совпадают</p><?
							}

						}
					?>								
								
						<div class="row" >
						  <div class="col-md-6" style="    display: none;">
							
							<h3 class="page-title">Изменить данные для входа</h3>	
								<div class="panel panel-default">
									<div class="panel-heading">Администратор</div>
									<div class="panel-body">
							
							
							
							<div id="myTabContent" class="tab-content">
							  <div class="tab-pane active in" id="home">
							  <form id="tab" action="/pn/" method="post">
								<div class="form-group">
								<label>Текущий логин</label>
								<input type="text" value="" name="name_old" class="form-control">
								</div>
								<div class="form-group">
								<label>Новый логин</label>
								<input type="text" value="" name="name_new" class="form-control">
								</div>
								<div class="form-group">
								<label>Текущий пароль</label>
									 <input type="password" value="" name="pass_old" class="form-control">
								</div>
								
								<div class="form-group">
								<label>Новый пароль</label>
									 <input type="password" value="" name="pass_new" class="form-control">
								</div>
							  </div>
							</div>

							<div class="btn-toolbar list-toolbar">
							  <input type="submit" class="btn btn-primary" value="Изменить">
							  <a href="/pn/" class="btn btn-danger">Отмена</a>
							  <input type="hidden" name="log_change">
							  
							   </form>
							</div>
						  </div>
						</div>

									</div>
								</div>

			

  
<?
	include $_SERVER['DOCUMENT_ROOT']."/pn/footer.html";
?>