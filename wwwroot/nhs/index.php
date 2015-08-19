<?php include "nav.php"?>
<?php
$main = "home.php";
$site_error = "error.php";
if(isset($_GET['nhs']))
{
$site_include = "".$_GET['nhs'].=".php";
if(file_exists($site_include))
{
include $site_include;
}
else
{
include $site_error;
}
}
else
{
include $main;
}
?>
<?php include "nav2.php"?>