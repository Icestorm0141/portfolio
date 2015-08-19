#! /usr/bin/php
<?php
$feed = "http://news.christiansunite.com/rss.cgi";
$myRSSfile = file($feed);
echo implode($myRSSfile);

?>