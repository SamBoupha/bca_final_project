<?php

class Session {
	public $id;
	public $username;
	private $logged_in = false;

	function __construct() {
		session_start();
		$this->check_log_in();
	}

	function log_in($user) {
		$this->id = $_SESSION['id'] = $user['id'];
		$this->username = $_SESSION['username'] = $user['username'];
		$this->logged_in = true;
	}

	function is_logged_in() {
		return $this->logged_in;
	}

	function check_log_in() {
		if(isset($_SESSION['id'])) {
			$this->id = $_SESSION['id'];
			$this->username = $_SESSION['username'];
			$this->logged_in = true;
		} else {
			$this->logged_in = false;
		}
	}

	function log_out() {
		$_SESSION = array();
		unset($this->id);
		unset($this->username);
		$this->logged_in = false;
	}
}

$session = new Session();

?>