<?
	session_start();
	Header("Content-Type: text/html;charset=UTF-8");
	include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";

	$id = $_POST['id'];
	$img = $_POST['img'];
	$table = $_POST['table'];
	$number = $_POST['number'];
	
		$foto_text = "";
		$SQL = "SELECT * FROM `".$table."` WHERE `id`=".$id."";
		$result = mysql_query($SQL);
		$foto = explode("\n", mysql_result($result, 0, $img));
		$j = 0;
		if ($foto[0] != ''){
			for ($i = 0; $i < count($foto) - 1; ++$i)
			{
				if ($i != $number)
				{
						$foto_text = $foto_text."".$foto[$i]."\n"; 
				}
			}
		}

		$sql = "
		UPDATE `".$table."` SET
		`".$img."` =  '".$foto_text."'	
		WHERE  `".$table."`.`id` =".$id."";
		mysql_query($sql);
?>