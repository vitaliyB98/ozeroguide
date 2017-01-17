<h1>Фото галерея</h1>
<? if ($data != NULL): ?>
<? if ($user->role >= 1): ?>
	<a href = "/photo/formCreate" class = "button photo">Додати фото</a>
<? else: ?>
	<div class = "information-message">
		Щоб завантажити своє фото <a href = "\usero">увійдіть на сайт</a>
	</div>
<? endif; ?>
<center>
<? foreach ($data as $field): ?>
	<? if ($field['photo'] != NULL): ?>
		<img class = "large" src = "/images/<?= $field['photo'] ?>" alt = "<?= $field['title']?>" title = "<?= $field['title']?>">
	<? endif ?>
<? endforeach ?>
</center>
<? else: ?>
	Немає фото
<? endif ?>