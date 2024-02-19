<?
Header("Content-Type: text/html;charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
$result = mysql_query("SELECT * FROM `prod` WHERE `id`=".$_POST["id"]."");	
$count = mysql_num_rows($result);
$id = mysql_result($result, 0, 'id');
$name = mysql_result($result, 0, 'name');
?>
<h3 class="caption">Покупка в один клик</h3>
<p>Наименование товара: <?=htmlspecialchars($name);?></p>
<form name="formPayCatalog" id="formPayCatalog" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?echo $id;?>">
	<input type="hidden" name="theme" value="Быстрая покупка">
	<input type="hidden" name="reply" value="Ваша заявка успешно оформлена. Наш менеджер свяжется с вами в ближайшее время.">
	<input type="hidden" name="text" value="Наименование товара: <?=htmlspecialchars($name);?> (<?=htmlspecialchars($about)?>)">
	<div class="form-group">
		<input type="text" name="name" value="" autocomplete="name" placeholder="Имя" class="form-control" required="required">
	</div>
	<div class="form-group">
		<input type="tel" name="tel" value="" autocomplete="tel" placeholder="Телефон" class="form-control" required="required">
	</div>
	<div class="form-group">
		<input type="email" name="email" value="" autocomplete="email" placeholder="Email" class="form-control" required="required">
	</div>

	<br/>
	<div class="form-group">
		<button type="submit" class="btn btn-main">Отправить</button>
	</div>
</form>
<script>
$("#formPayCatalog").submit(function() {
		$.ajax({
			type: "POST",
			url: "/mail.php",
			data: $(this).serialize()
		}).done(function(response) {
			$("#myModal .modal-body").html(response);
		});
		return false;
	});
</script>