<?php
class aenima
  {
  public function aenima($app, $logo, $google_client_id, $google_client_secret, $redirect_uri, $socket_url)
    {          
    $this->app = 'aenima';
    $this->subapp = $app;
    $this->apilog = '';   
    $this->logo = $logo;    
    $this->google_client_id = $google_client_id;   
    $this->google_client_secret = $google_client_secret;
    $this->redirect_uri = $redirect_uri;
    $this->socket_url = $socket_url;
    }
  public function run()
    {
    try
      {
      require_once 'google/Google_Client.php';
      require_once 'google/contrib/Google_PlusService.php';
      require_once 'google/contrib/Google_CalendarService.php';
      require_once 'google/contrib/Google_Oauth2Service.php';     
      require_once 'db.php';    
      }
    catch (Exception $e) 
      {
      $this->error_handle($e);                      
      } 
    $this->log('loading auth for '.$this->app);
    $this->init();    
    $this->load_google(); 
    $this->load_role();        
    $this->load_get_values();    
    $this->load_module();      
    }  
  public function load_get_values()
    {
    if (!isset($this->h2o))
       {
       $this->h2o = 3; 
       }  
    if (isset($_GET['h2o'])) 
       {    
       $this->h2o = $_GET['h2o'];
       }  
    if (isset($_GET['r'])) 
       {    
       $this->h2o = $_GET['r'];
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
    }     
  public function load_module()
    {              
    $this->log('module#'.$this->h2o);       
    $module = $this->init_auth($this->app,$this->h2o,$this->role);   
    if ($module)
       {
       if ($module->id_auth)
          {   
          $this->module=$module->module;
          $this->action=$module->action;
          }
          else
             {     
             $this->module="error";
             $this->action="main";
             $this->error_msg="You dont have permission to access this page, please reload or go back to the <a href='index.php'>begining</a>";   
             }
       }
       else
          {
          $this->module=="error";
          $this->action="main";
          $this->error_msg="You dont have permission to access this page, please reload or go back to the <a href='index.php'>begining</a>";         
          } 
    $this->log('module:{'.$this->module.'},action:{'.$this->action.'};'); 
    $name_control = $this->module."_control";
    $name_action  = $this->action;
    if ((isset($this->id_user))&&(isset($_SESSION["persona_google_name"])))      
       {
       $this->aenima = '<div id="data_aenima" data-aenima="'.$this->socket_url.'"></div><input type="hidden" id="module_input" value="'.$this->module.'" /><input type="hidden" id="action_input" value="'.$this->action.'" /><input type="hidden" id="user_id_input" value="'.$this->id_user.'" /><input type="hidden" id="user_input" value="'.$_SESSION["persona_google_name"].'" />';      
       }
       else
          {
          $this->aenima= '</div><input type="hidden" id="module_input" value="'.$this->module.'" /><input type="hidden" id="action_input" value="'.$this->action.'" />';              
          }    
    try {      
        require_once("control/".$name_control.".php");          
        $ctrl=new $name_control(); //Function variable name by manuel perez :)
        $ctrl->$name_action();         
        } 
    catch (Exception $e) 
        {
        $this->error_handle($e);       
        }     
    }     
  public function log($msg)
    {


    print ('<!-- #Log: '.$msg.'-->
');   


 
/*if (isset($this->apilog))      
       {
    $this->apilog .= '<!-- #Log: '.$msg.'-->  
';    
       }        
       else
          {
     $this->apilog = '<!-- #Log: '.$msg.'-->  
';           
          }*/



    }
  private function error_handle($e)
    {
    $this->log('the app '.$this->app.' has died from {{'.$e.'}}'); 
    echo $this->apilog; 
    exit();  
    }      
  private function init()
    {
    $bd_app="cisbit_aps";
    $host="54.235.167.23"; 
    $user="aliens";     
    $password="aliens%2013";                            
    if (isset($this->role_name))
       {
       switch ($this->role_name) 
         {                        
         case 'user':
                   $user="superuser";
                   $password="Sup3rUs3r%2013";
                   $this->h2o = 4;
                   break;                       
         case 'alien':
                   $user="aliens";
                   $password="aliens%2013";                  
                   $this->h2o = 3 ;                  
                   break;
         }
       }                  
    $this->api=new db($bd_app,$user,$password);
    $this->api->conect();
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
    return $this->api->search($sql,$data);       
    }       
  private function load_role()
    { 
    $this->role = 3;
    $this->role_name = 'alien';      
    if ((isset($_SESSION['persona_google_profile']))&&(isset($_SESSION['persona_google_profile']['id'])))
       {       
       $just_checking = $this->load_client($_SESSION['persona_google_profile']['id']);   
       if (!(isset($_SESSION['persona_google_profile']['picture'])))  
          {
          $_SESSION['persona_google_profile']['picture'] = $this->logo;  
          } 
       if (!(isset($_SESSION['persona_google_profile']['gender'])))  
          {
          $_SESSION['persona_google_profile']['gender'] = 'X';  
          }         
       if (isset($just_checking->role_name))
          {
          $this->id_user = $just_checking->id_user;   
          $this->role = $just_checking->id_role;  
          $this->role_name = $just_checking->role_name;          
          $this->init();     
          }
          else
             {        
             if (!(isset($_SESSION['persona_google_profile']['birthday'])))
                {
                $timestamp_birth = 0;  
                }
                else
                   {
                   $a = strptime($_SESSION['persona_google_profile']['birthday'], '%Y-%m-%d');
                   $timestamp_birth = mktime(0, 0, 0, $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900); 
                   }
             try 
               {
               $this->insert_client($_SESSION['persona_google_profile']['id'], $_SESSION['persona_google_profile']['name'], $_SESSION['persona_google_profile']['email'], $_SESSION['persona_google_profile']['gender'], $timestamp_birth, $_SESSION['persona_google_profile']['picture']);                       
               } 
             catch (Exception $e) 
               {
               $this->error_handle($e);                      
               } 
             header('Location: '.$this->redirect_uri); 
             } 
       }  
    $this->log('role defined as '.$this->role_name.'::'.$this->role);   
    }   
  private function load_google()
    {
    try {
        $_SESSION['client_google'] = new Google_Client();
        $_SESSION['client_google']->setApplicationName($this->app);
        $_SESSION['client_google']->setClientId($this->google_client_id);
        $_SESSION['client_google']->setClientSecret($this->google_client_secret);
        $_SESSION['client_google']->setRedirectUri($this->redirect_uri);
        //$_SESSION['client_google']->setDeveloperKey('insert_your_developer_key');             
        } catch (Exception $e) {
        $this->error_handle($e);     
        }    
    if (isset($_GET['code'])) 
       {
       $_SESSION['client_google']->authenticate($_GET['code']);
       $_SESSION['access_token'] = $_SESSION['client_google']->getAccessToken();  
       header('Location: '.$this->redirect_uri);               
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
           echo 'offline this work do not.';
           exit();
           }             
    }
  private function load_fb()
    {
    $config_fb = array(
      'appId' => '',
      'secret' => '',
      );
    $_SESSION['facebook'] = new Facebook($config_fb);
    $_SESSION['persona_fb'] =  $_SESSION['facebook']->getUser();           
    }
  private function load_client($id)  
    {
    $data=array();
    array_push($data,$id);         
    $sql="SELECT * FROM api.api_users WHERE id_oauth LIKE $1 LIMIT 1"; 
    $res = $this->api->search($sql,$data);  
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
    return $this->api->procedure($sql,$data);
    }
  public function load_user_list()
    {
    $this->log('loading user list');        
    $sql="SELECT * FROM api.api_user_list";    
    return $this->api->consult($sql,$data);      
    }
  public function load_app_list()
    {
    $this->log('loading app list');        
    $sql="SELECT * FROM api.app";    
    return $this->api->consult($sql,$data);       
    }       
  }    
?>
