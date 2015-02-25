<?php require_once("../include/initialize.php"); ?>
<?php $detailPage = true; $checkout_page = true; ?> 
<?php include(INC_PATH.DS."header.php"); ?>
<?php
	if (isset($_GET['id'])) {
		remove_from_cart($_GET['id']);
		header("location: checkout.php");
	}
	
	if (!$customer_session->is_logged_in()) {
		header('location: index.php');
	}


?>

<!-- body of the page -->

<section class='container'>
	<div class="row">
		<h2>Shipping Detail</h2>
		<form method='post' name='shipping' class='shipping'>
			<div>
				<label>Name:</label><br />
				<input type='text' name='name' value='<?php echo $customer_session->name ?>' required>
			</div>
			<div>
				<label>Email:</label><br />
				<input type='text' name='email' value='<?php echo $customer_session->email ?>' required>
			</div>
			<div>
				<label>Shipping Address:</label><br />
				<textarea class='address' name='address' value='<?php echo $customer_session->shipping_address ?>' required></textarea>
			</div>
			<div>
				<label>State:</label>
				<select name='state_id' id='state' onchange='showCity(this.value)'>
					<option value='0'> Please select your state </option>
					<?php 
						$states = DatabaseObject::select_from_table('customer_state','state_name');
						foreach ($states as $state) {
							echo "<option value='".$state->id."'";
							if ($customer_session->shipping_state_id == $state->id) {
								echo "selected";
							}
							echo ">".$state->name."</option>";
						}
					?>
				</select>
			</div>
			<div>
				<label>City:</label>
				<select name='city' id='city' >
					<option value='0' id='default_city'> Please select your city</option>
					
				</select>
			</div>
			<div>
				<label>Postcode:</label><br />
				<input type='text' name='postcode' required value='<?php echo $customer_session->postcode ?>'>
			</div>
			<div>
				<label>Mobile number:</label><br />
				<input type='text' name='mobile_number' required value='<?php echo $customer_session->mobile_number ?>'>
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