<?php
	class Controller_admin extends Controller {
		function __construct () {
			$this->model =  new Model_admin();
			$this->view = new View();
		}

		function action_index () 

			$this->view->generate('admin/admin_view.php', 'template_view.php', $data);
		}

		function action_all () {
			$this->model->getAll($_POST['tbl_name'], true);
		}


	}
?>