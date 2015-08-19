<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>set the cookie:cookie example</title>
	<meta name="generator" content="BBEdit 8.7" />
</head>
<body>
<?php

function writeXML($xmlString,$filePath)
{
	$success = "false";
	$fh = fopen($filePath,"w");
	flock($fh,LOCK_EX);
	if ($fh)
	{
		fwrite($fh,$xmlString);
		$success = "true";
	}
	else 
	{
		echo "Cannot write to the file";
	}
	flock($fh,LOCK_UN);
	fclose($fh);
	
	return $success;
}

function showObject($pOneObject, $label="object or variable") {
		$results = "<hr><pre>\n";
		$results .= "Value displayed: $label \n";
		$results .= print_r($pOneObject,true); //second arg enables to return string
		$results .= "</pre>\n";
		return $results;
	}
$fishXML = "<fishlist>";
//$num = 1;
//echo $_REQUEST["myFish".$num."URL"];
for($num = 1; isset($_REQUEST['myFish'.$num."URL"]); $num++)
{
	$fishXML .= "<fish>images/".$_REQUEST["myFish".$num."URL"]."</fish>";
}
$fishXML .="</fishlist>";
echo "Builing Fish XML list......";
//echo "blah".showObject($fishXML);
//$builtXML = $fishXML->asXML();
//echo $builtXML;
if(writeXML("$fishXML","Flash/fish.xml"))
{
	$result = "<script type=\"text/javascript\">\n";
	$result .= "window.location = \"Flash/fishTank.html\"\n";
	$result .="</script>\n";
	echo $result;
}

?>
</body>
</html>