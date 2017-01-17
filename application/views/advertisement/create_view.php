<?
	if ( isset($data) ) {
		$button_label = "Оновити";
		$path = "/advertisement/update?id={$data['id']}";
	} else {
		$button_label = "Створити";
		$path = "/advertisement/create";
	}
?>
<? if ($user->role >= 1): ?>
<h2>Створення оголошення</h2>
<form method = "POST" enctype="multipart/form-data" action = "<?= $path ?>" >

	<span class = "label">Заголовок:</span><br>
	<input type = "text" name = "title" value = "<?=$data['title']?>" class = "input-element create-input" autocomplete="off" required><br>
	
	<span class = "label">Текст оголешення:</span><br>
	<textarea name = "content" class = "input-element" style = "width: 80%; height: 150px" required><?= $data['content'] ?></textarea><br>
	<script type="text/javascript">
	CKEDITOR.replace( 'content');
	</script>	
	<span class = "label">Контактні данні:</span><br>
	<textarea name = "contacts" class = "input-element create-input" style = " height: 100px" required><?= $data['contacts'] ?></textarea><br>

	<span class = "label">Завантажити фото:</span><br>
	<input type = "file" class = "input-element" name = "photo">
	
	<input type = "submit" value = "<?= $button_label ?>" class = "button">

</form>
<? endif ?>