<?php
include ('header.php');
echo '<div id="content">';
if ($_SESSION['Login']==1)
{   if(isset($_POST['page']))$page=$_POST['page'];
    else $page=0;
    // Lädt die Seite aus der Datenbank
    $sql = $db->prepare("SELECT * FROM `".$pre."knowledge` ORDER BY `id` LIMIT :page,1");
    if ($result=$sql->execute(array(':page'=>$page))) {
        $knowledge = $result->fetch();
        echo '<h1>' . $knowledge['title'] . '</h1>';
        echo '<p>' . $knowledge['content'] . '</p>';
        echo '<table>';
        echo '<tr><td>';
        if ($page >= 1) echo '<form action="knowledge.php"><input type="hidden" name="page" value='.($page - 1).' /><input type="submit" value="letzte Seite" /></form>';
        echo '</td><td><form action="knowledge.php"><input type="hidden" name="page" value='.$page.' /><input type="submit" value="n&auml;chste Seite" /></form></td>';
    }
    else{
        // Zugang zum Wissenstest
        echo '<h1>Weiter zum Wissenstest</h1>';
        echo '<p>Sie haben alle Seiten angesehen und k&ouml;nnen nun den Wissenstest starten</p>';
        echo '<form action="quiz.php"><input type="hidden" name="knowledge" value="1" /><input type="submit" value="weiter zum Quiz" /></form>';
    }
}
else header('location:index.php');
include ('footer.php');
?>