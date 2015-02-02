<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | ssh</title>
    <link href="../style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
    <div id="page">
        <div id="page-bgtop">
            <div id="page-bgbtm">
                <div id="content">

                    <div class="post">
                        <h2 class="title"><a href="#">Single bruteforce</a></h2>
                        <div class="entry">
                            <p class="meta"> 
                    Single SSH attack &nbsp;&bull;&nbsp; If you won't use wordlist, default passwords array will be set
                            </p>

                            <form method="post">
                            <table>
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
                             echo "<input type=\"text\" style=\"width: 70px;\" value=\"". (empty($_POST['suser'])?"root":htmlspecialchars($_POST['suser'])) ."\" name=\"suser\"></b>";
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
                    Massive SSH attack &nbsp;&bull;&nbsp; Specify ip range as shown below
                            </p>

                            <form method="post">
                            <table>
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
                             echo "<input type=\"text\" style=\"width: 70px;\" value=\"". (empty($_POST['muser'])?"root":htmlspecialchars($_POST['muser'])) ."\" name=\"muser\"></b>";
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

                                brute_ssh();

                            ?>


                    <div style="clear: both;">&nbsp;</div>
                </div>
                <div style="clear: both;">&nbsp;</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
