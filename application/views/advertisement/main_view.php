<h1>Оголошення</h1>
<? if ($user->role >= 1): ?>
<a href = "/advertisement/formCreate" class = "button advertisement">Написати оголошення</a>
<? else: ?>
	Щоб залишати оголошення <a href = "/user/index">увійдіть на сайт</a>
<? endif ?>
<? if ($data != NULL): ?>
<div class = "wrapper-advertisement">
	
	<? foreach ($data as $field): ?>
		<a href = "\advertisement\view?id=<?= $field['id']?>">
			<div class = "adver-paper">
				<h3><?= $field['title']?></h3>
				<p><?= $field['contacts']?></p>
			</div>
		</a>
	<? endforeach ?>
</div>
<? else: ?>
	Немає оголошень
<? endif ?>