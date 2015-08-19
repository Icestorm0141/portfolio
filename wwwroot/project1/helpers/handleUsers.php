<?php
		include "../../../dbInfo.inc";
		include "commHelpers.php";
		
		if($stmt = $mysqli->prepare("SELECT username FROM users where loggedIn = '1'"))
		{
			$data = returnAssArray($stmt);
			$data = json_encode($data);
			$stmt->close();
		}

//next 5 lines will clear the cache
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//this line MUST be here, it declares the content-type
header('Content-Type: text/plain'); 
echo $data; // This will become the response value for the XMLHttpRequest object
?>







