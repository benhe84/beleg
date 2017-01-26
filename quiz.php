<?php
// Sorgt dafür das beim neuladen die nächste Frage gezeigt wird
/**
 *
 */
function next_question(){
	global $solved,$db,$qnr,$awresult,$points;
	// Speichert Ergebnis in Datenbankaufruf
	if (!$solved) {
        $sql = ("INSERT INTO `bhe_quiz_gefragt`(`sid`, `fnr`, `try`, `solved`,`points`) VALUES (".$_SESSION['SID'].",".$qnr.",".$_SESSION['Versuch'].",".(int) $awresult.",".$points.")");
		$db->query($sql);}
	// Nächste Frage
	$_SESSION['quest']++;
	$_SESSION['Versuch']=0;
}
// Zufällige Anordnung der Antworten
function choice_shuffle(){
	$i=1;
	$option = range(1, 6);
	shuffle($option);
	foreach ($option as $no) {
		$_SESSION['fragen'][$i]='aw0'.$no;
		$i++;
	}	
}
// Wertet die Gesamtpunkzahl aus
function auswertung(){
    global $db, $pre;
    $st = $db->prepare("SELECT SUM(`points`) as 'Punkte' FROM ".$pre."quiz_gefragt WHERE `sid`=".$_SESSION['SID']);
    $st->execute();
    $erg = $st->fetch();
    $points = $erg[0];                                                                                                  // Erreichte Punkte
    $st = ("SELECT * FROM ".$pre."quiz_gefragt WHERE `sid`=".$_SESSION['SID']);
    $erg=$db->query($st);
    $reachable = (($erg->rowCount())*5);
    echo '<h2>Du hast '.$points.' von '.$reachable.' Punkten erreicht!</h2>'."\n";
}

