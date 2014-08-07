<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | rss</title>
    <link href="../style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
    <div id="header">


        <div id="logo">
            <h1><a href="index.php">&nbsp; &nbsp; &nbsp;<?php echo date('H:i:s') ?></a></h1>

<?php
    quotes();
?>

        </div>
    </div>
    <div id="menu">
        <ul>
            <li class="txt_left"><?php echo $_SERVER['DOCUMENT_ROOT'] ?></li>
            <li class="txt_left"><?php echo $_SERVER['PHP_SELF'] ?></li>
            <li class="txt_center"><?php echo date("d.m.y"); ?></li>
            <li class="txt_right"><?php echo $_SERVER['SERVER_ADDR'] ?></li>
            <li class="txt_right"><?php echo $_SERVER['SERVER_NAME'] ?></li>
            <li class="txt_right"><?php echo conn('http://bot.whatismyipaddress.com/') ?></li>
        </ul>
    </div>
 <div id="page">
        <div id="page-bgtop">
            <div id="page-bgbtm">
                <div id="content">
                      <div class="post" name="top" >
                    <h2 class="title"><center><a href="#1337day">1337day</a> - <a href="#NVD">Nation Vuln Database</a> - <a href="#securityfocus">Security Focus</a> - <a href="#cxsecurity">cxsecurity</a></center></h2>
                    </div>
                      <div class="post">
                        <h2 class="title"><a name="1337day" href="#top" >1337day</a></h2>
                        <div class="entry">
                            <p class="meta">1337day.com</p>

    <?php
        rss('http://1337day.com/rss');
    ?>

                        </div>
                    </div>
                    
                    <div class="post">
                        <h2 class="title"><a name="NVD" href="#top" >National Vulnerabilit Database</a></h2>
                        <div class="entry">
                            <p class="meta">nvd.nist.gov</p>

    <?php
        rss('http://nvd.nist.gov/download/nvd-rss.xml');
    ?>

                        </div>
                    </div>
                    
                      <div class="post">
                        <h2 class="title"><a name="securityfocus" href="#top" >Security Focus</a></h2>
                        <div class="entry">
                            <p class="meta">securityfocus.com</p>

    <?php
        rss('http://www.securityfocus.com/rss/vulnerabilities.xml');
    ?>

                        </div>
                    </div>
                    
                        <div class="post">
                        <h2 class="title"><a name="cxsecurity" href="#top" >cxsecurity</a></h2>
                        <div class="entry">
                            <p class="meta">cxsecurity.com</p>

    <?php
        rss('http://cxsecurity.com/cverss/fullmap/');
    ?>

                        </div>
                    </div>
                    <div style="clear: both;">&nbsp;</div>
                </div>
                <div id="sidebar">
                    <ul>
                        <li>
                            <h2>Home</h2>
                            <ul>
                                <li><a href="index.php">Index</a></li>
                                <li><a href="settings.php">Settings</a></li>
                                <li><a href="rss.php"><b>RSS</b></a></li>
                            </ul>
                        </li>
                        <li>
                           <h2>Hack</h2>
                            <ul>
                                <li><a href="../hack/rce.php">RCE</a></li>
                                <li><a href="../hack/scan.php">Scan</a></li>
                                <li><a href="../hack/pwn.php">Pwn</a></li>
                                <li><a href="../hack/shell.php">Shell</a></li>
                            </ul>
                        </li>
                        <li>
                           <h2>Bruteforce</h2>
                            <ul>
                                <li><a href="../bf/ssh.php">SSH</a></li>
                                <li><a href="../bf/ftp.php">FTP</a></li>
                                <li><a href="../bf/dbs.php">DB's</a></li>
                                <li><a href="../bf/www.php">WWW</a></li>
                            </ul>
                        </li>
                        <li>
                           <h2>Tools</h2>
                            <ul>
                                <li><a href="../tools/sql.php">MySQL Manager</a></li>
                                <li><a href="../tools/hostscan.php">HostScan</a></li>
                             </ul>
                        </li>
                        <li>
                           <h2>Bots</h2>
                            <ul>
                                <li><a href="../hack/ddos.php">DDoS</a></li>
                                <li><a href="../hack/more.php">Run</a></li>
                             </ul>
                        </li>
                </div>
                <div style="clear: both;">&nbsp;</div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
    <p><?php echo $_SERVER['SERVER_SOFTWARE']; echo '  -  '; echo $_SERVER['HTTP_USER_AGENT'] ?></p>
</div>
</body>
</html>
