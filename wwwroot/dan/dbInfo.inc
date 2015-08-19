<?php
	$mysqli=new mysqli('localhost','ajs2189_ajs2189','E54952kg4g','ajs2189_EcoTheory');     
    //check connection
	if(mysqli_connect_errno()){
		printf("connection failed: ",mysqli_connect_errno());
		exit();
	}
?>