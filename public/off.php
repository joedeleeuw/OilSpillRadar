<?php

session_name("DD");
session_start();

define('INCLUDE_CHECK',true);

require 'inc/connect.php';

$query = "UPDATE `system` SET `on` = 0 WHERE `desc` = \"Power\"";
mysql_query($query);

system("sudo -u root -S python /home/pi/Scripts/off.py");

header("location: index.php");

?>