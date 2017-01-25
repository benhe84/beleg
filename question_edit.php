<?php
include ('header.php');
if ($_SESSION['Admin']==1){
    echo '<h1>Frage &auml;ndern</h1>'."\n";
	echo '<div class="page_hint">'."\n";
	include ('question_hint.php');
	echo '</div>'."\n";
	if (isset($_POST['save'])){
		$FNR = $_POST['fnr'];
		$Frage = htmlentities(($_POST['Frage']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1');
        $Fragetyp = htmlentities(($_POST['Fragetyp']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1');
        $AW1 = htmlentities(($_POST['Antwort_1']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1');
        $AW2 = htmlentities(($_POST['Antwort_2']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1');
        $AW3 = htmlentities(($_POST['Antwort_3']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1');
        $AW4 = htmlentities(($_POST['Antwort_4']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1');
        $AW5 = htmlentities(($_POST['Antwort_5']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1');
        $AW6 = htmlentities(($_POST['Antwort_6']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1');
        $Hinweis = htmlentities(($_POST['Hinweis']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1');
		// Create connection
		$db = new PDO($dsn, $user, $pwd);
		$st = $db->prepare("UPDATE `".$pre."quiz_fragen` SET `frage` = :frage, `fragetyp` = :fragetyp, `aw01` = :aw1, `aw02`  = :aw2 , `aw03` = :aw3, `aw04` = :aw4, `aw05` = :aw5, `aw06`  = :aw6, `hint` = :hint  WHERE `fnr` = '".$FNR."'");
		if ($st->execute(array(':frage' => $Frage, ':fragetyp'=> $Fragetyp, ':aw1' => $AW1, ':aw2' => $AW2, ':aw3' => $AW3, ':aw4' => $AW4, ':aw5' => $AW5, ':aw6' => $AW6,':hint'=>$Hinweis))){
			echo '<p>Erfolgreich gespeichert</p>'."\n";
		} else {
			echo '<p>Eintrag konnte nict gespeichert werden</p>'."\n";
		}
	}
	if (isset($_POST['fnr'])){
	$FNR = $_POST['fnr'];;
	$db = new PDO($dsn, $user, $pwd);
	$st = $db->prepare("SELECT `frage` as 'Frage', `fragetyp` as 'Fragetyp', `aw01` as 'Antwort_1', `aw02` as 'Antwort_2', `aw03` as 'Antwort_3', `aw04` as 'Antwort_4', `aw05` as 'Antwort_5', `aw06` as 'Antwort_6', `hint` as 'Hinweis' FROM `".$pre."quiz_fragen` WHERE `fnr` = '".$FNR."'");
	if ($st->execute()){
		$rows = $st->rowCount();
		$cols = $st->columnCount();
		if ($rows==1){
			echo '<table>'."\n";
			echo '<form action="question_edit.php" method="post">'."\n";
			foreach ($st as $erg){
				for ($i=0;$i<=$cols-1;$i++){
					$meta = $st->getColumnMeta($i);
					echo '<tr><td>'.$meta['name'].'</td>'."\n";
					switch ($i) {
						case 0:
							echo '<td><textarea name="'.$meta['name'].'" cols="30" rows="4">'.($erg[$meta['name']]).'</textarea>'."\n";
							echo '</td></tr>'."\n";
							break;
						case 1:
							echo '<td>'."\n";
							echo '<select name="'.$meta['name'].'">'."\n";
							echo '<option value="0"';	if ($erg[$meta['name']]==0) echo ' selected'; echo '>Freie Frage</option>'."\n";
							echo '<option value="1"';	if ($erg[$meta['name']]==1) echo ' selected'; echo '>MultipleChoice (1)</option>'."\n";
							echo '<option value="2"';	if ($erg[$meta['name']]==2) echo ' selected'; echo '>MultipleChoice (2)</option>'."\n";
							echo '<option value="3"';	if ($erg[$meta['name']]==3) echo ' selected'; echo '>MultipleChoice (3)</option>'."\n";
							echo '<option value="4"';	if ($erg[$meta['name']]==4) echo ' selected'; echo '>MultipleChoice (4)</option>'."\n";
							echo '<option value="5"';	if ($erg[$meta['name']]==5) echo ' selected'; echo '>MultipleChoice (5)</option>'."\n";
							echo '<option value="6"';	if ($erg[$meta['name']]==6) echo ' selected'; echo '>MultipleChoice (6)</option>'."\n";
							echo '</select>'."\n";
							break;
						default:
							echo '<td><input type="Text" name="'.$meta['name'].'" Value="'.($erg[$meta['name']]).'" />'."\n";
							echo '</td></tr>'."\n";
					}
				}
			}
		}
		echo '<tr><td colspan=2><input type="hidden" name="fnr" value='.$FNR.' /><input type="Submit" value="Absenden" name="save" /> </td>'."\n";
		echo '</tr>'."\n";
		echo '</form></table>'."\n";
		}
		else echo '<p>Abfrage liefert keine Datens�tze</p>'."\n";
	}
	else echo '<p>Datenbankaufruf fehlgeschlagen</p>'."\n";
	}
else header('location:index.php');
include ('footer.php');
?>