<?php 
$feed = "http://vega.it.rit.edu/~ajs2189/pfw/inclass/ic07/SkepChrist.rss";
$myRSS = simplexml_load_file($feed);
$htmlString = $myRSS ->channel->title."<br />";
$htmlString .= $myRSS->attributes()->{'version'}."<br />\n";
foreach($myRSS ->channel->item as $item)
{
	$htmlString .="<a href\"$item->link\">"."$item->title</a>$item->description<br />\n";
}
echo $htmlString;
?>
