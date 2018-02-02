<?php

	session_start();
	if( isset($_SESSION['login_id']) ){
		header("Location: user.php");
	}
	else {

		include("includes/functions.php");
		include("includes/connect.php");

		$login_error="";
	
		$email="";
		$pass="";


		if( isset($_POST['login-btn']) ){

			$email=validate_data($_POST['login-email']);
			$pass=validate_data($_POST['login-pass']);

			if ($email=="")$login_error="<div class='alert alert-danger'>Enter a proper Email.</div>";

			else if ($pass=="")$login_error="<div class='alert alert-danger'>Enter a proper password.</div>";

			else{

				$login_query    = "SELECT * FROM users WHERE email = '".$email."';";
				$result=mysqli_query($connection, $login_query);

				$cur_user=mysqli_fetch_array($result);

				if(isset($cur_user['email'])){

					if(password_verify($pass,$cur_user['password'])){

						$_SESSION['login_id']   =$cur_user['id'];
						$_SESSION['login_name'] =$cor_row['name'];
						$_SESSION['login_email']=$cur_user['email'];

						header("Location: user.php");
					}
					else $login_error="<div class='alert alert-danger'>Email and Password doesnot match.</div>"; 

				}else $login_error="<div class='alert alert-danger'>User not found.</div>";
				
			}


		}

		else if( isset($_POST['doc-login-btn']) ){

			$email=validate_data($_POST['login-email']);
			$pass=validate_data($_POST['login-pass']);

			if ($email=="")$login_error="<div class='alert alert-danger'>Enter a proper Email.</div>";

			else if ($pass=="")$login_error="<div class='alert alert-danger'>Enter a proper password.</div>";

			else{

				$result=mysqli_query($connection, $login_query);

				$cur_user=mysqli_fetch_array($result);

				if(isset($cur_user['email'])){

					if($cur_user['type']===0)$login_error="<div class='alert alert-danger'>Sorry! You are not a doctor. Login as User.</div>";

					else if(password_verify($pass,$cur_user['password'])){

						$_SESSION['login_id']   =$cur_user['id'];
						$_SESSION['login_name'] =$cor_row['name'];
						$_SESSION['login_email']=$cur_user['email'];

						header("Location: doctor.php");
					}
					else $login_error="<div class='alert alert-danger'>Email and Password doesnot match.</div>"; 

				}else {
					$email='';
					$login_error="<div class='alert alert-danger'>User not found.</div>";}
				
			}


		}

	}

	mysqli_close($connection);

	include("includes/header.php");
?>
	<h1>Login</h1>

	<?php echo $login_error; ?>

	<form method='post' >
		
		<input class="form-control" type="email" name="login-email" placeholder="Email" value="<?php echo $email; ?>">

		<br>

		<input class="form-control" type="password" name="login-pass" placeholder="Password">

		<br>

		<center>
			<button class="btn btn-info" name="login-btn">Login!</button>
			<button class="btn btn-primary" name="doc-login-btn">Login as Doctor!</button>
		</center>

	</form>


<?php include("includes/footer.php"); ?>