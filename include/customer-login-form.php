<?php
	if (isset($_POST['register'])) {
		$new_customer['name']             = $_POST['name'];
		$new_customer['email']            = $_POST['email'];
		$new_customer['password'] 		  = $_POST['password'];
		$new_customer['mobile_number']    = $_POST['mobile_number'];
		echo "serious?";
		if (Customer::insert($new_customer)) {
			$customer = Customer::select_by($_POST['email'],$_POST['password']);
			$customer_session->log_in($customer);
			if($checkout_page && !empty($_SESSION['cart'])) { header('location: shipping_detail.php'); } 
			// refresh the page so that $customer_session variable that loads before can take effect
			else { header('location: '.$_SERVER['PHP_SELF']); }
		} else {
			echo "error";
		}
	}
	
	if (isset($_POST['log_in'])) {
		if($customer = Customer::select_by($_POST['email'],$_POST['password'])) {
			$customer_session->log_in($customer);
			
			if($checkout_page && !empty($_SESSION['cart'])) { header('location: shipping_detail.php'); }
			// refresh the page so that $customer_session variable that loads before can take effect	
			else { header('location: '.$_SERVER['PHP_SELF']); }
		} else {
			echo "invalid email/password";
		}
	}
?>

	<!-- if user is not logged in echo the following form -->
	<div class='lightOut'>
		<form class='customer-login' method='post' name='customer-login' action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<span class='closed'>X</span>
			<p><span>Not a member?</span> <a href='#'>Create a new account</a></p>
			<h3>Log me in</h3>
			<div class='left'>
				<br />
				<br />
				<br />	
				Connect with facebook
			</div>
			<div class='right'>
			
				<input type='email' name='email' placeholder='Email' required>			
				<input type='password' name='password' placeholder='Password' required>	
								
				<input type='submit' class='btn login-btn' value='LOG INTO MY ACCOUNT' name='log_in'> 
				
			</div>
		</form>
	</div>


	<script type="text/javascript">
		$( function() {
			$('span.closed').click( function() {
				$('div.lightOut').hide();
			});

			function position() {
				$('form.customer-login').css( "margin-top" ,function() {
					console.log($(this).height());
					//return ($(this).height())/(-2.0);
					}
				);
				$('form.customer-login').css( "margin-left" ,function() {
					// why +305 ? including margin
					console.log($('form.customer-login').outerWidth());
					//return ($(this).outerWidth()+305)/(-2.0);
					}
				);
			};

			position();

			var i = 1;
			$('form.customer-login a').click( function() {
				if (i % 2 == 1) {
					$('input.login-btn').remove();
					$("<input type='text' name='name' id='mobile' placeholder='Enter Your Name' required> ").prependTo('div.right');
					$("<input type='text' name='mobile_number' id='mobile' placeholder='Mobile Number' maxlength='10' required> ").appendTo('div.right');
					$("<input type='submit' class='btn login-btn' value='CREATE MY ACCOUNT' name='register' required> ").appendTo('div.right');
					$('form.customer-login p span').text("Already have an account?");
					$('form.customer-login p a').text("Login to BCA.com");
					$('form.customer-login h3').text("Registration");
				}
				else {
					
					$('input#mobile, input.login-btn').remove();
					$("<input type='submit' class='btn login-btn' value='LOG INTO MY ACCOUNT' name='login'> ").appendTo('div.right');
					$('form.customer-login p span').text("Not a member?");
					$('form.customer-login p a').text("Create a new account");
					$('form.customer-login h3').text("Log me in");
				}
				i++;
			});
		});
	</script>
