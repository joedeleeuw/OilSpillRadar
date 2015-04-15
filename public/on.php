<?php

session_name("DD");
session_start();

define('INCLUDE_CHECK',true);

require 'inc/connect.php';

$query = "UPDATE `system` SET `on` = 1 WHERE `desc` = \"Power\"";
mysql_query($query);

system("sudo -u root -S python /home/pi/Scripts/on.py");

header("location: index.php");

?>