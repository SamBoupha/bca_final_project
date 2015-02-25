<?php require_once("../include/initialize.php"); ?>
<?php $detailPage = true; $checkout_page = true; ?> 
<?php include(INC_PATH.DS."header.php"); ?>
<?php
	
	$state_id = true;
	$city_id = true;

	if (!$customer_session->is_logged_in()) {
		header('location: index.php');
	}

	if (isset($_POST['submit'])) {
		$info['id'] = $customer_session->id;
		$info['name'] = $_POST['name'];
		$info['email'] = $_POST['email'];
		$info['shipping_address'] = $_POST['address'];
		$info['postcode'] = $_POST['postcode'];
		$info['mobile_number'] = $_POST['mobile_number'];

		if($_POST['state_id'] == 0) {
			$state_id = false;
		} else {
			$info['shipping_state_id'] = $_POST['state_id'];
		}

		if($_POST['city_id'] == 0) {
			$city_id = false;
		} else {
			$info['shipping_city_id'] = $_POST['city_id'];
		}

		if ($state_id && $city_id) {
			Customer::update($info);
			header('location: payment.php');
		}
	}

?>

<!-- body of the page -->

<section class='container'>
	<div class="row">
		<h2>Shipping Detail</h2>
		<form method='post' name='shipping' class='shipping'>
			<div>
				<label>Name:</label><br />
				<input type='text' name='name' 
				value="<?php echo $_POST['name'] ? htmlspecialchars($_POST['name']) : $customer_session->name ?>" required>
			</div>
			<div>
				<label>Email:</label><br />
				<input type='text' name='email' value='<?php echo $_POST['email'] ? htmlspecialchars($_POST['email']) : $customer_session->email ?>' required>
			</div>
			<div>
				<label>Shipping Address:</label><br />
				<textarea class='address' name='address' required>
					<?php echo $_POST['address'] ? trim($_POST['address']) : $customer_session->shipping_address ?>
				</textarea>
			</div>
			<div>
				<label>State:</label>
				<select name='state_id' id='state'  onchange='showCity(this.value)'>
					<option value='0'> Please select your state </option>
					<?php 
						$states = DatabaseObject::select_from_table('customer_state','state_name');
						foreach ($states as $state) {
							echo "<option value='".$state->id."'";
							if ($customer_session->shipping_state_id == $state->id || $_POST['state_id'] == $state->id) {
								echo "selected";
							}
							echo ">".$state->name."</option>";
						}
					?>
				</select><?php echo $state_id ? "": "<span class='danger'>You must select this option" ?>
			</div>
			<div>
				<label>City:</label>
				<select name='city_id' id='city' >
					<option value='0' id='default_city'> Please select your city</option>
					
				</select> <?php echo $city_id ? "": "<span class='danger'>You must select this option" ?>
			</div>
			<div>
				<label>Postcode:</label><br />
				<input type='text' name='postcode' required value='<?php echo $_POST['postcode'] ? htmlspecialchars($_POST['postcode']) : $customer_session->postcode ?>'>
			</div>
			<div>
				<label>Mobile number:</label><br />
				<input type='text' name='mobile_number' required value='<?php echo $_POST['mobile_number'] ? htmlspecialchars($_POST['mobile_number']) : $customer_session->mobile_number ?>'>
			</div>
			
			<input type='submit' class='btn buy-now' style='margin: 2em auto' value='PROCEED' name='submit'>
		</form>
	</div>
	
</section> <!-- main body section-->
<script type="text/javascript">
	function showCity(state_id) {
    if (state_id !== 0) {
       
        xmlhttp = new XMLHttpRequest();
       
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	$('option.value_from_db').remove();
                $("select#city").append(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET","../include/get_city.php?state="+state_id,true);
        xmlhttp.send();
    }
}
</script>
<?php include(INC_PATH.DS."footer.php"); ?>