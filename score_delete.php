<?php
include ('header.php');
if ($_SESSION['Admin']==1){
    if(isset($_POST['SID']))
    {
        $SID=$_POST['SID'];
        $db = new PDO($dsn, $user, $pwd);
        $st = $db->prepare("DELETE FROM ".$pre."quiz_gefragt WHERE `sid`= :sid");
        if ($st->execute(array(':sid'=>$SID))){
        echo '<p>Datens&auml;tze erfolgreich gel&ouml;scht</p>';
        echo '<p><a href="score_show.php">zur&uuml;ck</a> </p>';
        }
        else echo '<p>Keine Datens&auml;tze vorhanden</p>';
    }
    else header('location:score_show.php');
}
// else header('location:index.php');
include ('footer.php');
?>