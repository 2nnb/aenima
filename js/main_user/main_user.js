var h2o = Class.extend(
     {
     init: function(app)
       {
       var self = this;   
       self.app = app;
       },
     initrato: function()
       {
       var self = this;
       var id = self.form;
	   $("input").keypress(function(event){
		var nav4 = window.Event ? true : false;
		var key = nav4 ? event.which : event.keyCode	
		if ($(this).hasClass("texto")) 
			return (key==0 || (key>=97 && key<=122) || (key>=65 && key<=90) || key==32 || key==8);	
		if ($(this).hasClass("rif"))
			return (key==0 || (key>=48 && key<=57) || key==8 || key==86 || key==71 || key==69 || key==74 || key==118 || key==106 || key==101 || key==103);
		if ($(this).hasClass("numero"))
			return (key==0 || (key>=48 && key<=57) || key==8);
		if ($(this).hasClass("decimal"))
			return (key==0 || (key>=48 && key<=57) || key==8 || key==190 || key==46);	
		if ($(this).hasClass("fecha"))
			return (key==0 || (key>=48 && key<=57) || key==8 || key==47);
		if ($(this).hasClass("correo"))
			return (key==0 || (key>=97 && key<=122) || (key>=65 && key<=90) || (key>=48 && key<=57) || key==46 || key==45 || key==95 || key==64 || key==8 );
		if ($(this).hasClass("telefono"))
			return (key==0 || (key>=48 && key<=57) || key==8 || key==45);	
		});
	    $("input, select, textarea").blur(function(){
	  	  $(this).removeClass("error");
	      });
	    if (id!=null)
		  setTimeout('$("#'+id+' .primero").focus();',500);
	    $('.enter').keyup(function(event) 
	      {
		  if (event.which == 13)
			$("#"+id+" button.btn-primary").click();
	      }).keydown(function(event) 
	           {
		       if (event.which == 13)
			      event.preventDefault();		  
	           });		
	   $("#"+id+" div.alert").hide();	       
       },
     validate: function()
       {
       var self = this;
	   $("#"+self.form+" div.alert").html("");
   	   $("#"+self.form+" div.alert").hide();
	   var result="<ol>";
	   var status=true;
	   $("#"+self.form+" input,#"+self.form+" select,#"+self.form+" textarea").each(function (){
	   var type=$(this)[0].tagName;
		var patron='';
                var value = $(this).val();
		var msj_patron='';
		$(this).removeClass('error');
		if ($(this).hasClass('requerido'))
		   {
			if (type=='SELECT')
			{
				if (value==0)
				{
					result+="<li>"+$(this).attr("name")+" it's required</li>";
					$(this).addClass("error");
                                        $(this).attr('placeholder', $(this).attr("name")+" it's required");
					status=false;
				}
			}
			else
			{                       
				if (value=="")
				{			
					result+="<li>"+$(this).attr("name")+" it's required</li>";
                                        $(this).attr('placeholder', $(this).attr("name")+" it's required");
					$(this).addClass("error");
					status=false;
				}
			}
		   }
		if (status)
		   {
			if ($(this).hasClass("text"))
			{
				patron=/^[a-zA-ZáéíóúÁÉÍÓÚ\ ]*$/;
				msj_patron=': solo acepta letras';
			}
			else if ($(this).hasClass("rif"))
			{
				patron=/^[V|v|G|g|E|e|J|j]{1}\d*$/;	
				msj_patron=': ej V12345678';
			}
			else if ($(this).hasClass("number"))
			{
				patron=/^\d*$/;
				msj_patron=': solo acepta números enteros';
			}
			else if ($(this).hasClass("decimal"))
			{
				patron=/^\d+\.{0,1}\d{1,2}$/;
				msj_patron=': solo acepta números con un maximo de 2 decimales';
			}
			else if ($(this).hasClass("fecha"))
			{
				patron=/^\d{1,2}\-\d{1,2}\-\d{2,4}$/;
				msj_patron=': ej 01/01/2012';						
			}
			else if ($(this).hasClass("fechahora"))
			{
				//patron=/^\d{1,2}\/\d{1,2}\/\d{2,4}\ \d{1,2}\:\d{1,2}$/;
                                patron=/^\d{1,2}\/\d{1,2}\/\d{2,4}\ \d{1,2}\:\d{1,2}\:\d{1,2}$/;
				msj_patron=': ej 01/01/2012';						
			}                        
			else if ($(this).hasClass("mail"))
			{
				patron=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
				msj_patron=': ej admin@eserv.com';												
			}
			else if ($(this).hasClass("phone"))
			{
				patron=/^0\d{3}-\d{7}$/;
				msj_patron=': 0416-1990102';												
			}					
			if ((patron!="")&&(patron.test(value)==false))
                        {
				result+="<li>"+$(this).attr("label")+" doesn't have a valid format</li>";
				$(this).addClass("error");	
				status=false;
			}
		}
	});	 
	result+="</ol>";
//	if (!status)
//	   {
//		$("#"+self.form+" div.alert").html(result);
//		$("#"+self.form+" div.alert").fadeIn(800);
//	   }
//        var res = {
//        error: status,
//        msg: result
//        };
	return status;       
       },    
     loadFields: function()
         {
         var self = this;         
         var fields='';
         var i=0;
         var size=$("#"+self.form+" input,#"+self.form+" select,#"+self.form+" textarea,#"+self.form+" input[type='button']").length;
         $("#"+self.form+" input,#"+self.form+" select,#"+self.form+" textarea,#"+self.form+" input[type='button']").each(function()
           {
           if ((($(this).attr("type")!="checkbox") || (($(this).attr("type")=="checkbox") && ($(this).attr("checked")==true))))
              {
              if (i<size-1)
                 fields=fields+$(this).attr("name")+"="+$(this).val()+"&";
              else
                 fields=fields+$(this).attr("name")+"="+$(this).val();
              i++;
              }
           }); 
         return fields;              
         },           
      send: function(container, file, form)
        {
        var self = this;      
        self.container = container;
        self.file = file; 
        self.form = form;         
        //$('#content').showLoading();
        if (self.file=='')
            self.file = 'index.php';
        if (self.form!='')
        self.fields = self.loadFields();
        if (self.fields!='')
            {
            log.info("PROCESS: sending fields:"+self.fields+" TO-> "+self.file);             
            $.ajax({
                    type: "POST",
                    url: self.file+'&ajax=1',
                    data: self.fields,
                    success:function(data)
                        {
                        if (self.container=='')
                           {
                           eval(data);
                           }
                           else
                              { 
                              $('#'+self.container).html(data).slideDown();
                              //$('#content').hideLoading();
                              }  
                        },
                    error:function(XMLHttpRequest,textStatus,errorThrown)
                        {                            
                        if (errorThrown)
                           {
                           log.info("ERROR:: "+errorThrown);                             
                           }
                        if (XMLHttpRequest)
                           {
                           log.info("XMLHttpRequest:: "+XMLHttpRequest);                             
                           }
                        if (textStatus)
                           {
                           log.info("textStatus:: "+textStatus);                             
                           }     
                        log.info("ERROR:: No se pudo procesar su solicitud, intentelo nuevamente");    
                        //self.msg.show('error', 'No se pudo procesar su solicitud, intentelo nuevamente');   
                        $('#content').hideLoading();
                        //$('#content').show();
                        }          
                }); 
            }
            else
                {
                log.info("ERROR:: no fields to send"); 
                //self.msg.show('error', 'No hay campos para enviar');
                } 
        }, 
      get: function(url)
        {
        var self = this;
        data = 'http://www.quantic.com.ve/cisbit/'+data;
        log.info('#= Geting data from::'+url);
        $.getJSON(url, function(data) {
         $('#'+self.app.name).append("<div id='json'>"+JSON.stringify(data)+"</div>");
         return JSON.stringify(data);
         }); 
        return self.res.responseText;                    
        /*$.ajax({
          type: 'GET',
          url: url,
          dataType: 'jsonp',
          success: function(data){
            return data.message;
          }
        });*/ 
        }                      
 });
