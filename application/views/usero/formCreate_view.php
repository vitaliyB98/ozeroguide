<?php
	$POST = $data[0];
	$errors = $data[1];
	if ( isset($data) ) {
		$button_label = "Оновити";
		$path = "/usero/update?id={$POST['id']}";
	} else {
		$button_label = "Зареєструватися";
		$path = "/usero/save";
	}
?>
<h1>Реєстрація</h1>
<div class = "errors"><?=$errors ?></div>
<form method = "POST" action = "<?= $path?>">
	<span class = "label">Логін:</span><br>
	<input type = "text" name = "login" value = "<?= $POST['login']?>" class = "input-element" autocomplete="off" required><br>

	<span class = "label">Імя на сайті:</span><br>
	<input type = "text" name = "name" value = "<?= $POST['name']?>" class = "input-element" autocomplete="off" required><br>

	<span class = "label">Пароль:</span><br>
	<input type = "password" name = "password" class = "input-element" required><br>

	<span class = "label">Повторіть пароль:</span><br>
	<input type = "password" name = "password_1" class = "input-element" required><br>

	<input type = "submit" name = "signup" value = "<?= $button_label?>" class = "button">
</form>
