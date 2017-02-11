<?php
// Bindet den Header der Seite mit der Navigation ein
include('header.php');
if ($_SESSION['Login']==1)
{   if(isset($_POST['page']))$page=$_POST['page'];
    else $page=0;
    echo '<div class="knowledge">'."\n";
    // Lädt die Seite aus der Datenbank
    $st = ("SELECT * FROM `".$pre."knowledge` ORDER BY `id` LIMIT ".$page.",1");
    if ($erg=$db->query($st)){
        $row=$erg->rowCount();
        if ($row==1){
            $knowledge = $erg->fetch();
            echo '<h1>' . $knowledge['title'] . '</h1>'."\n";
            echo $knowledge['content'];
            echo '<div class="sub-nav-container">'."\n";
            if ($page >= 1) echo '<div class="sub-nav-left"><form action="knowledge.php" method="post"><input type="hidden" name="page" value='.($page - 1).' /><input type="submit" value="letzte Seite" /></form></div>'."\n";
            echo '<div class="sub-nav-right"><form action="knowledge.php" method="post"><input type="hidden" name="page" value='.($page+1).' /><input type="submit" value="n&auml;chste Seite" /></form></div></div>'."\n";
        }
        else {
            // Zugang zum Wissenstest
            echo '<h1>Weiter zum Wissenstest</h1>'."\n";
            echo '<p>Sie haben alle Seiten angesehen und k&ouml;nnen nun den Wissenstest starten</p>'."\n";
            echo '<form action="quiz.php" method="post"><input type="hidden" name="knowledge" value="1" /><input type="submit" value="weiter zum Quiz" /></form>'."\n";
        }
    }
    echo '</div>'."\n";
}
// Umleitung auf Loginseite, wenn User nicht eingeloggt
else header('location:login.php');
// Bindet den Footer der Seite ein
include ('footer.php');