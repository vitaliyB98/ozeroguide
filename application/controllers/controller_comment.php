<?php
	class Controller_comment extends Controller {
		public $tableName = "comment";

		function __construct () {
			$this->model = new Model_comment();
			
		}
		function action_index () {
			$data = $this->model->getAll();
			
			$this->view->generate(
				'photo/main_view.php', 
				'template_view.php',
				 $data);
		}

	}
?>