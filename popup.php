<?php 

if($_POST['full'] == 3){
	$cookie_name = "full";
	$cookie_value = "3";		
	setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); 
	header("Location: https://cafeodessa.ru");
	ob_end_flush();
}?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">
		<title>CafeOdessa</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

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
				background: url(/images/odessa-popup.jpg)no-repeat top center;
				background-size: cover;
			}
			#logo{position: relative; padding-bottom: 30px;}
			
		</style>
	</head>
	<body id="body">
	
		<a href="#" onclick="form.submit()" class="glyphicon glyphicon-remove" style="font-size: 20pt; float: right; position: relative; right: 50px; top: 50px; color: #F7C508; text-decoration: none;"></a>

		<form method="POST" name="form" style="flex-direction: column; display: flex; align-items: center; justify-content: center; text-align: center; height: 100%;">
			<div id="logo">
				<img src="/images/odessa-mob-logo.svg" alt="logo" width="200px"/>
			</div>
			<div class="main">
				<h1 style="color: #FEFEFE; font-family: 'PFDinTextCompPro'; font-size: 36pt; font-weight: 100;">Закажи доставку Одесской кухни<br>
				через приложение!</h1>
				<h3 style="color: #FEFEFE; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 18px; font-weight: 100;">Дарим пирожное «Картошка» при первом заказе</h3>
			</div>
			<br><br>
			<div id="footer" style="position: relative;">
				<input type="hidden" name="full" value="3"/>
				<a onclick="form.submit()" style="color: #fff !important; text-decoration: none !important; background: #F7C508; padding: 15px 30px; display: block; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 13pt;font-weight: 100;border: 0px;" >Перейти на сайт</a><br>
				
				
			</div>
		</form>
	</body>
</html>
<?php

?>