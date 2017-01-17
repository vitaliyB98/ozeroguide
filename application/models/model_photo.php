<?php
	class Model_photo extends Model {
		protected $tableName = 'photo';

		public $title;
		public $photo;
		public $date;

		public function save ($data,$files) {	

			$this->title = $this->parse($data['title']);
			$this->date = time();
			
			$files['photo']['name'] = $this->parse($files['photo']['name']);

			$format  = 	$files['photo']['type'] == "image/gif" ||
						$files['photo']['type'] == "image/jpg" ||
						$files['photo']['type'] == "image/jpeg" ||
						$files['photo']['type'] == "image/png";	

			
			if ($format) {

				$this->photo = uniqid() . $files['photo']['name'];
				move_uploaded_file( strip_tags($files['photo']['tmp_name']) , 'images/'.$this->photo);
			
			}

			$DBH = DB::Connect();
			$STH = $DBH->prepare("
					INSERT INTO photo 
						( `title`, `photo`, `date`, `user_id` ) 
					values ( '$this->title', '$this->photo', '$this->date', '$this->userId')");  
			$STH->execute();
		}

		public function update ($data, $files, $id) {
			$this->title = $this->parse($data['title']);
			$this->date = time();
			
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
			
			$STH = $DBH->prepare("UPDATE `photo` SET `title` = '{$data['title']}'$add_photo  WHERE id = $id");  
			$STH->execute();  
			
		}

		



	}
?>