include('header.php');
if ((($_SESSION['Login']==1)&&((isset($_POST['knowledge'])==1)))||($_SESSION['Admin']==1)){
    if(isset($_POST['menu'])){$_SESSION['quest']=1;$_SESSION['Versuch']=0;}
    // Einlesen der Frage
	if(isset($_SESSION['quest'])){$quest=$_SESSION['quest'];}
	else $_SESSION['quest']=1;
	// Initialisierung der Versuche
	if(!isset($_SESSION['Versuch'])){$_SESSION['Versuch']=0;}
	// Antwort auf Falsch setzen
	$awresult=false;
	// Zählt auf Versuche
	if ((($_SESSION['Versuch'])==0)&&(isset($_POST['answer0']))) $_SESSION['Versuch']++;
	if ((($_SESSION['Versuch'])==1)&&(isset($_POST['answer1']))) $_SESSION['Versuch']++;
	// Variablen belegen
	$points=0;
	$try=$_SESSION['Versuch'];
	$quest=$_SESSION['quest'];
	$db = new PDO($dsn, $user, $pwd);
	$sqlq = ("SELECT * FROM `".$pre."quiz_fragen` ORDER BY `fnr` LIMIT ".($quest-1).",1");
	if ($question=$db->query($sqlq)){
		$erg = $question->fetch();
		$qnr = $erg['fnr'];
		// Prüft ob eine Frage vorhanden ist
        if (($question->rowCount())==1){
            // Prüft ob Frage bereits gelöst wurde.
            $sqlaw = ("SELECT * FROM `".$pre."quiz_gefragt` WHERE `sid` = ".$_SESSION['SID']." && `fnr` = ".$qnr);
            if ($solve=$db->query($sqlaw)){
                if (($solve->rowCount())==1){$solved=true;}
                else {$solved=false;}
            }
            // Frage wird ausgegeben
            echo '<h1>'.$erg['frage'].'</h1>'."\n";
			echo '<form action="quiz.php" method="post">'."\n";
			// Prüft auf Freitexteingabefragen
			if ($erg['fragetyp']==0){
				//Auswertung
				if ($try>=1 ){
				    //Prüft ob Eingegebene Daten mit dem gespeicherten Regulären Ausdruck übereinstimmen
					if(preg_match($erg['aw01'],htmlentities(($_POST['frantwort']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1'))){
					    $awresult=true;
                        $points=floor(5/$_SESSION['Versuch']);
                    }
				}
				if ($try<= 1){
					if (!$awresult) {
						echo '<h2>Dies ist Ihr '.($_SESSION['Versuch']+1).'.Versuch</h2>'."\n";
						if ($try==1){echo '<div class="hint">'.$erg['hint'].'</div>'."\n";}
						echo '<p>Bitte geben Sie die Antwort ein:</p>'."\n";
					}
				}
				echo '<p><input type="text" name="frantwort"';
				if (isset($_POST['frantwort'])) echo 'value="'.$_POST['frantwort'].'"';
				if (($awresult)||($try== 2)) {echo ' readonly="true"';} else {echo ' required';}
				echo ' /></p>'."\n";
				if ((!$awresult)&&($try== 2)) echo '<h2>Die Antwort war falsch.</h2>'."\n";
			}
			
			// Prüft auf Multiple-Choice-Einfach-Wahl
			if ($erg['fragetyp']==1){
				//Auswertung
				if ($try>=1){
				    //Prüft ob gewählte Antwort richtig
					if(htmlentities(($_POST['dropdown']), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1')==$erg['aw01']){
                        $awresult=true;
                        //Berechnet die Punkte
                        $points=floor(5/$_SESSION['Versuch']);
					}
				}
				//Zufällige Anordnung der Antworten im 1. Versuch
				if ($try==0){choice_shuffle();}
				//Fragestellen
				if (($try<= 1)){
					if (!$awresult) {
						echo '<h2>Dies ist Ihr '.($_SESSION['Versuch']+1).'.Versuch</h2>'."\n";
						if ($try==1){echo '<div class="hint">'.$erg['hint'].'</div>'."\n";}
						echo '<p>Bitte w&auml;hle eine Antwort aus:</p>'."\n";
					}
					//Erzeuge Spinner mit Antworten
					echo '<select name="dropdown"';
					if (($awresult)||($try==2)) {echo ' disabled';};
					echo '>'."\n";
					for ($i=1;$i<=6;$i++){
						$j=$_SESSION['fragen'][$i];
						echo '<option value="'.$erg[$j].'"';
						if (isset($_POST['answer'.($try-1)])) if ($_POST['dropdown']==$erg[$j]) echo ' selected';
						echo '>'.$erg[$j].'</option>'."\n";
					}
					echo '</select>'."\n";
				}
				
			}
			// Prüft auf Multiple-Choice-Mehrfach-Wahl
			if ($erg['fragetyp']>=2){
				//Auswertung
				if ($try>=1){
					$fixed=0;					//Anzahl der gewählten Boxen
					$correct=0;					//Anzahl der richtig gewählten Boxen
					$opted=$erg['fragetyp'];	//Anzahl der richtigen Boxen
					// Prüft die Richtig gewählten Boxen
                    for ($i=1;$i<=$opted;$i++){
						for($j=1;$j<=6;$j++){
							if(isset($_POST[$j])){if(htmlentities(($_POST[$j]), ENT_QUOTES| ENT_SUBSTITUTE, 'ISO8859-1')==$erg['aw0'.$i]){$correct++;}}
						}
					}
                    // Zählt alle gewählten Boxen
					for($j=1;$j<=6;$j++){if(isset($_POST[$j])){$fixed++;}}
                    // Prüft ob alle und nur die richtigen Antworten gewählt wurden
					if(($fixed==$correct)&&($fixed==$opted)){
						$awresult=true;
					}
					//Berechnet die Punkte
					$points=floor((5/$opted*$correct)/$_SESSION['Versuch']);
				}
				//Zufällige Anordnung der Antworten im 1. Versuch
				if ($try==0){choice_shuffle();}
				//Fragestellen
				if (!$awresult) {
					if ($try>=1){echo '<div class="hint">'.$erg['hint'].'</div>'."\n";}
					if (($try<=1)){echo '<h2>Dies ist Ihr '.($_SESSION['Versuch']+1).'.Versuch</h2>'."\n";}
					if (($try<=1)){echo '<p>Bitte w&auml;hle alle richtigen Antworten aus:</p>'."\n";}
				}
				for ($i=1;$i<=6;$i++){
					$j=$_SESSION['fragen'][$i];
					echo '<p><input type="checkbox"  value="'.$erg[$j].'" name="'.$i.'"';
					if (isset($_POST[$i])) if ($_POST[$i]==$erg[$j]) echo ' checked="checked"';
					if (($awresult)||($try==2)) {echo ' disabled';};
					echo '/> '.$erg[$j].'</p>'."\n";
				}
			}
			if ((!$awresult)&&(!($try==2))) echo '<br /><p><input type="submit" value="Pr&uuml;fe die Antwort" name="answer'.$try.'" /></p>'."\n";
			echo '</form>'."\n";
            if ($solved) echo '<h2>Die Frage wurde bereits beantwortet. Dieser Versuch wird nicht gewertet!</h2>'."\n";
			if (($awresult)||($try==2)) {
				next_question();
				if ($awresult) echo '<h3>Die Antwort war Richtig</h3>'."\n";
				echo '<h2>Du hast '.$points.' von 5 Punkten erreicht</h2>'."\n";
				echo '<br /><br /><p><a href="quiz.php">N&auml;chste Frage</a>'."\n";
			}
		}
		else{
            // Startet die Auswertung des Tests
            auswertung();
            // Setzt die Fragen zurück
		    $_SESSION['quest']=1;
		    $_SESSION['Versuch']=0;
		}
	}
	else echo 'Datenbankaufruf fehlgeschlagen';
}
else header('location:index.php');
include ('footer.php');
?>