<?
$uri_parts[0] = 'index';
if ($_SERVER['REQUEST_URI'] != '/') {
	try {
		$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$uri_parts = explode('/', trim($url_path, ' /'));
	} catch (Exception $e) {
		$uri_parts[0] = '404';
	}
}

switch($uri_parts[0]){
	case 'production': {
		$page = '/catalog/index.php';
		if (isset($uri_parts[1])) {
			if ($uri_parts[1] == 'section'){
				if (isset($uri_parts[2])) {
					$category = $uri_parts[2];
				}
			} else if ($uri_parts[1] == 'id'){
				$prod = $uri_parts[2];
			} else if ($uri_parts[1] == 'brand'){
				$brand = $uri_parts[2];
			}
		}
		break;
	}
	case 'info': {
		if (isset($uri_parts[1])) {
			switch($uri_parts[1]){
				case 'article':
					$page = '/news/index.php';break;
				default:
					$page_url = 'info';$param = $uri_parts[1]; $page = '/information/index.php';break;
			}
			if (isset($uri_parts[2])) {
				$param = $uri_parts[2];
			}
		} else {
			$page = '/information/index.php';
			$page_url = 'info';
		}
		break;
	}
	case 'order': {$page = '/cart/order.php';break;}
	case 'news': {
			$page = '/news/index.php';
			if (isset($uri_parts[1])){
				$number = $uri_parts[1];
				if (isset($uri_parts[2])){
					$param = $uri_parts[2];
				}
			}
			break;
		}
	case 'brand': {
			if (isset($uri_parts[1])){
				$brand = $uri_parts[1];
				$page = '/catalog/index.php';
			} else {
				Header("HTTP/1.0 404 Not Found");
				$page = '/404.php';
			}
			if (isset($uri_parts[2])){
				Header("HTTP/1.0 404 Not Found");$page = '/404.php';
			}
			break;
		}
	case '404': {Header("HTTP/1.0 404 Not Found");$page = '/404.php';break;}
	default: {
		require_once $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
		$result = mysql_query("SELECT * FROM `category` WHERE `url`='".$uri_parts[0]."'");
		$count = mysql_num_rows($result);
		if ($count > 0) {
			$page = '/catalog/index.php';
			$category = $uri_parts[0];
			if (isset($uri_parts[1])){
				if ($uri_parts[1] == 'prod') {
					$prod = $uri_parts[2];
				} else {
					$category = $uri_parts[1];
				}
			}
			if (isset($uri_parts[2]) && !isset($prod)){
				if ($uri_parts[2] == 'prod') {
					$prod = $uri_parts[3];
				} else {
					Header("HTTP/1.0 404 Not Found");
					$page = '/404.php';
				}
			}
			if (isset($uri_parts[4])){
				Header("HTTP/1.0 404 Not Found");
				$page = '/404.php';
			}
		} else {
			Header("HTTP/1.0 404 Not Found");
			$page = '/404.php';
		}
		break;
	}
}
include $_SERVER['DOCUMENT_ROOT'].$page;

?>
