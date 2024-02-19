<?
session_start();
$title = "Сравнение продукции от компании «Кирпич на Гоголя 51»";
$description = "Сравнение выбираемой продукции, кирпичей, газобетона, керамических блоков, плитки, смесей и цемента.";
$keywords = "Сравнение продукции";
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
include $_SERVER['DOCUMENT_ROOT']."/data/header.html";
?>
<div class="section">
	<div class="container">
		<ul class="path-url">
			<li><a href="/">Главная</a></li> 
			<li class="arrow-path"><i class="icon-5"></i></li> 
			<li>Сравнение</li>				
		</ul>
		<div id="cart" class="cart compare">
			<div id="load-data">
				<?include $_SERVER['DOCUMENT_ROOT']."/core/load_compare.php";?>
			</div>
		</div>
	</div>
</div>
<?
include $_SERVER['DOCUMENT_ROOT']."/data/footer.html";
?>