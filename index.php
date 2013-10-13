<?php
  error_reporting(E_ALL + E_STRICT);
  require_once 'api.php';
  session_start();
  $_SESSION['api'] = new api('aenima');  
  if (isset($_GET['h2o'])) 
     {    
     $_SESSION['h2o'] = $_GET['h2o'];
     }
  if (isset($_GET['r'])) 
     {    
     $_SESSION['h2o'] = $_GET['r'];
     //header("location: index.php");
     }     
  if (isset($_GET['callback']))
     {
     $_SESSION['callback'] =  $_GET['callback'];
     }
  if (isset($_GET['filter']))
     {
     $_SESSION['filter'] =  $_GET['filter'];
     }
     else
        {
        $_SESSION['filter'] = null;
        }        
  $module = $_SESSION['api']->load_module($_SESSION['h2o']);           
?>
