<?php

	function validate_data($data){
		$data = str_replace( array( '(' , ')' ) , '' , $data );
		$data = strip_tags($data);
		return trim( stripslashes( htmlspecialchars( $data , ENT_QUOTES ) ) );
	}
	
	function getDocId($email){
		include("connect.php");
		$doc=mysqli_fetch_array( mysqli_query($connection,"SELECT * FROM users WHERE email='".$email."';") );
		return $doc['id'];
	}

	function getClinicId($name){
		include("connect.php");
		$clinic=mysqli_fetch_array( mysqli_query($connection,"SELECT * FROM clinics WHERE clinic_name='".$name."';") );
		return $clinic['clinic_id'];
	}

	function checkIfEmailExist($email){
		include("connect.php");

		$query="SELECT * FROM users WHERE email='".$email."';";
		$result=mysqli_query($connection , $query);

		$user=mysqli_fetch_array( $result );
		
		if(isset($user['id']))return true;
		else return false;

	}

?>