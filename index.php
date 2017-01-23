<?php
include ('header.php');
if ($_SESSION['Login']){
	echo '<h1>Willkommen bei Quizcard</h1>';
	echo '<p>Quizcard ist das Ultimative Sch&uuml;lerquiz und bietet Informationen rund um das Thema PHP Programmierung</p>';
	echo '<p>Bitte lies dir zun&auml;chst die Seiten mit dem Wissensinhalt durch!</p>';
	}
    else header('location:login.php');
include ('footer.php');
?>