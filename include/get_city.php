<?php 
require_once("initialize.php");
$sql = "SELECT id, city_name as name FROM customer_city WHERE state_id = ".$_GET['state']." Order by city_name ";
$cities = DatabaseObject::select_by_query($sql);
foreach ($cities as $city) {
	echo "<option class='value_from_db' value='".$city->id."'>".$city->name."</option>";
}
?>