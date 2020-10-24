<!doctype html>
<html>
<?php
	require '../private/terminator.php';
	session_start();
setlocale(LC_TIME, "de_DE.utf8"); //Zeitumgebung Deutschland
?>
<script>

//
function popupUmschalten(arrayIndex) {
  var popup = document.getElementById("myPopup"+arrayIndex);
  popup.classList.toggle("show");
}
</script>
	<head>
		<link rel="stylesheet" href="stylesheet.css">
		<title>Terminator</title>
	</head>
	<body>
		<div class="grid-container">
			<?php zeigeTermine(); ?>
			<div class="header_mid"><h4>TERMINATOR</h4></div>
			<div class="footer_mid">
			
			</div>
		</div>

	<footer>
   <div id="extra">
		 <img src="extra.png">
   </div>
	</footer>
	</body>


</html>
