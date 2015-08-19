#! /usr/bin/php
<?php
$myRSSfile = file("http://www.skepticalchristian.com/rss/");
echo implode($myRSSfile);

?>