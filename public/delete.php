<?

ob_start();

session_name("DD");
session_start();

define('INCLUDE_CHECK',true);

require 'inc/connect.php';

$id = $_GET["id"];

$query = "DELETE FROM `sets` WHERE `ID` = \"$id\"";

mysql_query($query);

$query = "DELETE FROM `samples` WHERE `SetID` = \"$id\"";

mysql_query($query);

header("location: index.php");

?>