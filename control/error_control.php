<?php
class error_control
  {
  public function error_control()
	{
	//include_once("model/blog_control.php");
	}
  public function error()
	{
	if ($_GET["ajax"]=="")
	   {
	   include("view/main.php");
	   } 
	   else
	   	  {
	      echo 'Uhm.. No, you dont have permission to do that';
	      }
	}	
  public function main()
	{
    echo $_SESSION['apilog'];
	include("view/main.php");
	}		
  public function logout()
	{
	session_destroy();
	header("location: index.php");
	}		
}
?>