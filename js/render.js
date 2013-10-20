var Render = Class.extend(
    {
    init: function(app)
         {
         self = this;         
         self.app = app;                    
         },     
    load_list: function()
         {
         $('#list_table').dataTable({
                    "sDom": "t",
                    "sPaginationType": "none",
                    "aoColumnDefs": [
                              { 'bSortable': false, 'aTargets': [ 4 ] }
                           ],                             
                    "iDisplayLength": 15,
                    "bDestroy":true,
                    "bRetrieve": true
                  });
         $('.load_modal_list').each(function(){
           $(this).click(function(){
              var id_item =  $(this).attr('id');
              id_item = id_item.split('_');
              id_item = id_item[1];
              console.log(id_item);

              });
           });
         $('#update_action').click(function(){
                  client_fields = 'index.php?save_tweet=1';  
                  var error = false;                    
                  $("#form_tweets input,#form_tweets select,#form_tweets textarea").each(function (){
                    if ($(this).val()=='')
                       {
                       error = true;
                       $(this).parent().parent().addClass('has-error');
                       }
                       else
                          {
                          $(this).parent().parent().removeClass('has-error');
                          client_fields += "&"+$(this).attr('id')+"="+$(this).val();
                          }       
                  });          
               if (!(error))
                  {                     
                  $.ajax({
                      type: "POST",
                      url: client_fields,
                      success:function(data)
                          {                              
                          render.load_view('tweet_list', 'tweet_list', 'index.php?act=product_list', render.load_tweets);                           $('#mymodal_add').modal('hide');    
                          console.log('SUCCESS');  
                          },
                      error:function(XMLHttpRequest,textStatus,errorThrown)
                          {                            
                          if (errorThrown)
                             {
                             console.log("ERROR:: "+errorThrown);                             
                             }
                          if (XMLHttpRequest)
                             {
                             console.log("XMLHttpRequest:: "+XMLHttpRequest);                             
                             }
                          if (textStatus)
                             {
                             console.log("textStatus:: "+textStatus);                             
                             }     
                          console.log("ERROR");
                          }          
                      });                       
                  }
                  else
                     {
                     console.log('ERROR: all fields are required'); 
                     }               
                  });       
          $('#submit_client').click(function()
               {   
               client_fields = 'control/control.php?save_client=true';  
               var error = false;                    
               $("#form_client input,#form_client select,#form_client textarea").each(function (){
                 if ($(this).val()=='')
                    {
                    error = true;
                    $(this).parent().parent().addClass('has-error');
                    }
                    else
                       {
                       $(this).parent().parent().removeClass('has-error');
                       client_fields += "&"+$(this).attr('id')+"="+$(this).val();
                       }       
               }); 
               if (!(error))
                  {                     
                  $.ajax({
                      type: "POST",
                      url: client_fields,
                      success:function(data)
                          {
                          console.log('SUCCESS');          
                          },
                      error:function(XMLHttpRequest,textStatus,errorThrown)
                          {                            
                          if (errorThrown)
                             {
                             console.log("ERROR:: "+errorThrown);                             
                             }
                          if (XMLHttpRequest)
                             {
                             console.log("XMLHttpRequest:: "+XMLHttpRequest);                             
                             }
                          if (textStatus)
                             {
                             console.log("textStatus:: "+textStatus);                             
                             }     
                          console.log("ERROR");
                          }          
                      });                       
                  }
                  else
                     {
                     console.log('ERROR: all fields are required'); 
                     }         
               });                           
         },
    load_tweet: function()
         {          
         console.log('tweet loaded!');      
         $('#data_update').click(function(){
                            client_fields = 'index.php?update_tweet=1';  
                             var error = false;                    
                               $("#form_tweets2 input,#form_tweets2 select,#form_tweets2 textarea").each(function (){
                                 if ($(this).val()=='')
                                    {
                                     error = true;
                                     $(this).parent().parent().addClass('has-error');
                                    }
                                    else
                                       {
                                        $(this).parent().parent().removeClass('has-error');
                                        client_fields += "&"+$(this).attr('id')+"="+$(this).val();   
                                       }  
                          }); 
                          $.ajax({
                            type: "POST",
                            url: client_fields,
                            success:function(data)
                                             {
                                             console.log('SUCCESS');
                                             console.log(data);  
                                             render.load_view('tweet_list', 'tweet_list', 'load_table.php', render.load_tweets); 
                                             $('#mymodal_option').modal('hide');                  
                                             },
                            error:function(XMLHttpRequest,textstatus,errorThrown)
                                             {                            
                                             if (errorThrown)
                                                {
                                                console.log("ERROR:: "+errorThrown);                             
                                                }
                                             if (XMLHttpRequest)
                                                {
                                                console.log("XMLHttpRequest:: "+XMLHttpRequest);                             
                                                }
                                             if (textstatus)
                                                {
                                                console.log("textstatus:: "+textstatus);                             
                                                }     
                                             console.log("ERROR");
                                             }          
                                         });                
                          });  
             $('#data_delete').click(function(){
                   client_fields = 'index.php?delete_tweet=1';  
                    var error = false;                    
                      $("#form_tweets2 input,#form_tweets2 select,#form_tweets2 textarea").each(function (){
                        if ($(this).val()=='')
                           {
                           error = true;
                           $(this).parent().parent().addClass('has-error');
                           }
                           else
                              {
                              $(this).parent().parent().removeClass('has-error');
                              client_fields += "&"+$(this).attr('id')+"="+$(this).val();         
                                 
                              }  
                 });          

                       $.ajax({
                                type: "POST",
                                url: client_fields,
                                success:function(data)
                                    {
                                    console.log('SUCCESS');
                                    console.log(data);  
                                    render.load_view('tweet_list', 'tweet_list', 'load_table.php', render.load_tweets); 
                                    $("#order").val('');
                                    $("#handle").val('');
                                    $("#status").val('');
                                    $('#mymodal_option').modal('hide');                                                           
                                    },
                                error:function(XMLHttpRequest,textstatus,errorThrown)
                                    {                            
                                    if (errorThrown)
                                       {
                                       console.log("ERROR:: "+errorThrown);                             
                                       }
                                    if (XMLHttpRequest)
                                       {
                                       console.log("XMLHttpRequest:: "+XMLHttpRequest);                             
                                       }
                                    if (textstatus)
                                       {
                                       console.log("textstatus:: "+textstatus);                             
                                       }     
                                    console.log("ERROR");
                                    }          
                                });                
                      });                                      
         $('#modal_item').modal('show');
         },      
    load_modal_item: function(item,id)
         {
         console.log(id);
         var url = 'index.php'+'?item_name='+item+'&=item_id='+id;
         this.load_view('item_modal', 'item_modal', url, this.load_tweet);
         },                            
    load_view: function(view_src, view, url, callback)
         {
         var self = this; 
         url = ''+url;         
         var src = $("#"+view_src+"_src").html();         
         var compiled = Handlebars.compile(src);         
         console.log('#= Geting data from::'+url);
         $.getJSON(url, function(data) 
           {  
           if (!(_.isEmpty(data)))
              { 
              var ares = JSON.stringify(data);
              var item = data[0];
              var i = 0;
              items = _.keys(item);
              items = $.parseJSON(JSON.stringify(items));
              }
              else
                 {
                 items = $.parseJSON('[]'); 
                 }                                        
           $("#"+view).html(compiled({"data":data, "items":items})); 
           console.log(self.app.name+' loaded view:'+view+' with:'+ares);
           console.log('thetags::'+items);            
           callback();      
           });                   
         }             
    });
var render = new Render()