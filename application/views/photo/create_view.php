<?
	if ( isset($data) ) {
		$button_label = "Оновити";
		$path = "/photo/update?id={$data['id']}";
	} else {
		$button_label = "Створити";
		$path = "/photo/create";
	}
?>
<? if ($user->role >= 1): ?>
<h2>Додати фото</h2>
<form method = "POST" enctype="multipart/form-data" action = "<?= $path ?>" >

	<span class = "label">Підпис до фото:</span><br>
	<input type = "text" name = "title" value = "<?= $data['title'] ?>" class = "input-element" style = "width: 40%" autocomplete="off" required><br>

	<span class = "label">Завантажити фото:</span><br>
	<input type = "file" class = "input-element" name = "photo">
	
	<input type = "submit" value = "<?= $button_label ?>" class = "button">

</form>
<? endif ?>