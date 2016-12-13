<?php
$link = mysql_connect('localhost', 'Pro_Qova', 'Dkof)fnjf');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db('Pro_Qova_22Dec15_Sud', $link);
if (!$db_selected) {
    die ('Could not connect to Database : ' . mysql_error());
}
