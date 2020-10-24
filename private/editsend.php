<?php
	require 'db_terminator.php'; //DB Funktionalität einbinden

	
	// Variablen prüfen
	if(isset($_REQUEST['id']) && isset($_REQUEST['datum']) && isset($_REQUEST['ersteller']) && isset($_REQUEST['fach']) && isset($_REQUEST['notizen']) && isset($_REQUEST['titel']) && isset($_REQUEST['uhrzeit']) && isset($_REQUEST['art']))
	{
		//Variablen holen
		$id = $_REQUEST['id'];
		$datum = $_REQUEST['datum'];
		$ersteller = $_REQUEST['ersteller'];
		$fach = $_REQUEST['fach'];
		$notizen = $_REQUEST['notizen'];
		$titel = $_REQUEST['titel'];
		$uhrzeit = $_REQUEST['uhrzeit'];
		$art = $_REQUEST['art'];
		
		//Termin updaten über db_terminator.php -> db_UpDateTermin()
		db_UpdateTermin($id, $datum, $ersteller, $fach, $notizen, $titel, $uhrzeit, $art);
		

	}
		
