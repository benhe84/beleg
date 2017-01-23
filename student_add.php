<?php
include ('header.php');
echo '<h1>Sch&uuml;ler anlegen</h1>';
if ((isset($_POST['senden'])) && (($_POST['EPWD1'])==($_POST['EPWD2']))){
	$EMail = $_POST['EMail'];
	$EVname = $_POST['EVname'];
	$EName = $_POST['EName'];
	$EPWD = $_POST['EPWD1'];
	$EKlasse = $_POST['EKlasse'];
	$pwd_md5= md5($EPWD);
	// Create connection
	$db = new PDO($dsn, $user, $pwd);
	// Check connection
	$st = $db->prepare ("INSERT INTO `".$pre."user`(`e-mail`,`password`, `Name`, `Vorname`, `Klasse`) VALUES
	(:mail,:pwd,:name,:vname,:klasse)");
	if ($st->execute(array(':mail' => $EMail, ':pwd'=> $pwd_md5, ':name'=> $EName,':vname'=> $EVname,':klasse'=>$EKlasse))) {
		echo '<table>';
		echo '<tr>';
		echo '<th colspan="2">Sch&uuml;ler erfolgreich hinzugef&uuml;gt</th>';
		echo '</tr>';
		echo '<tr><td>E-Mail</td><td>'.$EMail.'</td></tr>';
		echo '<tr><td>Name</td><td>'.$EName.'</td></tr>';
		echo '<tr><td>Vorname</td><td>'.$EVname.'</td></tr>';
		echo '<tr><td>Klasse</td><td>'.$EKlasse.'</td></tr>';
		echo '<td colspan="2"><a href="index.php">Zum Login</a></td></tr>';
		echo '</table>';} 
	else {
		echo "Es ist bereits ein Sch&uuml;ler mit dieser E-Mail Adresse registriert<br />";
		echo '<a href="student_add.php">zur&uuml;ck</a></td></tr>';
	}
}

else{
	echo '<Form action="student_add.php" method="post">';
	echo '<input type="e-mail" name="EMail" placeholder="E-Mail"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['EMail']);
	echo ' required /><br/>';
	echo '<input type="Text" name="EVname" placeholder="Vorname"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['EVname']);
	echo ' required /><br/>';
	echo '<input type="Text" name="EName" placeholder="Name"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['EName']);
	echo ' required /><br/>';
	echo '<input type="Text" name="EKlasse" placeholder="Klasse"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['EKlasse']);
	echo ' required /><br/>';
	echo '<input type="password" name="EPWD1" placeholder="Passwort"><br/>';
	echo '<input type="password" name="EPWD2" placeholder="Passwort wiederholen"><br/>';
	if (isset($_POST["senden"])){echo 'Passw&ouml;rter stimmen nicht überein';}
	echo '<input class="dropbtn" type="Submit" value="Sch&uuml;ler anlegen" name="senden">';
	echo '</form>';
	
} 
include ('footer.php');
?>