<?php
	class Model_interest extends Model {
		protected $tableName = 'interest';

		

		public function setViews ($id) {
			if ( !isset( $_COOKIE[$id] )) {
				$DBH = DB::Connect();
				$STH = $DBH->query("SELECT `views` FROM `interest` WHERE id = $id");
				$STH->setFetchMode(PDO::FETCH_ASSOC); 

				$row = $STH->fetch();
				$views = $row['views']+1;

				$STH = $DBH->prepare("UPDATE `interest` SET `views` = $views WHERE id = $id");  
				$STH->execute();
				setcookie($id, 32, time() + 360000);
			}
			
		}

		public function save ($data,$files) {	

			$this->title = $this->parse($data['title']);
			$this->content = $data['content'];
			$this->date = time();
			$files['photo']['name'] = $this->parse($files['photo']['name']);

			$format  = 	$files['photo']['type'] == "image/gif" ||
						$files['photo']['type'] == "image/jpg" ||
						$files['photo']['type'] == "image/jpeg" ||
						$files['photo']['type'] == "image/png";	


			//Download photo on server
			if ($format) {

				$this->photo = uniqid() . $files['photo']['name'];
				move_uploaded_file(strip_tags($files['photo']['tmp_name']), 'images/'.$this->photo);
			
			}

			$DBH = DB::Connect();
			$STH = $DBH->prepare("INSERT INTO interest ( `title`, `content`, `photo`, `date`, `user_id` ) values ( '$this->title', '$this->content', '$this->photo', '$this->date', '$this->userId')");  
			$STH->execute();
		}

		public function update ($data, $files, $id) {
			$this->title = $this->parse($data['title']);
			$this->content = $this->parse($data['content']);
			
			if ( isset($files['photo']) ) {
				$files['photo']['name'] = $this->parse($files['photo']['name']);

				$format  = 	$files['photo']['type'] == "image/gif" ||
							$files['photo']['type'] == "image/jpg" ||
							$files['photo']['type'] == "image/jpeg" ||
							$files['photo']['type'] == "image/png";	

				
				if ($format) {

					$this->photo = uniqid() . $files['photo']['name'];
					move_uploaded_file(strip_tags($files['photo']['tmp_name']), 'images/'.$this->photo);
					
					$add_photo = ", `photo` = '$this->photo'";
				}
			}

			$DBH = DB::Connect();
			$STH = $DBH->prepare("UPDATE `interest` SET `title` = '{$data['title']}', `content` = '{$data['content']}' $add_photo WHERE id = $id");  
			$STH->execute();
		}

		
		
	}
?>