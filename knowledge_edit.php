<?php
include ('header.php');
echo '<div id="content">'."\n";
if ($_SESSION['Admin']==1)
{   if(isset($_POST['page']))$page=$_POST['page'];
else $page=0;
    // Lädt die Seite aus der Datenbank
    $sql = $db->prepare("SELECT * FROM `".$pre."knowledge` ORDER BY `id` WHERE ID = :page");
    if ($result=$sql->execute(array(':page'=>$page))) {
        $knowledge = $result->fetch();
        echo '<h1>' . $knowledge['title'] . '</h1>'."\n";
        echo '<p>' . $knowledge['content'] . '</p>'."\n";
        echo '<table>'."\n";
        echo '<tr><td>'."\n";
        if ($page >= 1) echo '<form action="knowledge.php"><input type="hidden" name="page" value='.($page - 1).' /><input type="submit" value="letzte Seite" /></form>'."\n";
        echo '</td><td><form action="knowledge.php"><input type="hidden" name="page" value='.$page.' /><input type="submit" value="n&auml;chste Seite" /></form></td>'."\n";
    }
    else{
        // Zugang zum Wissenstest
        echo '<h1>Weiter zum Wissenstest</h1>'."\n";
        echo '<p>Sie haben alle Seiten angesehen und k&ouml;nnen nun den Wissenstest starten</p>'."\n";
        echo '<form action="quiz.php"><input type="hidden" name="knowledge" value="1" /><input type="submit" value="weiter zum Quiz" /></form>'."\n";
    }
}
else header('location:index.php');
include ('footer.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>A Simple Page with CKEditor</title>
        <!-- Make sure the path to CKEditor is correct. -->
        <script src="../ckeditor.js"></script>
    </head>
    <body>
        <form>
            <textarea name="editor1" id="editor1" rows="10" cols="80">
    This is my textarea to be replaced with CKEditor.
            </textarea>
            <script>
// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.
CKEDITOR.replace( 'editor1' );
            </script>
        </form>
    </body>
</html>