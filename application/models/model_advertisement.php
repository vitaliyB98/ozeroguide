<?php
	class Model_advertisement extends Model {
		protected $tableName = 'advertisement';

		public $title;
		public $content;
		public $contacts;
		public $photo;
		public $date;

		public function save ($data,$files) {	

			$this->title = $this->parse($data['title']);
			$this->content = $this->parse($data['content']);
			$this->contacts = $this->parse($data['contacts']);
			$this->date = time();
			$files['photo']['name'] = $this->parse($files['photo']['name']);

			$format  = 	$files['photo']['type'] == "image/gif" ||
						$files['photo']['type'] == "image/jpg" ||
						$files['photo']['type'] == "image/jpeg" ||
						$files['photo']['type'] == "image/png";	

			

			if ($format) {

				$this->photo = uniqid() . $files['photo']['name'];
				move_uploaded_file(strip_tags($files['photo']['tmp_name']), 'images/'.$this->photo);
			
			}

			$DBH = DB::Connect();
			$STH = $DBH->prepare("
					INSERT INTO advertisement 
						( `title`, `content`, `photo`, `contacts`, `date`, `user_id` ) 
					values ( '$this->title', '$this->content', '$this->photo', '$this->contacts', '$this->date', '$this->userId')");  
			$STH->execute();
		}

		public function update ($data, $files, $id) {
			$this->title = $this->parse($data['title']);
			$this->content = $this->$data['content'];
			$this->contacts = $this->parse($data['contacts']);
			
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
			$STH = $DBH->prepare("UPDATE `advertisement` SET `title` = '{$data['title']}', `content` = '{$data['content']}', `contacts` = '{$data['contacts']}' $add_photo WHERE id = $id");  
			$STH->execute();
		}

		public function delete ($id) {
			$DBH = DB::Connect();
			
			$STH = $DBH->query("SELECT `photo` FROM `advertisement` WHERE id = $id");
			$STH->setFetchMode(PDO::FETCH_ASSOC); 

			$row = $STH->fetch();
			$DBH->exec("DELETE FROM `advertisement` WHERE id = $id");
			@unlink('images/'.$row['photo']);

		}

	}
?>