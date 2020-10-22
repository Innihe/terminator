<!doctype html>
<html>
<?php
	require 'terminator.php';
	session_start();
?> 
<script>
// When the user clicks on <div>, open the popup
function myFunction(arrayIndex) {
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
	</body>
</html>