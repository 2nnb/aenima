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
  socket.on('disconnect', function () 
    {
    io.sockets.emit('log', 'user disconnected');

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
console.log("Api Started");