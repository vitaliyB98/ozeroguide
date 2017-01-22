<?php
	class Controller_usero extends Controller {
		public $tableName = "usero";

		function __construct () {
			$this->model =  new Model_users();
			$this->view = new View();
			 
			//include redbean library
			require_once "application/lib//rb.php";
			//conecting dataBase for redbean

			// settings for my local server =)
			R::setup( 'mysql:host=localhost;dbname=ozero','admin', 'php' );
		}

		// registration
		function action_formCreate () {

			$this->view->generate('usero/formCreate_view.php', 'template_view.php');
		}

		function action_index () {

			$this->view->generate('usero/login_view.php', 'template_view.php');
		}

		function action_create () {
			$this->model->save($_POST,$_FILES);
			$this->redirect("/admin/index?table=$this->tableName");	
		}

		function action_update ($data) {
			$this->model->update ($_POST, $data['id']);

			$this->redirect("/admin/index?table=$this->tableName");
		}
		
		function action_save () {
			
			session_start();
			if ( isset($_SESSION['user']) ) {
				$user = unserialize($_SESSION['user']);
			}

			$errors = $this->model->registration($_POST);
			
			if ( !isset($user) ) {
				$errors = $this->model->login($_POST);	
			}
			
			if ( empty($errors) ) {

				$this->redirect("/news");

				// create here user object 

			} else {
				
				$this->view->generate('usero/formCreate_view.php', 'template_view.php', 
					[
						$_POST,					
						array_shift($errors)
					]);
			}

		}

		function action_login () {
			$errors = $this->model->login($_POST);
			
			if ( empty($errors) ) {
				$this->redirect("/news");	
			} else {
				
				$this->view->generate('usero/login_view.php', 'template_view.php', 
					[
						$_POST,					
						array_shift($errors)
					]);
			}				
		}

		function action_enterCodeVK () {
			
			$path = $this->model->getPathForVk();

    		$this->redirect($path);			
		}

		function action_loginVk () {
			
			// create user model with information about user
			$this->model->getUserVk($_GET);	

			if ( empty($errors) ) {
				$this->redirect("/news");	
			} else {
				
				$this->view->generate('usero/login_view.php', 'template_view.php', 
					[
						NULL,				
						array_shift($errors)
					]);
			}
		}

		
		function action_logout () {
			
			unset ($_SESSION['user']);

			$this->redirect("/news");
		}

		function action_updateForm ($data) {
			$data = $this->model->getOne($data['id']);

			$this->view->generate(
				'usero/formCreate_view.php', 
				'template_view.php',
				[$data, null]);
		}

		function action_delete ($data) {
			// Можна видалити тут не займає багато коду
			$DBH = DB::Connect();
			$DBH->exec("DELETE FROM `$this->tableName` WHERE id = {$data['id']}");
			
			$this->redirect("/admin/index?table=$this->tableName");
		}

		function action_setRole () {
			$DBH = DB::Connect();
			
			$STH = $DBH->prepare("UPDATE `usero` SET `role` = '{$_POST['role']}' WHERE `id` = '{$_POST['id']}'");  
			$STH->execute(); 
		}
	}
?>