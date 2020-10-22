<!-- Plan: Termine pullen und chronologisch sortiert in ein array
		bestimmen was der nächste stattfindende Termin im Bezug auf das heutige Datum ist
		Diesen Eintrag im Array als Startpunkt speichern;  zb nächster Termin Array Index 4: $jetzt = 4; termine[jetzt].datum
		diese div classes dynamisch erzeugen heute = termine[jetzt], morgen termine[(jetzt + 1)], gestern termine[(jetzt - 1)];
		auf scroll event jetzt+=1 oder jetzt-=1 und html neu bauen
		~~ dennis fragen ob er bock hat mit css transition was zu bauen, dass es aussieht als würde der text scrollen~~
		
		
		um rauszufinden welcher termin am nächsten dran ist:
			die mysql dates müssen entweder in php date form gebracht werden oder unix time stamp, aufjedenfall umwandeln, so dass
			in php verglichen werden kann
			dann das array durchgehen
			
			int closest;
			foreach eintrag in array
				if to_unixtimestamp(eintrag.datum) >= to_unixtimestamp(jetzt())
					closest = eintrag.index;
				else 
					break;
------------------------------------------------------
-->
<?php					
require "db_terminator.php";
session_start();



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
		$cssClass = "p" . strval(($naechsterTermin - $i));
		
		//erste Zeile erstellt HTML für Hauptseiten Eintrag
		//zweite Zeile erstellt Popup für Eintrag mithilfe von terminMehrInfo()
		echo "<div class=".$cssClass.">".$terminArray[$i]["Datum"]." ".$terminArray[$i]["Titel"]." ".$terminArray[$i]["Fach"]." ";
		echo "<div class='popup' onclick='myFunction(".$i.")'><img title='moreInfo' src='burgermenu.png'/>".terminMehrInfo($terminArray, $i)."</div></div>";
	}
	
	//Von Index (naechsterTermin + 1) bis zum Ende des Arrays Einträge bauen
	for($i = $naechsterTermin + 1; $i < $anzahlTermine; $i++)
	{
		//CSS Selektor (div class) generieren, n{nummer} // n = negativ -> in der Vergangenheit vom Startpunkt
		$cssClass = "n" . strval(($i - $naechsterTermin));
		
		//erste Zeile erstellt HTML für Hauptseiten Eintrag
		//zweite Zeile erstellt Popup für Eintrag mithilfe von terminMehrInfo()
		echo "<div class=".$cssClass.">".$terminArray[$i]["Datum"]." ".$terminArray[$i]["Titel"]." ".$terminArray[$i]["Fach"]." ";
		echo "<div class='popup' onclick='myFunction(".$i.")'><img title='moreInfo' src='burgermenu.png'/>".terminMehrInfo($terminArray, $i)."</div></div>";
		
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
	
	
	
	/* echo "DEBUG: anzahlTermine = ".$anzahlTermine;
	echo"<div class='termine'>";
	echo	"<div class='p0'>".$terminArray[$naechsterTermin]["Datum"]." ".$terminArray[$naechsterTermin]["Titel"]." ".$terminArray[$naechsterTermin]["Fach"]."</div>";
	echo	"<div class='p1'>".$terminArray[$naechsterTermin-1]["Datum"]." ".$terminArray[$naechsterTermin-1]["Titel"]." ".$terminArray[$naechsterTermin-1]["Fach"]."</div>";
	echo	"<div class='p2'>uebermorgen</div>";
	echo	"<div class='m1'>gestern</div>";
	echo	"<div class='m2'>vorgestern</div>";
	echo"</div>"; */

