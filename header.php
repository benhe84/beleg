<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link href='http://fonts.googleapis.com/css?family=Philosopher' rel='stylesheet' type='text/css'>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="index, follow" />
	<title>Quizcards</title>
	<link type="text/css" href="style.css" rel="stylesheet" media="screen" /> 
</head>
<body>
<div class="wrap">
<a href="index.php" id="logo">Quizcard</a>
<div class="topnav">
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


	// Create PDO
	$db = new PDO($dsn, $user, $pwd);
	if ($admin == 1){
		$sql = "SELECT `Kategorie`, `link` FROM `bhe_navi_categories` WHERE `logout`=0";
	}
	else{
		if ($login == 1){
			$sql = "SELECT `Kategorie`, `link` FROM `bhe_navi_categories` WHERE `admin` = 0 && `logout`=0";
		}
		else{
			$sql = "SELECT `Kategorie`, `link` FROM `bhe_navi_categories` WHERE `login`= 0 && `admin` = 0";
		}
	}
	if ($result=$db->query($sql)){
		$cols = $result->rowCount();
		if ($cols>0){
			echo '<ul>';
			foreach ($result as $main){
				echo '<li class="'.$main[0].'"><a href="'.$main[1].'">'.$main[0].'</a>';
				if ($admin==1){
					$sql1 ="SELECT `Eintrag`, `Adresse` FROM `bhe_navi_entries` INNER JOIN `bhe_navi_categories` ON `KATID` = `ID` WHERE `Kategorie` LIKE '".$main[0]."' && `bhe_navi_entries`.`login`= 1";			
				}
				else{
					if ($login == 1){
						$sql1 ="SELECT `Eintrag`, `Adresse` FROM `bhe_navi_entries` INNER JOIN `bhe_navi_categories` ON `KATID` = `ID` WHERE `Kategorie` LIKE '".$main[0]."' && `bhe_navi_entries`.`login`= 1 && `bhe_navi_entries`.`admin` = 0";
					}
					else{
						$sql1 ="SELECT `Eintrag`, `Adresse` FROM `bhe_navi_entries` INNER JOIN `bhe_navi_categories` ON `KATID` = `ID` WHERE `Kategorie` LIKE '".$main[0]."' && `bhe_navi_entries`.`login`= 0 && `bhe_navi_entries`.`admin` = 0";
					}
				}
				if ($result1=$db->query($sql1)){
					echo '<ul>';
					foreach ($result1 as $entry){
						echo '<li><a href="'.$entry[1].'">'.$entry[0].'</a></li>';
					}
					echo '</ul></li>';
				}
			}
			echo '</ul>';
		}
	} 
?>
</div>
<div class="content">