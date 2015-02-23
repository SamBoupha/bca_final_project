<?php

class Session {
	public $id;
	public $username;
	protected $logged_in = false;

	function __construct() {
		session_start();
		$this->check_log_in();
	}

	function log_in($user) {
		$this->id = $_SESSION['user']['id'] = $user->id;
		$this->username = $_SESSION['user']['username'] = $user->username;
		$this->logged_in = true;
	}

	function is_logged_in() {
		return $this->logged_in;
	}

	function check_log_in() {
		if(isset($_SESSION['user']['id'])) {
			$this->id = $_SESSION['user']['id'];
			$this->username = $_SESSION['user']['username'];
			$this->logged_in = true;
		} else {
			$this->logged_in = false;
		}
	}

	function log_out() {
		$_SESSION['user'] = array();
		unset($this->id);
		unset($this->username);
		$this->logged_in = false;
	}
}

$session = new Session();

?>