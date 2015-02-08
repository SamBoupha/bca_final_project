<?php

class Session {
	public $admin_id;
	public $admin_username;
	private $logged_in = false;

	function __construct() {
		session_start();
		$this->check_log_in();
	}

	function log_in($admin) {
		$this->admin_id = $_SESSION['admin_id'] = $admin['id'];
		$this->admin_username = $_SESSION['admin_username'] = $admin['username'];
		$this->logged_in = true;
	}

	function is_logged_in() {
		return $this->logged_in;
	}

	function check_log_in() {
		if(isset($_SESSION['admin_id'])) {
			$this->admin_id = $_SESSION['admin_id'];
			$this->admin_username = $_SESSION['admin_username'];
			$this->logged_in = true;
		} else {
			$this->logged_in = false;
		}
	}

	function log_out() {
		$_SESSION = array();
		unset($this->admin_id);
		unset($this->admin_username);
		$this->logged_in = false;
	}
}

$session = new Session();

?>