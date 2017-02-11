<?php
// Bindet den Header der Seite mit der Navigation ein
include('header.php');
if ($_SESSION['Admin']==1){
    // Erzeuge PDO
	$db = new PDO($dsn, $user, $pwd);
    // Bereite PDO Statement vor
    $st = $db->prepare("SELECT ".$pre."user.sid, Vorname, Name, SUM(`points`) as 'Punkte' FROM ".$pre."user INNER JOIN ".$pre."quiz_gefragt ON ".$pre."user.sid = ".$pre."quiz_gefragt.sid GROUP BY Name ORDER BY Name");
	if ($st->execute()){
		$rows = $st->rowCount();
		$cols = $st->columnCount();
		if ($rows>0){
			echo '<table><tr>'."\n";
			for ($i=2;$i<=$cols-1;$i++){
				$meta = $st->getColumnMeta($i);
				echo '<th>'.$meta['name'].'</th>'."\n";
			}
			echo '<th>Zur&uuml;cksetzen</th></tr>'."\n";
			foreach ($st as $erg){
				echo '<tr>'."\n";
				echo '<td>'.$erg[1].', '.$erg[2].'</td>'."\n";
				echo '<td>'.$erg[3].'</td>'."\n";
                echo '<td><Form action="score_delete.php" method="post"><input type="hidden" name="SID" value='.$erg[0].' /><input type="Submit" value="Reset" name="edit"></form></td></tr>'."\n";
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
