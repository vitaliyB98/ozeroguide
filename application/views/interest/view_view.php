<a href = "\interest">Назад</a>
	<h3 class = "view-news"><?= $data['title']?></h3>
	<p class = "date"><?= date("Y.m.d   H:i", $data['date']) ?></p>

	<? if ($data['photo'] != NULL): ?>
		<img class = "large" src = "/images/<?= $data['photo'] ?>"><br>
	<? endif ?>

	<p><?= $data['content']?></p>
		
	

	<p class = "views">Переглядів: <?= $data['views'] ?></p>
	
	<?php
		Widget::FacebookShare();
		Widget::VKShare($data['photo']);
	?>

