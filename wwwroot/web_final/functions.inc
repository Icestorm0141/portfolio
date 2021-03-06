<?php
function showObject($pOneObject, $label="object or variable") {
		$results = "<hr><pre>\n";
		$results .= "Value displayed: $label \n";
		$results .= print_r($pOneObject,true); //second arg enables to return string
		$results .= "</pre>\n";
		return $results;
	}
  
function getStateCode()
{
$stateCode = array(1=> "AL" ,
      "AK" ,
      "AZ" ,
      "AR" ,
      "CA" ,
      "CO" ,
      "CT" ,
      "DE" ,
      "DC" ,
      "FL" ,
      "GA" ,
      "HI" ,
      "ID" ,
      "IL" ,
      "IN" ,
      "IA" ,
      "KS" ,
      "KY" ,
      "LA" ,
      "ME" ,
      "MD" ,
      "MA" ,
      "MI" ,
      "MN" ,
      "MS" ,
      "MO" ,
      "MT" ,
      "NE" ,
      "NV" ,
      "NH" ,
      "NJ" ,
      "NM" ,
      "NY" ,
      "NC" ,
      "ND" ,
      "OH" ,
      "OK" ,
      "OR" ,
      "PA" ,
      "RI" ,
      "SC" ,
      "SD" ,
      "TN" ,
      "TX" ,
      "UT" ,
      "VT" ,
      "VA" ,
      "WA" ,
      "WV" ,
      "WI" ,
      "WY" );
return $stateCode;
}

function getStateName()
{
  $stateName = array(1=> "Alabama", 
      "Alaska", 
      "Arizona", 
      "Arkansas", 
      "California", 
      "Colorado", 
      "Connecticut", 
      "Delaware", 
      "District of Columbia", 
      "Florida", 
      "Georgia", 
      "Hawaii", 
      "Idaho", 
      "Illinois", 
      "Indiana", 
      "Iowa", 
      "Kansas", 
      "Kentucky", 
      "Louisiana", 
      "Maine", 
      "Maryland", 
      "Massachusetts", 
      "Michigan", 
      "Minnesota", 
      "Mississippi", 
      "Missouri", 
      "Montana", 
      "Nebraska", 
      "Nevada", 
      "New Hampshire", 
      "New Jersey", 
      "New Mexico", 
      "New York", 
      "North Carolina", 
      "North Dakota", 
      "Ohio", 
      "Oklahoma", 
      "Oregon", 
      "Pennsylvania", 
      "Rhode Island", 
      "South Carolina", 
      "South Dakota", 
      "Tennessee", 
      "Texas", 
      "Utah", 
      "Vermont", 
      "Virginia", 
      "Washington", 
      "West Virginia", 
      "Wisconsin", 
      "Wyoming");
return $stateName;
}
?>
