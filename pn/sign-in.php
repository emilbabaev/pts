<?

	session_start();
	Header("Content-Type: text/html;charset=UTF-8");
	
	if (isset($_SESSION["user_id"]))
	{
		?><script> location.href="/pn/" </script><?
	}
	$title = "Авторизация";
	$sign_in = '';
	include $_SERVER['DOCUMENT_ROOT']."/pn/header.html";

if (isset($_POST['name']))
{
    include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
    $SQL = "SELECT * FROM `admin` WHERE `name`='".$_POST['name']."' and `pass`='".md5($_POST['pass'])."'";
    $result = db_query($link, $SQL); // Используйте $link вместо $SQL
    $count = mysqli_num_rows($result);
    
    if ($count > 0)
    {
        mysqli_data_seek($result, 0);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        $_SESSION["user_id"] = $id;
        ?><script> location.href="/pn/" </script><?
    }
    
    else
		{
			$sign_in = '<font color="red"> (Логин или пароль введены не верно)</font>';
		}
	}

?>
    
</div>

    <div class="dialog">
    <div class="panel panel-default">
        <p class="panel-heading no-collapse">Войти<?echo $sign_in;?></p>
        <div class="panel-body">
            <form action="/pn/sign-in.php" method="post">
                <div class="form-group">
                    <label>Имя</label>
                    <input type="text" name="name" class="form-control span12">
                </div>
                <div class="form-group">
                <label>Пароль</label>
                    <input type="password" name="pass" class="form-controlspan12 form-control">
                </div>
                <input type="submit" class="btn btn-primary pull-right" value="Войти">
                
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
    <p class="pull-right">Панель управления разработана в компании <a href="http://wbest.ru/" target="_blank">Webest</a></p>
   
</div>


    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  
</body></html>