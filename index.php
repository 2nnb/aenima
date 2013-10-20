<?php
  require_once 'api/lib/aenima.php';
  session_start();  
  if (!(isset($_SESSION['api'])))
  	 {
  	 //Local deploy start 	
     $_SESSION['api'] = new aenima('aenima', 'https://lh3.googleusercontent.com/-9a0y-GzcK2o/T-pcVa8cc3I/AAAAAAAAAD4/oLzbfVwBvYY/s450-no/fp.jpg', '800208504678-hqp091fanunajd8nm5v30k6jpe02f03t.apps.googleusercontent.com', 'uDqnb5SMm_YlkbnE00cwOQJT', 'http://localhost/aenima/', 'http://54.235.167.23:1337');              
  	 //Remote deploy start
     //$_SESSION['api'] = new aenima('aenima', 'https://lh3.googleusercontent.com/-9a0y-GzcK2o/T-pcVa8cc3I/AAAAAAAAAD4/oLzbfVwBvYY/s450-no/fp.jpg', '346445246321.apps.googleusercontent.com', 'u0GmIsKRx-Qb5lDMzd03xoVH', 'http://ec2-54-204-3-189.compute-1.amazonaws.com', 'http://ec2-54-204-3-189.compute-1.amazonaws.com:1337');
     header("location: ./");
     }
     else
     	{     	
     	$_SESSION['api']->run();
     	}
?>
