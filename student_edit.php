<?php
include ('header.php');
if ($_SESSION['Admin']==1){
	if (isset($_POST['save'])){
		$SID = $_POST['SID'];
		$EMail = $_POST['E-Mail'];
		$Name = $_POST['Name'];
		$Vorname = $_POST['Vorname'];
		$Klasse = $_POST['Klasse'];
		$Lehrkraft = $_POST['Lehrkraft'];
		// Create connection
		$db = new PDO($dsn, $user, $pwd);
		$st = $db->prepare("UPDATE `".$pre."user` SET `Vorname`=:vname,`Name`= :name,`e-mail`=:mail,`Klasse`= :klasse,`lehrer`= :lehrer WHERE `sid` = ".$SID);
		if ($st->execute(array(':mail' => $EMail, ':vname'=> $Vorname, ':name' => $Name,':klasse'=>$Klasse,':lehrer'=>$Lehrkraft))){
			echo '<p>Erfolgreich gespeichert</p>';
		} else {
			echo "Error: " . $sql . "<br />" . $conn->error;
		}
	}
	if (isset($_POST['SID'])){
	$ESID = $_POST['SID'];
	$db = new PDO($dsn, $user, $pwd);
	$st = $db->prepare("SELECT `e-mail` as `E-Mail`, `Vorname`, `Name`, `Klasse`, `lehrer` as `Rolle`  FROM `".$pre."user` WHERE `sid` = '".$ESID."'");
	if ($st->execute()){
		$rows = $st->rowCount();
		$cols = $st->columnCount();
		if ($rows==1){
			echo '<table>';
			echo '<form action="student_edit.php" method="post">';
			foreach ($st as $erg){
				for ($i=0;$i<=$cols-1;$i++){
					$meta = $st->getColumnMeta($i);
					echo '<tr><td>'.$meta['name'].'</td>';
					if ($i==4){										//Spinner f�r Rolle
					echo '<td>';
					echo '<select name="'.$meta['name'].'">';
					echo '<option value="0"';	if ($erg[$meta['name']]==0) echo ' selected'; echo '>Sch&uuml;ler</option>';
					echo '<option value="1"';	if ($erg[$meta['name']]==1) echo ' selected'; echo '>Lehrer</option>';
					echo '</select>';
					}
					else echo '<td><input type="Text" name="'.$meta['name'].'" Value='.($erg[$meta['name']]).' />';
					echo '</td></tr>';
			}
			}
		}
		echo '<tr><td colspan=2><input type="hidden" name="SID" value='.$ESID.' /><input type="Submit" value="Absenden" name="save" /> </td>';
		echo '</tr>';
		echo '</form></table>';
		}
		else echo '<p>Abfrage liefert keine Datens�tze</p>';
	}
	else echo '<p>Datenbankaufruf fehlgeschlagen</p>';
	}
else //header('location:index.php');
include ('footer.php');
?>