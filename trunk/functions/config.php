<?php
$link = mysql_connect('localhost', 'Dev_IOSNativeApp', 'mobi123DB');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db('Dev_IOSNativeAppDevelopment_07Dec16_Ravi', $link);
if (!$db_selected) {
    die ('Could not connect to Database : ' . mysql_error());
}
