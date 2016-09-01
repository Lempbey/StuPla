<?php
    session_start();
    $_SESSION["userid"]=1;
    if(!isset($_SESSION['userid'])) {
        die('Bitte zuerst <a href="login.php">einloggen</a>');
    }
    $userid = $_SESSION['userid'];

    //Verbindung zur DB aufbauen
    $pdo = new PDO('mysql:host=localhost;dbname=studienplaner', 'root', '');

    $statement = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $result = $statement->execute(array($userid));
    $user = $statement->fetch();

?>

<!DOCTYPE html>
<html> 
    <head>
        <title>Startseite</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/sunny/jquery-ui.css">
        <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
        <link href="../css/stylesheet.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="../css/nav.css" rel="stylesheet" type="text/css" media="screen">
        <link href="../css/footer.css" rel="stylesheet" type="text/css" media="screen">
        <link href="../css/icons.css" rel="stylesheet" type="text/css" media="screen">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="../css/chartist.css">
        <script src="../js/chartist.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../js/graphs.js"></script>
        <script>
            $(document).ready(function(){
                $("#radioCharts").buttonset();
                $(".ui-buttonset .ui-button").css("min-width","250px");
                $("#radioCharts").css("transform","scale(0.7)");
            });
        </script>
    </head>
    <body>
        <div class="wrapper">
        <header>
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
        </header>
        <main id="chartWahl">
                <form id="chartForm">
                    <div id="radioCharts">
                        <input type="radio" id="ectsSemester" class="datenLaden" name="charts" checked="checked" value="1">
                        <label for="ectsSemester">ECTS/Semester</label></br>

                        <input type="radio" id="notenschnittSemester" class="datenLaden" name="charts" value="2">
                        <label for="notenschnittSemester">Notenschnitt/Semester</label></br>

                        <input type="radio" id="ectsGesamt" class="datenLaden" name="charts" value="3">
                        <label for="ectsGesamt">ECTS/gesamt</label></br>

                        <input type="radio" id="ectsSoll" class="datenLaden" name="charts" value="4">
                        <label for="ectsSoll">ECTS-Soll</label>
                    </div>
                </form>
            <!--Radiomenu zur Auswahl des gewünschten Diagramms-->
            <div id="chart2"></div>
        </main>

        <form action="logout.php">
            <input type="submit" value="logout">
        </form>
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
        <div id="hidden" style="display:none"></div>
    </body>
</html>
