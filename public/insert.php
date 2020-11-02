
<!DOCTYPE html>
<html>
  <head>
  		<link rel="stylesheet" href="stylesheet.css">
		<title>Terminator</title>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form action="../private/addsend.php" method="post">
      <input type="text" name="title" placeholder="Titel">
      <br>
      <input type="date" name="date" placeholder="Datum">
      <br>
      <input type="time" name="time" placeholder="Zeit">
      <br>
      <input type="text" name="note" placeholder="Notizen">
      <br>
      <input type="text" name="creator" value="Ersteller">
      <br>
      <input type="text" name="subject" value="Fach">
      <br>
      <input type="text" name="type" value="Art">
      <br>
      <button type="submit" name="insert">Einfügen</button>
  </body>
</html>
