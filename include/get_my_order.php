<?php
require_once(INC_PATH.DS."order_object.php");
require_once(INC_PATH.DS."book_object.php");
require_once(INC_PATH.DS."computer_object.php");
require_once(INC_PATH.DS."wireless_object.php");
require_once(INC_PATH.DS."cloth_object.php");

$orders = array();

$offset = isset($_GET['q']) ? $_GET['q'] : 0;

$list_of_orders = Order::get_last_orders($customer_session->id, $customer_session->recent_order, $offset, $item_per_page );
$last_index = count($list_of_orders)-1;

if ($book_orders = Order::select_order_of_user($customer_session->id,"book",$customer_session->recent_order,$list_of_orders[$last_index]->id)) {
	$orders = array_merge($orders, $book_orders);
	foreach ($orders as $order) {
		// the product _id will be replace by more meaningful details of that product id
		// but then I figured out that I will still need the product_id so
		// I cache it in temp then reassigns it back 
		$temp = $order->product_id;
		$order->product_id = BookObject::order_select($order->product_id);
		$order->product_id->id = $temp;
		// since this id prop is free and not relevant here 
		// so I use it to store category identification instead
		$order->customer_id = "book";
	}
} 

if ($computer_orders = Order::select_order_of_user($customer_session->id,"computer",$customer_session->recent_order,$list_of_orders[$last_index]->id)) {
	
	foreach ($computer_orders as $order) {
		// the product _id will be replace by more meaningful details of that product id
		// but then I figured out that I will still need the product_id so
		// I cache it in temp then reassigns it back 
		$temp = $order->product_id;
		$order->product_id = ComputerObject::order_select($order->product_id);
		$order->product_id->id = $temp;
		// since this id prop is free and not relevant here 
		// so I use it to store category identification instead
		$order->customer_id = "computer";
	}

	$orders = array_merge($orders, $computer_orders);
} 

if ($wireless_orders = Order::select_order_of_user($customer_session->id,"wireless_product",$customer_session->recent_order,$list_of_orders[$last_index]->id)) {
	
	foreach ($wireless_orders as $order) {
		// the product _id will be replace by more meaningful details of that product id
		// but then I figured out that I will still need the product_id so
		// I cache it in temp then reassigns it back 
		$temp = $order->product_id;
		$order->product_id = WirelessObject::order_select($order->product_id);
		$order->product_id->id = $temp;
		// since this id prop is free and not relevant here 
		// so I use it to store category identification instead
		$order->customer_id = "wireless_product";
	}

	$orders = array_merge($orders, $wireless_orders);
} 

if ($clothing_orders = Order::select_order_of_user($customer_session->id,"clothing",$customer_session->recent_order,$list_of_orders[$last_index]->id)) {
	
	foreach ($clothing_orders as $order) {
		// the product _id will be replace by more meaningful details of that product id
		// but then I figured out that I will still need the product_id so
		// I cache it in temp then reassigns it back 
		$temp = $order->product_id;
		$order->product_id = ClothObject::order_select($order->product_id);
		$order->product_id->id = $temp;
		// since this id prop is free and not relevant here 
		// so I use it to store category identification instead
		$order->customer_id = "clothing";
	}

	$orders = array_merge($orders, $clothing_orders);
}

?>