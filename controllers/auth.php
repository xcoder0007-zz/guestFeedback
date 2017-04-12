<?php
require_once('models/auth.php');

/**
* backend class
*/
class Auth
{
	private $model;
	private $data;
	
	function __construct()
	{
		$this->model = new Authmodel();
	}

	private function user_set($uid) {
		$user = $this->model->get_by_id('users', $uid);
		$_SESSION['user'] = $user;
		header('Location: /backend');
		die();
	}

	public function login($id) {

		if (!empty($_POST)) {
	         
	        // validate input
	        $valid = true;
	        if (empty($_POST['username'])) {
	            $Error = 'Please enter Username';
	            $valid = false;
	        }

	        $validation = $this->model->auth_user($_POST['user']);

	        if ($validation['password'] == $_POST['pass'] && $validation['active'] == 1) {
	        	$this->user_set($validation['id']);
	        }

	    }
	    require_once('views/backend/login.php');
	}

}


#ROUTER#
$be = new Auth();
$be->{$params[1]}($params[2]);
?>