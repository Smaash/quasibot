<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | home</title>
    <link href="../style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>

<div id="wrapper">

     

    <div id="header">
        <div id="logo">
            <h1><a href="index.php">&nbsp; &nbsp; &nbsp;<?php echo date('H:i:s') ?></a></h1>
            <?php quotes();?>
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
                
                <div id="sidebar" style="float:left"> 
                    <iframe src="/hacktest/quasibot/home/sidebar.php" width="300px" height="1000px" scrolling=auto ></iframe>
                </div> 

                <div id="content" style="float:left"> 
                    <iframe name="contentframe" src="/hacktest/quasibot/home/content.php" width="735px" height=1000px scrolling=auto></iframe>
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
