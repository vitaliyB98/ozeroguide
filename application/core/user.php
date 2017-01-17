<?php
	class User {
		public $id;
		public $login;
		public $name;
		public $role;

		function __construct ( $id, $login, $name, $role ) {
			$this->id = $id;
			$this->login = $login;
			$this->name = $name;
			$this->role = $role;
		}

	} 
?>