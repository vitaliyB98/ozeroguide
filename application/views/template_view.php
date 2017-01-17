<?php
	if ( isset($_SESSION['user']) )
		$user = unserialize($_SESSION['user']); 
		
?>

<html>
	<head>

		<meta charset = "utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>OZEROguide</title>
		<link rel = "stylesheet" href = "../css/head.css" type = "text/css">
		<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
		<link rel="icon" type="image/png" href="pic/ico.png" />
	</head>

	<body>
		<header>
			<div class = "title">
				<a href = "/news">
					OZERO<i>guide</i>
				</a>
			</div>
			<div class = "humburg">
				
			</div>
			<div class = "menu">
				<a href = "/news"><div>Головна</div></a>
				<a href = "/advertisement"><div>Оголошення</div></a>
				<a href = "/photo"><div>Фото</div></a>
				<a href = "/interest"><div>Цікаве</div></a>
				<? if ( isset($user) && $user->role == 3): ?>
					<a href = "/admin/index"><div>Адмін</div></a>
				<? endif ?>
				
				<? if ( !isset($_SESSION['user']) ): ?>
					<a href = "/usero/index"><div>Увійти</div></a>
				<? else: ?>
					<a href = "/usero/logout"><div>Вийти</div></a>
				<? endif ?>
			</div>
		</header>
		<link rel = "stylesheet" href = "../css/style.css" type = "text/css">		
		<content>
		
			<script type="text/javascript" src = "../js/jquery-3.0.0.min.js"></script>	
			<div class = "wrapper">
				<?php include 'application/views/'.$content_view; ?>
			</div>

			<div class = "left-block">
				<div class = "information">
					<h2>ПОПУЛЯРНІ НОВИНИ</h2>

					<div class = "news-block">

						<? Widget::PopularNews() ?>

					</div>

					<h2>ЧИТАЙТЕ ТАКОЖ</h2>

					<div class = "news-block">
						<? Widget::RandomNews() ?>
					</div>

				</div>
				<? Widget::VKPublic () ?>
				<br>
				<? //Widget::Weather() ?>	
			</div>

		</content>

		
		<footer>
			<!-- Yandex.Metrika informer -->
			<? //Widget::MetricaCounter(); ?>
			<? //Widget::Metrica(); ?>
			<!-- /Yandex.Metrika informer -->
			<div>
				Озеро <?= date("Y",time())?>
			</div>
		</footer>
		
	</body>
</html>


<script type="text/javascript">
	$(document).ready( function () {
		
		function giveMenu () {
			var windowWidth = $(window).width();

			if ( windowWidth <= 1000 ) {
				$('.menu').hide();
			} else {
				$('.menu').show();
			}	
		}
		
		giveMenu();

		$(window).resize( function () {
			giveMenu();
					
		});

		$('.humburg').click( function () {
			$('.menu').slideToggle();
		});


	});
</script>
