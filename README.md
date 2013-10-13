ænima
======

<h2>what is ænima?</h2>

<a target="_blank" href="http://b3n0n.github.io/aenima">aenima</a> is a restful api built with a little help of my friends: websocket, 
socket.io, nodejs, apache, php, underscorejs, postgresql, jquery, handlebars and bootstrap.

Following the steps of meteor and express but holding on to our old friend apache.

<h2>But why?</h2>

Working with or in realtime apps makes you forget about rendering views server-side, the goal is
to load all in the client, accessing a restful api, this way we can preserve the functionality of many js plugins
that we all use to make our apps (datatables, datagrid, isotope, d3js, etc) and remain the dom accesibility of this
re-rendered elements.

<h2>Can I help?</h2>
Any help, feedback and support is welcome! contact by mail b3n0ns@gmail.com

<h2>Whats the vision of ænima?</h2>

The goal is to make an unobtrusive framework that allows you to do your work and gives you a way to achieve
the functionality that we want, and eventually allow us to build apps on it.

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
  <li>$ cd /var/www/</li>
  <li>$ sudo git clone git://github.com/b3n0n/aenima.git</li>
  <li>$ sudo chmod 777 -R /var/www</li>
  <li>go to http://localhost/aenima/ (compatibility test for different browsers and devices needed)</li>
</ul>
<p>You need to have installed in your server apache, php, php-pgsql and php-curl on windows too, clone the repo in your www folder and run</p>

<h1>Self æniming?</h1>
<p>If you want to make your own ænima then just modify the api.js file with your database and config to it, modify the views port to your own one runing with nodejs</p>

