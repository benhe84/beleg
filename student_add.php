<?php
include ('header.php');
echo '<h1>Sch&uuml;ler anlegen</h1>'."\n";
if ((isset($_POST['senden'])) && (($_POST['EPWD1'])==($_POST['EPWD2']))){
	$EMail = $_POST['EMail'];
	$EVname = $_POST['EVname'];
	$EName = $_POST['EName'];
	$EPWD = $_POST['EPWD1'];
	$EKlasse = $_POST['EKlasse'];
	$pwd_md5= md5($EPWD);
	// Create PDO
	$db = new PDO($dsn, $user, $pwd);
	// Prepare PDO Statement
	$st = $db->prepare ("INSERT INTO `".$pre."user`(`e-mail`,`password`, `Name`, `Vorname`, `Klasse`) VALUES
	(:mail,:pwd,:fname,:vname,:klasse)");
	// Exceute PDO Statement
	if ($st->execute(array(':mail' => $EMail, ':pwd'=> $pwd_md5, ':fname'=> $EName,':vname'=> $EVname,':klasse'=>$EKlasse))) {
		echo '<table>'."\n";
		echo '<tr>'."\n";
		echo '<th colspan="2">Sch&uuml;ler erfolgreich hinzugef&uuml;gt</th>'."\n";
		echo '</tr>'."\n";
		echo '<tr><td>E-Mail</td><td>'.$EMail.'</td></tr>'."\n";
		echo '<tr><td>Name</td><td>'.$EName.'</td></tr>'."\n";
		echo '<tr><td>Vorname</td><td>'.$EVname.'</td></tr>'."\n";
		echo '<tr><td>Klasse</td><td>'.$EKlasse.'</td></tr>'."\n";
		echo '<td colspan="2"><a href="index.php">Zum Login</a></td></tr>'."\n";
		echo '</table>'."\n";}
	else {
		echo "Es ist bereits ein Sch&uuml;ler mit dieser E-Mail Adresse registriert<br />/n";
		echo '<a href="student_add.php">zur&uuml;ck</a></td></tr>'."\n";
	}
}

else{
	echo '<Form action="student_add.php" method="post">'."\n";
	echo '<input type="e-mail" name="EMail" placeholder="E-Mail"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['EMail']);
	echo ' required /><br />'."\n";
	echo '<input type="Text" name="EVname" placeholder="Vorname"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['EVname']);
	echo ' required /><br />'."\n";
	echo '<input type="Text" name="EName" placeholder="Name"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['EName']);
	echo ' required /><br />'."\n";
	echo '<input type="Text" name="EKlasse" placeholder="Klasse"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['EKlasse']);
	echo ' required /><br />'."\n";
	echo '<input type="password" name="EPWD1" placeholder="Passwort"><br />'."\n";
	// echo '<p id="strength">&nbsp;</p>'."\n";
	echo '<input type="password" name="EPWD2" placeholder="Passwort wiederholen"><br />'."\n";
	// echo '<p id="valid">&nbsp;</p>'."\n";
	if (isset($_POST["senden"])){echo 'Passw&ouml;rter stimmen nicht überein';}
	echo '<input class="dropbtn" type="Submit" value="Sch&uuml;ler anlegen" name="senden">'."\n";
	echo '</form>'."\n";
	
} 
include ('footer.php');
