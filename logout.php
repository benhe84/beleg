<?php
    // Bindet den Header der Seite mit der Navigation ein
    include('header.php');
	session_destroy();
	echo 'Sie wurden erfolgreich ausgeloggt';
	header('location:login.php');

