<?php
	class Model {

		public $userId;

		public function __construct ($id = NULL) {
			$this->userId = $id;
		}

		public function parse ($str) {
			$str = strip_tags($str);

			return $str;
		}

		public function getOne ($id) {

			$DBH = DB::Connect();
			$STH = $DBH->query("SELECT * FROM `$this->tableName` WHERE id = $id");
			$STH->setFetchMode(PDO::FETCH_ASSOC); 

			$row = $STH->fetch();

			return $row;
		}

		public function getAll () {
			
			$DBH = DB::Connect();
			$STH = $DBH->query("SELECT * FROM `$this->tableName` ORDER BY `date` DESC");
			$STH->setFetchMode(PDO::FETCH_ASSOC); 

  			while ($row = $STH->fetch()) {
  				$list[] = $row;
  			}

  			if ( $list == NULL) {
  				echo "Немає новин";
  				return false;
  			}

			return $list;
		}
		
		
		public function delete ($id) {
			$DBH = DB::Connect();
			
			$STH = $DBH->query("SELECT `photo` FROM `$this->tableName` WHERE id = $id");
			$STH->setFetchMode(PDO::FETCH_ASSOC); 

			$row = $STH->fetch();
			chmod('images', 0777);
			
			if ( file_exists('images/'.$row['photo']) && $row['photo'] != NULL ) {
				unlink('images/'.$row['photo']); 
			}	
			$DBH->exec("DELETE FROM `$this->tableName` WHERE id = $id");	
			
		}
	} 
?>