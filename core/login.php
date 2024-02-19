<?
session_start();
Header("Content-Type: text/html;charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
function generate_password($number)	{
	$arr = array('a','b','c','d','e','f',
				 'g','h','i','j','k','l',
				 'm','n','o','p','r','s',
				 't','u','v','x','y','z',
				 'A','B','C','D','E','F',
				 'G','H','I','J','K','L',
				 'M','N','O','P','R','S',
				 'T','U','V','X','Y','Z',
				 '1','2','3','4','5','6',
				 '7','8','9','0');
	$pass = "";
	for($i = 0; $i < $number; $i++)
	{
	  $index = rand(0, count($arr) - 1);
	  $pass .= $arr[$index];
	}
	return $pass;
}
if (isset($_POST["login"]) && isset($_POST["pass"])) {
	$result = mysql_query("SELECT * FROM `users` WHERE `login`='".$_POST['login']."' and `pass`='".md5($_POST['pass'])."'");
	if(mysql_num_rows($result) > 0){
		$token = md5(generate_password(8));
		$id = mysql_result($result, 0, "id");
		mysql_query("UPDATE `users` SET `token`='".$token."', `date_enter`='".date("Y-m-d H:i:s")."' WHERE `id`=".$id."");
		$_SESSION["user"] = $id;
		$_SESSION["token"] = $token;
		setcookie("user", $id, time()+3600 + 3600*24*360, '/');
		setcookie("token", $token, time()+3600 + 3600*24*360 , '/');
	} else {
		echo "Логин и/или пароль введены не верно";
	}
} else {
	echo "Ошибка при авторизации";
}
?>