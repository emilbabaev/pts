<?

	session_start();
	Header("Content-Type: text/html;charset=UTF-8");
	
	if (isset($_SESSION["user_id"]))
	{
		session_destroy();
		?><script> location.href="/pn/sign-in.php" </script><?
	}

?>
