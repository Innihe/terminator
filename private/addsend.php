<?php
	require 'db_terminator.php'; //DB Funktionalität einbinden
	if(isset($_REQUEST['date']) && isset($_REQUEST['creator']) && isset($_REQUEST['subject']) && isset($_REQUEST['note']) && isset($_REQUEST['title']) && isset($_REQUEST['time']) && isset($_REQUEST['type']))
	{
		//Variablen holen
		$datum = $_REQUEST['date'];
		$ersteller = $_REQUEST['creator'];
		$fach = $_REQUEST['subject'];
		$notizen = $_REQUEST['note'];
		$titel = $_REQUEST['title'];
		$uhrzeit = $_REQUEST['time'];
		$art = $_REQUEST['type'];
		
		//Termin hinzufügen über db_terminator.php -> db_AddTermin()
		db_AddTermin($datum, $ersteller, $fach, $notizen, $titel, $uhrzeit, $art);

		//Zurück
		header("Location: ../public/index.php");
		die();
	}
?>