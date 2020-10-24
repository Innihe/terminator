<?php 
	require 'db_terminator.php';

	if(isset($_REQUEST['id'])) //Wenn ID übergeben wurde
			{
				$terminID = $_REQUEST['id'];
				$termin = db_PullOne($terminID);

				header("Location: ../public/update.php?id=".$terminID."&art=".$termin->Art."&datum=".$termin->Datum."&ersteller=".$termin->Ersteller."&fach=".$termin->Fach."&notizen=".$termin->Notizen."&titel=".$termin->Titel."&uhrzeit=".$termin->Uhrzeit."");
			}