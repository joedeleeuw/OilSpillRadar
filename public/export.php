<?

ob_start();

session_name("DD");
session_start();

define('INCLUDE_CHECK',true);

require 'inc/connect.php';

$id = $_GET["ID"];


$query = "SELECT * FROM `sets` WHERE `ID` = '$id'";
echo $query."<br>";
$result = mysql_query($query);
mysql_error();

$row = mysql_fetch_assoc($results);

echo "ID,";
echo $row["ID"];
$row["Oil_Amount"];



$query = "SELECT * FROM `samples` WHERE `SetID` = '$id' ORDER BY Number ASC";
//echo $query;
$result = mysql_query($query);
        	

        	
        		
       ?>