<?php
session_start(); 
include "scripts/commHelpers.php";	
include "tools.php";
include "gameFunctions.php";

$tag =  $_GET['user'];
$role = getRole($tag);
	echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>EcoGame</title>
	<script type="text/javascript" src="scripts/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.appendDom.js"></script>
<script type="text/javascript" src="scripts/HttpClient.js"></script>
<script type="text/javascript" src="scripts/chatClient.js"></script>
<script type="text/javascript">
var gamerTag = '<?php echo $tag; ?>';
var role = '<?php echo $role; ?>';

function fillInData()
{
	
}
</script>
<script type="text/javascript" src="scripts/library.js"></script>

	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="debug"></div>
<div style="margin-right:auto; margin-left:auto; width: 1000px;"> 
<div id = "left" >
	<div>
		<p id = "playerData" style = "margin-top: 5px;" >	Player: <?php echo $tag; ?> </p>
      <p id="role"> Role: <?php echo $role; ?></p>
		<span id = "playerData" style = "float: left; padding-top: 10px"> Change Production: </span>
	  <form method="post" action="">
		  
		  <span id="production" style="float:right;">
		    <input type="text" id="txtProduction" value="0" style="height: 20px; padding: 0px; text-align:center; margin-left: 30px; position: relative; top: 2px; " />
	      <input type="button" value="Change" style="height:25px;margin-left:5px;position: relative; top: 4px;" onclick="updateProd()" />
		  </span>
	  </form>
      
	</div>
	<div style="clear:both"></div>
	<div id = "playArea">The pictoral interface would go here</div>
    <div id="chat" class="chat_main">
			
		</div>
		<form id="frmmain" name="frmmain" onsubmit="">
			<input type="text" id="txt_message" name="txt_message" style="width: 580px; position:relative; top: -25px; left: 2px;" />
			<input type="button" name="btn_send_chat" id="btn_send_chat" value="Send" style = "border-style: 1px solid #000; position:relative; top: -25px; float: right;"/>
		</form>
</div>
<div id = "right">
<div style = "text-align: center; height: 25px; padding-top: 5px;"> <p style="padding: 0px; position: relative; top: -15px; margin-left: auto; margin-right: auto;"> <b>Your Production</b></p></div>
<div id = "prodMonitor"> <span id="indVal">4</span>/<span id = "indMax">10</span>  </div>

<div style = "text-align: center; height: 25px; padding-top: 15px;"> <p style="padding: 0px; position: relative; top: -15px; margin-left: auto; margin-right: auto;"> <b>Your Externality</b></p></div>
<div id = "extMonitor"><span id="indExt">7.3</span></div>

<div style = "text-align: center; height: 25px; padding-top: 15px;"> <p style="padding: 0px; position: relative; top: -15px; margin-left: auto; margin-right: auto;"> <b>Grade</b></p></div>
<div id = "resourceMonitor"><span id ="grade"> 104 </span></div>
<div id = "navBar"></div>
</div>
</div>
</body>
</html>