var render = Class.extend(
    {
    init: function(app)
         {
         self = this;
         self.app = app; 
         Handlebars.registerHelper('link', function(text, url) 
           {
           text = Handlebars.Utils.escapeExpression(text);
           url  = Handlebars.Utils.escapeExpression(url); 
           var result = '<a href="' + url + '">' + text + '</a>'; 
           return new Handlebars.SafeString(result);
           });         	        	
         },	
    load_view: function(view_src, view, url, callback, filter)
         {
         var self = this; 
         if (filter!='')
            {
            url = 'http://www.quantic.com.ve/cisbit/index?h2o='+url+'&filter='+filter;         
            }
            else
               {
               url = 'http://www.quantic.com.ve/cisbit/index?h2o='+url;	
               }
         var src = $("#"+view_src+"_src").html();         
         var compiled = Handlebars.compile(src);         
         log.info('#= Geting data from::'+url);
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
           log.info(self.app.name+' loaded view:'+view+' with:'+ares);
           log.info('thetags::'+items);            
           callback();            
           });                   
         },
    load_table: function(name)
         {        
         var modjson = self.app.h2o.get('index.php?h2o=12');
         log.info(modjson);
         
         return modjson;
         },
    load_stfu: function()
         {

         }              
    }); 
var main_user = Class.extend(
    {
    init: function() 
         {
         var self = this;
         log.info('user main module loaded');	                                 	
         },
    load_app_select: function()
         {
         $('#app_list').select2(
            {   
            width: "400px",
            placeholder: "Select a table"
            });              
         render.load_view('view_list', 'view_list', '14', main.load_view_list, $('#app_list option:selected').val());   	
         },
    load_view_list: function()
         {
         $('#sample_1').dataTable(
             {
             "aLengthMenu": [
                 [10, 25, 50, -1],
                 [5, 15, 20, "All"]
             ],
             // set the initial value
             "iDisplayLength": 5,
             "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
             "sPaginationType": "bootstrap",
             "oLanguage": {
                 "sLengthMenu": "_MENU_ records per page",
                 "oPaginate": {
                     "sPrevious": "Prev",
                     "sNext": "Next"
                 }
             },
             "aoColumnDefs": [{
                 'bSortable': false,
                 'aTargets': [0]
             }],
             "bDestroy":true,
             "bRetrieve": true
             });
         jQuery('#sample_1 .group-checkable').change(function () {
             var set = jQuery(this).attr("data-set");
             var checked = jQuery(this).is(":checked");
             jQuery(set).each(function () {
                 if (checked) {
                     $(this).attr("checked", true);
                 } else {
                     $(this).attr("checked", false);
                 }
             });
             jQuery.uniform.update(set);
         }); 

         jQuery('#sample_1_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
         jQuery('#sample_1_wrapper .dataTables_length select').addClass("m-wrap xsmall"); // modify table per page dropdown
         }                       
    }); 
var app = function() 
    {
    var self = this;  
    self.name = 'cisbit';
    self.render = new render(self);   
    self.h2o = new h2o(self);  
    log.info('App initialized');
     /*setTimeout("$('.preloader').animate({'opacity' : '0'},600)", 1000);
     setTimeout("$('.content_wrapper').animate({'opacity' : '1'},600)", 1000);
     setTimeout("$('header').animate({'opacity' : '1'},600)", 1000);*/       
     var action_input = $('#action_input').val(); 
     switch(action_input)
       {
       case 'user': 
           main = new main_user(); 
           render.load_view('app_list', 'app_list', '12', main.load_app_select, '');           
           break;
       case 'smartblog':
           log.info('blog module Loaded');    
           self.post = new Post(self); 
           //log.info(action_input);
           //self.render.load_file_uploader_blog();                            
           //self.render.load_post_isotope();                
           break;             
       case 'services':
           log.info(self.name+' Services module Loaded');               
           break;
       }     
    };        	