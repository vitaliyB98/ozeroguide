<a href = "\news">Назад</a>
	<h3 class = "view-news"><?= $data['title']?></h3>
	<meta property="mrc__share_title" content="<?= $data['title']?>"/>
	<p class = "date"><?= date("Y.m.d   H:i", $data['date']) ?></p>

	<p><?= $data['content']?></p>
		
	<? if ($data['photo'] != NULL): ?>
		<img class = "large" src = "/images/<?= $data['photo'] ?>"><br>
	<? endif ?>

	<p class = "views">Переглядів: <?= $data['views'] ?></p>
	
	<?php
		Widget::FacebookShare();
		Widget::VKShare($data['photo']);
		Comment::index($data['id'], $user->id);
	?>

