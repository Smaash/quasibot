quasibot
========

quasiBot 0.1 - Read Me

Date - 24.07.14
Author - Smash (smash[at]devilteam.pl)

#Agenda

QuasiBot is a complex webshell manager written in PHP, which operate on web-based backdoors implemented by user himself. Using prepared php backdoors, quasiBot will work as C&C trying to communicate with each backdoor. Tool goes beyond average web-shell managers, since it delivers useful functions for scanning, exploiting and so on. It is quasi-HTTP botnet, therefore it is called. 

All data about bots is stored in SQL database, ATM only MySQL is supported. TOR proxy is also supported, the goal was to create secure connection between C&C and backdoors; using SOCKS5, it is able to torify all connections between you and web server. All configuration is stored in config file. QuasiBot it's still under construction so i am aware of any potential bugs.

You will need any web server software; tested on Linux, Apache 2.2 and PHP 5.4.4.


#How it works?

 - quasiBot is operating on web-shells delivered by user, each backdoor is being verified by md5 hash which changes every hour

		quasiBot (C&C) -[request/verification]-> Bots (Webshells) -[response/verification]-> quasiBot (C&C) -[request/command]-> Bots (Webshells) -[response/execution]-> quasiBot (C&C)				

 - Backdoors consists of two types, with and without DDoS module, source code is included and displayed in home page; 
 - Connection between C&C and server is being supported by curl, TOR proxy is supported, User Agent is being randomized from an array

 		quasiBot (C&C) -[PROXY/TOR]-> Bots (Webshells) <-[PROXY/TOR]- quasiBot (C&C)

 - Webshells can be removed and added at 'Settings' tab, they are stored in database
 - 'RSS' tab contain latest exploits and vulnerabilities feeds
 - 'RCE' tab allows to perform Remote Code Execution on specific server using selected PHP function
 - 'Scan' tab allows to resolve IP or URL and perform basic scan using nmap, dig and whois - useful in the phase of gathering information
 - 'Pwn' tab stands for few functions, which generally will help collect informations about server and try to find exploits for currently used OS version using Linux Exploit Suggestor
 - 'MySQL Manager', as the name says, can be used to perform basic operations on specific database - it could be helpful while looking for config files that include mysql connections on remote server; it also displays some informations about it's envoirment
 - 'Run' tab allows you to run specific command on every bots at once
 - 'DDoS' tab allows you to perform UDP DoS attacks using all bots or single one, expanded backdoor is required
 - Whole front-end is maintaned in a pleasant, functional interface


#Screens

Home
 - Index - http://i.imgur.com/tzUFm4x.png
 - Settings - http://i.imgur.com/y9QiFIL.png
 - RSS - http://i.imgur.com/Rt1mITd.png 

Hack
 - RCE - http://i.imgur.com/CeVOej3.png
 - Scan - http://i.imgur.com/Em44FNj.png
 - Pwn - http://i.imgur.com/08Wgydz.jpg

Tools
 - MySQL Manager - http://i.imgur.com/36Y7PEH.png
 - HostScan - http://i.imgur.com/nhtSW7L.png

Bots
 - DDoS - http://i.imgur.com/Ze7Lczm.png
 - Run - http://i.imgur.com/J3aIutf.png


#Running quasi for first time

 - Move all files to prepared directory, change default settings in config file (config.php)
 - Visiting quasiBot for the first time will create needed database and it's structure
 - In 'Settings' tab, you are able to add and delete shells, you're ready to go


#Todo

 - Authorization system
 - Move Linux Exploit Suggestor to PHP language
 - Add Windows support to 'PWN' module
 - Automatic attacks on servers
 - Backdoors creation (backconnects)
 - Source code cleanup, it's still pretty shitty
 - ???

...and ofc., it's for educational purposes only ;)
