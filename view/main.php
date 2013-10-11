<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="ico/favicon.png">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href='css/style.css' rel="stylesheet">
    <title>ænima - <?php echo $_SESSION['module'] ?></title>
  </head>
<body onload="var app = new App(self);"  data-spy="scroll"> 
<div id="facebox_overlay">
    <div id="loaderImage"></div>
</div>
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=358283570941553";
  fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
  <?php
    $module_input = "<input type='hidden' id='module_input' value='".$_SESSION["module"]."' />";
    $action_input = "<input type='hidden' id='action_input' value='".$_SESSION["action"]."' />";
    print $module_input;
    print $action_input;  
  ?>    
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex2-collapse">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"/>
         <span class="icon-bar"/>
         <span class="icon-bar"/>
         </button>
         <a class="navbar-brand" href="#"><img src="ico/logo.png"></img></a>
      </div>
         <div class="collapse navbar-collapse navbar-ex2-collapse">
        <?php
          if (isset($_SESSION['client_google']))
             {
             print $_SESSION['google_sign_in'];   
             }
        ?>  
      </div>
    </nav>
   <?php
     include('view/'.$_SESSION["module"]."/".$_SESSION["module"]."_".$_SESSION["action"].".php");
   ?>
    <script type="text/javascript" src="js/class.js"></script>
    <script type="text/javascript" src="js/log.js"></script>
    <script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/App.js"></script>
  </body>
</html>