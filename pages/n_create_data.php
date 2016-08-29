<?php
session_start();
$_SESSION["userid"]=1;
if(!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="../../Studienplaner/pages/login.php">einloggen</a>');
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
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <link href="../../Studienplaner/css/stylesheet.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="../../Studienplaner/css/nav.css" rel="stylesheet" type="text/css" media="screen">
    <link href="../../Studienplaner/css/footer.css" rel="stylesheet" type="text/css" media="screen">
    <link href="../../Studienplaner/css/icons.css" rel="stylesheet" type="text/css" media="screen">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/humanity/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        $(document).ready(function(){
            $("input[type='button']").button();

            $( "#semester" )
                .selectmenu()
                .selectmenu( "menuWidget" )
                .addClass( "overflow" );
            $("#radioFaecher").buttonset();
            $( "#note" )
                .selectmenu()
                .selectmenu( "menuWidget" )
                .addClass( "overflow" );

            $("#pflichtfach").on("click",function(){
                $("#fachSelect").show();
            });
            $("#seminar").on("click",function(){
                $("#fachSelect").hide();
            });
            $("#sprache").on("click",function(){
                $("#fachSelect").hide();
            });
            $("#wahlpflichtfach").on("click",function(){
                $("#fachSelect").hide();
            });

            $.ajax({
                url: '../xml/pflichtfaecher.xml',
                type: 'GET',
                dataType: 'xml',
                beforeSend: function () {

                },
                complete: function () {

                },
                success: function (xml) {
                    // Extract relevant data from XML
                    var i = 0;
                    $(xml).find('fach').each(function () {
                        var t = [];
                        var note = $(this).find("note").text();
                        var ects = $(this).find("ects").text();
                        var fachnr = $(this).find("fachnr").text();
                        var semester = $(this).find("semester").text();
                        t.push(note);
                        t.push(ects);
                        t.push(fachnr);
                        t.push(semester);
                        i++;
                    });

                }
                ,
                error: function (data) {
                    alert('Error loading XML data');
                }
            });

        });
    </script>
</head>
<body>
<div class="wrapper">
    <header>
        <nav class="horizontal-nav full-width">
            <ul>
                <li><a href="../../Studienplaner/pages/login.php"><h5>Studienplaner</h5></a></li>
                <li><a href="../../Studienplaner/pages/login.php">Home</a></li>
                <li><a href="registrieren.php">Registration</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Impressum</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="insert_data.php" id="scheinForm">

            <fieldset>
                <legend>Art des Faches</legend>
                <div id="radioFaecher">
                    <input type="radio" id="pflichtfach" name="fachart" checked="checked" autofocus>
                    <label for="pflichtfach">Pflichtfach</label>
                    </br>
                    <input type="radio" id="wahlpflichtfach" name="fachart">
                    <label for="wahlpflichtfach">Wahlpflichtfach</label>
                    </br>
                    <input type="radio" id="seminar" name="fachart">
                    <label for="seminar">Seminar</label>
                    </br>
                    <input type="radio" id="sprache" name="fachart">
                    <label for="sprache">Sprache</label>
                </div>
            </fieldset>
            </br></br>
            <fieldset id="fachSelect">
                <select>
                    <optgroup label="1.Semester">

                    </optgroup>
                    <optgroup label="2.Semester">

                    </optgroup>
                    <optgroup label="3.Semester">

                    </optgroup>
                    <optgroup label="4.Semester">

                    </optgroup>
                    <optgroup label="5.Semester">

                    </optgroup>
                    <optgroup label="6.Semester">

                    </optgroup>
                </select>
            </fieldset>
            <br><br><br>
            <fieldset>
                <label for="semester">Semester der erbrachten Leistung:</label>
                <select name="semester" id="semester">
                    <?php
                        $past = new DateTime('-10 years');
                        $now = new DateTime();
                        $now->getTimestamp();
                        $begin = $past->format("y");
                        $end = $now->format("y");
                        for($i=$begin;$i<=$end;$i++){
                            if($i==$end){
                                echo "<option value='SS".$i."' selected>SS$i</option>\n";
                                echo "<option value='WS".$i."'>WS$i</option>\n";
                            }else{
                                echo "<option value='SS".$i."'>SS$i</option>\n";
                                echo "<option value='WS".$i."'>WS$i</option>\n";
                            }
                        }
                    ?>
                </select>
            </fieldset>
            <br><br><br>


            <fieldset>
                <label for="note">Note</label>
                <select>
                    <optgroup label="1">
                        <option value="1">1,0</option>
                        <option value="1.3">1,3</option>
                        <option value="1.7">1,7</option>
                    </optgroup>
                    <optgroup label="2">
                        <option value="1">2,0</option>
                        <option value="1.3">2,3</option>
                        <option value="1.7">2,7</option>
                    </optgroup>
                    <optgroup label="3">
                        <option value="1">3,0</option>
                        <option value="1.3">3,3</option>
                        <option value="1.7">3,7</option>
                    </optgroup>
                    <optgroup label="4">
                        <option value="1">4,0</option>
                    </optgroup>
                </select>

            </fieldset>
            <br><br><br><br>

            <input type="button" id="saveButton" value="Speichern"><br><br>
            <input type="button" id="resetButton" value="Zurücksetzen">
        </form>
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
