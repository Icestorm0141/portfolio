<?php
function getRole($role)
{
	include "dbInfo.inc";
	if($stmt = $mysqli->prepare("SELECT roleName from RoleTable r join Player p using(roleId) where p.gamerTag = ?"))
	{
		$stmt->bind_param("s",$role);
		$data = returnAssArray($stmt);
		$stmt->close();
	}
	return $data[0]['roleName'];
}
?>