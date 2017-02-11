<?php
include ('header.php');
if ($_SESSION['Admin']==1){
	if (isset($_POST['senden'])){
        $fname = $_POST['FName']."%";
		$vname = $_POST['VName']."%";
		$klasse = $_POST['Klasse']."%";
	}
    else {
        $fname = "%";
        $vname = "%";
        $klasse = "%";
    }
	echo '<div class="page_hint">'."\n";
	echo '<h2>Sch&uuml;lersuche</h2>'."\n";
	echo '<Form action="student_show.php" method="post">'."\n";
	echo '<input type="Text" placeholder="Name" name="FName"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['FName']);
	echo ' />'."\n";
	echo '<input type="Text" placeholder="Vorname" name="VName"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['VName']);
	echo ' />'."\n";
	echo '<input type="Text" placeholder="Klasse" name="Klasse"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['Klasse']);
	echo ' />'."\n";
	echo '<input type="Submit" value="Suchen" name="senden" />'."\n";
	echo '</form>'."\n";
	echo '</div>'."\n";
    // Erzeuge PDO
	$db = new PDO($dsn, $user, $pwd);
    // Bereite PDO Statement vor
    $st = $db->prepare("SELECT `sid`, `e-mail` as `E-Mail`, `Vorname`, `Name`, `Klasse`, `lehrer` as `Rolle`  FROM `".$pre."user` WHERE `Name` LIKE :fname && `Vorname` LIKE :vname && `Klasse` LIKE :klasse");
	if ($st->execute(array(':fname' => $fname, ':vname'=> $vname, ':klasse'=>$klasse))){
		$rows = $st->rowCount();
		$cols = $st->columnCount();
		if ($rows>0){
			echo '<table><tr>'."\n";
			for ($i=1;$i<=$cols-1;$i++){
				$meta = $st->getColumnMeta($i);
				echo '<th>'.$meta['name'].'</th>'."\n";
			}
			echo '<th>Bearbeiten</th></tr>'."\n";
			foreach ($st as $erg){
				echo '<tr>'."\n";
				for ($i=1;$i<=$cols-1;$i++){
					if ($i==5){										//Rolle
						if ($erg[$i]==0) echo '<td>Sch&uuml;ler</td>'."\n";
						if ($erg[$i]==1) echo '<td>Lehrer</td>'."\n";
					}
					else echo '<td>'.$erg[$i].'</td>'."\n";
				}
				echo '<td><Form action="student_edit.php" method="post"><input type="hidden" name="SID" value='.$erg[0].' /><input type="Submit" value="Bearbeiten" name="edit"></form></td></tr>'."\n";
			}
			echo '</table>'."\n";
		}
	else echo '<p>Abfrage liefert keine Datens&auml;tze</p>'."\n";
	}
	else echo '<p>Datenbankaufruf fehlgeschlagen</p>'."\n";
}
// Umleitung auf Loginseite, wenn User nicht eingeloggt
else header('location:login.php');
// Bindet den Footer der Seite ein
include ('footer.php');
