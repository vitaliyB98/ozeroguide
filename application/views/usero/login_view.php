<?php
	$POST = $data[0];
	$errors = $data[1];
?>
<h1>Вхід</h1>
<div class = "errors"><?=$errors ?></div>
<form method = "POST" action = "/usero/login">
	<span class = "label">Логін:</span><br>
	<input type = "text" name = "login" value = "<?= $POST['login']?>" class = "input-element" autocomplete="off" required><br>

	<span class = "label">Пароль:</span><br>
	<input type = "password" name = "password" class = "input-element" autocomplete="off" required><br>

	<input type = "submit" name = "do_login" value = "Увійти" class = "button" style = "margin-top: 10px">
</form>


<a href = "/usero/enterCodeVK">Увійти через ВК</a><br><br>
<a href = "/usero/formCreate">Ще не зареєстровані?</a>


