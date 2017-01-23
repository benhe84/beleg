<?php
include ('header.php');
if ($_SESSION['Admin']==1){
	$db = new PDO($dsn, $user, $pwd);
	$st = $db->prepare("SELECT ".$pre."user.sid, Vorname, Name, SUM(`points`) as 'Punkte' FROM ".$pre."user INNER JOIN ".$pre."quiz_gefragt ON ".$pre."user.sid = ".$pre."quiz_gefragt.sid GROUP BY Name ORDER BY Name");
	if ($st->execute()){
		$rows = $st->rowCount();
		$cols = $st->columnCount();
		if ($rows>0){
			echo '<table><tr>';
			for ($i=2;$i<=$cols-1;$i++){
				$meta = $st->getColumnMeta($i);
				echo '<th>'.$meta['name'].'</th>';
			}
			echo '<th>Zur&uuml;cksetzen</th></tr>';
			foreach ($st as $erg){
				echo '<tr>';
				echo '<td>'.$erg[1].', '.$erg[2].'</td>';
				echo '<td>'.$erg[3].'</td>';
                echo '<td><Form action="score_delete.php" method="post"><input type="hidden" name="SID" value='.$erg[0].' /><input type="Submit" value="Reset" name="edit"></form></td></tr>';
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