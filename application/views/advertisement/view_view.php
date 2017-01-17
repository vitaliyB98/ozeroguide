	<a href = "\advertisement\index">Назад</a>	
	<h3><?= $data['title']?></h3>
	<p class = "date"><?= date("Y.m.d   H:i", $field['date']) ?></p>

	<p><?= $data['content']?></p>
	
	<? if ($data['photo'] != NULL): ?>
		<img class = "medium" src = "../images/<?= $data['photo'] ?>"><br>
	<? endif ?>

	<p><?= $data['contacts']?></p>

	
