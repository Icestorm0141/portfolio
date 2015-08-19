<?php

	session_name('ajs2189'); 
	session_start();
	
	include "commHelpers.php";
	
	destroyToken($_SESSION['token']);
	$_SESSION['token'] = "";
	$_SESSION['s_Us3rName'] = "";
	session_destroy();
	header("Location:../index.php");
?>