<?php
	session_start();
	$pdo = new PDO('mysql:host=localhost;dbname=studienplaner', 'root', '');

	if(isset($_GET['login'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];

		$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$result = $statement->execute(array('email' => $email));
		$user = $statement->fetch();

			if ($user !== false && password_verify($password, $user['password'])) {
				$_SESSION['userid'] = $user['id'];
				header('Location: n_user_data.php');
			} else {
				$errorMessage = "E-Mail oder Passwort war ungültig<br>";
			}
	}
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

	});
	</script>
</head>
<body>
<div class="wrapper">
	<header>
		<div class="clearfix">
			<nav class="horizontal-nav full-width">
				<ul>
					<li><a href="n_index.php"><h5>Studienplaner</h5></a></li>
					<li><a href="n_index.php">Home</a></li>
					<li><a href="n_registration.php">Registration</a></li>
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
		<form id="login" action="?login=1" method="post">
			<input type='hidden' name='submitted' id='submitted' value='1'/>
			<label for="email">Ihre Zugangs-eMail</label>
			<input type="email" id="email" name="email" placeholder="Ihre E-Mail" size="40" maxlength="250">
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