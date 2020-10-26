<?php					
require "db_terminator.php";
setlocale(LC_TIME, "de_DE.utf8"); //Date Umgebung auf Deutschland eingestellt


//Gibt als return ein numerisch assoziatives Array aller Termine, chronologisch absteigend sortiert
function terminArray()
{					
	$ergebnis = db_PullAll(); //Über dbaccess.php alle PostIt relevanten Einträge als Objekt holen
	$ergebnisArray = $ergebnis->fetch_all(MYSQLI_BOTH); //Ergebnisobjekt in numerisch assoziatives Array umwandeln
	//print_r($ergebnisArray); //DEBUG
	//echo time(); //DEBUG
	
	return $ergebnisArray;
}

//Gibt als return Wert den Index des Array Eintrages für den nächstfolgenden Termin,
//gibt NULL zurück wenn kein Termin in der Zukunft liegt
function naechsterTermin($ergebnisArray)
{
	$naechsterTerminIndex = NULL; 
	$naechsterTerminTimeStamp = NULL;
	$jetzt = time();
	
	
	foreach($ergebnisArray as $key => $value)
	{
		//Aus jedem Array Eintrag Datum und Uhrzeit in einen String joinen und in Unix Timestamp konvertieren
		$datumZeit = "".$value["Datum"]." ".$value["Uhrzeit"]; 
		$unixTimeStamp = strtotime($datumZeit);
		
		//Wenn der Termin in der Zukunft liegt und noch kein anderer Termin als nächster feststeht: Dieser Termin = nächster Termin
		if($unixTimeStamp >= $jetzt && $naechsterTerminTimeStamp == NULL)
		{
			$naechsterTerminTimeStamp = $unixTimeStamp;
			$naechsterTerminIndex = $key;
		}
		//Wenn der Termin in der Zukunft liegt, aber näher an $jetzt ist als der bisherige $naechsterTermin: Dieser Termin = nächster Termin
		elseif ($unixTimeStamp >= $jetzt && $unixTimeStamp < $naechsterTerminTimeStamp)
		{
			$naechsterTerminTimeStamp = $unixTimeStamp;
			$naechsterTerminIndex = $key;
		}
		//Wenn der Termin nicht in der Zukunft liegt
		else
		{
			break;
		}
		//DEBUG
		//echo "<br>".$value["Datum"]."<br>";
		//echo $value["Uhrzeit"]."<br>";
		//echo $unixTimeStamp."<br>";
	}
	return $naechsterTerminIndex;	
}

//$offset als signed integer um gewählten Termin zu ändern (in relation zum zeitlich nächsten Termin) +1, +2, -1, -2 usw
function zeigeTermine($offset = 0)
{
	$terminArray = terminArray();
	$naechsterTermin = naechsterTermin($terminArray) + $offset;
	$anzahlTermine = count($terminArray);
	
	
	echo"<div class='termine'>";
	
	//Vom Index naechsterTermin bis Index 0 Einträge bauen
	for($i = $naechsterTermin; $i >= 0; $i--)
	{
		//CSS Selektor (div class) generieren, p{nummer} // p = positiv -> in der Zukunft vom Startpunkt
		$cssClass = ($naechsterTermin - $i);
		
		//erste Zeile erstellt HTML für Hauptseiten Eintrag
		//zweite Zeile erstellt Popup Button und Popup Inhalt mithilfe von terminMehrInfo()
		//dritte Zeile bindet Edit Button ein
		echo "<div class='pa".$cssClass."'>".strftime("%a", strtotime($terminArray[$i]["Datum"]))."  ".date('d.m.Y', strtotime($terminArray[$i]["Datum"]))."</div><div class='pb".$cssClass."'> ".$terminArray[$i]["Titel"]." ".$terminArray[$i]["Fach"]."</div>";
		echo "<div class='pc".$cssClass."'><div class='popup' onclick='popupUmschalten(".$i.")'><img title='moreInfo' src='burgermenu.png'/>".terminMehrInfo($terminArray, $i)."</div>";
		echo "<a href='../private/edit.php?id=".$terminArray[$i]["ID"]."'><div class='editimg'><img title='edit' src='edit.png'/></div></a></div>";
		//WIP Formular als Popup echo "<div class='pc".$cssClass."'><div class='popup' onclick='popupUmschalten(".$i."edit)'><img title='edit' src='edit.png'/>".editFormular($i)."</div>";
	}
	
	//Von Index (naechsterTermin + 1) bis zum Ende des Arrays Einträge bauen
	for($i = $naechsterTermin + 1; $i < $anzahlTermine; $i++)
	{
		//CSS Selektor (div class) generieren, n{nummer} // n = negativ -> in der Vergangenheit vom Startpunkt
		$cssClass = ($i - $naechsterTermin);
		
		//erste Zeile erstellt HTML für Hauptseiten Eintrag
		//zweite Zeile erstellt Popup für Eintrag mithilfe von terminMehrInfo()
		//dritte Zeile bindet Edit Button ein
		echo "<div class='na".$cssClass."'>".strftime("%a", strtotime($terminArray[$i]["Datum"]))."  ".date('d.m.Y', strtotime($terminArray[$i]["Datum"]))."</div><div class='nb".$cssClass."'>".$terminArray[$i]["Titel"]." ".$terminArray[$i]["Fach"]."</div>";
		echo "<div class='nc".$cssClass."'><div class='popup' onclick='popupUmschalten(".$i.")'><img title='moreInfo' src='burgermenu.png'/>".terminMehrInfo($terminArray, $i)."</div>";
		echo "<a href='../private/edit.php?id=".$terminArray[$i]["ID"]."'><div class='editimg'><img title='edit' src='edit.png'/></div></a></div>";
		
	}
	
	echo"</div>";
}

//Generiert Mehr Info Popup-Inhalt für Termin mit übergebenem Array und Array Index
function terminMehrInfo($terminArray, $arrayIndex)
{
	$infos = "<span class='popuptext' id='myPopup".$arrayIndex."'>Titel: ".$terminArray[$arrayIndex]["Titel"]."<br>"
				."Fach: ".$terminArray[$arrayIndex]["Fach"]."<br>"
				."Art: ".$terminArray[$arrayIndex]["Art"]."<br>"
				."Datum: ".$terminArray[$arrayIndex]["Datum"]."<br>"
				."Uhrzeit: ".$terminArray[$arrayIndex]["Uhrzeit"]."<br>"
				."Notizen: ".$terminArray[$arrayIndex]["Notizen"]."<br>"
				."VerfasserIn: ".$terminArray[$arrayIndex]["Ersteller"]."<br></span>";
				
	return $infos;
}
	
	
	//WIP Edit als Popup
/* function editFormular($arrayIndex)
{
	$formular = "<span class='popuptext' id='myPopup".$arrayIndex."edit'>" .
				"<form action='' method='post'>" .
				"<input type='text' name='title' placeholder='Titel'>" .
				"<br>" .
				"<input type='date' name='date' placeholder='Datum'>" .
				"<br>" .
				"<input type='time' name='time' placeholder='Zeit'>" .
				"<br>" .
				"<input type='text' name='note' placeholder='Notizen'>" .
				"<br>" .
				"<input type='text' name='creator' value='Ersteller'>" .
				"<br>" .
				"<input type='text' name='subject' value='Fach'>" .
				"<br>" .
				"<input type='text' name='type' value='Art'>" .
				"<br>" .
				"<button type='submit' name='update'>Update</button> HELLO WORLD</span>";
	return $formular;
}
	 */

