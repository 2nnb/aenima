  var cSpeed=9;
  var cWidth=124;
  var cHeight=128;
  var cTotalFrames=20;
  var cFrameWidth=124;
  var cImageSrc='ico/sprites.gif';
  
  var cImageTimeout=false;
  var cIndex=0;
  var cXpos=0;
  var cPreloaderTimeout=false;
  var SECONDS_BETWEEN_FRAMES=0;
  
  function startAnimation(){
    
    document.getElementById('loaderImage').style.backgroundImage='url('+cImageSrc+')';
    document.getElementById('loaderImage').style.width=cWidth+'px';
    document.getElementById('loaderImage').style.height=cHeight+'px';
    
    //FPS = Math.round(100/(maxSpeed+2-speed));
    FPS = Math.round(100/cSpeed);
    SECONDS_BETWEEN_FRAMES = 1 / FPS;
    
    cPreloaderTimeout=setTimeout('continueAnimation()', SECONDS_BETWEEN_FRAMES/1000);
    
  }
  
  function continueAnimation(){
    
    cXpos += cFrameWidth;
    //increase the index so we know which frame of our animation we are currently on
    cIndex += 1;
     
    //if our cIndex is higher than our total number of frames, we're at the end and should restart
    if (cIndex >= cTotalFrames) {
      cXpos =0;
      cIndex=0;
    }
    
    if(document.getElementById('loaderImage'))
      document.getElementById('loaderImage').style.backgroundPosition=(-cXpos)+'px 0';
    
    cPreloaderTimeout=setTimeout('continueAnimation()', SECONDS_BETWEEN_FRAMES*1000);
  }
  
  function stopAnimation(){//stops animation
    clearTimeout(cPreloaderTimeout);
    cPreloaderTimeout=false;
  }
  
  function imageLoader(s, fun)//Pre-loads the sprites image
  {
    clearTimeout(cImageTimeout);
    cImageTimeout=0;
    genImage = new Image();
    genImage.onload=function (){cImageTimeout=setTimeout(fun, 0)};
    genImage.onerror=new Function('alert(\'Could not load the image\')');
    genImage.src=s;
  }
  
  //The following code starts the animation
new imageLoader(cImageSrc, 'startAnimation()'); 

var App = Class.extend(
    {
    init: function(app)
         {
         self = this;
         self.app = app; 
         self.name = 'aenima';
             
         var module_input = $('#module_input').val(); 
         var action_input = $('#action_input').val(); 
         switch(module_input)
           {
           case 'main': 
               log.info(self.name+' main module Loaded');
               switch (action_input)
                 {
                 case 'user':
                    var socket = io.connect('http://54.235.167.23:1337/', { query: 
                                                                          "user_id="+$('#user_id_input').val()+"&"+"username="+$('#user_input').val() 
                                                                      });  
                    socket.on('chat', function (data) 
                      {
                      log.info(data);
                      $('#msg_list').html($('#msg_list').html()+'<li class="list-group-item">'+data.msg+'<span class="badge">'+data.user+'</span></li>');
                      $('#face_box').stop().animate({
                          scrollTop: $("#face_box")[0].scrollHeight
                      }, 800);
                      });
                    socket.on('log', function (data) 
                      {
                      log.info(data);
                      if (data.length > 13)
                         {
                         var lasttw = data.substr(data.length - 12);
                         }
                         else
                            {
                            var lasttw = 'n';  
                            }
                      if (lasttw!='disconnected')
                         $('#msg_list').html($('#msg_list').html()+'<li class="list-group-item"><span class="badge alert-success">'+data+' is now in ænima</span></li>');
                       else
                         $('#msg_list').html($('#msg_list').html()+'<li class="list-group-item"><span class="badge alert-danger">'+data+' from ænima</span></li>');
                      $('#face_box').stop().animate({
                          scrollTop: $("#face_box")[0].scrollHeight
                      }, 800);                      
                      });
                    socket.on('connect', function () {                      
                      setTimeout("$('#facebox_overlay').animate({'opacity' : '0'},600)", 300);
                      $('#facebox_overlay').hide();
                      stopAnimation();
                      // socket connected
                      });   
                    socket.on('auth', function (data) 
                      {
                      $('#id_profile').attr('src',data.picture);
                      log.info(data);
                      });            
                    $('#chat_send').click(function()
                     {
                     var chat_input = $('#chat_input').val();
                     var user_input = $('#user_input').val();
                     var json_data = {
                      "user": user_input,
                      "msg": chat_input
                     };
                     socket.emit('chat', json_data); 
                        $('#chat_input').val('');
                        });
                    $('#chat_input').keyup(function(event){
                        if(event.keyCode == 13){
                            $('#chat_send').click();
                        }
                    });
                 break;
                 default:
                      setTimeout("$('#facebox_overlay').animate({'opacity' : '0'},600)", 300);
                      $('#facebox_overlay').hide();                 
                 break;
                 }
               log.info('Welcome to aenima main module'); 
               break;
           }  
         log.info('App initialized');                               
         }  
    }); 
