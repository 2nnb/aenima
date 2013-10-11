<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="ico/favicon.png">
    <link rel="stylesheet" href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
    <link rel="stylesheet" href='css/style.css' rel="stylesheet">
    <title>ænima - <?php echo $_SESSION['module'] ?></title>
  </head>
<body onload="var app = new App(self);"  data-spy="scroll">
<div id="facebox_overlay">
    <div id="loaderImage"></div>
</div>
<script src="http://54.235.167.23:1337/socket.io/socket.io.js"></script>	
  <?php
    $module_input = "<input type='hidden' id='module_input' value='".$_SESSION["module"]."' />";
    $action_input = "<input type='hidden' id='action_input' value='".$_SESSION["action"]."' />";
    print '<input type="hidden" id="user_id_input" value="'.$_SESSION["id_user"].'" />';
    print '<input type="hidden" id="user_input" value="'.$_SESSION["persona_google_name"].'" />';
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
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <?php
          if (isset($_SESSION['client_google']))
             {
             if (isset($_SESSION['persona_google_name']))
                {
                print '<a href="#" class="dropdown-toggle" data-toggle="dropdown"> '.$_SESSION['persona_google_img'].'</a>';
                } 
             }
        ?>        
        <ul class="dropdown-menu">
          <li><a href="?h2o=2">Salir</a></li>
        </ul>
      </li>
    </ul>            
        
      </div>
    </nav>
   <?php
     include('view/'.$_SESSION["module"]."/".$_SESSION["module"]."_".$_SESSION["action"].".php");
   ?>
    <script type="text/javascript" language="javascript" src="js/class.js"></script>
    <script type="text/javascript" language="javascript" src="js/log.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/dataTables.bootstrap.js"></script>    
    <script type="text/javascript" language="javascript" src="js/App.js"></script>    
  </body>
</html>