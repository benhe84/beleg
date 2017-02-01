<?php
include ('header.php');
if ($_SESSION['Admin']==1){
	if (isset($_POST['senden'])){
		$pupil = $_POST['pupil'];
	}
	else $pupil ="reset";
	echo '<div class="page_hint">'."\n";
	echo '<h2>Sch&uuml;lerauswahl</h2>'."\n";
	echo '<Form action="answers_show.php" method="post">'."\n";
	$sql = "SELECT `Name`, `Vorname`, `sid` FROM `".$pre."user`";
	if ($result=$db->query($sql)){
		$ds = $result->rowCount();
		if ($ds>0){
		echo '<select name="pupil">'."\n";
		foreach ($result as $spinner){
			echo '<option value="'.$spinner[2].'"';
			if (isset($_POST["senden"])) if ($_POST['pupil']==$spinner[2]) echo ' selected';
			echo '>'.$spinner[0].', '.$spinner[1].'</option>'."\n";
		}
		echo '<option value="reset"';
		if (isset($_POST["senden"])) if ($_POST['pupil']=='reset') echo ' selected';
		echo '>Alle Sch&uuml;ler anzeigen</option>'."\n";
		echo '</select><br />'."\n";
		}
	}
	echo '<input type="Submit" value="W&auml;hlen" name="senden" />'."\n";
	echo '</form>'."\n";
	echo '</div>'."\n";
	$db = new PDO($dsn, $user, $pwd);
	if ($pupil=="reset") $st = $db->prepare("SELECT `Vorname`, `Name`, `frage` as 'Frage', `try` as 'Versuche', `solved` as '', `points` as 'Punkte' FROM ".$pre."user INNER JOIN ( ".$pre."quiz_gefragt INNER JOIN ".$pre."quiz_fragen ON ".$pre."quiz_gefragt.fnr = ".$pre."quiz_fragen.fnr ) ON ".$pre."user.sid = ".$pre."quiz_gefragt.sid ORDER BY `frage`");
	else $st = $db->prepare("SELECT Vorname, Name, frage as 'Frage', try as 'Versuche', solved as '', `points` as 'Punkte' FROM ".$pre."user INNER JOIN ( ".$pre."quiz_gefragt INNER JOIN ".$pre."quiz_fragen ON ".$pre."quiz_gefragt.fnr = ".$pre."quiz_fragen.fnr ) ON ".$pre."user.sid = ".$pre."quiz_gefragt.sid WHERE ".$pre."user.sid = :pupil ORDER BY `frage`");
    if ($st->execute(array(':pupil'=>$pupil))){
		$rows = $st->rowCount();
		$cols = $st->columnCount();
		if ($rows>0){
			echo '<table>'."\n";
			for ($i=1;$i<=$cols-1;$i++){
				$meta = $st->getColumnMeta($i);
				echo '<th>'.$meta['name'].'</th>'."\n";
			}
			foreach ($st as $erg){
				echo '<tr>'."\n";
				for ($i=1;$i<=$cols-1;$i++){
					if ($i==4){										//Lösung
						if ($erg[$i]==0) echo '<td><img src="img/false.svg" alt="falsche Antwort" height="26" ></td>'."\n";
						if ($erg[$i]==1) echo '<td><img src="img/ok.svg" alt="richtige Antwort" height="26" ></td>'."\n";
					}
					else {
						echo '<td>'.substr($erg[$i],0,25);
						if (strlen($erg[$i])>25) echo '...';
						echo '</td>'."\n";
					}
				}
			}
			echo '</table>'."\n";
		}
	else echo '<p>Abfrage liefert keine Datens&auml;tze</p>'."\n";
	}
	else echo '<p>Datenbankaufruf fehlgeschlagen</p>'."\n";
}
else header('location:index.php');
include ('footer.php');
