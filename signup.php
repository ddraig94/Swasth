<?php

	$signup_error="";

	if( isset($_POST['signup-submit']) ){

		include("includes/functions.php");
		include("includes/connect.php");

		$name=validate_data($_POST['signup-name']);
		$email=validate_data($_POST['signup-email']);
		$pass=validate_data($_POST['signup-pass']);
		$conf_pass=validate_data($_POST['signup-conf-pass']);
		$clinic_name=validate_data($_POST['signup-clinic-name']);
		$default_time=validate_data($_POST['signup-default-time']);
		$default_duration=validate_data($_POST['signup-default-duration']);
		$clinic_id=validate_data($_POST['signup-clinic-id']);
		$clinic_locality=validate_data($_POST['signup-clinic-locality']);
		$clinic_city=validate_data($_POST['signup-clinic-city']);
		$clinic_state=validate_data($_POST['signup-clinic-state']);
		$type=0;	# 1 if doctor 


		if($name==="") $signup_error="<div class='alert alert-danger'>Enter a proper name.</div>";
		
		else if($email==="") $signup_error="<div class='alert alert-danger'>Enter a proper Email.</div>";

		else if($pass==="") $signup_error="<div class='alert alert-danger'>Enter a proper Password. A proper pasword can't have (spaces, ( , ) , \). </div>";

		else if($conf_pass!==$pass) $signup_error="<div class='alert alert-danger'>Passwords doesn't match</div>";

		else if(checkIfEmailExist($email)){
			$signup_error="<div class='alert alert-danger'>User Already Exists.</div>";
		}


		else if(isset($_POST['signup-if-doc'])){

			if(isset($_POST['signup-if-newclinic'])){

				if($clinic_name===""){
					$signup_error="<div class='alert alert-danger'>Enter Clinic Name.</div>";
				}
				else if($clinic_locality===""){
					$signup_error="<div class='alert alert-danger'>Enter Locality.</div>";
				}
				else if($clinic_city===""){
					$signup_error="<div class='alert alert-danger'>Enter City.</div>";
				}
				else if($clinic_state===""){
					$signup_error="<div class='alert alert-danger'>Enter State.</div>";
				}

				else {
					
					$type=1;
					$signup_query   = "INSERT INTO `users` (`id`, `email`, `name`, `password`, `type`,`signup_date`) VALUES (NULL, '".$email."', '".$name."', '".$pass."', ".$type." , CURRENT_TIMESTAMP);";
					$result=mysqli_query($connection,$signup_query);					
					
					$doc_id=getDocId($email);
					
					$signup_newclinic_query  = "INSERT INTO `clinics` (`clinic_id`, `clinic_name`, `locality`, `city`,`state` , `added_by`) VALUES (NULL, '".$clinic_name."', '".$clinic_locality."', '".$clinic_city."', '".$clinic_state."', ".$doc_id." );";
					$result=mysqli_query($connection,$signup_newclinic_query);

					$clinic_id = getClinicId($clinic_name,$clinic_locality,$clinic_city);

					$signup_doc_query  = "INSERT INTO `doctors` (`doc_id`, `doc_name`, `availability` , `default_sit_time`,`default_sit_duration`,`clinic_id`) VALUES (".$doc_id.", '".$name."', 0, '".$default_time."', '".$default_duration."' , ".$clinic_id." );";
					$result = mysqli_query($connection,$signup_doc_query);
					
				}				

			}

			else if($clinic_id==""){
				$signup_error="<div class='alert alert-danger'>Enter proper Clinic Id.</div>";
			}
			else {
			
				$type=1;
				$signup_query   = "INSERT INTO `users` (`id`, `email`, `name`, `password`, `type`,`signup_date`) VALUES (NULL, '".$email."', '".$name."', '".$pass."', ".$type." , CURRENT_TIMESTAMP);";
				$result=mysqli_query($connection,$signup_query);					
				
				$doc_id=getDocId($email);

				$signup_doc_query  = "INSERT INTO `doctors` (`doc_id`, `doc_name`, `availability` , `default_sit_time`,`default_sit_duration`,`clinic_id`) VALUES (".$doc_id.", '".$name."', 0, '".$default_time."', '".$default_duration."' , ".$clinic_id." );";
				$result = mysqli_query($connection,$signup_doc_query);
			}

		}

		else {

			$type=0;
			$signup_query   = "INSERT INTO `users` (`id`, `email`, `name`, `password`, `type`,`signup_date`) VALUES (NULL, '".$email."', '".$name."', '".$pass."', ".$type." , CURRENT_TIMESTAMP);";
			$result=mysqli_query($connection,$signup_query);
		}


		mysqli_close($connection);
	}
	
	include("includes/header.php");
