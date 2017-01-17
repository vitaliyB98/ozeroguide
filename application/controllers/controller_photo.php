<?php
	class Controller_photo extends Controller {
		public $tableName = "photo";

		function __construct () {
			
			$userId = $this->getUserId();
			$this->model =  new Model_photo($userId);
			$this->view = new View();
			$this->module = new LIKE();
		}
		
		function action_index () {
			$data = $this->model->getAll();
			
			$this->view->generate(
				'photo/main_view.php', 
				'template_view.php',
				 $data);
		}
		function action_formCreate () {
			$this->view->generate(
				'photo\create_view.php', 
				'template_view.php');	
		}
		

		function action_updateForm ($data) {
			$data = $this->model->getOne($data['id']);

			$this->view->generate(
				'photo/create_view.php', 
				'template_view.php',
				$data);
		}

		
	}
?>