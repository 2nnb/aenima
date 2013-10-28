var aenima = Class.extend(
    {
    init: function(app)
         {
         self = this;
         self.app = app; 
         self.name = String.fromCharCode( 230 )+'nima';
         var module_input = $('#module_input').val(); 
         var action_input = $('#action_input').val(); 
         switch(module_input)
           {
           case 'main': 
               log.info(self.name+' main module Loaded');
               switch (action_input)
                 {
                 case 'user':
                    self.main = new main();
                 break;
                 } 
               break;
           case 'error':
               log.info(self.name+' error module Loaded');      
           }
         setTimeout("$('#facebox_overlay').animate({'opacity' : '0'},600)", 300);
         $('#facebox_overlay').hide();    
         log.info(String.fromCharCode( 230 )+'nima initialized');                               
         }  
    }); 
