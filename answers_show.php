<?php
include ('header.php');
if ($_SESSION['Admin']==1){
	if (isset($_GET['senden'])){
		$pupil = $_GET['pupil'];
	}
	else $pupil ="reset";
	echo '<div class="page_hint">';
	echo '<h2>Sch&uuml;lerauswahl</h2>';
	echo '<Form action="answers_show.php" method="get">';
	$sql = "SELECT `Name`, `Vorname`, `sid` FROM `".$pre."user`";
	if ($result=$db->query($sql)){
		$ds = $result->rowCount();
		if ($ds>0){
		echo '<select name="pupil">';
		foreach ($result as $spinner){
			echo '<option value="'.$spinner[2].'"';
			if (isset($_GET["senden"])) if ($_GET['pupil']==$spinner[2]) echo ' selected';
			echo '>'.$spinner[0].', '.$spinner[1].'</option>';
		}
		echo '<option value="reset"';
		if (isset($_GET["senden"])) if ($_GET['pupil']=='reset') echo ' selected';
		echo '>Zur&uuml;cksetzen</option>';
		echo '</select><br />';
		}
	}
	echo '<input type="Submit" value="W&auml;hlen" name="senden" />';
	echo '</form>';
	echo '</div>';
	$db = new PDO($dsn, $user, $pwd);
	if ($pupil=="reset") $st = $db->prepare("SELECT Vorname, Name, frage as 'Frage', try as 'Versuche', solved as '', `points` as 'Punkte' FROM ".$pre."user LEFT JOIN ( ".$pre."quiz_gefragt INNER JOIN ".$pre."quiz_fragen ON ".$pre."quiz_gefragt.fnr = ".$pre."quiz_fragen.fnr ) ON ".$pre."user.sid = ".$pre."quiz_gefragt.sid ORDER BY Name");
	else $st = $db->prepare("SELECT Vorname, Name, frage as 'Frage', try as 'Versuche', solved as '', `points` as 'Punkte' FROM ".$pre."user LEFT JOIN ( ".$pre."quiz_gefragt INNER JOIN ".$pre."quiz_fragen ON ".$pre."quiz_gefragt.fnr = ".$pre."quiz_fragen.fnr ) ON ".$pre."user.sid = ".$pre."quiz_gefragt.sid WHERE ".$pre."user.sid = ".$pupil." ORDER BY Name"); 
	if ($st->execute()){
		$rows = $st->rowCount();
		$cols = $st->columnCount();
		if ($rows>0){
			echo '<table>';
			for ($i=1;$i<=$cols-1;$i++){
				$meta = $st->getColumnMeta($i);
				echo '<th>'.$meta['name'].'</th>';
			}
			foreach ($st as $erg){
				echo '<tr>';
				for ($i=1;$i<=$cols-1;$i++){
					if ($i==4){										//Lösung
						if ($erg[$i]==0) echo '<td><img src="img/false.svg" alt="falsche Antwort" height="26" ></td>';
						if ($erg[$i]==1) echo '<td><img src="img/ok.svg" alt="richtige Antwort" height="26" ></td>';
					}
					else {
						echo '<td>'.substr($erg[$i],0,25);
						if (strlen($erg[$i])>25) echo '...';
						echo '</td>';
					}
				}
			}
			echo '</table>';
		}
	else echo '<p>Abfrage liefert keine Datens&auml;tze</p>';
	}
	else echo '<p>Datenbankaufruf fehlgeschlagen</p>';
}
else header('location:index.php');
include ('footer.php');
?>