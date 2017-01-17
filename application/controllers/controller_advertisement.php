<?php
	class Controller_advertisement extends Controller {
		public $tableName = "advertisement";

		function __construct () {
			
			$userId = $this->getUserId();
			$this->model =  new Model_advertisement($userId);
			$this->view = new View();
			$this->module = new LIKE();
		}

		function action_index () {
			$data = $this->model->getAll();
			$this->view->generate('advertisement/main_view.php', 'template_view.php', $data);
		}

		function action_view ($argument) {
			$data = $this->model->getOne($argument['id']);
			$this->view->generate('advertisement/view_view.php', 'template_view.php', $data);	
		}

		function action_formCreate () {
			$this->view->generate('advertisement/create_view.php', 'template_view.php');	
		}

		


		function action_updateForm ($data) {
			$data = $this->model->getOne($data['id']);
			$this->view->generate (
									'advertisement/create_view.php', 
									'template_view.php', 
									$data);	
		}
	}
?>