<?

/*

Written By: Jonathan Logan

Desc: Runs the capture.py script, and imports basic stuff to the database


*/


ob_start();

session_name("DD");
session_start();

define('INCLUDE_CHECK',true);

require 'inc/connect.php';

$RT = $_POST["config"];

if($RT == 0) {
	
	$T = "V";
	$R = "V";
	
}

if($RT == 1) {
	
	$T = "V";
	$R = "H";
	
}

if($RT == 2) {
	
	$T = "H";
	$R = "V";
	
}

if($RT == 3) {
	
	$T = "H";
	$R = "H";
	
}

$title = $_POST["title"];
$txtune = $_POST["txtune"];
$rxtune = $_POST["rxtune"];
$capture = $_POST["capture"];
$oil = $_POST["oil"];
$wspeed = $_POST["wspeed"];
$wamp = $_POST["wamp"];
$wfreq = $_POST["wfreq"];
$com = $_POST["comments"];
$date = date("Y-m-d H:i:s");

$query = "INSERT INTO `sets`( `Title`, `Oil_Amount`, `rxTune`, `TxTune`, `Time_Stamp`, `transferMode`, `receivingMode`, `timeLength`, `waveAmplitude`, `waveFrequency`, `windSpeed`, `Comments`) VALUES (\"$title\",\"$oil\",\"$rxtune\",\"$txtune\",\"$date\",\"$T\",\"$R\",\"$capture\",\"$wamp\",\"$wfreq\",\"$wspeed\",\"$com\")";

mysql_query($query);
$id = mysql_insert_id();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="viewport" content="width=1024px, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <title>Spina</title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/icons.css" />
    <link rel="stylesheet" href="css/formalize.css" />
    <link rel="stylesheet" href="css/checkboxes.css" />
    <link rel="stylesheet" href="css/sourcerer.css" />
    <link rel="stylesheet" href="css/jqueryui.css" />
    <link rel="stylesheet" href="css/tipsy.css" />
    <link rel="stylesheet" href="css/calendar.css" />
    <link rel="stylesheet" href="css/tags.css" />
    <link rel="stylesheet" href="css/selectboxes.css" />
    <link rel="stylesheet" href="css/960.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" media="all and (orientation:portrait)" href="css/portrait.css" />
    <link rel="apple-touch-icon" href="apple-touch-icon-precomposed.png" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/excanvas.js"></script>
    <![endif]-->
    
    <!-- JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jqueryui.min.js"></script>
    <script src="js/jquery.cookies.js"></script>
    <script src="js/jquery.pjax.js"></script>
    <script src="js/formalize.min.js"></script>
    <script src="js/jquery.metadata.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/jquery.checkboxes.js"></script>
    <script src="js/jquery.chosen.js"></script>
    <script src="js/jquery.fileinput.js"></script>
    <script src="js/jquery.datatables.js"></script>
    <script src="js/jquery.sourcerer.js"></script>
    <script src="js/jquery.tipsy.js"></script>
    <script src="js/jquery.calendar.js"></script>
    <script src="js/jquery.inputtags.min.js"></script>
    <script src="js/jquery.wymeditor.js"></script>
    <script src="js/jquery.livequery.js"></script>
    <script src="js/jquery.flot.min.js"></script>
    <script src="js/application.js"></script>
  </head>
  
  <body>

    <!-- Primary navigation -->
    <nav id="primary">
      <ul>
        <li >
          <a href="index.php">
            <span class="icon32 dashboard"></span>
            Dashboard
          </a>
        </li>
        <li>
          <a href="#">
            <span class="icon32 chart"></span>
            Charts
          </a>
        </li>
        
        <li class="active">
          <a href="import.php">
            <span class="icon32 plus2"></span>
            Aquire Data
          </a>
        </li>
        
        <?
        
        $query = "SELECT * FROM `system` WHERE `desc` = \"Power\"";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
		
		if($row["on"] == 1) {
		        
        ?>
        
        <li class="bottom active">
          <a href="off.php">
            <span class="icon32 quit"></span>
            Turn Off
          </a>
        </li>
        
        <?
        
        } else {
        
        ?>
        
        
        <li class="bottom">
          <a href="on.php">
            <span class="icon32 quit"></span>
            Turn On
          </a>
        </li>
        
        <?
        
        }
        
        ?>
        
      </ul>
    </nav>
    
    <!-- Secondary navigation -->
    
    
    <section id="maincontainer">
      <div id="main" class="container_12">
      	<div class="box">
      		<div class="box-header">
      			<h1>Import Data</h1>
      		</div>
      		<div class="box-content">
      			
      			<form action="submit.php" method="post">
      			
      			<? $output = shell_exec("sudo -u root -S python /home/pi/Public/capture.py $capture");
      			
      			
      			// this bit will remove the last }, to make the output valid JSON.
      			
      			if($output == 1) {
	      			
	      			?>
	      			
	      			<input type="hidden" name="id" value="<? echo $id; ?>">
	      			
	      			<p>
	                    <textarea readonly="yes" style="height: 500px;"><? echo file_get_contents("data.txt"); ?></textarea>
                    </p>
	      			
	      			<?
	      			
      			} else {
	      			
	      			echo "The script \"capture.py\" didn't return a 1... yell loudly until help arives.";
	      			
      			}
      			
      			?>
      			
      		</div>
      		<div class="action_bar">
      			<input type="submit" class="button blue" value="Submit" />
      			</form>
      		</div>
      	</div>      
      </div>
    </section>
  </body>
</html>
