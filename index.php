<?php
include ('header.php');
if ($_SESSION['Login']){
	echo '<h1>Willkommen bei Quizcard</h1>'."\n";
	echo '<p>Quizcard ist das Ultimative Sch&uuml;lerquiz und bietet Informationen rund um das Thema PHP Programmierung</p>'."\n";
	echo '<p>Bitte lies dir zun&auml;chst die Seiten mit dem Wissensinhalt durch!</p>'."\n";
	}
    else header('location:login.php');
include ('footer.php');
