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

Handlebars.registerHelper('link', function(text, url) 
           {
           text = Handlebars.Utils.escapeExpression(text);
           url  = Handlebars.Utils.escapeExpression(url); 
           var result = '<a href="' + url + '">' + text + '</a>'; 
           return new Handlebars.SafeString(result);
           });
Handlebars.registerHelper('list', function(context, options) {
  var out = "<ul>", data;

  for (var i=0; i<context.length; i++) {
    if (options.data) {
      data = Handlebars.createFrame(options.data || {});
      data.index = i;
    }

    out += "<li>" + options.fn(context[i], { data: data }) + "</li>";
  }

  out += "</ul>";
  return out;
});

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
        default:
            return options.inverse(this)
            break;
        }
    });


