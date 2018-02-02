<?php

	session_start();
	if( !isset($_SESSION['login_id']) ){
		header("location: /hackathon");
	}

	$clinic_name="IIITA Health Center";
	$clinic_id  =5;

	while(0){

	}

?>