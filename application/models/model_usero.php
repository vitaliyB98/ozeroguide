<?php
	
	class Model_users extends Model {
		protected $tableName = 'usero';
		// VK auth params

		public $client_id = '5762769'; // ID приложения
    	public $client_secret = 'iMAqTHNFyPM4o0bdFSyB'; // Защищённый ключ
    	public $redirect_uri = 'http://shop1/usero/loginVk'; // Адрес сайта

    	public function saveUsers ($login, $name, $password) {
    		// Redbens method
			$user = R::dispense('usero');
			$user->login = $login;
			$user->name = $name;
			$user->password = password_hash($password, PASSWORD_DEFAULT);
			$user->date = time();
			R::store($user);
    	}

		public function registration ($data) {
			
			$errors = array();

			if ( isset($data['signup']) ) {

				if ( R::count('usero', "login = ?", array($data['login'])) > 0 ) {
					$errors[] = 'Користувач з логіном "'. $data['login'] . '" вже існує'; 
				}

				if ( $data['password'] != $data['password_1'] ) {
					$errors[] = 'Паролі не співпадають';
				}

				if ( empty($errors) ) {
					
					$this->saveUsers ($data['login'], $data['name'], $data['password']);

				}
					
			} else {
				$errors[] = 'Ви не відправили форму';
			}

			return $errors;
		}

		public function login ($data) {
			$errors = array();

			if ( isset($data['do_login']) || isset($data['signup']) ) {
				
				$user = R::findOne( 'usero', 'login = ?', array($data['login']) );

				//Перевіряємо чи існує логін
				if ( $user ) {
					
					if ( password_verify($data['password'], $user->password) ) {
						//всі данні занесемо у клас User
						$object = new User (
							$user->id, 
							$user->login, 
							$user->name,
							$user->role
							
						);

						$_SESSION['user'] = serialize($object); 
						
					} else {

						$errors[] = 'Невірний пароль';
					}
				} else {

					$errors[] = 'Невірний логін';
				}
			} else {

				$errors[] = 'Ви не відправили форму';
			}

			return $errors;			
		}

		// функції для роботи з ВК
		public function getPathForVk () {

			$url = 'http://oauth.vk.com/authorize';

		    $params = array(
		        'client_id'     => $this->client_id,
		        'redirect_uri'  => $this->redirect_uri,
		        'response_type' => 'code'
		    );
    		$path = $url . '?' . urldecode(http_build_query($params));
    		
    		return $path;
		}

		public function getUserVk ($data) {

			if (isset($data['code'])) {
		    		$result = false;
		    		$params = array(
				        'client_id' => $this->client_id,
				        'client_secret' => $this->client_secret,
				        'code' => $_GET['code'],
				        'redirect_uri' => $this->redirect_uri
				    );

		    	$token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

			    if (isset($token['access_token'])) {
			        $params = array(
			            'uids'         => $token['user_id'],
			            'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
			            'access_token' => $token['access_token']
			        );

			        $user = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
			        if (isset($user['response'][0]['uid'])) {
			            $user = $user['response'][0];
			            $result = true;
			        }
			    }
		    
			    if ($result) {

			    	$fullName = $user['first_name'] . " " .	$user['last_name'];

			    	if ( R::count('usero', "login = ?", array($user['screen_name'])) == 0 ) {
						$this->saveUsers ($user['screen_name'], $fullName, time());						
					}

					$data = R::findOne( 'usero', 'login = ?', array($user['screen_name']) );

			        $object = new User (
			        	$data->id,
			        	$user['screen_name'],
			        	$fullName,
			        	$data->role
			        );


					$_SESSION['user'] = serialize($object);
			    }

			    else {
			    	$errors = "Не вдалося увійти через ВК";
			    	return $errors;
			    }
			}

		}

		public function update ($data, $id) {

			$DBH = DB::Connect();
			
			$STH = $DBH->prepare("UPDATE `usero` SET `login` = '{$data['login']}', `name` = '{$data['name']}', `password` = '{$data['password']}' WHERE id = $id");  
			$STH->execute();  
			
		}
	}
?>