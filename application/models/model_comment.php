<?php
	class Model_comment extends Model {
		public $tableName = "comment";

		public function delete ($id) {
			$DBH = DB::Connect();
			
			
			$DBH->exec("DELETE FROM `$this->tableName` WHERE id = $id");	
			
		}
		
	}
?>