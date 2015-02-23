<?php
	if (isset($_POST['register'])) {
		$new_customer['email']            = $_POST['email'];
		$new_customer['password'] 		  = $_POST['password'];
		$new_customer['mobile_number']    = $_POST['mobile_number'];
		
		if (Customer::insert($new_customer)) {
			$customer = Customer::select_by($_POST['email'],$_POST['password']);
			$customer_session->log_in($customer);
			header('location: '.$_SERVER['PHP_SELF']);
		} else {
			echo "error";
		}
	}

	if (isset($_POST['login'])) {

		if($customer = Customer::select_by($_POST['email'],$_POST['password'])) {
			$customer_session->log_in($customer);
			header('location: '.$_SERVER['PHP_SELF']);
		} else {
			echo "invalid email/password";
		}
	}
?>
<?php if(!$customer_session->is_logged_in()) : ?>
	<!-- if user is not logged in echo the following form -->
	<div class='lightOut'>
		<form class='customer-login' method='post' name='customer-login'>
			<span class='closed'>X</span>
			<p><span>Already have an account?</span> <a href='#'>Login to BCA.com</a></p>
			<h3>Registration</h3>
			<div class='left'>
				<br />
				<br />
				<br />	
				Connect with facebook
			</div>
			<div class='right'>
			
				<input type='email' name='email' placeholder='Email'>			
				<input type='password' name='password' placeholder='Password'>	
				<input type='text' name='mobile_number' id='mobile' placeholder='Mobile Number'>
				
				<input type='submit' class='btn login-btn' value='CREATE MY ACCOUNT' name='register'> 
				
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
					return ($(this).height())/(-2.0);
					}
				);
				$('form.customer-login').css( "margin-left" ,function() {
					// why +305 ? including margin
					return ($(this).outerWidth()+305)/(-2.0);
					}
				);
			};

			position();

			var i = 1;
			$('a').click( function() {
				if (i % 2 == 1) {
					$('input#mobile, input.login-btn').remove();
					$("<input type='submit' class='btn login-btn' value='LOG IN TO MY ACCOUNT' name='login'> ").appendTo('div.right');
					$('p span').text("Not a member?");
					$('p a').text("Create a new account");
					$('h3').text("Log me in");
				}
				else {
					$('input.login-btn').remove();
					$("<input type='text' name='mobile_number' id='mobile' placeholder='Mobile Number'> ").appendTo('div.right');
					$("<input type='submit' class='btn login-btn' value='CREATE MY ACCOUNT' name='register'> ").appendTo('div.right');
					$('p span').text("Already have an account?");
					$('p a').text("Login to BCA.com");
					$('h3').text("Registration");
				}
				i++;
			});
		});
	</script>

<?php endif ?>