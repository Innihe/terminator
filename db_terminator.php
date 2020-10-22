<?php
	//Fehlermeldungen behandeln
	error_reporting(E_ALL); //Alle Fehlermeldungen anzeigen, aus Sicherheitsgründen ausschalten wenn im Produktivbetrieb
	/* error_reporting(0);     //Alle Fehlermeldungen ausblenden, aus Sicherheitsgründen anschalten wenn im Produktivbetrieb */


	/// db_connect() baut eine Verbindung zur Datenbank auf und liefert das erstellte Objekt als Rückgabewert
	function db_connect()
	{
		//Datenbank Login Daten
		$servername = "localhost";
		$username = "root";
		$password = "";
		$db       = "terminator";
		
		//Verbindung zur Datenbank aufbauen
		$conn = new mysqli($servername, $username, $password, $db);
		
		//Verbindung überprüfen
		if ($conn->connect_error)
		{														 		//!Ersetzen durch $db->connect_errno und exakte Fehlermeldung nicht ausgeben
			die("Verbindung fehlgeschlagen: ".$conn->connect_error); //Falls es Fehlermeldung gibt abbrechen und Fehlermeldung ausgeben 
		}
		//echo "DEBUG db_access.php: Verbindung läuft<br>";
		
		$conn->set_charset('utf8'); //Umlaute
		return $conn;
	}
	
	function db_PullAll() 
	{
		$conn = db_connect(); //Funktion db_connect() nutzen um Verbindung herzustellen und Rückgabeobjekt in $conn speichern
		//Alle Termine und Informationen aus der DB holen, Einträge absteigend nach Feld "datum sortieren"  und als Objekt übergeben
		//kein prepared statement notwendig weil kein user input //
	
		//Abfrage senden und Ergebnis speichern (liefert ein Objekt)
		$ergebnis = $conn->query("SELECT * FROM TERMINE ORDER BY datum DESC")
					or die($conn->error); //Wenn Abfrage fehlschlägt Abbruch und Fehlermeldung
		return $ergebnis; //Abfrageergebnisobjekt als Rückgabewert
		db_Close($conn); // Verbindung über dbClose() schliessen, $conn Objekt übergeben
	}
	
	function db_Close($conn)
	{
		
		$conn->close();		//Verbindung zur Datenbank schliessen
	}