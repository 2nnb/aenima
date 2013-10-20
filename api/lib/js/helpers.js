Handlebars.registerHelper('link', function(text, url) 
           {
           text = Handlebars.Utils.escapeExpression(text);
           url  = Handlebars.Utils.escapeExpression(url); 
           var result = '<a href="' + url + '">' + text + '</a>'; 
           return new Handlebars.SafeString(result);
           }); 

Handlebars.registerHelper('each_hash', function(context, options) {
    var fn = options.fn, inverse = options.inverse;
    var ret = "";

    if(typeof context === "object") {
        for(var key in context) {
            if(context.hasOwnProperty(key)) {
                // clone the context so it's not
                // modified by the template-engine when
                // setting "_key"
                var ctx = jQuery.extend(
                    {"_key":key},
                    context[key]);

                ret = ret + fn(ctx);
            }
        }
    } else {
        ret = inverse(this);
    }
    return ret;
});

/*--------------------------------------------------------------------------------------*/
Handlebars.registerHelper('oach', function(context, options) {
  var out = '';
  var vi, li;
  for(var i=0, li=items.length; i<li; i++) 
    { 
    console.log(options.fn(items[i])); 
    console.log(this);
    console.log('help');
    if ((i+1) == li)
       { 
       out = out + '<td><a id="launch_modal_edit('+options.fn(items[i])+')" href="#mymodal_option" data-toggle="modal"class="btn btn-primary"> <i class="icon-pencil icon-large"></i> </a></td>';
       }
       else
          {
          out = out + "<td>"+options.fn(items[i])+"</td>";
          }       
    }
  return out;
});
Handlebars.registerHelper('listid', function(context, options) {
  var ret = "";

  for(var i=0, j=context.length; i<j; i++) {
    ret = ret + options.fn(context[i]);
  }

  return ret;  
  });
/*--------------------------------------------------------------------------------------*/
Handlebars.registerHelper("debug", function(optionalValue) {
  console.log("Current Context");
  console.log("====================");
  console.log(this);
 
  if (optionalValue) {
    console.log("Value");
    console.log("====================");
    console.log(optionalValue);
  }
});
/*--------------------------------------------------------------------------------------*/
Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) 
    {
    switch (operator) 
        {
        case '==':
            return (v1 == v2) ? options.fn(this) : options.inverse(this);
            break;
        case '===':
            return (v1 === v2) ? options.fn(this) : options.inverse(this);
            break;
        case '<':
            return (v1 < v2) ? options.fn(this) : options.inverse(this);
            break;
        case '<=':
            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
            break;
        case '>':
            return (v1 > v2) ? options.fn(this) : options.inverse(this);
            break;
        case '>=':
            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
            break;
        case '!=':
            return (v1 != v2) ? options.fn(this) : options.inverse(this);
            break;            
        default:
            return options.inverse(this)
            break;
        }
    });


