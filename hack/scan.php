<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | scan</title>
    <link href="../style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
    <div id="page">
        <div id="page-bgtop">
            <div id="page-bgbtm">
                <div id="content">

                    <div class="post">
                        <h2 class="title"><a href="#">Determine target</a></h2>
                        <div class="entry">
                        <p class="meta">
                        url 2 ip &nbsp;&bull;&nbsp; ip 2 url 
                        </p>
                        <form method="post">
                        <table style="width: 80%;">
                        <tr>
                        <td>
                        <?php
                        echo "<td><input type=\"text\" style=\"width: 300px;\" value=\"". (empty($_POST['urlip'])?"127.0.0.1":htmlspecialchars($_POST['urlip'])) ."\" name=\"urlip\">"; 
                        ?>
                        </td>
                        <td><input type="radio" name="sup" value="iptourl">IP -> URL<br/><input type="radio" name="sup" value="urltoip">URL -> IP</td>
                        <td><input type="submit" value="Go"></td>
                        </table>
                        </tr>
                        </form>
                        <?php
                        if(isset($_POST['urlip']))
                        {
                            if($_POST['sup'] == 'iptourl') {
                                echo '<br/><p>'.htmlspecialchars($_POST['urlip']).' -> '.gethostbyaddr($_POST['urlip']).'</p>';
                            } elseif($_POST['sup'] == 'urltoip') {
                                echo '<br/><p>'.htmlspecialchars($_POST['urlip']).' -> '.gethostbyname($_POST['urlip']).'</p>';
                            }
                        }
                        ?>
                        </div>
                        </div>

                    <div class="post">
                        <h2 class="title"><a href="#">Target scan</a></h2>
                        <div class="entry">
                            <p class="meta"> 
                            Based on Linux command execution &nbsp;&bull;&nbsp; NOT using proxy by default, use proxychains
                            </p>
                        <form method="post">
                        <table>
                        <tr><td></td><td></td><td><b>Nmap args</b></td></tr>
                        <tr>
                        <td><input type="checkbox" name="proxychains" value="yes">Proxychains</td>
                        <td>
                            <?php
                             echo "<input type=\"text\" style=\"width: 300px;\" value=\"". (empty($_POST['host'])?"127.0.0.1":htmlspecialchars($_POST['host'])) ."\" name=\"host\"></td>&nbsp;";
                             echo "<td><input type=\"text\" style=\"width: 90px;\" value=\"". (empty($_POST['ncmd'])?"-sV -A":htmlspecialchars($_POST['ncmd'])) ."\" name=\"ncmd\">"; 
                            ?>
                        </td>
                        <td style="text-align: left;"><input type="checkbox" name="nmap" value="yes"> Nmap<br />
                        <input type="checkbox" name="dig" value="yes"> Dig<br />
                        <input type="checkbox" name="whois" value="yes"> Whois<br /></td>
                        <td><input type="submit" value="Scan"></td>
                        </tr>
                        </table>
                        </form>
                            </p>
                        </div>
                    </div>

                    <?php
                        scan();
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
