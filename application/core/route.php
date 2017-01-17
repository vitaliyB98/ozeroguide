<?php 
class Route {
	static function start() {
		// контроллер и действие по умолчанию
		$controller_name = 'news';
		$action_name = 'index';
		$argument = NULL;
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		// получаем имя контроллера
		if ( !empty($routes[1]) ) {	
			$controller_name = $routes[1];

			// назва сторінки
			$_SESSION['controller_name'] = $controller_name;
			//Якщо екшен не був викликаний явно, то за замовчуваннямі
			$_SESSION['action_name'] = $action_name;
		}

		// получаем имя экшена
		if ( !empty($routes[2]) ) {
			$action_name = $routes[2]; 

			// назва екшена
			$_SESSION['action_name'] = $action_name;

			// отримаємо масив аргументів запиту GET
			if ( !empty($_GET) ) {
				
				$argument = $_GET;

				$action_name = explode('?', $routes[2]);
				$action_name = $action_name[0];
				
				// назва екшена
				$_SESSION['action_name'] = $action_name;


			}
			
		}

		// добавляем префиксы
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		// подцепляем файл с классом модели (файла модели может и не быть)

		$model_file = strtolower($model_name).'.php';
		$model_path = "application/models/".$model_file;
		if(file_exists($model_path))
		{
			include "application/models/".$model_file;
		}

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			include "application/controllers/".$controller_file;
		}
		else
		{
			/*
			правильно было бы кинуть здесь исключение,
			но для упрощения сразу сделаем редирект на страницу 404
			*/
			include "application/controllers/Controller_404.php";
			//Route::ErrorPage404();
		}
		
		// создаем контроллер
		$controller = new $controller_name;
		$action = $action_name;
		
		if(method_exists($controller, $action))
		{
			// вызываем действие контроллера
			$controller->$action($argument);
		}
		else
		{
			// здесь также разумнее было бы кинуть исключение
			Route::ErrorPage404();
		}

	
	}
	
	function ErrorPage404()
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
    }
}
?>