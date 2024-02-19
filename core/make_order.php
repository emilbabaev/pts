<?
session_start();
Header("Content-Type: text/html;charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
if (isset($_COOKIE["prod"])) {
	mysql_query("INSERT INTO `order` (`id`, `fio`, `tel`, `email`, `pay`, `addr`, `delivery`, `date`, `about`) VALUES 
	(NULL, '".mysql_real_escape_string($_POST['name'])."', '".mysql_real_escape_string($_POST['tel'])."', '".mysql_real_escape_string($_POST['email'])."', '', '', '', '".date("Y-m-d")."', '".mysql_real_escape_string($_POST['text'])."');");	
	$SQL = "SELECT MAX(`id`) as `max_id` FROM `order`";
	$result = mysql_query($SQL);
	$id_order = mysql_result($result, 0, 'max_id');
	$theme = "Заказ товара";
	$subject = "Заказ товара";
	$text = "<table><thead><tr><th style=padding:5px;>Название:</th><th style=padding:5px;>Кол-во:</th><th style=padding:5px;>Цена:</th><th style=padding:5px;>Стоимость:</th></tr></thead><tbody>";
	$myProd = explode('#', $_COOKIE["prod"]);
	$prod = "";
	$sum = 0;
	if (count($myProd) > 0) {
		for ($i = 0; $i < count($myProd); ++$i) {
			$temp = explode(',',$myProd[$i]);
			$myId = $temp[0];
			$myColor = $temp[1];
			$myCount = $temp[2];
			$myStatus = $temp[3];
			if ($myStatus == 0) {
				$result_prod = mysql_query("SELECT * FROM `prod` WHERE `id`='".$myId."'");
				$id = mysql_result($result_prod, 0, 'id');
				$name = mysql_result($result_prod, 0, 'name');
				$price = mysql_result($result_prod, 0, 'price');
				$sum += (double)$price*(double)$myCount;
				$text = $text."<tr><td style=padding:5px;>".$name." </td><td style=padding:5px;text-align:center;>".$myCount." </td><td style=padding:5px;text-align:center;>".$price." р.</td><td style=padding:5px;text-align:center;>".(double)$price*(double)$myCount." р.</td></tr>";	
				mysql_query("INSERT INTO `order_prod` (`id_prod`, `id_order`, `count`) VALUES('".$id."', '".$id_order."', '".$myCount."')");
			}
		}
		setcookie ("prod", "", time() - 3600,'/');
	}
	$text = $text."</tbody></table><p>Общая стоимость: ".$sum."</p>";
	mysql_query("UPDATE `order` SET `sum`='".$sum."' WHERE `id`=".$id_order."");
	
	$message = '
	<html>
			<head>
				<title>'.$subject.'</title>
			</head>
			<body>
					<p>'.$theme.'</p>
					<p>Имя: '.$_POST['name'].'</p>
					<p>Телефон: '.$_POST['tel'].'</p>
					<p>E-Mail: '.$_POST['email'].'</p>
					<p>Комментарий: '.$_POST['text'].'</p>
					'.$text.'
			</body>
	</html>';
	$mail = mail("info@kirpich-cherepovets.ru", $subject, $message,
        "Content-type: text/html; charset=utf-8 \r\n"
		."From: info@kirpich-cherepovets.ru" . "\r\n"
		."X-Mailer: PHP/" . phpversion());
	$_SESSION['order'] = true;
}

?>