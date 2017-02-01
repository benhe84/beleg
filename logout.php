<?php
	include ('header.php');
	session_destroy();
	echo 'Sie wurden erfolgreich ausgeloggt';
	header('location:index.php');

