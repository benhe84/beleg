<?php
// Bindet den Header der Seite mit der Navigation ein
include('header.php');
if ($_SESSION['Admin'] == 1) {
    if (isset($_POST['save'])) {
        $SID = $_POST['SID'];
        $EMail = $_POST['E-Mail'];
        $Name = $_POST['Name'];
        $Vorname = $_POST['Vorname'];
        $Klasse = $_POST['Klasse'];
        $Lehrkraft = $_POST['Lehrkraft'];
        // Erzeuge PDO
        $db = new PDO($dsn, $user, $pwd);
        // Bereite PDO Statement vor
        $st = $db->prepare("UPDATE `" . $pre . "user` SET `Vorname`=:vname,`Name`= :name,`e-mail`=:mail,`Klasse`= :klasse,`lehrer`= :lehrer WHERE `sid` = " . $SID);
        if ($st->execute(array(':mail' => $EMail, ':vname' => $Vorname, ':name' => $Name, ':klasse' => $Klasse, ':lehrer' => $Lehrkraft))) {
            echo '<p>Erfolgreich gespeichert</p>' . "\n";
        } else {
            echo "Nutzer konnte nicht angelegt werden";
        }
    }
    if (isset($_POST['SID'])) {
        $ESID = $_POST['SID'];
        // Erzeuge PDO
        $db = new PDO($dsn, $user, $pwd);
        // Bereite PDO Statement vor
        $st = $db->prepare("SELECT `e-mail` as `E-Mail`, `Vorname`, `Name`, `Klasse`, `lehrer` as `Rolle`  FROM `" . $pre . "user` WHERE `sid` = '" . $ESID . "'");
        if ($st->execute()) {
            $rows = $st->rowCount();
            $cols = $st->columnCount();
            if ($rows == 1) {
                echo '<table>' . "\n";
                echo '<form action="student_edit.php" method="post">' . "\n";
                foreach ($st as $erg) {
                    for ($i = 0; $i <= $cols - 1; $i++) {
                        $meta = $st->getColumnMeta($i);
                        echo '<tr><td>' . $meta['name'] . '</td>' . "\n";
                        if ($i == 4) {                                        //Spinner für Rolle
                            echo '<td>' . "\n";
                            echo '<select name="' . $meta['name'] . '">' . "\n";
                            echo '<option value="0"';
                            if ($erg[$meta['name']] == 0) echo ' selected';
                            echo '>Sch&uuml;ler</option>' . "\n";
                            echo '<option value="1"';
                            if ($erg[$meta['name']] == 1) echo ' selected';
                            echo '>Lehrer</option>' . "\n";
                            echo '</select>' . "\n";
                        } else echo '<td><input type="Text" name="' . $meta['name'] . '" Value=' . ($erg[$meta['name']]) . ' />' . "\n";
                        echo '</td></tr>' . "\n";
                    }
                }
            }
            echo '<tr><td colspan=2><input type="hidden" name="SID" value=' . $ESID . ' /><input type="Submit" value="Absenden" name="save" /> </td>' . "\n";
            echo '</tr>' . "\n";
            echo '</form></table>' . "\n";
        } else echo '<p>Abfrage liefert keine Datens&auml;tze</p>' . "\n";
    } else echo '<p>Datenbankaufruf fehlgeschlagen</p>' . "\n";
}
// Umleitung auf Loginseite, wenn User nicht eingeloggt
else header('location:login.php');
// Bindet den Footer der Seite ein
include ('footer.php');