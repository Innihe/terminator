<?php
	//Fehlermeldungen behandeln
	error_reporting(E_ALL); //Alle Fehlermeldungen anzeigen, aus Sicherheitsgründen ausschalten wenn im Produktivbetrieb
	/* error_reporting(0);     //Alle Fehlermeldungen ausblenden, aus Sicherheitsgründen anschalten wenn im Produktivbetrieb */


	/// db_connect() baut eine Verbindung zur Datenbank auf und liefert das erstellte Objekt als Rückgabewert
	function db_Connect()
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
		$conn = db_Connect(); //Funktion db_Connect() nutzen um Verbindung herzustellen und Rückgabeobjekt in $conn speichern
		//Alle Termine und Informationen aus der DB holen, Einträge absteigend nach Feld "datum sortieren"  und als Objekt übergeben
		//kein prepared statement notwendig weil kein user input //
	
		//Abfrage senden und Ergebnis speichern (liefert ein Objekt)
		$ergebnis = $conn->query("SELECT * FROM TERMINE ORDER BY datum DESC")
					or die($conn->error); //Wenn Abfrage fehlschlägt Abbruch und Fehlermeldung
		return $ergebnis; //Abfrageergebnisobjekt als Rückgabewert
		db_Close($conn); // Verbindung über dbClose() schliessen, $conn Objekt übergeben
	}
	
	
	function db_PullOne($terminID)
	{
		$conn = db_Connect();  //Funktion db_Connect() nutzen um Verbindung herzustellen und Rückgabeobjekt in $conn speichern
		//Abfrage mit Prepared Statement falls $terminID manipuliert wurde
		$queryStatement = $conn->prepare("SELECT * FROM termine WHERE termine.ID = ?")
							or die($conn->error);
		$queryStatement->bind_param("i", $terminID);
		$queryStatement->execute();
		$ergebnis = $queryStatement->get_result();
		$ergebnis = $ergebnis->fetch_object();
		return $ergebnis;
		db_Close($conn);
	}
	
	function db_UpdateTermin($id, $datum, $ersteller, $fach, $notizen, $titel, $uhrzeit, $art)
	{
		$conn = db_Connect(); //Funktion db_Connect() nutzen um Verbindung herzustellen und Rückgabeobjekt in $conn speichern
		
			//Update mit Prepared Statement
			$updateStatement = $conn->prepare("UPDATE termine 
											SET termine.Art = ?, termine.Datum = ?, termine.Ersteller = ?, termine.Fach = ?, termine.Notizen = ?, termine.Titel = ?, termine.Uhrzeit = ?
											WHERE termine.ID = ?")
							or die($conn->error);
			$updateStatement->bind_param("sssssssi", $art, $datum, $ersteller, $fach, $notizen, $titel, $uhrzeit, $id);
			$updateStatement->execute();

		db_Close($conn); // Verbindung über db_Close() schliessen, $conn Objekt übergeben
	}
	
	function db_AddTermin($datum, $ersteller, $fach, $notizen, $titel, $uhrzeit, $art)
	{
		$conn = db_Connect(); //Funktion db_Connect() nutzen um Verbindung herzustellen und Rückgabeobjekt in $conn speichern
		
			//Insert mit Prepared Statement
			$insertStatement = $conn->prepare("INSERT INTO termine (Datum, Ersteller, Fach, Notizen, Titel, Uhrzeit, Art)
												VALUES (?,?,?,?,?,?,?)")
							or die($conn->error);
			$insertStatement->bind_param("sssssss", $datum, $ersteller, $fach, $notizen, $titel, $uhrzeit, $art);
			$insertStatement->execute();

		db_Close($conn); // Verbindung über db_Close() schliessen, $conn Objekt übergeben
	}
	
	function db_Close($conn)
	{
		
		$conn->close();		//Verbindung zur Datenbank schliessen
	}