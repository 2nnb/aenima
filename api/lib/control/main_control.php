<?php
class main_control
  {
  public function main_control()
	  {
	  //$_SESSION['api']->log('loading '.$_SESSION['app'].' main control');
	  }
  public function error()
	  {
    //echo $_SESSION['api']->apilog;    
	  include("./view/main.php");
	  }	
  public function main()
	  {
	  //echo $_SESSION['api']->apilog;             			    
	  include("./view/main.php");
	  }
  public function user()
    { 
    include("./view/main_user.php"); 
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
       	  //echo $_SESSION['api']->apilog;           	  
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
       	  //echo $_SESSION['api']->apilog;		
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
       	  //echo $_SESSION['api']->apilog;           	  
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
       	  //echo $_SESSION['api']->apilog;		
          echo $modjson;
          }
    }              
  public function superuser()
    {	
	include("./view/superuser.php");    	
    }			
  public function logout()
	  {	
    session_destroy(); 
    session_start(); 
    //$_SESSION['api'] = new aenima('aenima', 'https://lh3.googleusercontent.com/-9a0y-GzcK2o/T-pcVa8cc3I/AAAAAAAAAD4/oLzbfVwBvYY/s450-no/fp.jpg', '346445246321.apps.googleusercontent.com', 'u0GmIsKRx-Qb5lDMzd03xoVH', 'http://ec2-54-204-3-189.compute-1.amazonaws.com', 'http://ec2-54-204-3-189.compute-1.amazonaws.com:1337');
	  header("location: ./");
	  }		
}
?>