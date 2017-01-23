<?php
include ('header.php');
if ($_SESSION['Admin']==1){
    echo '<h1>Frage anlegen</h1>';
    echo '<div class="page_hint">';
    include ('question_hint.php');
    echo '</div>';
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
        // Create connection
        $db = new PDO($dsn, $user, $pwd);
        //INSERT INTO `bhe_quiz_fragen`(`fnr`, `frage`, `fragetyp`, `aw01`, `aw02`, `aw03`, `aw04`, `aw05`, `aw06`, `hint`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10])
        $st = $db->prepare("INSERT INTO `".$pre."quiz_fragen` SET `frage` = :frage, `fragetyp` = :fragetyp, `aw01` = :aw1, `aw02`  = :aw2 , `aw03` = :aw3, `aw04` = :aw4, `aw05` = :aw5, `aw06`  = :aw6, `hint` = :hint");
        if ($st->execute(array(':frage' => $Frage, ':fragetyp'=> $Fragetyp, ':aw1' => $AW1, ':aw2' => $AW2, ':aw3' => $AW3, ':aw4' => $AW4, ':aw5' => $AW5, ':aw6' => $AW6,':hint'=>$Hinweis))){
            echo '<p>Erfolgreich angelegt</p>';
        } else {
            echo '<p>Eintrag konnte nict gespeichert werden</p>';
        }
    }
    else{
?>
<form action="question_add.php" method="post">
    <table>
        <tr><td><textarea name="Frage" placeholder="Hier die Frage eingeben" cols="35" rows="4"></textarea></td></tr>
        <tr>
            <td>
                <select title="Fragentyp" name="Fragetyp">
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
        <tr><td><input name="Antwort_1" placeholder="Antwort 1"  type="Text"></td></tr>
        <tr><td><input name="Antwort_2" placeholder="Antwort 2" type="Text"></td></tr>
        <tr><td><input name="Antwort_3" placeholder="Antwort 3" type="Text"></td></tr>
        <tr><td><input name="Antwort_4" placeholder="Antwort 3" type="Text"></td></tr>
        <tr><td><input name="Antwort_5" placeholder="Antwort 4" type="Text"></td></tr>
        <tr><td><input name="Antwort_6" placeholder="Antwort 5" type="Text"></td></tr>
        <tr><td><input name="Hinweis" placeholder="Hinweis" type="Text"></td></tr>
        <tr><td><input value="Frage anlegen" name="save" type="Submit"></td></tr>
    </table>
</form>
    <?php
        }
}
else header('location:index.php');
include ('footer.php');
?>