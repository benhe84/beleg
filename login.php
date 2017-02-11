<?php
// Bindet den Header der Seite mit der Navigation ein
include('header.php');
echo '<h1>Login</h1>'."\n";
if (isset($_POST['submit_login'])){
	$f_email=$_POST['Mail'];
	$f_password=md5($_POST['PWD']);
    // Erzeuge PDO
	$db = new PDO($dsn, $user, $pwd);
    // Bereite PDO Statement vor
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
	
	echo '<form action="login.php" method="post">'."\n";
    echo '<h2>Bitte geben Sie Ihre Nutzerdaten ein:</h2>'."\n";
    echo '<label for="Mail">E-Mail</label>'."\n";
    echo '<p><input id="Mail" type="e-mail" style="width: 165px" name="Mail" placeholder="E-Mail"/></p>'."\n";
    echo '<label for="PWD">Passwort</label>'."\n";
    echo '<p><input id="PWD" type="password" style="width: 165px" name="PWD" placeholder="Passwort" /></p>'."\n";
    echo '<p><input type="submit" name="submit_login" value="Login" /></p>'."\n";
	echo '</form>'."\n";
}
// Bindet den Footer der Seite ein
include ('footer.php');