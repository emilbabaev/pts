<?
	include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
    define("CONTACT_FORM", 'info@kirpich-cherepovets.ru');
    $post = (!empty($_POST)) ? true : false;
    if($post){
        $name = stripslashes($_POST['name']);
        $tel = stripslashes($_POST['tel']);
        $email = stripslashes($_POST['email']);
        $subject = stripslashes($_POST['theme']);
		$theme = stripslashes($_POST['theme']);
		$text = stripslashes($_POST['text']);
		$reply =stripslashes($_POST['reply']);
		$count_k =stripslashes($_POST['count_k']);
		$message = "";
		if ($theme != '') {
			$message .= "<p>".$theme."</p>";
		}
		if ($name != '') {
			$message .= "<p>Имя: ".$name."</p>";
		}
		if ($email != '') {
			$message .= "<p>Email: ".$email."</p>";
		} else {
			$email = CONTACT_FORM;
		}
		if ($tel != '') {
			$message .= "<p>Телефон: ".$tel."</p>";
		}
		if ($count_k != '') {
			$message .= "<p>Кол-во кирпичей: ".$count_k."</p>";
		}
		if ($text != '') {
			$message .= "<p>".$text."</p>";
		}
		$message = '<html><head><title>'.$subject.'</title></head><body>'.$message.'</body></html>';
		$mail = mail(CONTACT_FORM, $subject, $message,
			"Content-type: text/html; charset=utf-8 \r\n"
			."From: info@kirpich-cherepovets.ru" . "\r\n"
			."X-Mailer: PHP/" . phpversion());
		if($mail){echo $reply;}
	}
?>