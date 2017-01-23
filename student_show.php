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
	echo '<div class="page_hint">';
	echo '<h2>Sch&uuml;lersuche</h2>';
	echo '<Form action="student_show.php" method="post">';
	echo '<input type="Text" placeholder="Name" name="FName"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['FName']);
	echo ' />';
	echo '<input type="Text" placeholder="Vorname" name="VName"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['VName']);
	echo ' />';
	echo '<input type="Text" placeholder="Klasse" name="Klasse"';
	if (isset($_POST["senden"])) echo ' Value='.($_POST['Klasse']);
	echo ' />';
	echo '<input type="Submit" value="Suchen" name="senden" />';
	echo '</form>';
	echo '</div>';
	$db = new PDO($dsn, $user, $pwd);
	$st = $db->prepare("SELECT `sid`, `e-mail` as `E-Mail`, `Vorname`, `Name`, `Klasse`, `lehrer` as `Rolle`  FROM `".$pre."user` WHERE `Name` LIKE :fname && `Vorname` LIKE :vname && `Klasse` LIKE :klasse");
	if ($st->execute(array(':fname' => $fname, ':vname'=> $vname, ':klasse'=>$klasse))){
		$rows = $st->rowCount();
		$cols = $st->columnCount();
		if ($rows>0){
			echo '<table>';
			for ($i=1;$i<=$cols-1;$i++){
				$meta = $st->getColumnMeta($i);
				echo '<th>'.$meta['name'].'</th>';
			}
			echo '<th>Bearbeiten</th>';
			foreach ($st as $erg){
				echo '<tr>';
				for ($i=1;$i<=$cols-1;$i++){
					if ($i==5){										//Rolle
						if ($erg[$i]==0) echo '<td>Sch&uuml;ler</td>';
						if ($erg[$i]==1) echo '<td>Lehrer</td>';
					}
					else echo '<td>'.$erg[$i].'</td>';
				}
				echo '<td><Form action="student_edit.php" method="post"><input type="hidden" name="SID" value='.$erg[0].' /><input type="Submit" value="Bearbeiten" name="edit"></form></td></tr>';
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