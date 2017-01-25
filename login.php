<?php
include ('header.php');
echo '<h1>Login</h1>';
if (isset($_POST['submit_login'])){
	$f_email=$_POST['email'];
	$f_password=md5($_POST['password']);
	$db = new PDO($dsn, $user, $pwd);
	$st = $db->prepare("SELECT* FROM `".$pre."user` WHERE `e-mail` = :mail && `password`= :pwd");
	if ($st->execute(array(':mail' => $f_email, ':pwd'=> $f_password))){
	$row=$st->rowCount();
    if ($row==1){
		$erg = $st->fetch();
		$_SESSION['E-Mail'] = $erg['e-mail'];
		$_SESSION['SID'] = $erg['sid'];
		$_SESSION['Admin'] = $erg['lehrer'];
		$_SESSION['Login'] = 1;
		header('location:index.php');}
	else echo 'Ung&uuml;ltiges Login, bitte wiederholen!';
	}
else{echo 'SQL Verbindung fehlgeschlagen';}
}
else {
	
	echo '<form action="login.php" method="post">';
    echo '<h2>Bitte geben Sie Ihre Nutzerdaten ein:</h2>';
    echo '<label for="email">E-Mail</label>';
    echo '<p><input id="email" type="e-mail" style="width: 165px" name="email" placeholder="E-Mail"/></p>';
    echo '<label for="password">Passwort</label>';
    echo '<p><input id="Passwort" type="password" style="width: 165px" name="password" placeholder="Passwort" /></p>';
    echo '<p><input type="submit" name="submit_login" value="Login" /></p>';
	echo '</form>';
}
include ('footer.php');
?>