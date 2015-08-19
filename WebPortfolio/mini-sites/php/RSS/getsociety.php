#! /usr/bin/php
<?php
$feed = "http://www.christianpost.com/rss/feed.xml?cat=19";
$myRSSfile = file($feed);
echo implode($myRSSfile);

?>