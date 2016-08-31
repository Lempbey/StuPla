<?php
   /* Vor Beenden der Session wieder aufnehmen */
   session_start();

   /* Beenden der Session */
   session_destroy();
   $_SESSION = array();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>Startseite</title>
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/sunny/jquery-ui.css">
	<link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
	<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" media="screen"/>
	<link href="../css/nav.css" rel="stylesheet" type="text/css" media="screen">
	<link href="../css/footer.css" rel="stylesheet" type="text/css" media="screen">
	<link href="../css/icons.css" rel="stylesheet" type="text/css" media="screen">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
	<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){
		//Daten für den Chart einspeisen
		var data = {
			// A labels array that can contain any sort of values
			labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
			// Our series array that contains series objects or in this case series data arrays
			series: [
				[5, 2, 4, 2, 0]
			]
		};

// Create a new line chart object where as first parameter we pass in a selector
// that is resolving to our chart container element. The Second parameter
// is the actual data object.
		new Chartist.Line('.ct-chart', data);

		// Andere Variante um Daten einzuspeisen und statt Line-Chart ein Balkendiagramm
		new Chartist.Bar('#chart1', {labels:['1.Semester','2.Semester','3.Semester','4.Semester','5.Semester','6.Semester'],series:[['25','25','20','40','35','40']]});
	});
	</script>
</head>
<body>
<div class="wrapper">
	<header>
		<div class="clearfix">
			<nav class="horizontal-nav full-width">
				<ul>
					<li><a href="login.php"><h5>Studienplaner</h5></a></li>
					<li><a href="login.php">Home</a></li>
					<li><a href="registrieren.php">Registration</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Contact</a></li>
					<li><a href="#">Impressum</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<?php
	if(isset($errorMessage)) {
		echo $errorMessage;
	}
	?>
	<div class="login">
		<form id="login" method="post" action="login.php">
			<input type='hidden' name='submitted' id='submitted' value='1'/>
			<label for="email">Ihre Zugangs-eMail</label>
			<input type="email" id="email" name="email" placeholder="Ihre E-Mail">
			<label for="password">Passwort</label>
			<input type="password" id="password" name="password" placeholder="*****">
			<button type="submit" name="login_btn" id="login_btn" >Einloggen</button></br>
			<a href="registration.php">Noch keinen Account?<br> Hier registrieren</a>
		</form>
	</div>
	<main>
		<div class="ct-chart ct-perfect-fourth"></div>
		<div class="ct-chart ct-perfect-fourth" id="chart1"></div>

	</main>
	<footer>
		<div class="footer-left">
			<h3>Studienplaner <span>Hochschule Trier</span></h3>
			<div class="footer-icons">
				<a href="#"><i class="fa fa-facebook-square"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-linkedin"></i></a>
			</div>
			<p class="footer-company-name">Studienplaner &copy; 2016</p>
		</div>
		<div class="footer-center">
			<div>
				<i class="fa fa-map-marker"></i>
				<p><span>Musterstraße 1</span> Trier, Deutschland</p>
			</div>
			<div>
				<i class="fa fa-phone"></i>
				<p>06562 112233</p>
			</div>
			<div>
				<i class="fa fa-envelope"></i>
				<p><a href="mailto:support@company.com">support@studienplaner.de</a></p>
			</div>
		</div>
		<div class="footer-right">
			<a href="#">Home</a>
			<hr noshade>
			<a href="#">Registration</a>
			<hr noshade>
			<a href="#">About</a>
			<hr noshade>
			<a href="#">Contact</a>
			<hr noshade>
			<a href="#">Impressum</a>
			<hr noshade>
		</div>
	</footer>
</div>

</body>
</html>