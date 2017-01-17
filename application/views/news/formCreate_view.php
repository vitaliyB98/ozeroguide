<?
	if ( isset($data) ) {
		$button_label = "Оновити";
		$path = "/news/update?id={$data['id']}";
	} else {
		$button_label = "Створити";
		$path = "/news/create";
	}
?>
<? if ($user->role >= 2): ?>
<form method = "POST" enctype="multipart/form-data" action = "<?= $path ?>" >

	<span class = "label">Заголовок:</span><br>
	<input type = "text" name = "title" value = "<?= $data['title'] ?>" class = "input-element create-input"  autocomplete="off" required><br>
	
	<span class = "label">Текст новини:</span><br>
	<textarea name = "content" id="editor1" class = "input-element" style = "width: 80%; height: 800px" required><?= $data['content'] ?></textarea><br>
	<script type="text/javascript">
	CKEDITOR.replace( 'content');
	</script>
	<span class = "label">Завантажити фото:</span><br>
	<input type = "file" class = "input-element" name = "photo">
	
	<input type = "submit" value = "<?= $button_label ?>" class = "button">

</form>
<? endif ?>