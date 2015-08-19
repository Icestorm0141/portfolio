<?	
    session_name('ajs2189'); 
	session_start();
    include "tools.php";
	include "helpers/commHelpers.php";
	$authenticated =callAuthentication("Chat","index","forward");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project 1 - Chat Program</title>
<link href="styles/style.css" type="text/css" rel="stylesheet" />
<script src="scripts/jquery-1.3.2.min.js"></script>
<script src="scripts/jquery.appendDom.js"></script>
<script src="helpers/HttpClient.js"></script>
<script src="scripts/library.js"></script>
</head>

<body>
<div id="container">
	<div id="contentContainer">
		<?php
		if($authenticated == "true")
		{
			$content = displayChat();
		}
		else
		{
			if($authenticated != "false") $content = "<span>$authenticated</span>"; //use jquery to get the p element and replace it with authenticated
			if(isset($_GET['from'])) $content .= "<span>You must log in to play a game.</span>";
			$content .= displayForm("chat");
		}
		
		echo $content;
		?>
		<script type="text/javascript">
			$("#contentContainer h2").append($("#contentContainer span"));
		</script>
    </div>
</div>
</body>
</html>
<?php //echo phpinfo();echo "blah".$_SERVER['HTTP_REFERER']; ?>