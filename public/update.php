
<!DOCTYPE html>
<html>
  <head>
  		<link rel="stylesheet" href="stylesheet.css">
		<title>Terminator</title>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
	<?php
					//Bisherige Daten des Stickies holen
					if(isset($_REQUEST['id']) && isset($_REQUEST['datum']) && isset($_REQUEST['ersteller']) && isset($_REQUEST['fach']) && isset($_REQUEST['notizen']) && isset($_REQUEST['titel']) && isset($_REQUEST['uhrzeit']) && isset($_REQUEST['art']))
					{
						$id = $_REQUEST['id'];
						$datum = $_REQUEST['datum'];
						$ersteller = $_REQUEST['ersteller'];
						$fach = $_REQUEST['fach'];
						$notizen = $_REQUEST['notizen'];
						$titel = $_REQUEST['titel'];
						$uhrzeit = $_REQUEST['uhrzeit'];
						$art = $_REQUEST['art'];
						

					}
	?>
    <form action="../private/editsend.php?id=<?php echo $id; ?>" method="post">
      <input type="text" name="titel" value="<?php echo $titel; ?>">
      <br>
      <input type="date" name="datum" value="<?php echo $datum; ?>">
      <br>
      <input type="time" name="uhrzeit" value="<?php echo $uhrzeit; ?>">
      <br>
      <input type="text" name="notizen" value="<?php echo $notizen; ?>">
      <br>
      <input type="text" name="ersteller" value="<?php echo $ersteller; ?>">
      <br>
      <input type="text" name="fach" value="<?php echo $fach; ?>">
      <br>
      <input type="text" name="art" value="<?php echo $art; ?>">
      <br>
      <button type="submit" name="update">Update</button>

  </body>
</html>
