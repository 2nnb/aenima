
<?php 

class api
  {
  public function api($app)
   	{
    require_once 'lib/php/google/Google_Client.php';
    require_once 'lib/php/google/contrib/Google_PlusService.php';
    require_once 'lib/php/google/contrib/Google_CalendarService.php';
    require_once 'lib/php/google/contrib/Google_Oauth2Service.php';
    require_once 'lib/php/fb/facebook.php';
    require_once 'lib/php/cisbit/bd.php';
    $_SESSION['apilog'] = '';
   	$this->log('loading auth api');
    $this->app = $app;
    $this->load_google(); 
    $this->load_role();
    $this->load_app(); 
   	}
  public function log($msg)
    {
/*    print ('<!-- #Log: '.$msg.'-->
');
*/    if (isset($_SESSION['apilog']))      
       {
    $_SESSION['apilog'] .= '<!-- #Log: '.$msg.'-->  
';    
       }	    
       else
          {
     $_SESSION['apilog'] = '<!-- #Log: '.$msg.'-->  
';           
          }
    }
  private function	init_app($app)
    {
    $bd_app="cisbit_aps";
    $host="54.235.167.23"; 
    if (isset($_SESSION['role_name']))
       {
       switch ($_SESSION['role_name']) 
         {
         case 'superuser':
                   $user="superuser";
                   $password="Sup3rUs3r%2013";
                   $_SESSION['h2o'] = 4;                   
                   break;
         case 'administrator':
                   $module       = $_SESSION['api']->load_module(6);
                   break;                         
         case 'user':
                   $user="superuser";
                   $password="Sup3rUs3r%2013";
                   $_SESSION['h2o'] = 11;
                   break;                       
         default:
                   $user="aliens";
                   $password="aliens%2013";                  
                   $_SESSION['h2o'] = 3;                   
                   break;
         }
       }                  
    $GLOBALS["api_bd"]=new bd($bd_app,$user,$password);
    $GLOBALS["api_bd"]->conect();
    $this->log('set '.$host.' database conection to '.$user);    	
    }
  private function init_auth($id_app="", $id_auth="", $id_role="")
    {
    $data=array();
  	array_push($data,$id_auth);	
  	if (($id_role!="")&&($id_app!=""))
  	   {
  	   array_push($data,$id_role);
  	   array_push($data,$id_app);				
  	   $sql="SELECT * FROM api.api_auth WHERE id_auth=$1 AND id_role=$2 AND (name_app LIKE $3 OR name_app LIKE 'api')";
  	   }
  	   else
     		  {	
     		  if (($id_role=="")&&($id_app!=""))
     		  	 {
     		  	 array_push($data,$id_app);	
              $sql="SELECT * FROM api.api_auth WHERE id_auth=$1 AND (name_app LIKE $2 OR name_app LIKE 'api')";
     		  	 }
     		  	 else
     		  	    {
     		        $sql="SELECT * FROM api.api_auth WHERE id_auth=$1 AND id_role=4";
     		        }
     		  }	  
  	$this->log('processing auth::'.$id_app.'='.$id_auth.'='.$id_role);	  
  	return $GLOBALS["api_bd"]->search($sql,$data);	     
    }    	
  private function load_app()
	  {  
    if (isset($_SESSION['app']))
       {
       if ($_SESSION['app']!=$this->app) 
          {
          $_SESSION['in_app'] = $_SESSION['app'];
          $this->log('aplication origin: '.$_SESSION['in_app']);
          }                              
       }
       else
          {
          $_SESSION['h2o'] = 3;
          $_SESSION['in_app'] = $this->app;            
          }
    $_SESSION['app'] = $this->app;            
	  }
  private function load_role()
    { 	
    $_SESSION["role"] = 3;
    $_SESSION["role_name"] = 'alien';        
    $this->init_app($this->app);
    if ((isset($_SESSION['persona_google_profile']))&&isset($_SESSION['persona_google_profile']['id']))
       {       
       $just_checking = $this->load_client($_SESSION['persona_google_profile']['id']);  
       if (!(isset($_SESSION['persona_google_profile']['picture'])))  
          {
          $_SESSION['persona_google_profile']['picture'] = 'http://www.cisbit.com/api/ico/default.png';  
          } 
       if (!(isset($_SESSION['persona_google_profile']['gender'])))  
          {
          $_SESSION['persona_google_profile']['gender'] = 'X';  
          }         
       if (isset($just_checking->role_name))
          {
          $_SESSION['id_user'] = $just_checking->id_user;   
          $_SESSION['role'] = $just_checking->id_role;  
          $_SESSION['role_name'] = $just_checking->role_name;
          $this->init_app($this->app);            
          }
          else
             {        
             //echo $timestamp_birth;
             if (!(isset($_SESSION['persona_google_profile']['birthday'])))
                {
                $timestamp_birth = 0;  
                }
                else
                   {
                    $a = strptime($_SESSION['persona_google_profile']['birthday'], '%Y-%m-%d');
                    $timestamp_birth = mktime(0, 0, 0, $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900); 
                   }              
             $this->insert_client($_SESSION['persona_google_profile']['id'], $_SESSION['persona_google_profile']['name'], $_SESSION['persona_google_profile']['email'], $_SESSION['persona_google_profile']['gender'], $timestamp_birth, $_SESSION['persona_google_profile']['picture']); 
             header('Location: http://cisbit.com/api/');
             } 
       }  
    $this->log('role defined as '.$_SESSION["role_name"].'::'.$_SESSION["role"]);   
    } 	
  public function load_module($m_i)
    {   	 
    $_SESSION['h2o']=$m_i;      
    $this->log('initzializing module '.$_SESSION['h2o']);       
    //echo ($_SESSION["app"].'---'.$_SESSION['h2o'].'---'.$_SESSION["role"]);
    $module = $this->init_auth($_SESSION["app"],$_SESSION['h2o'],$_SESSION["role"]);   
    if ($module)
       {
       if ($module->id_auth)
          {   
          $_SESSION["module"]=$module->module;
          $_SESSION["action"]=$module->action;
          }
          else
             {     
             $_SESSION["module"]="error";
             $_SESSION["action"]="main";
             $_SESSION["error_msg"]="You dont have permission to access this page, please reload or go back to the <a href='index.php'>main page</a>";   
             }
       }
       else
          {
          $_SESSION["module"]="error";
          $_SESSION["action"]="main";
          $_SESSION["error_msg"]="You dont have permission to access this page, please reload or go back to the <a href='index.php'>main page</a>";         
          } 
    $this->log('M='.$_SESSION["module"].'::'.$_SESSION["action"]); 
    $name_control = $_SESSION["module"]."_control";
    $name_action  = $_SESSION["action"];
    include ("control/".$name_control.".php");
    $ctrl=new $name_control();
    $ctrl->$name_action();     	
    }
  private function load_google()
    {

    $_SESSION['client_google'] = new Google_Client();
    $_SESSION['client_google']->setApplicationName("Cisbit Aps");
    $_SESSION['client_google']->setClientId('800208504678-hqp091fanunajd8nm5v30k6jpe02f03t.apps.googleusercontent.com');
    $_SESSION['client_google']->setClientSecret('uDqnb5SMm_YlkbnE00cwOQJT');
    $_SESSION['client_google']->setRedirectUri('http://localhost/aenima/');
    //$_SESSION['client_google']->setDeveloperKey('insert_your_developer_key');         
    if (isset($_GET['code'])) 
       {
       try 
         {
         $_SESSION['client_google']->authenticate($_GET['code']);
         $_SESSION['access_token'] = $_SESSION['client_google']->getAccessToken();
         header('Location: http://localhost/api/');
         } 
       catch (Exception $e) 
         {
         $_SESSION['client_google'] = null; 
         } 
       }    
    if ((isset($_SESSION['client_google']))&&(isset($_SESSION['access_token'])))
       {
       $_SESSION['client_google']->setAccessToken($_SESSION['access_token']);
       }            
    if (isset($_SESSION['client_google']))    
       $_SESSION['access_token'] = $_SESSION['client_google']->getAccessToken();
    if ((isset($_SESSION['client_google']))&&($_SESSION['client_google']!=null))
       {
       if ($_SESSION['client_google']->getAccessToken()) 
         {
         $_SESSION['client_google_oauth'] = new Google_Oauth2Service($_SESSION['client_google']);     
         $_SESSION['persona_google_profile'] = $_SESSION['client_google_oauth']->userinfo->get(); 
         $_SESSION['persona_google_email'] = $_SESSION['persona_google_profile']['email'];
         $_SESSION['persona_google_name'] = $_SESSION['persona_google_profile']['name'];
         if (isset($_SESSION['persona_google_profile']['picture']))
            $_SESSION['persona_google_img'] = '<img class="profile_picture" src="'.$_SESSION['persona_google_profile']['picture'].'">';    
         else
            $_SESSION['persona_google_img'] = '<img class="profile_picture" src="ico/default.png">';
         $_SESSION['google_sign_out'] = '<a class="btn btn-danger navbar-btn pull-right btn-sm" href="?h2o=2">Sign Out</a>';
         }
         else
            {            
            $_SESSION['client_google_oauth'] = new Google_Oauth2Service($_SESSION['client_google']); 
            $_SESSION['oauth'] = $_SESSION['client_google']->createAuthUrl();    
            $_SESSION['google_sign_in'] = '<a class="btn btn-success navbar-btn pull-right btn-sm" href="'.$_SESSION['oauth'].'" id="sign_in_google">Sign in with google</a>';              
            } 
        }
        else
           { 
           echo 'are you runing this offline?';
           }             
    }
  private function load_fb()
    {
    $config_fb = array(
      'appId' => '358283570941553',
      'secret' => '8a7fae02b871c75046f4a0fcae5bcdd0',
      );
    $_SESSION['facebook'] = new Facebook($config_fb);
    $_SESSION['persona_fb'] =  $_SESSION['facebook']->getUser();           
    }
  private function load_client($id)  
    {
    $data=array();
    array_push($data,$id); 
    $this->log('processing oauth check b');        
    $sql="SELECT * FROM api.api_users WHERE id_oauth LIKE $1 LIMIT 1"; 
    $res = $GLOBALS["api_bd"]->search($sql,$data);  
    return $res;    
    }        		
  private function insert_client($id, $name, $email, $gender, $birthday, $picture)  
    {
    $data=array();
    array_push($data,$id);
    array_push($data,$name);
    array_push($data,$email);
    array_push($data,$gender);
    array_push($data,$birthday);
    array_push($data,$picture);              
    $this->log('processing oauth insert::'.$id.$name.$email.$gender.$birthday.$picture); 
    $sql="SELECT api.insert_user($1,$2,$3,$4,$5,$6);";
    return $GLOBALS["api_bd"]->procedure($sql,$data);
    }
  public function load_user_list()
    {
    $data=array();
    //array_push($data,$id); 
    $this->log('loading user list');        
    $sql="SELECT * FROM api.api_user_list";    
    return $GLOBALS["api_bd"]->consult($sql,$data);      
    }
  public function load_app_list()
    {
    $data=array();
    //array_push($data,$id); 
    $this->log('loading app list');        
    $sql="SELECT * FROM api.app";    
    return $GLOBALS["api_bd"]->consult($sql,$data);       
    }
  public function load_struct_list($app)
    {
    $data=array();
    $this->log('loading struct list'); 
    if ($app!=null)
       {  
       array_push($data,$app);         
       $sql="SELECT * FROM data.struct_u_app WHERE app LIKE $1";    
       }
       else
          {
          $sql="SELECT * FROM data.struct_u_app";
          }                
    return $GLOBALS["api_bd"]->consult($sql,$data);       
    }    
  public function load_view_list($app)
    {
    $data=array();    
    $this->log('loading view list '.$app); 
    if ($app!=null)
       {  
       array_push($data,$app);         
       $sql="SELECT * FROM api.api_view_list WHERE name_app LIKE $1";    
       }
       else
          {
          $sql="SELECT * FROM api.api_view_list";
          }
    return $GLOBALS["api_bd"]->consult($sql,$data);       
    }
  public function load_table_list($struct)
    {
    $data=array();    
    $this->log('loading table view list '.$struct); 
    if ($struct!=null)
       {           
       $sql="SELECT * FROM data.table_view_".$struct;    
       }
    return $GLOBALS["api_bd"]->consult($sql,$data);       
    } 
  public function load_post_list()
    {
    $data=array();    
    $this->log('loading post list ');          
    $sql="SELECT * FROM data.view_posts ORDER BY title_post"; 
    echo $sql;   
    return $GLOBALS["api_bd"]->consult($sql,$data);       
    }                     
  }
?>
