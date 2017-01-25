<?php
include ('header.php');
if ($_SESSION['Admin']==1){
	echo '<div class="page_hint">'."\n";
	include ('question_hint.php');
	echo '</div>'."\n";
	$db = new PDO($dsn, $user, $pwd);
	$st = $db->prepare("SELECT `fnr` as 'Fragenummer', `frage` as 'Frage', `fragetyp` as 'FT', `aw01` as 'Antwort 1',`hint` as 'Hinweis' FROM `".$pre."quiz_fragen`");
	if ($st->execute()){
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
				for ($i=1;$i<=$cols-1;$i++) {
				if ($i==2){
					echo '<td>'."\n";
					switch ($erg[$i]) {
						case 0: echo 'FF'; break;
						case 1: echo 'MC (1)'; break;
						case 2: echo 'MC (2)'; break;
						case 3: echo 'MC (3)'; break;
						case 4: echo 'MC (4)'; break;
						case 5: echo 'MC (5)'; break;
						case 6: echo 'MC (6)'; break;
					}
					echo '</td>'."\n";
				}
				else {
						echo '<td>'.substr($erg[$i],0,25);
						if (strlen($erg[$i])>25) echo '...';
						echo '</td>'."\n";
					}
				}
				echo '<td><Form action="question_edit.php" method="post"><input type="hidden" name="fnr" value='.$erg[0].' /><input type="Submit" value="Bearbeiten" name="edit"></form></td></tr>'."\n";
			}
			echo '</table>'."\n";
		}
	else echo '<p>Abfrage liefert keine Datens&auml;tze</p>'."\n";
	}
	else echo '<p>Datenbankaufruf fehlgeschlagen</p>'."\n";
}
else header('location:index.php');
include ('footer.php');
?>