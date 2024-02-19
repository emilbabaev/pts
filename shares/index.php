<?
session_start();
$title = "Акции";
$description = "";
$keywords = "";
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
include $_SERVER['DOCUMENT_ROOT']."/data/header.html";
?>
	<div id="shares">	
		<div class="container">
			<h1>Акции</h1>
			<ul class="row">
				<?
				$result = mysql_query("SELECT * FROM `shares`");
				$count = mysql_num_rows($result);
				if ($count > 0) {
					$catalog = mysql_fetch_array($result);
					do {?>
						<li class="col-sm-6"><div class="content" style="background: url(<?=$catalog['img']?>) no-repeat;background-size: cover;background-position: center;"><div class="text"><span><?=$catalog['name']?></span></div></div></li>
					<?} while ($catalog = mysql_fetch_array($result));
				}
				?>
			</ul>
		</div>
	</div>
<?
include $_SERVER['DOCUMENT_ROOT']."/data/footer.html";
?>