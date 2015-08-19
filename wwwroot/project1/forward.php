<?php 

	$authenticated = callAuthentication("Chat","index","forward");
	if($authenticated)
	{
	?>
<script language="javascript">
	var who = "<?php echo $_SESSION['s_Us3rName']; ?>";
</script>
<script language="javascript" src="helpers/chat.js"></script>
<script language="javascript" src="scripts/library.js"></script>
<script language="javascript">
function init()
{
	
	getInfo();
	$("#newName").focus();
	
}
	var myBody = document.getElementsByTagName('body')[0];
	if(checkBrowser() == "modIE") 
	{
		myBody.onload = init;
		myBody.onbeforeunload = logout;
		window.onbeforeunload = logout;
		//alert(myBody.onload);
	} else {
		myBody.setAttribute('onload','init();');
		myBody.setAttribute('unload','logout()');
		//window.addEventListener
		//alert("Other");
	}
	
	//$(window).unload( function() { logout(); });
	var userArray = new Array();

</script>
<div id="chatContainer">

<div id="chatBox"></div>
<a href="#" id="challenge" style="margin-left:30px;" onclick="selectPlayers()" alt="Challenge Users">Challenge Users to a Game!</a>
<select multiple="multiple" id="userList" name="users" disabled="disabled">
</select>
<form method="" action="">
<input type="text" name="newName" id="newName" onchange="getInfo(this.value)"/>
</form>
</div>
<div id="buttonContainer">
<button name="submitBtn" onclick="getInfo(document.getElementById('newName').value);">Send</button>

<a href="helpers/logout.php" alt="Log out">Log out</a>


</div>

<?php
	} else
{
	//header("Location: index.php");
}
?>
            