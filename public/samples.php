<?

ob_start();

session_name("DD");
session_start();

define('INCLUDE_CHECK',true);

require 'inc/connect.php';

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
        <li>
          <a href="index.php">
            <span class="icon32 dashboard"></span>
            Dashboard
          </a>
        </li>
        
        <li class="active">
          <a href="#">
            <span class="icon32 chart"></span>
            Charts
          </a>
        </li>
        
        <li>
          <a href="import.php">
            <span class="icon32 plus2"></span>
            Aquire Data
          </a>
        </li>
      </ul>
    </nav>
    
    <!-- Secondary navigation -->
   <?
        		
        		$id = $_GET["ID"];
        		
        		$query = "SELECT * FROM `samples` WHERE `SetID` = '$id' ORDER BY Number ASC";
        		//echo $query;
        		$result = mysql_query($query);
        		
       ?>
    
    <section id="maincontainer">
      <div id="main" class="container_12">
      
      	<script type="text/javascript">  
          var dataArray = [];
          
          	<? while($row = mysql_fetch_assoc($result)) { ?>
          	
            dataArray.push([<? echo $row["Number"]; ?>, <? echo $row["Amplitude"]; ?>]);
            
            <?
            
            }
            
            ?>
          

          var data = [{
            label: "Power Received (dBm)",
            data: dataArray
          }];

          var options = {
            legend: {
              show: true
            },
            points: {
              show: true,
              radius: 3
            },
            lines: {
              show: true
            },
            grid: {
              borderWidth: 0
            },
            xaxis: {
              tickSize: 1,
              label: "Sample Number"
            },
            yaxis: {
              tickSize: 5,
              label: "Power Received (dBm)",
              tickDecimals: 0
            }
          };

          $('document').ready(function() {
            $.plot($("#jflot"), data, options);
          });
        </script>
        
      
        <div class="box">
          <div class="box-header">
            <h1>Line Chart</h1>
          </div>

          <div class="box-content" style="overflow-x:scroll;">
            <div id="jflot" style="width: 1500%; height: 500px">
            </div>
          </div>

        </div>
      
        <div class="grid_12 box">
        	<div class="box-header">
        		<h1>Samples</h1>
        	</div>
        	<table class="datatable">
        		<thead>
        			<th>
        				Number
        			</th>
        			<th>
        				Power Recieved (dBm)
        			</th>
        			
        			
        		</thead>
        		<tbody>
        		
        		<?
        		mysql_data_seek($result, 0);
        		while($row = mysql_fetch_assoc($result)) {
	        		
	        		?>
	        		
	        		<tr>
	        			<td>
	        				<? echo $row["Number"]; ?>
	        			</td>
	        			<td>
	        				<? echo $row["Amplitude"]; ?>
	        			</td>
	        			
	        			
	        		</tr>
	        		
	        		<?
	        		
        		}
        		
        		?>
        		
        		</tbody>
        	</table>
        		
        
        </div>
      
      </div>
    </section>
  </body>
</html>