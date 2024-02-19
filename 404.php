<!DOCTYPE html>
<html>
<head><meta charset='UTF-8'><meta name="robots" content="noindex">
<link rel="stylesheet" href="/libs/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/css/main.css" />
<style class="cp-pen-styles">
body{
	height: 100vh;
	width: 100%;
	display: table;
	vertical-align: middle;
	text-align: center;
	overflow: hidden;
	background: #F2F7FF;
	margin: 0px;
}
.item{
    display: table-cell;
    vertical-align: middle;
}
.text{
	font-size: 42.5pt;
	color: #4D4D4d;
	margin-top: 10px;
	line-height: 1.2;
	font-family: "arial";
	font-weight: bold;
}
img{
	max-width: 100%;
}
p{
	font-size: 14.5pt;
	color: #4D4D4d;	
	font-family: "arial";
}
.btn-4{
	margin-top: 40px;
}
</style>
</head>
<body>
<div class="item">
<img src="/img/404.png">
<div class="text">Ошибка 404</div>
<p>Страница не найдена</p>
<a class="btn btn-main btn-4" href="http://<?echo $_SERVER['SERVER_NAME'];?>" rel="nofollow"><span>На главную <i class="icon-5"></i></span></a>
</div>
</body></html>