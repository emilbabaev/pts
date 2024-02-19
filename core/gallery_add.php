<?
Header("Content-Type: text/html;charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
include $_SERVER['DOCUMENT_ROOT']."/pn/classSimpleImage.php";
$imgs = '';
$table = 'gallery';
$page_url = 'gallery';

if (basename($_FILES['imgs']['name']) != ''){
	$path_info = pathinfo(basename($_FILES['imgs']['name']));
	$upload_file = substr_replace(sha1(microtime(true)), '', 12).".".$path_info['extension'];
	move_uploaded_file($_FILES['imgs']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
	$imgs = $imgs.$upload_file."\n";
	$image = new SimpleImage();
	$image->load($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
	$image->resizeToHeight(1024);
	$image->save($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
	$image = new SimpleImage();
	$image->load($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/'.$upload_file);
	$image->resizeToWidth(500);
	$image->save($_SERVER['DOCUMENT_ROOT'].'/images/'.$page_url.'/s'.$upload_file);
}

$SQL = "INSERT INTO ".$table."(
`id` , 
`name`,
`email`,
`tel`,
`imgs`,
`title`,
`text`,
`status`,
`category_id`
)
VALUES (
NULL ,  '".mysql_real_escape_string($_POST['name'])."',  '".mysql_real_escape_string($_POST['email'])."', '".mysql_real_escape_string($_POST['tel'])."', '".$imgs."', '', '".mysql_real_escape_string($_POST['text'])."', '0', '0'
);";

$result = mysql_query($SQL);

$name = stripslashes($_POST['name']);
$tel = stripslashes($_POST['tel']);
$email = stripslashes($_POST['email']);
$subject = stripslashes($_POST['theme']);
$theme = stripslashes($_POST['theme']);
$text = stripslashes($_POST['text']);
$reply =stripslashes($_POST['reply']);
define("CONTACT_FORM", 'rodionzam@yandex.ru');
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

if ($text != '') {
	$message .= "<p>".$text."</p>";
}
$message = '<html><head><title>'.$subject.'</title></head><body>'.$message.'</body></html>';
$mail = mail(CONTACT_FORM, $subject, $message,
	"From: <".$email.">\r\n"
	."Reply-To: ".$email."\r\n"
	."Content-type: text/html; charset=utf-8 \r\n"
	."X-Mailer: PHP/" . phpversion());
if($mail){echo $reply;}
?>