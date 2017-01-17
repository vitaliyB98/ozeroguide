
	<h3><?= $data['title']?></h3>
	
	<p><?= $data['content']?></p>
	
	<? if ($data['photo'] != NULL): ?>
		<img class = "medium" src = "../images/<?= $data['photo'] ?>"><br>
	<? endif ?>

	<p><?= $data['contacts']?></p>

	<?= date("Y.m.d   H:i", $data['date']) ?>
