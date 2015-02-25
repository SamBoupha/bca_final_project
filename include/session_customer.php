<?php
	class CustomerSession extends Session {
		public $id,
			   $name,
			   $email,
			   $mobile_number,
			   $shipping_address,
			   $shipping_state_id,
			   $shipping_city_id,
			   $postcode;

		private function init() {
			
			$this->id = $_SESSION['customer']['id'];
			$this->name = $_SESSION['customer']['name'];
			$this->email = $_SESSION['customer']['email'];
			$this->mobile_number = $_SESSION['customer']['mobile_number'] ;
			$this->shipping_address = $_SESSION['customer']['shipping_address'];
			$this->shipping_state_id = $_SESSION['customer']['shipping_state_id'];
			$this->shipping_city_id = $_SESSION['customer']['shipping_city_id'];
			$this->postcode = $_SESSION['customer']['postcode'];
			$this->logged_in = true;
		}

		function log_in($customer) {
			$_SESSION['customer']['id'] = $customer->id;
			$_SESSION['customer']['name'] = $customer->name;
			$_SESSION['customer']['email'] = $customer->email;
			$_SESSION['customer']['mobile_number'] = $customer->mobile_number;
			$_SESSION['customer']['shipping_address'] = $customer->shipping_address;
			$_SESSION['customer']['shipping_state_id'] = $customer->shipping_state_id;
			$_SESSION['customer']['shipping_city_id'] = $customer->shipping_city_id;
			$_SESSION['customer']['postcode'] = $customer->postcode;
			$this->init();
		}

		function check_log_in() {
			if(isset($_SESSION['customer']['id'])) {
				$this->init();
			} else {
				$this->logged_in = false;
			}
		}

		function log_out() {
			$_SESSION['customer'] = array();
			unset($this->id);
			unset($this->name);
			unset($this->email);
			unset($this->mobile_number);
			unset($this->shipping_address);
			unset($this->shipping_state_id);
			unset($this->shipping_city_id);
			unset($this->postcode);
			$this->logged_in = false;
		}
	}
	$customer_session = new CustomerSession();
?>