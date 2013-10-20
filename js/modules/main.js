var main = Class.extend({
    init: function()
         {
         var socket = io.connect($('#data_aenima').data('aenima')+'/', { query: 
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
                         $('#msg_list').html($('#msg_list').html()+'<li class="list-group-item"><span class="badge alert-success">'+data+' is now in '+String.fromCharCode( 230 )+'nima</span></li>');
                       else
                         $('#msg_list').html($('#msg_list').html()+'<li class="list-group-item"><span class="badge alert-danger">'+data+' from '+String.fromCharCode( 230 )+'nima</span></li>');
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
                    socket.on('disconnect', function () {                      
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
         render.load_view('item_list', 'item_list', 'index.php?act=product_list', render.load_list);                   
         }
    });

