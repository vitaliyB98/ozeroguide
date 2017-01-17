<?php
	
	class LIKE {
		public $likeCount = 0;
		public $tableName = 'news';

		public function showLike ($id ,$like = '0') {
			$id_array = unserialize($like);
			if (empty($id_array)) {
				$this->likeCount = 0;
			} else {
				$this->likeCount = count($id_array);	
			}

			echo "
				<div class = 'like-wrapper'>
					<div class = 'likes' id = '$id'></div>
					<div class = 'count-like' id = '$id'>
				".
				$this->likeCount.
				"	</div>
				</div>";
		}

		public function likeScript () {
			echo "
				<script type='text/javascript'>
					$(document).ready( function () {

						function click_like (id) {
							$.ajax({
								type: 'POST',
								cache: true,
								url: 'news/like',
								data: ({id: id}),
				                dataType: 'html',
				                success: function (data) {
				                	if (data == '')
				                		data = '0';
				                	
				                    $('#' + id +'.count-like').html(data);
				                    
				                }
							});
						}

						$('.likes').click(function () {
							var id = $(this).attr('id');
							click_like(id);
						});
					});
				</script>";
		}

		public function getLike ($id) {
			$DBH = DB::Connect();
			@$STH = $DBH->query("SELECT `likes` FROM `$this->tableName` WHERE id = $id");
			@$STH->setFetchMode(PDO::FETCH_ASSOC); 

			$row = $STH->fetch();
			
			$id_array = unserialize($row['likes']);
			$count_like = count($id_array);

			return $count_like;
		}

		public function setLike ($id, $user_id) {
			$DBH = DB::Connect();

			@$STH = $DBH->query("SELECT `likes` FROM `$this->tableName` WHERE id = $id");
			@$STH->setFetchMode(PDO::FETCH_ASSOC); 

			$row = $STH->fetch();
			// unserialize string
			$likes = $row['likes'];
			
			$id_array = unserialize($likes);

			if ( empty($id_array)) {
				$id_array = array();
			}

			if ( !in_array($user_id, $id_array) ) {
			
				$id_array[] = $user_id;
				$likes = serialize($id_array);

				$STH = $DBH->prepare("UPDATE `$this->tableName` SET `likes` = '$likes' WHERE id = $id");  
				$STH->execute();
			
			}
						
			
		}

		public function indexLike ($id) {

			if ( isset($_SESSION['user']) ) {
				$user = unserialize($_SESSION['user']);

				$this->setLike($id,  $user->id);	
			}
			
			$likes = $this->getLike( $id );
			echo $likes;
			
		}


	}

?>
