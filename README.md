ænima
======


<h3><a href="http://www.youtube.com/watch?v=J4fdPrjKDME">Be water my friend</a><h3>

<h2>First of all, what is this made of anyway?</h2>

<a href="http://cisbit.com/api/">aenima</a> is a restful api built with a little help of my friends: websocket, 
socket.io, nodejs, apache, php, underscorejs, postgresql, jquery, handlebars and bootstrap 

<b>ty all you guys are awesome</b>

Cloud Computing allows the elasticity of the data server-side, using this we can achieve a simulation of 
fluency giving a seamless product. This is the goal of aenima, following the steps of meteor and express
but holding on to our beloved and old friend apache and adding some layers.

<h2>But why?</h2>

Working with or in realtime apps makes you forget about rendering views server-side, the goal is
to load all in the client, accessing a restful api, this way we can preserve the functionality of many js plugins
that we all use to make our apps (datatables, datagrid, isotope, d3js, etc) and remain the dom accesibility of this
re-rendered elements.... Or at least thats what I tell myself so I can keep on working on it :)

<h2>Can I help?</h2>
This is a one and a half men operation, any help, feedback and support is welcome! contact by mail
b3n0ns@gmail.com

<h2>Whats the vision of ænima?</h2>

The goal is to make an unobtrusive framework that allows you to make your work and just gives you a way to achieve
the functionality that we want, and eventually allow us to build apps that haves a mix of this big, larger than life 
friends:

<ul>
   <li>amazon</li>
   <li>twitter</li>
   <li>facebook</li>
   <li>wizpert</li>
   <li>wordpress</li>
</ul>

How far can we push the  user-server interaction? The goal of aenima es to provide an union between different 
aplications:

<ul>
  <li>blog</li>
  <li>social network</li>
  <li>cms</li>
  <li>crms</li>
  <li><b>and all realtime</b> or and justice for all... :)</li>
</ul>  

All working under the same structure, a seamless transparent solution for both programer and user working 
for different devices and OSs.

  
<h1>Installing on ubuntu</h1>
<ul>
  <li>$ sudo apt-get install apache php5 libapache2-mod-php5 php5-pgsql php5-curl</li>
  <li>$ sudo git clone git://github.com/b3n0n/aenima.git</li>
  <li>$ sudo chmod 777 -R /var/www</li>
  <li>go to http://localhost/aenima/ (compatibility test for different browsers and devices needed)</li>
</ul>
<p>You need to have installed in your server apache, php, php-pgsql and php-curl (this runs in windows too, I must add install instructions for that) then clone the repo in your www folder and run :)</p>

<h1>Self æniming?</h1>
<p>If you want to make your own ænima then just modify the api.js file with your database, modify the views port to your own one runing with nodejs.</p>

