<?php
include ('header.php');
if ($_SESSION['Admin']==1){
    echo '<h1>Frage &auml;ndern</h1>';
	echo '<div class="page_hint">';
	include ('question_hint.php');
	echo '</div>';
	if (isset($_POST['save'])){
		$FNR = $_POST['fnr'];
		$Frage = $_POST['Frage'];
		$Fragetyp = $_POST['Fragetyp'];
		$AW1 = $_POST['Antwort_1'];
		$AW2 = $_POST['Antwort_2'];
		$AW3 = $_POST['Antwort_3'];
		$AW4 = $_POST['Antwort_4'];
		$AW5 = $_POST['Antwort_5'];
		$AW6 = $_POST['Antwort_6'];
		$Hinweis = $_POST['Hinweis'];
		// Create connection
		$db = new PDO($dsn, $user, $pwd);
		$st = $db->prepare("UPDATE `".$pre."quiz_fragen` SET `frage` = :frage, `fragetyp` = :fragetyp, `aw01` = :aw1, `aw02`  = :aw2 , `aw03` = :aw3, `aw04` = :aw4, `aw05` = :aw5, `aw06`  = :aw6, `hint` = :hint  WHERE `fnr` = '".$FNR."'");
		if ($st->execute(array(':frage' => $Frage, ':fragetyp'=> $Fragetyp, ':aw1' => $AW1, ':aw2' => $AW2, ':aw3' => $AW3, ':aw4' => $AW4, ':aw5' => $AW5, ':aw6' => $AW6,':hint'=>$Hinweis))){
			echo '<p>Erfolgreich gespeichert</p>';
		} else {
			echo '<p>Eintrag konnte nict gespeichert werden</p>';
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
			echo '<table>';
			echo '<form action="question_edit.php" method="post">';
			foreach ($st as $erg){
				for ($i=0;$i<=$cols-1;$i++){
					$meta = $st->getColumnMeta($i);
					echo '<tr><td>'.$meta['name'].'</td>';
					switch ($i) {
						case 0:
							echo '<td><textarea name="'.$meta['name'].'" cols="35" rows="4">'.($erg[$meta['name']]).'</textarea>';
							echo '</td></tr>';
							break;
						case 1:
							echo '<td>';
							echo '<select name="'.$meta['name'].'">';
							echo '<option value="0"';	if ($erg[$meta['name']]==0) echo ' selected'; echo '>Freie Frage</option>';
							echo '<option value="1"';	if ($erg[$meta['name']]==1) echo ' selected'; echo '>MultipleChoice (1)</option>';
							echo '<option value="2"';	if ($erg[$meta['name']]==2) echo ' selected'; echo '>MultipleChoice (2)</option>';
							echo '<option value="3"';	if ($erg[$meta['name']]==3) echo ' selected'; echo '>MultipleChoice (3)</option>';
							echo '<option value="4"';	if ($erg[$meta['name']]==4) echo ' selected'; echo '>MultipleChoice (4)</option>';
							echo '<option value="5"';	if ($erg[$meta['name']]==5) echo ' selected'; echo '>MultipleChoice (5)</option>';
							echo '<option value="6"';	if ($erg[$meta['name']]==6) echo ' selected'; echo '>MultipleChoice (6)</option>';
							echo '</select>';       
							break;
						default:
							echo '<td><input type="Text" name="'.$meta['name'].'" Value="'.($erg[$meta['name']]).'" />';
							echo '</td></tr>';
					}
				}
			}
		}
		echo '<tr><td colspan=2><input type="hidden" name="fnr" value='.$FNR.' /><input type="Submit" value="Absenden" name="save" /> </td>';
		echo '</tr>';
		echo '</form></table>';
		}
		else echo '<p>Abfrage liefert keine Datens�tze</p>';
	}
	else echo '<p>Datenbankaufruf fehlgeschlagen</p>';
	}
else header('location:index.php');
include ('footer.php');
?>