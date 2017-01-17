<?php
	class Controller_Interest extends Controller {
		public $tableName = "interest";
		
		function __construct () {
			
			$userId = $this->getUserId();
			$this->model =  new Model_interest($userId);
			$this->view = new View();
			$this->module = new LIKE();
		}

		function action_index () {
			$data = $this->model->getAll();
			$this->view->generate(
									'interest/main_view.php',
									'template_view.php',
									$data);
		}

		function action_view ($argument) {
			$data = $this->model->getOne ($argument['id']);
			$this->model->setViews ($argument['id']);

			$this->view->generate(
									'interest/view_view.php', 
									'template_view.php', 
									$data);	
		}

		// when we set like
		function action_like () {
			$this->module->indexLike($_POST['id']);
	
		}

		function action_comment () {
			Comment::saveComment($_POST['postId'], $_POST['userId'], $_POST['text']);
		}
 

		function action_formCreate () {
			$this->view->generate('interest/formCreate_view.php', 'template_view.php');
		}

		function action_updateForm ($data) {
			$data = $this->model->getOne($data['id']);
			$this->view->generate (
									'interest/formCreate_view.php', 
									'template_view.php', 
									$data);	
		}

	}
?>