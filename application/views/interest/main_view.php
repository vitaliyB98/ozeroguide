<? if ($data != NULL): ?>
<? foreach ($data as $field): ?>
	<div class = "news-teaser">
		<h3><a href = "\interest\view?id=<?= $field['id']?>"><?= $field['title']?></a></h3>
		<p class = "date"><?= date("Y.m.d   H:i", $field['date']) ?></p>
		
		<? if ($field['photo'] != NULL): ?>
				<a href = "\interest\view?id=<?= $field['id']?>">
				<img src = "/images/<?= $field['photo'] ?>"><br>
				</a>
		<? endif ?>
		<div class = "short-p"><?= $field['content']?></div>
		<a href = "\interest\view?id=<?= $field['id']?>" class = "learn-more">Детальніше</a>
		<br>
		<?php
			LIKE::showLike($field['id'], $field['likes']);
		 ?>
		 <div class = "eye-wrapper">
		 	<div class = "eye"></div>
		 	<?= $field['views'] ?>
		 </div>
	</div>
<? endforeach ?>
<?php
	LIKE::likeScript();
?>
<? else: ?>
	Немає публікацій
<? endif ?>