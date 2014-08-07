<?php

require('config.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>quasiBot | login</title>
    <link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>

<div id="page-login">

<div class="post">
<h2 class="title"><center>Login area</center></h2>
<div class="entry">
<form method="post">
<p class="meta"></p>
<center>
<p>Name - <input type="text" name="username" style="width: 150px;"></p>
<p>Pass - &nbsp;<input type="password" name="password" style="width: 150px;"></p>
<input type="submit" value="Login">
</center>
</form>

<?php

if(AUTH_ENABLE == 1) {

session_start();

if(isset($_POST['username']) && isset($_POST['password'])) {
	if($_POST['username'] == AUTH_USER && md5($_POST['password']) == AUTH_PASS) {
		$_SESSION['user'] = $_POST['username'];
		header('Location: home/index.php');
	} else {
		echo '<br /><center><p>Incorred user or password</p></center>';
	}
}
} else {
	header('Location: home/index.php');
}

?>

</div>

</div>
</div>

</body>
