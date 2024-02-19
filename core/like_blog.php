<?
	Header("Content-Type: text/html;charset=UTF-8");
	include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
	if (!isset($_COOKIE["article_like".$_POST['id']])) {
		$SQL = "SELECT * FROM `article` WHERE `id`=".$_POST['id']."";
		$result = mysql_query($SQL);
		$likes = mysql_result($result, 0, 'likes');
		$likes++;
		$result = mysql_query("UPDATE `article` SET `likes`=".$likes." WHERE `id`=".$_POST['id']."");
		setcookie("article_like".$_POST['id'], "1", time()+(3600 * 24 * 365), '/');
		echo $likes;
	}
?>