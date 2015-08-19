<?php
include "tools.php";
ini_set("soap.wsdl_cache_enabled", "0");
$client = new SoapClient("http://vega.it.rit.edu/~ajs2189/pfw/project3/weather.wsdl");
$v_States = $client->getStates();
$s_State = $_POST['state'];
$s_City = $_POST['city'];
if(isset($s_City))
{
	$v_Station = $client->getStation($s_City);
	echo "http://www.weather.gov/data/current_obs/".$v_Station.".rss";
}
else if(isset($s_State))
{
	$v_Cities = $client ->getCities($s_State);
	$output = "<form name=\"cityform\" action=\"".$_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
	$output .="<select name=\"city\" onchange=\"cityform.submit()\">\n";
	foreach ($v_Cities as $key => $value)
	{
		$output .="<option value=$value>".$value."</option>\n";
	}
	$output .="</select><br/><br/>\n";
	$output .="</form>";
}

else {
	$output = "<form name=\"stateform\" action=\"".$_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
	$output .="<select name=\"state\" onchange=\"stateform.submit()\">\n";
	foreach ($v_States as $key => $value)
	{
		$output .="<option value=\"$value\">".$value."</option>\n";
	}
	$output .="</select><br/><br/>\n";
	$output .="</form>";
}
echo $output;
?>