<?php
	class Model_admin extends Model {



		public $title;
		public $content;
		public $photo;
		public $date;

		public function getControler ($tableName) {
			// Визначаємо модель яка буде обробляти оновлення
			switch ($tableName) {
				case 'news':
					$controlerName = 'news';
					break;
				case 'interest':
					$controlerName = 'interest';
					break;
				case 'photo':
					$controlerName = 'photo';
					break;
				case 'advertisement':
					$controlerName = 'advertisement';
					break;
				case 'comment':
					$controlerName = 'comment';
					break;
				case 'usero':
					$controlerName = 'usero';
					break;		
							
				default:
					$controlerName = 'news';
					$tableName = 'news';	
					break;
			}

			return $controlerName;
		}

		public function getQueryString ($controlerName) {
			// Визначаємо поля для Select запиту
			$firstCondition = 	$controlerName == 'news' || 
								$controlerName == 'interest' || 
								$controlerName == 'photo' || 
								$controlerName == 'advertisement';
			
			$secondCondition = $controlerName == 'comment';
			
			$thirdCondition = $controlerName == 'usero';

			$userName = "(SELECT `name` FROM `usero` WHERE usero.id = $controlerName.user_id) as `user name`";

			if ($firstCondition) {
				$queryLine = "
							`id`,
							`title`,
							`photo`,
							`date`,
							$userName";

					
			} elseif ($secondCondition) {

				
				$postTitle = "(SELECT `title` FROM `news` WHERE news.id = comment.post_id) as `post title`"; 

				$queryLine = "`id`,
							  $userName,
							  `text`,
							  $postTitle,
							  `date`
							  ";

			} elseif ($thirdCondition) {
				$queryLine = "`id`,
							  `login`,
							  `name`,
							  `role`,
							  `date`
							  ";				
			}

			return $queryLine;
		}

		//Ajax query
		public function getAll ($tableName, $ajax = NULL) {

			// тип контролера, який буде оновляти і видаляти запис
			$controlerName = $this->getControler ( $tableName );

			$queryLine = $this->getQueryString ( $controlerName );
				
			$DBH = DB::Connect();

			$STH = $DBH->query("SELECT $queryLine FROM `$tableName` ORDER BY `date` DESC");
			$STH->setFetchMode(PDO::FETCH_ASSOC);
			 
  			if ($ajax && isset($STH)) {

  				while ($row = $STH->fetch()) {
  					$list[] = $row;
  				}
  				
  				if ($list == Null) {
  					echo "Немає записів";
  					return 0;
  				}

  				echo "<table>";

  				//header for table
 				echo "<thead>";
  				echo "<tr>";

  				foreach ($list[0] as $key=>$value) {
  					echo "<th  class = 'header'>$key</th>";
  				}
  				echo "<th class = 'header'>";
  				echo "action";
  				echo "</th>";
  				echo "</tr>";
  				echo "</thead>";

  				echo "<tbody>";
				foreach ($list as $line) {
				echo "<tr>";
					foreach ($line as $val=>$field) {
						
						switch ($val) {
							case 'title':
								echo "<th><p>$field</p></th>";
								break;

							case 'photo':
								if ( empty($field) ) {
									$text = 'Немає фото';	
								} else {
									$text = "<img class = 'small' src = '/images/$field'>"; 
								}

								echo "<th>$text</th>";
								break;

							case 'date':
								echo "<th><p>" . date("Y.m.d H:i", $field) . "</p></th>";
								break;

							case 'role':
								echo "
									<th>
										<select class = 'role-select' id = '{$line['id']}'>
											<option value = '1'>Користувач</option>
											<option value = '2'>Редактор</option>
											<option value = '3'>Адміністратор</option>
										</select>
										<script>
											$(document).ready(function () {
												$('select#{$line['id']}').val('$field').trigger('chosen:update')	
											});
										</script>
									</th>
									";
								break;

							default:
								echo "<th><p>$field</p></th>";	
								break;
						}
						
					}
					echo "<th>";

					if ( $tableName != 'comment') {
						echo "<a href = '/$controlerName/updateForm?id={$line['id']}'>Редагувати</a><br><br>";	
					}
					echo "<a href = '/$controlerName/delete?id={$line['id']}'>Видалити</a>";
					
					echo "</th>";
				echo "</tr>";
				
				}
				echo "</tbody>";
				echo "</table>"; 
				$this->script();
  				return;
  			}

			return $list;
		}

		public function script () {
			echo "
					<script>
						$(document).ready(function () {
							


							function setRole (role, id) {
								$.ajax({
									type: 'POST',
									cache: true,
									url: '/usero/setRole',
									data: ({role: role, id: id}),
					                dataType: 'html',
					                success: function (data) {
					                   
					                }
								});
							}

							$('.role-select').click(function () {
								var role = $(this).val();
								var id = $(this).attr('id');
								
								setRole(role, id);
							});


						} );
					</script>
				";
		}
	}
?>