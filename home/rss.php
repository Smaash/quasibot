<?php

require('../config.php');
auth();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | rss</title>
    <link href="../style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
 <div id="page">
        <div id="page-bgtop">
            <div id="page-bgbtm">
                <div id="content">
                      <div class="post" name="top" >
                    <h2 class="title"><center><a href="#1337day">1337day</a> - <a href="#NVD">Nation Vuln Database</a> - <a href="#securityfocus">Security Focus</a> - <a href="#cxsecurity">cxsecurity</a></center></h2>
                    </div>
                      <div class="post">
                        <h2 class="title"><a name="1337day" href="#top" >1337day</a></h2>
                        <div class="entry">
                            <p class="meta">1337day.com</p>

    <?php
        rss('http://1337day.com/rss');
    ?>

                        </div>
                    </div>
                    
                    <div class="post">
                        <h2 class="title"><a name="NVD" href="#top" >National Vulnerabilit Database</a></h2>
                        <div class="entry">
                            <p class="meta">nvd.nist.gov</p>

    <?php
        rss('http://nvd.nist.gov/download/nvd-rss.xml');
    ?>

                        </div>
                    </div>
                    
                      <div class="post">
                        <h2 class="title"><a name="securityfocus" href="#top" >Security Focus</a></h2>
                        <div class="entry">
                            <p class="meta">securityfocus.com</p>

    <?php
        rss('http://www.securityfocus.com/rss/vulnerabilities.xml');
    ?>

                        </div>
                    </div>
                    
                        <div class="post">
                        <h2 class="title"><a name="cxsecurity" href="#top" >cxsecurity</a></h2>
                        <div class="entry">
                            <p class="meta">cxsecurity.com</p>

    <?php
        rss('http://cxsecurity.com/cverss/fullmap/');
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
