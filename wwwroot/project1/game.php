<?php 
    session_name('ajs2189'); 
	session_start();
	
	include "helpers/commHelpers.php";
	include "helpers/gameFunctions.php";
	
	findCurrentGame();
	
	$playerId = $_SESSION['pl@yerId'];
	$player1 = $_SESSION['pl@yer1'];
	$player2 = $_SESSION['pl@yer2'];
	$player3 = $_SESSION['pl@yer3'];
	$player4 = $_SESSION['pl@yer4'];
	$_SESSION[$playerId.'_UpdatedTurn'] = "true";
	$gameId = $_SESSION['g@meId']; 
	
	if(!(isset($_SESSION[$playerId.'added'])))
	{
		//echo "hello";
		addPlayer($playerId);
	}
	$discard = dealDiscard($gameId,$playerId);
	$table = dealTable($gameId);
	//make sure the mine-type is SVG (xml), NOT html...
	header('Content-type: application/xhtml+xml');
	//HAVE TO echo this out - if not php short open tags will try to parse
	echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Project 1 - Rummy</title>
<link rel="stylesheet" type="text/css" href="styles/game.css" />

<!-- include components for the game -->
<script src="Player.js" type="text/javascript"></script>
<script src="Card.js" type="text/javascript"></script>
<script src="helpers/HttpClient.js" type="text/javascript"></script>
<script src="helpers/gameConnections.js" type="text/javascript"></script>
<script src="scripts/gameFunctions.js" type="text/javascript"></script>
<script src="scripts/library.js" type="text/javascript"></script>

<!-- include libraries -->
<script src="scripts/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="scripts/jquery.appendDom.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.7.1.custom.min.js"></script>
<script src="scripts/ui.core.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript">
<![CDATA[
	//newGame();	//call this when challenged
	var player1 = new Player("<?php echo $player1; ?>",1);
	var player2 = new Player("<?php echo $player2; ?>",2);
	var player3 = new Player("<?php echo $player3; ?>",3);
	var player4 = new Player("<?php echo $player4; ?>",4);
	var playerId = "<?php echo $playerId; ?>";
	var gameId = "<?php echo $gameId; ?>";
	var cardNode = '';
	
	$(document).ready(function () {
		init();
		<?php echo"makeDiscardPile($discard,null);"; ?>
		<?php echo"makeTable($table,null);"; ?>
		
		
		
		//playerArray[playerId].showHand();
			
			$("#table").sortable({stop:function(e,ui){
					$(this).sortable('cancel');
				}, receive: function(e,ui) {
					moveCard($(ui.item).children().children().attr("id"),"table");
				}
			});
			$("#discard").sortable({receive:function(e,ui){
					$(ui.item).remove();
					$("#discard").append(ui.item);
					moveCard($(ui.item).children().children().attr("id"),"discard");
				},stop:function(e,ui){
					$(this).sortable('cancel');
				},remove:function(e,ui){
					$(this).sortable('cancel');
					cardNode = ui.item;
					setTimeout("moveFromDiscard(cardNode)",.5);
					//moveFromDiscard(ui.item);
				},connectWith: '.connect-sort-discard'
			});
			$("#handContainer").sortable({items:'li',placeholder:'placeholder-card',connectWith: '.connected-sortable'
			});
		changeTurn();
		var deckCard = new Card("game_"+gameId, "deck","Deck","backside");
		deckCard.showCard(0,0);
		$('#deck').parent().bind('click',deckClick);
		backCards.push(deckCard);

		//checkForUpdates();
	});
	
]]>
</script>

</head>
<body>
<div id="container">
<span style="float:left"></span><div id="gameStatus"></div>
<div id="scoreCard"><h4 style="margin:0;">Game Score:</h4></div>
<div id="gameContainer"></div>
<ul id="discard">
</ul>
<h3 style="position:relative; top:135px;left:20px">Your hand:</h3>

<ul id="table" class="connected-sortable"></ul>
</div>
</body>
</html>