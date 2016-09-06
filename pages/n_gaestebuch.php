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
                    <li><a href="n_registration.php">Registration</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Impressum</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <h1>G&auml;stebuch</h1>
        <?php
        session_start();
            $db = new PDO('mysql:host=localhost;dbname=studienplaner', 'root', '');

            if(!isset($_SESSION['userid'])) {
                die('Bitte zuerst <a href="n_index.php">einloggen</a>');
            }
            $userid = $_SESSION['userid'];

        if (isset($_POST["Name"]) && isset($_POST["Ueberschrift"]) && isset($_POST["Kommentar"])) {
            try {
                $db = new PDO('mysql:host=localhost;dbname=studienplaner', 'root', '');
                $sql = "INSERT INTO eintraege (name, ueberschrift, eintrag) VALUES (?, ?, ?)";// ? = Platzhalter
                $werte = array($_POST["Name"], $_POST["Ueberschrift"], $_POST["Kommentar"]);
                $kommando = $db->prepare($sql);
                $kommando->execute($werte); //Ausführung des SQL Statements
                echo "Eintrag erfoglreich hinzugef&uuml;gt.";
            } catch (PDOException $e) {
                echo 'Fehler: ' . htmlspecialchars($e->getMessage());
            }
        }
        ?>
        <form method="post">
            Name <input type="text" name="Name" /><br />
            &Uuml;berschrift <input type="text" name="Ueberschrift" /><br />
            Kommentar
            <textarea cols="70" rows="10" name="Kommentar"></textarea><br />
            <input type="submit" name="Submit" value="Eintragen" />
        </form>
        <?php
        try {
            $db = new PDO('mysql:host=localhost;dbname=studienplaner', 'root', '');
            $sql = "SELECT * FROM eintraege ORDER BY datum DESC";
            $ergebnis = $db->query($sql);

            foreach ($ergebnis as $zeile) {
                printf("<p>%s</a> schrieb am/um %s:</p><h3>%s</h3><p>%s</p><hr/>",
                    htmlspecialchars($zeile['name']),
                    htmlspecialchars($zeile['datum']),
                    htmlspecialchars($zeile['ueberschrift']),
                    nl2br(htmlspecialchars($zeile['eintrag']))
                );//%s = platzhalter für strings
            }
        } catch (PDOException $e) {
            echo 'Fehler: ' . htmlspecialchars($e->getMessage());
        }
        ?>
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