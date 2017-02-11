<?php
// Bindet den Header der Seite mit der Navigation ein
include('header.php');
if ($_SESSION['Admin']==1){
    echo '<h1>Frage anlegen</h1>'."\n";
    echo '<div class="page_hint">'."\n";
    include ('question_hint.php');
    echo '</div>'."\n";
    if (isset($_POST['save'])){
        $Frage = $_POST['Frage'];
        $Fragetyp = $_POST['Fragetyp'];
        $AW1 = $_POST['Antwort_1'];
        $AW2 = $_POST['Antwort_2'];
        $AW3 = $_POST['Antwort_3'];
        $AW4 = $_POST['Antwort_4'];
        $AW5 = $_POST['Antwort_5'];
        $AW6 = $_POST['Antwort_6'];
        $Hinweis = $_POST['Hinweis'];
        //Erzeuge PDO
        $db = new PDO($dsn, $user, $pwd);
        // Bereite PDO Statement vor
        $st = $db->prepare("INSERT INTO `".$pre."quiz_fragen` SET `frage` = :frage, `fragetyp` = :fragetyp, `aw01` = :aw1, `aw02`  = :aw2 , `aw03` = :aw3, `aw04` = :aw4, `aw05` = :aw5, `aw06`  = :aw6, `hint` = :hint");
        if ($st->execute(array(':frage' => $Frage, ':fragetyp'=> $Fragetyp, ':aw1' => $AW1, ':aw2' => $AW2, ':aw3' => $AW3, ':aw4' => $AW4, ':aw5' => $AW5, ':aw6' => $AW6,':hint'=>$Hinweis))){
            echo '<p>Erfolgreich angelegt</p>'."\n";
        } else {
            echo '<p>Eintrag konnte nict gespeichert werden</p>'."\n";
        }
    }
    else{
?>

    <form action="question_add.php" name="question" method="post">
        <table>
            <tr><td><label for="Frage">Frage</label><textarea name="Frage" id="Frage" placeholder="Hier die Frage eingeben" cols="35" rows="4"></textarea></td></tr>
            <tr>
                <td>
                    <label for="Fragentyp">Fragetyp</label>
                    <select id="Fragetyp" title="Fragentyp" name="Fragetyp">
                        <option value="0">Freie Frage</option>
                        <option value="1">MultipleChoice (1)</option>
                        <option value="2">MultipleChoice (2)</option>
                        <option value="3">MultipleChoice (3)</option>
                        <option value="4">MultipleChoice (4)</option>
                        <option value="5">MultipleChoice (5)</option>
                        <option value="6">MultipleChoice (6)</option>
                    </select>
                </td>
            </tr>
            <tr><td><label for="Antwort_1">Antwort 1</label><input id="Antwort_1" name="Antwort_1" placeholder="Antwort 1"  type="Text"></td></tr>
            <tr><td><label for="Antwort_2">Antwort 2</label><input id="Antwort_2" name="Antwort_2" placeholder="Antwort 2" type="Text"></td></tr>
            <tr><td><label for="Antwort_3">Antwort 3</label><input id="Antwort_3" name="Antwort_3" placeholder="Antwort 3" type="Text"></td></tr>
            <tr><td><label for="Antwort_4">Antwort 4</label><input id="Antwort_4"  name="Antwort_4" placeholder="Antwort 4" type="Text"></td></tr>
            <tr><td><label for="Antwort_5">Antwort 5</label><input id="Antwort_5"  name="Antwort_5" placeholder="Antwort 5" type="Text"></td></tr>
            <tr><td><label for="Antwort_6">Antwort 6</label><input id="Antwort_6" name="Antwort_6" placeholder="Antwort 6" type="Text"></td></tr>
            <tr><td><label for="Hinweis">Hinweis</label><input id="Hinweis" name="Hinweis" placeholder="Hinweis" type="Text"></td></tr>
            <tr><td><input value="Frage anlegen" name="save" type="Submit"></td></tr>
        </table>
    </form>
    <?php
        }
}
// Umleitung auf Loginseite, wenn User nicht eingeloggt
else header('location:login.php');
// Bindet den Footer der Seite ein
include ('footer.php');
?>