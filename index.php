<?php
  require_once 'api/lib/aenima.php';
  session_start();  
  if (!(isset($_SESSION['api'])))
  	 {
  	 //Local deploy start 	
     $_SESSION['api'] = new aenima('aenima', 'https://lh3.googleusercontent.com/-9a0y-GzcK2o/T-pcVa8cc3I/AAAAAAAAAD4/oLzbfVwBvYY/s450-no/fp.jpg', '800208504678-hqp091fanunajd8nm5v30k6jpe02f03t.apps.googleusercontent.com', 'uDqnb5SMm_YlkbnE00cwOQJT', 'http://localhost/aenima/', 'http://54.204.3.189:1337');              
  	 
  	 
  	 //Remote deploy start
  	 //You can edit this data with your own google access data 
  	 //to create your app access data go to https://code.google.com/apis/console/
  	 //you can use the default port or make your own with the /api/api.js script runing in node
  	 //to run the nodejs part you need to npm install, node_modules are not in the repo
     
     //$_SESSION['api'] = new aenima('name_app', 'logo_app', 'user_id_google', 'user_secret_google', 'redirect_url', 'port_host_socket');
     header("location: ./");
     }
     else
     	{     	
     	$_SESSION['api']->run();
     	}
?>
