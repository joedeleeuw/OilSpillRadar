<?

/*

Written by: Jonathan Logan
Edited by: Nazarelle VanPutte
Desc: Parses data.txt and adds the data to the database.

*/


ob_start();

session_name("DD");
session_start();

define('INCLUDE_CHECK',true);

require 'inc/connect.php';

$id = $_POST["id"];
$title = $_POST["title"];


$data = array();

$json = file_get_contents("data.txt");


$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

$i = 0;

foreach ($jsonIterator as $key => $val) {
    if(is_array($val)) {
        
    } else {
    
    	$data[$i] = $val;
    	$i++;
    
    }
}

$i = 0;
$len = count($data)/2;
$j = 0;

for($i; $i < $len; $i++) {
	
	$num = $data[$j];
	echo $num;
	$j++;
	$amp = $data[$j];
	echo $amp;
	$j++;
	
	$query = "INSERT INTO `samples`(`Number`, `Amplitude`, `SetID`) VALUES (\"$num\",\"$amp\",\"$id\")";
	
	echo $query;
	
	mysql_query($query);
	
}

header("location: samples.php?ID=$id");

?>