?>
	
	<h1>SignUp</h1>

	<?php echo $signup_error; ?>

	<form method='post'>
		
		<div class="form-group">
			<label for='signup-name'>Name</label>
			<br>
			<input class="form-control" type="text" name="signup-name" id="signup-name">
		</div>

		<div class="form-group">
			<label for='signup-email'>Email</label>
			<br>
			<input class="form-control" type="text" name="signup-email" id="signup-email">
		</div>

		<div class="form-group">
			<label for='signup-pass'>Password</label>
			<br>
			<input class="form-control" type="password" name="signup-pass" id="signup-pass">
		</div>

		<div class="form-group">
			<label for='signup-conf-pass'>Confirm Password</label>
			<br>
			<input class="form-control" type="password" name="signup-conf-pass" id="signup-conf-pass">
		</div>

		<div class="form-group" >
			<input type="checkbox" name="signup-if-doc" value=1 id="doctor">I'm a Doctor
		</div>

		<div class="form-group doc-info">
			<label for='signup-default-time'>Time at which you are expected at Clinic.</label>
			<br>
			<input class="form-control" type="time" name="signup-default-time" id="signup-default-time">
		</div>

		<div class="form-group doc-info">
			<label for='signup-default-duration'>Duration for which you will be available.</label>
			<br>
			<input class="form-control" type="time" name="signup-default-duration" id="signup-default-duration">
		</div>

		<div class="form-group doc-info">
			<label for='signup-clinic-id'>Clinic Id</label>
			<br>
			<input class="form-control" type="text" name="signup-clinic-id" id="signup-clinic-id">
		</div>

		<div class="form-group doc-info">
			<input type="checkbox" name="signup-if-newclinic" value=1 id='clinic'>New Clinic
		</div>

		<div class="form-group doc-info clinic-info">
			<label for='signup-clinic-name'>Clinic Name</label>
			<br>
			<input class="form-control" type="text" name="signup-clinic-name" id="signup-clinic-name">
		</div>

		<div class="form-group doc-info clinic-info">
			<label for='signup-clinic-locality'>Locality</label>
			<br>
			<input class="form-control" type="text" name="signup-clinic-locality" id="signup-clinic-locality">
		</div>

		<div class="form-group doc-info clinic-info">
			<label for='signup-clinic-city'>City</label>
			<br>
			<input class="form-control" type="text" name="signup-clinic-city" id="signup-clinic-city">
		</div>

		<div class="form-group doc-info clinic-info">
			<label for='signup-clinic-state'>State</label>
			<br>
			<input class="form-control" type="text" name="signup-clinic-state" id="signup-clinic-state">
		</div>

		<div class="form-group">
			<button class="btn btn-success" name="signup-submit">Submit</button>
		</div>

	</form>

	<?php
		 $script="
		 <script type='text/javascript'>
		
		 $(function(){
			
		 	$('.doc-info').hide();

		 	$('#doctor').click(function(){
		 		if(document.getElementById('doctor').checked) {
				    $('.doc-info').show(300);
				    $('.clinic-info').hide();
				    
				} else {
				    $('.doc-info').hide(200);

				}
		 	});

		 	$('#clinic').click(function(){
		 		if(document.getElementById('clinic').checked) {
				    $('.clinic-info').show(300);
				} else {
				    $('.clinic-info').hide(200);
				}
		 	});

		 });

	 </script>"; ?>

	
<?php include("includes/footer.php"); ?>

