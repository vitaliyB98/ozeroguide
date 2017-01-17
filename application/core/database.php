<?php
	class DB {

		static function Connect () {

			$localhost = 'localhost';
			$dbName = 'ozero';
			$user = 'admin';
			$password = 'php';

			$DBH = new PDO("mysql:host=$localhost;dbname=$dbName", "$user", "$password");
			
			return $DBH;	
		}

		

	}
?>