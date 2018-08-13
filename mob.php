<?php 
	ob_start(); 
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']); 	
	if(stripos($ua,'android') !== false && stripos($ua,'linux') !== false) {
		$link = "https://play.google.com/store/apps/details?id=ru.smartomato.marketplace.odessa";
	}if(stripos($ua,'iphone') !== false){
		$link = "https://appsto.re/ru/YK2H_.";
	}
	?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">
		<title>Mobile</title>
		<style>
			@font-face {
				font-family: 'PFDinTextCompPro';
				src: url('/templates/yoo_master/fonts/pfdintextcomppro-regular.eot');
				src: url('/templates/yoo_master/fonts/pfdintextcomppro-regular.eot') format('embedded-opentype'),
					 url('/templates/yoo_master/fonts/pfdintextcomppro-regular.ttf') format('truetype');
				font-style: normal;
				font-weight: normal;
			}
			@font-face {
				font-family: 'PFDinTextCompPro';
				src: url('/templates/yoo_master/fonts/pfdintextcomppro-medium.eot');
				src: url('/templates/yoo_master/fonts/pfdintextcomppro-medium.eot') format('embedded-opentype'),
					 url('/templates/yoo_master/fonts/pfdintextcomppro-medium.ttf') format('truetype');
				font-style: normal;
				font-weight: bold;
			}
			#body{
			    height: 100vh;
				margin: 0;
				background: url(/images/odessa-mob-bg.jpg)no-repeat top center;
				background-size: cover;
			}
			#logo{position: relative; top: 50px;}
			.main{flex: 1; margin: 0; display: flex; align-items: center; justify-content: center; width: 100%; flex-direction: column;}
		</style>
	</head>
	<body id="body">

		<form method="POST" name="form" style="flex-direction: column; display: flex; align-items: center; justify-content: center; text-align: center; height: 100%;">
			<div id="logo">
				<img src="/images/odessa-mob-logo.svg" alt="logo" width="200px"/>
			</div>
			<div class="main">
				<h1 style="color: #FEFEFE; font-family: 'PFDinTextCompPro'; font-size: 27px; font-weight: 100;">Закажи доставку Одесской кухни<br>
				через приложение!</h1>
				<h3 style="color: #FEFEFE; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 13px; font-weight: 100;">Дарим пирожное «Картошка» при первом заказе</h3>
			</div>
			
			<div id="footer" style="position: relative;bottom: 100px;">
				<a href="<?php echo $link;?>" style="color: #fff !important; text-decoration: none !important; background: #F7C508; padding: 15px 30px; display: block; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 13pt;font-weight: 100;">Скачать</a><br>
				<input type="hidden" name="full" value="3"/>
				<a href="#" onclick="form.submit()" style="color: #fff !important; text-decoration: underline; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 12pt;font-weight: 100;">Перейти на сайт</a>
			</div>
		</form>
	</body>
</html>
<? if($_POST['full'] == 3){
	$cookie_name = "full";
	$cookie_value = "3";
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 
	header("Location: https://cafeodessa.ru");		
}?>