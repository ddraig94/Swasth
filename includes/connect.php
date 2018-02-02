<?php

	$server="localhost";
	$username="root";
	$password="";
	$db="db_hackathon";
	
	$connection = mysqli_connect($server, $username, $password, $db);
	
	if( ! $connection ){
		die("Connection Failed " . mysqli_connect_error());
	}

	//echo("Connection Established!");
	
	
	//CREATE TABLE `clients` ( `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,  `name` VARCHAR(100) NOT NULL ,  `email` VARCHAR(100) NOT NULL ,  `address` TEXT NULL ,  `phone` VARCHAR(30) NULL ,  `company` VARCHAR(100) NULL ,  `notes` TEXT NULL ,  `date_added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,    PRIMARY KEY  (`id`))

	
	//ALTER TABLE `clients_1` ADD UNIQUE(`email`);
?>