<!DOCTYPE html>
<html lang="de">
<head>

	<link href='http://fonts.googleapis.com/css?family=Philosopher' rel='stylesheet' type='text/css'>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="index, follow" />
	<title>PHPquiz</title>
	<link type="text/css" href="style.css" rel="stylesheet" media="screen" /> 
</head>
<body>
<div class="wrap">
<a href="index.php" id="logo">PHPquiz</a>
    <div class="nav">
<?php
session_start();
include ("config.php");
if (isset($_SESSION['Login'])){
	$admin =($_SESSION['Admin']);
	$login =($_SESSION['Login']);
	$email =($_SESSION['E-Mail']);
	}
else {
	$admin ="0";
	$login ="0";
}
    // Erzeuge PDO
	$db = new PDO($dsn, $user, $pwd);
    // Generiert SQL String für Hauptmenü
	if ($admin == 1){
        // Erzeuge SQL-ANWEISUNG für Hauptmenü wenn Lehrer angemeldet
        $sql = "SELECT `Kategorie`, `link` FROM `bhe_navi_categories` WHERE `logout`=0";
	}
	else{
		if ($login == 1){
            // Erzeuge SQL-ANWEISUNG für Hauptmenü wenn Schüler angemeldet
            $sql = "SELECT `Kategorie`, `link` FROM `bhe_navi_categories` WHERE `admin` = 0 && `logout`=0";
		}
		else{
            // Erzeuge SQL-ANWEISUNG für Hauptmenü wenn niemand angemeldet
            $sql = "SELECT `Kategorie`, `link` FROM `bhe_navi_categories` WHERE `login`= 0 && `admin` = 0";
		}
	}
	if ($result=$db->query($sql)){
		$cols = $result->rowCount();
		if ($cols>0){
			echo '<ul>'."\n";
			foreach ($result as $main){
			    // Erzeugt Hauptmnüeinträge
				echo '<li class="'.$main[0].'"><a href="'.$main[1].'">'.$main[0].'</a>'."\n";
				// Generiert SQL String für Untermenüs
				if ($admin==1){
                    // Erzeuge SQL-ANWEISUNG für Untermenü wenn Lehrer angemeldet
                    $sql1 ="SELECT `Eintrag`, `Adresse` FROM `bhe_navi_entries` INNER JOIN `bhe_navi_categories` ON `KATID` = `ID` WHERE `Kategorie` LIKE '".$main[0]."' && `bhe_navi_entries`.`login`= 1";
				}
				else{
					if ($login == 1){
                        // Erzeuge SQL-ANWEISUNG für Untermenü wenn Schüler angemeldet
                        $sql1 ="SELECT `Eintrag`, `Adresse` FROM `bhe_navi_entries` INNER JOIN `bhe_navi_categories` ON `KATID` = `ID` WHERE `Kategorie` LIKE '".$main[0]."' && `bhe_navi_entries`.`login`= 1 && `bhe_navi_entries`.`admin` = 0";
					}
					else{
                        // Erzeuge SQL-ANWEISUNG für Untermenü wenn niemand angemeldet
                        $sql1 ="SELECT `Eintrag`, `Adresse` FROM `bhe_navi_entries` INNER JOIN `bhe_navi_categories` ON `KATID` = `ID` WHERE `Kategorie` LIKE '".$main[0]."' && `bhe_navi_entries`.`login`= 0 && `bhe_navi_entries`.`admin` = 0";
					}
				}
                if ($result1=$db->query($sql1)){
                    echo '<ul>'."\n";
                    foreach ($result1 as $entry){
                        // Erzeugt Untermenüeinträge
                        echo '<li><a href="'.$entry[1].'">'.$entry[0].'</a></li>'."\n";
                    }
                    echo '</ul></li>'."\n";
                }
			}
			echo '</ul>'."\n";
		}
	} 
?>
    </div>
    </div>
<div class="content">