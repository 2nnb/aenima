var Bot = require('./bot')
    config = require('./config'),
    _ = require('underscore'),
    $ = require('jquery'),
    bot = new Bot(config);

var nodecr = require('nodecr');

// Recognise text of any language in any format
nodecr.process(__dirname + '/img/zentest.png',function(err, text) {
    if(err) {
        console.error(err);
    } else {
        console.log(text);
    }
});


console.log('RTD2: Running.');

//get date string for today's date (e.g. '2011-01-01')
function datestring () 
  {
  var d = new Date(Date.now() - 5*60*60*1000);  //est timezone
  return d.getUTCFullYear()   + '-'
     +  (d.getUTCMonth() + 1) + '-'
     +   d.getDate();
  }
function handleError(err) 
  {
  console.error('response status:', err.statusCode);
  console.error('data:', err.data);
  }

  


var pg = require('pg'),
    conString = 'postgres://aliens:aliens%2013@54.235.167.23/cisbit_aps',
    pg_client = new pg.Client(conString), 
    io = require('socket.io').listen(1337); 


io.set('log level', 2);
io.configure(function (){
  io.set('authorization', function (handshakeData, callback) {
    callback(null, true); // error first callback style 
  });
});
io.sockets.on('connection', function (socket) 
  {  
  io.sockets.emit('log', socket.handshake.query.username);
  console.log('Auth: ',  socket.handshake.query);
  bot.twit.get('followers/list', function(err, reply) 
    {
    if(err) return handleError(err)
    var followers = reply.users;
    var followers_names = _.pluck(followers, 'name');
    io.sockets.emit('log', JSON.stringify(followers_names));  
    console.log('# followers:'+JSON.stringify(followers_names));
    });
  bot.twit.get('search/tweets', { q: '@nikemallamerica #RSVP since:2011-11-11', count: 100 }, function(err, reply) {
    if(err) return handleError(err)
    var tweets = reply.statuses;
    tweets = _.pluck(tweets, ['text','url']);
    //var followers_names = _.pluck(followers, 'name');    
    $.each(tweets, function(){
      console.log('# tweets:'+this);   
      //io.sockets.emit('log', JSON.stringify(this)); 
      });      
    })  
  socket.on('disconnect', function () 
    {
    io.sockets.emit('log', 'User '+socket.handshake.query.username+' disconnected');
    });
  socket.on('chat', function (data) 
    {
    pg_client = new pg.Client(conString);   
    pg_client.connect(function(err) 
        {
        if (err) 
           {
           return console.error('could not connect to postgres', err);
           }
        pg_client.query("INSERT INTO api.user_msg (id_user, msg, date) VALUES ("+socket.handshake.query.user_id+", '"+data.msg+"', "+Math.round(+new Date()/1000)+")", function(err, result) 
           {
           if (err) 
              {
              return console.error('error running query', err);
              }
           console.log(socket.handshake.query.username+': '+data.msg);
           pg_client.end();
           });
        });       
    io.sockets.emit('chat', data);
    });
  socket.on('disconnected', function (data) 
    {
    io.sockets.emit('chat', data);
    });  
  });