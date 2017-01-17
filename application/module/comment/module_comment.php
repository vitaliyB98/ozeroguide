<?php
	class Comment {

		public $postId;
		public $userId;

	
		public function __construct ( $post_id, $user_id = NULL ) {

			$this->postId = $post_id;
			$this->userId = $user_id;
		} 
	

		static public function index ( $id, $user_id = NULL ) {
			
			$comment = new Comment ($id, $user_id);
			include_once ('form.php');

		}
		

		public function getAllComment () {
			$DBH = DB::Connect();
			$STH = $DBH->query("
					SELECT 
						`text`,
						`date`,
						(SELECT `name` FROM `usero` WHERE usero.id = comment.user_id) as `name`
					FROM `comment` 
					WHERE `post_id` = $this->postId 
					ORDER BY `date`");
			$STH->setFetchMode(PDO::FETCH_ASSOC); 

  			while ($row = $STH->fetch()) {
  				$list[] = $row;
  			}
			return $list;
		}

		static public function saveComment ($postId, $userId, $text) {
			
			// $post_id - integer
			// $user_id - integer
			// $text - text
			// $date - integer
			
			$postId = htmlspecialchars($postId); 
			$userId = htmlspecialchars($userId);
			$text = trim( htmlspecialchars($text) );
			$date = time(); 

			if ( !empty($text) ) {
				$DBH = DB::Connect();
				$STH = $DBH->prepare("INSERT INTO comment ( `user_id`, `post_id`, `text`, `date` ) values ( '$userId', '$postId', '$text', '$date')");  
				$STH->execute();

				// ім'я користувача
				$STH = $DBH->query("SELECT `name` FROM `usero` WHERE id = $userId");
				$STH->setFetchMode(PDO::FETCH_ASSOC); 

				$row = $STH->fetch();

				echo "
					<div class = 'comentar'>
						<div class = 'comentar-user'>
							<span class = 'name'>
								{$row['name']}
							</span>
							|
							<span class = 'date'>" .
								date('Y/m/d H:i',$date) .
							"</span>
						</div>
						<div class = 'comentar-wrapper'>
							<p>$text</p>
						</div>
					</div>
				";	
			}
			
		}
	}

?>
