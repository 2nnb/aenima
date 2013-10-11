<?php
class main_control
  {
  public function main_control()
	{
	$_SESSION['api']->log('loading '.$_SESSION['app'].' main control');
	}
  public function error()
	{
  echo $_SESSION['apilog'];    
	include("view/main.php");
	}	
  public function main()
	{
	echo $_SESSION['apilog'];             			    
	include("view/main.php");
	}
  public function app_list()
    {
    $modules = $_SESSION['api']->load_app_list();
    $modjson = json_encode($modules);    
    header("Content-type: application/json");      
    if (isset($_SESSION['callback']))
       {
       echo $_SESSION['callback']."(".$modjson.")";
       }
       else
       	  {
       	  //echo $_SESSION['apilog'];           	  
          echo ($modjson);
          }      
    }
  public function view_list()
    {	
    $modules = $_SESSION['api']->load_view_list($_SESSION['filter']);
    $modjson = json_encode($modules);    
    header("Content-type: application/json");      
    if (isset($_SESSION['callback']))
       {
       echo $_SESSION['callback']."(".$modjson.")";
       }
       else
       	  {    
       	  //echo $_SESSION['apilog'];		
          echo $modjson;
          }      
    }
  public function struct_list()
    {
    $modules = $_SESSION['api']->load_struct_list($_SESSION['filter']);
    $modjson = json_encode($modules);    
    header("Content-type: application/json");      
    if (isset($_SESSION['callback']))
       {
       echo $_SESSION['callback']."(".$modjson.")";
       }
       else
       	  {
       	  //echo $_SESSION['apilog'];           	  
          echo ($modjson);
          }       	
    } 
  public function table_list()
    {
    $modules = $_SESSION['api']->load_table_list($_SESSION['filter']);
    $modjson = json_encode($modules);    
    header("Content-type: application/json");      
    if (isset($_SESSION['callback']))
       {
       echo $_SESSION['callback']."(".$modjson.")";
       }
       else
       	  {    
       	  //echo $_SESSION['apilog'];		
          echo $modjson;
          }
    }
  public function app()
    {
    include("view/main_superuser.php");	
    }
  public function struct()
    {
    include("view/main_superuser.php");	
    }               	
  public function user()
    {	
    include("view/main_user.php");	
    }	
  public function superuser()
    {	
	include("view/main_superuser.php");    	
    }			
  public function logout()
	{	
	if (isset($_SESSION['in_app']))
	   {
	   $in_app = $_SESSION['in_app'];
	   session_unset('in_app');	
	   session_destroy();	
	   header("location: ../".$in_app."/index.php");
	   }
	   else
	   	  {
	   	  session_destroy();
	   	  header("location: index.php");
	   	  }
	}		
}
?>