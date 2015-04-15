<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="viewport" content="user-scalable=no" />
    
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
  
  <body id="login">
  
    <div id="login_container">
      <div id="login_form">
        <form method="post" action="/login">
          <p>
            <input type="text" id="username" name="username" placeholder="Username" class="{validate: {required: true}}" />
          </p>
          <p>
            <input type="password" id="password" name="password" placeholder="Password" class="{validate: {required: true}}" />
          </p>
          <button type="submit" class="button blue">Login</button>
        </form>
      </div>
    </div>
  </body>
</html>