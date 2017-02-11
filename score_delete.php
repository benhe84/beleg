<?php
// Bindet den Header der Seite mit der Navigation ein
include('header.php');
if ($_SESSION['Admin']==1){
    if(isset($_POST['SID']))
    {
        $SID=$_POST['SID'];
        // Erzeuge PDO
        $db = new PDO($dsn, $user, $pwd);
        // Bereite PDO Statement vor
        $st = $db->prepare("DELETE FROM ".$pre."quiz_gefragt WHERE `sid`= :sid");
        if ($st->execute(array(':sid'=>$SID))){
        echo '<p>Datens&auml;tze erfolgreich gel&ouml;scht</p>'."\n";
        echo '<p><a href="score_show.php">zur&uuml;ck</a> </p>'."\n";
        }
        else echo '<p>Keine Datens&auml;tze vorhanden</p>'."\n";
    }
    else header('location:score_show.php');
}
// Umleitung auf Loginseite, wenn User nicht eingeloggt
else header('location:login.php');
// Bindet den Footer der Seite ein
include ('footer.php');
