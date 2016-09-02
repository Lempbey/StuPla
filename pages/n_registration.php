<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=studienplaner', 'root', '');

if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
        header('Location: geheim.php');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Registrierung</title>
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/sunny/jquery-ui.css">
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <link href="../css/stylesheet.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="../css/nav.css" rel="stylesheet" type="text/css" media="screen">
    <link href="../css/footer.css" rel="stylesheet" type="text/css" media="screen">
    <link href="../css/icons.css" rel="stylesheet" type="text/css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
</head>
<body>
<div class="wrapper">
    <header>
        <div class="clearfix">
            <nav class="horizontal-nav full-width">
                <ul>
                    <li><a href="n_index.php"><h5>Studienplaner</h5></a></li>
                    <li><a href="n_index.php">Home</a></li>
                    <li><a href="registration.php">Registration</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Impressum</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
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
        <?php
        $showFormular = true;
        if(isset($_GET['register'])) {
            $error = false;
            $vorname = $_POST['vorname'];
            $nachname = $_POST['nachname'];
            $email = $_POST['email'];
            $studiengang = $_POST['studiengang'];
            $semester = $_POST['semester'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
                $error = true;
            }
            if(strlen($password) == 0) {
                echo 'Bitte ein Passwort angeben<br>';
                $error = true;
            }
            if($password != $password2) {
                echo 'Die Passwörter müssen übereinstimmen<br>';
                $error = true;
            }
            if(!$error) {
                $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $result = $statement->execute(array('email' => $email));
                $user = $statement->fetch();
                if($user !== false) {
                    echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
                    $error = true;
                }
            }
            if(!$error) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $statement = $pdo->prepare("INSERT INTO users (vorname, nachname, email, studiengang, semester, password) VALUES (:vorname, :nachname, :email, :studiengang, :semester, :password)");
                $result = $statement->execute(array('vorname' => $vorname, 'nachname' => $nachname, 'email' => $email, 'studiengang' => $studiengang, 'semester' => $semester,  'password' => $password_hash));
                if($result) {
                    echo 'Du wurdest erfolgreich registriert. <a href="n_index.php">Zum Login</a>';
                    $showFormular = false;
                } else {
                    echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
                }
            }
        }

        if($showFormular) {
        ?>
        <article>
            <form action="?register=1" method="post">
                Vorname:
                <input type="text" size="40" maxlength="250" name="vorname" id="vorname"><br><br>
                Nachname:
                <input type="text" size="40" maxlength="250" name="nachname" id="nachname"><br><br>
                E-Mail:
                <input type="email" size="40" maxlength="250" name="email"><br><br>
                <label for="fachbereich">Studiengang:</label>
                <select name="studiengang" id="studiengang">
                    <option value="wirtschaftsinformatik">Wirtschaftsinformatik</option>
                    <option value="betriebswirtschaftslehre">Betriebswirtschaftslehre</option>
                    <option value="international business">International Business</option>
                    <option value="wirtschaftsingenieurwesen">Wirtschaftsingenieurwesen</option>
                </select><br><br>
                Semester:
                <input id="semester" size="40" maxlength="250" name="semester" type="number" min="1" max="6" step="1" value="6"><br><br>
                Passwort:
                <input type="password" size="40"  maxlength="250" name="password"><br><br>
                Passwort wiederholen:
                <input type="password" size="40" maxlength="250" name="password2"><br><br>
                <input type="submit" value="Registrieren">
            </form>
            <?php
            }
            ?>
        </article>
    </main>
    <footer>
        <div class="footer-left">
            <h3>Studienplaner <span>Hoschule Trier</span></h3>
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
            <a href="#">Startseite</a>
            <hr noshade>
            <a href="#">Registrierung</a>
            <hr noshade>
            <a href="#">KP</a>
            <hr noshade>
            <a href="#">Impressum</a>
            <hr noshade>
        </div>
    </footer>
</div>
</body>
</html>