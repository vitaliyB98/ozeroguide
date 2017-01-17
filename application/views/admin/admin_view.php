<?php if ($user->role == 3): ?>
	<?
		if ( isset($_GET['table']) ) {
			$tableName = $_GET['table'];
		} else {
			$tableName = "news";
		}
	?>
	<h1>Адмін</h1>
	<a href = "news/formCreate" class = "button add-news">Додати запис</a>

	<div class = "list-content">
		<select class = "chose-content">
			<option value = "news">Новини</option>
			<option value = "advertisement">Оголошення</option>
			<option value = "interest">Цікаве</option>
			<option value = "photo">Фото</option>
			<option value = "comment">Коментарі</option>
			<option value = "usero">Список користувачів</option>
		</select>
	</div>
	<br>
	<br>
	<br>
	<div class = "admin-content">

	</div>

	<script type="text/javascript">
		$(document).ready( function () {

			var tableDefault = "<?= $tableName ?>";

			$('.chose-content').val(tableDefault).trigger('chosen:update');
			var methodPath = '/' + tableDefault + "/formCreate";
			$("a.add-news").attr("href", methodPath);
			
			function fetch_data (tableName) {
				$.ajax({
					type: "POST",
					cache: true,
					url: "\\admin\\all",
					data: ({tbl_name: tableName}),
	                dataType: "html",
	                success: function (data) {
	                    $('.admin-content').html(data);
	                }
				});
			}

			fetch_data(tableDefault);

			$('.chose-content').click(function () {
				var tableName = $(".chose-content").val();
				// шлях до методу методу
				var methodPath = '/' + tableName + "/formCreate";
				$("a.add-news").attr("href", methodPath);
				
				fetch_data(tableName);
			});

		});
	</script>
<? else: ?>
	У вас немає доступу до цього розділу!
<? endif; ?>