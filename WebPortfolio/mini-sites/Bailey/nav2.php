</div><div id="leftNav"></div><div class='addContent'><?php
$beginTags = "<div class='leftNav1'>Additional Content</div><ul>";
$endTags = "</ul><a href='javascript:history.go(-1)'>Go back</a></div>";
	switch($folderID){ //Switch conditional
       		case "biography/":
				$content = "<li class=\"leftNavLI\"><a href='index.php?mbc=about_teaching'>Teaching and Educational Activities</a><br/></li>";
				$content .="<li class=\"leftNavLI\"><a href='index.php?mbc=about_other'>Other Accomplishments and Achievements</a></li>";
           		echo $beginTags.$content.$endTags;
           		break; 
			/*	
			case "courses/":
				$content = "<li class=\"leftNavLI\"><a href='index.php?mbc=thermodynamics'>Thermodynamics</a></li>";
				$content .="<li class=\"leftNavLI\"><a href='index.php?mbc=adv_thermo'>Advanced Thermodynamics</a></li>";
				$content .="<li class=\"leftNavLI\"><a href='index.php?mbc=designWorkshops'>Design Workshops</a></li>";
				$content .="<li class=\"leftNavLI\"><a href='index.php?mbc=honors'>Honors Course Sequence</a></li>";
				$content .="<li class=\"leftNavLI\"><a href='index.php?mbc=heatTransfer'>Heat Transfer</a></li>";
				$content .="<li class=\"leftNavLI\"><a href='index.php?mbc=Refrig_air'>Refridgeration & Air Conditioning</a></li>";
           		echo $beginTags.$content.$endTags;
           		break; 
			
			case "research/":
				$content = "Additional research links will go here";
				echo $beginTags.$content.$endTags;
				break;
				
			case "capstone/":
				$content = "Additional capstone links will go here";
				echo $beginTags.$content.$endTags;
				break;
				
			case "advising/":
				$content = "Additional Advising links will go here";
				echo $beginTags.$content.$endTags;
				break;
				
			case "cirDevel/":
				$content = "Addition Cirriculumn Development links will go here";
				echo $beginTags.$content.$endTags;
				break;
				*/
			case "we/":
				$content = "<li class=\"leftNavLI\"><a href='http://we.rit.edu'>WE@RIT</a></li>";
				$content .="<li class=\"leftNavLI\"><a href=\"http://teak.rit.edu\">TEAK</a></li>";
				echo $beginTags.$content.$endTags;
				break;
			
       		default:
           		$content = "<div class='leftNav1'>Contact Dr. Bailey</div>";
				$content .="<ul style='margin-left:-5px; padding-left:0px; line-height:140%; list-style:none;'>";
				$content .="<li style='margin-bottom:15px;'>Email:<br/><em><a href=\"mailto:margaret.bailey@rit.edu\" style=\"margin-left:0px; font-size:14px;\">margaret.bailey@rit.edu</a></em></li>";
				$content .="<li style='margin-bottom:15px;'>Office Phone:<em><br/>(585)475-2960</em></li>";
				$content .="<li style='margin-bottom:15px;'>Office Number:<em><br/>09-2061</em></li>";
				echo $content.$endTags;
			break;
	}
?>
</div><div id="vBar"></div>
</body>
</html>
