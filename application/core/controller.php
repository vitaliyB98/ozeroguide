<?php
	class Controller {
		public $model;
		public $view;

		function __construct () {
			$this->view = new View();
		}

		function getUserId () {
			session_start();

			if ( isset($_SESSION['user']) ) {
				$user = unserialize($_SESSION['user']);

				return $user->id; 
			}
			return NULL;
		}

		function action_index () {
			
		}

		function redirect ($path) {
			header("Location: $path");
		}

		function action_create () {
			$this->model->save($_POST,$_FILES);
			$this->redirect("/" . $this->tableName);	
		}

		function action_update ($data) {
			$this->model->update ($_POST, $_FILES, $data['id']);

			$this->redirect("/admin");
		}

		function action_delete ($data) {
			$this->model->delete($data['id']);
			
			$this->redirect("/admin/index?table=$this->tableName");
		}
	} 
?>