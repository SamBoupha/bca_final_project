<?php
	if (isset($_POST['submit'])) {
		require_once("../../include/initialize.php");

		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);

		$admin = admin::find_admin($username, $password);

		if(empty($admin)) {
			$error = "<h4 class='error'>Username/password is not correct. Please, try again</h4>";
		} else {
			$session->log_in($admin);
			header("location: index.php");
		}

	} 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/admin-login.css">
	</head>
	<body>
		<form method='post' >
			<h2>Admin Section</h2>
			<img src="../img/abc.png" style=" height: 80px">
			<?php echo $error ?><br />
			<label>Username:</label><br />
			<input type='text' name='username' value='<?php echo $username ?>'><br />
			<label>Password:</label><br />
			<input type='password' name='password' value=''><br />
			<input type='submit' class='btn btn-primary' value='Login >>' name='submit'><br />
		</form>
	</body>
</html>