<?
	session_start();
	$title = "Оформление заказа";
	$description = "";
	$keywords = "";
	if (!isset($_SESSION['order'])){
		header("Location: /404/");
	}
	include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
	include $_SERVER['DOCUMENT_ROOT']."/data/header.html";
	
?>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
            <h2 style="text-align: center; margin: 0; padding-top: 250px; padding-bottom: 250px;">Спасибо, ваша заявка оформлена.<br>Мы свяжемся с Вами в ближайщее время.</h2>
        </div>
	</div>
</div>
<?
include $_SERVER['DOCUMENT_ROOT']."/data/footer.html";
?>