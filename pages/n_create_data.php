<?php
session_start();
$_SESSION["studiengang"]="WI";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Noten eintragen</title>
    <meta charset="utf-8"/>
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <link href="../css/stylesheet.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="../css/nav.css" rel="stylesheet" type="text/css" media="screen">
    <link href="../css/footer.css" rel="stylesheet" type="text/css" media="screen">
    <link href="../css/icons.css" rel="stylesheet" type="text/css" media="screen">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/humanity/jquery-ui.css">
    <link rel="stylesheet" href="../css/chartist.css">
    <script src="../js/chartist.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        $(document).ready(function(){
            var faecherliste=[];
            $("#submitButton").button();
            $("input[type='button']").button();

            $( "#semester" )
                .selectmenu({width:150})
                .selectmenu( "menuWidget" )
                .addClass( "overflow" );
            $( "#ects" )
                .selectmenu({width:100})
                .selectmenu( "menuWidget" )
                .addClass( "overflow" );
            $("#radioFaecher").buttonset();
            $( "#note" )
                .selectmenu({width:100})
                .addClass( "overflow" );
            $("#fachWrite").hide();
            $("#pflichtfach").on("click",function(){
                $("#fachSelect").show();
                $("#fachWrite").hide();
            });
            $("#seminar").on("click",function(){
                $("#fachSelect").hide();
                $("#fachWrite").show();
            });
            $("#sprache").on("click",function(){
                $("#fachSelect").hide();
                $("#fachWrite").show();
            });
            $("#wahlpflichtfach").on("click",function(){
                $("#fachSelect").hide();
                $("#fachWrite").show();
            });
            //XML Datei für Pflichtfächer wird ausgelesen
            $.ajax({
                url: '../xml/pflichtfaecher.xml',
                type: 'GET',
                dataType: 'xml',
                beforeSend: function () {

                },
                complete: function () {
                    faecherliste[0].sort();
                    for(var i=0; i<=faecherliste[0].length-1;i++){
                        $("#opt1").append('<option value='+faecherliste[0][i]+'>'+faecherliste[0][i]+'</option>');
                    }
                    $("#pflichtmenu").selectmenu({width:250});

                },
                success: function (xml) {
                    // Extract relevant data from XML
                    $(xml).find('studiengang').each(function (index, element) {
                        if(element.attributes["name"]="<?php echo $_SESSION["studiengang"]?>")
                        {
                            var semesterliste = [];
                            $(element).find('semester').each(function(){
                                $(this).find("name").each(function(){
                                    var fachname =$(this).text();
                                    semesterliste.push(fachname);
                                });
                                faecherliste.push(semesterliste);
                            });
                        }
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
        <?php
        $pdo = new PDO('mysql:host=localhost;dbname=studienplaner', 'root', '');

        if(!isset($_SESSION['userid'])) {
            die('Bitte zuerst <a href="n_index.php">einloggen</a>');
        }

        $userid = $_SESSION['userid'];
        $showFormular = true;

        if(isset($_GET['register'])) {
            $fach = $_POST['pflichtmenu'];
            $userid = $_SESSION['userid'];
            $error = false;
            $note = $_POST['note'];
            $semester = $_POST['semester'];
            $ects = $_POST['ects'];

            echo $pflichtmenu;

            if(!$error) {
                $statement = $pdo->prepare("SELECT * FROM leistungsschein WHERE id = :userid AND fach = :pflichtmenu");
                $result = $statement->execute(array('userid' => $userid, 'pflichtmenu' => $fach));
                $user = $statement->fetch();

                if($user !== false) {
                    $statement = $pdo->prepare("UPDATE leistungsschein SET note = :note WHERE id = :userid AND fach = :pflichtmenu");
                    $result = $statement->execute(array('userid' => $userid, 'pflichtmenu' => $fach, 'note' => $note));

                    if($result) {
                        echo 'Note erfolgreich geändert zurück zur Übersicht.</a>';
                        $showFormular = false;
                        $error = true;
                    }
                }

                if(!$error) {
                    $statement = $pdo->prepare("INSERT INTO leistungsschein (id, fach, note, semester, ects) VALUES (:userid, :pflichtmenu, :note, :semester, :ects)");
                    $result = $statement->execute(array('userid' => $userid, 'pflichtmenu' => $fach, 'note' => $note, 'semester' => $semester, 'ects' => $ects));

                    if($result) {
                        echo 'Note erfolgreich eingetragen zurück zur Übersicht.</a>';
                        $showFormular = false;
                    } else {
                        echo 'Fehler';
                    }
                }
            }
        }
        if($showFormular) {
            ?>
            <form action="?register=1" method="post">
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
                    <label for="pflichtmenu">Pflichtfach</label>
                    <select id="pflichtmenu" name="pflichtmenu">
                        <optgroup id="opt1">
                        </optgroup>
                    </select>
                </fieldset>
                <br><br>
                <fieldset>
                    <label for="semester">Semester der erbrachten Leistung:</label>
                    <select name="semester" id="semester">
                        <?php
                        //Dynamisches Erzeugen der Semesterauswahl (immer letzte 10 Jahre WS+SS)
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
                <br><br>
                <fieldset>
                    <label for="fachbereich">Note</label>
                    <select id="note" name="note">
                        <option value="1.0">1,0</option>
                        <option value="1.3">1,3</option>
                        <option value="1.7">1,7</option>
                        <option value="2.0">2,0</option>
                        <option value="2.3">2,3</option>
                        <option value="2.7">2,7</option>
                        <option value="3.0">3,0</option>
                        <option value="3.3">3,3</option>
                        <option value="3.7">3,7</option>
                        <option value="4.0">4,0</option>
                        <option value="5.0">5,0</option>
                    </select>
                </fieldset>
                <br><br>
                <fieldset>
                    <label for="ects">ECTS</label>
                    <select id="ects" name="ects">
                        <option value="5">5</option>
                        <option value="10">10</option>
                    </select>
                </fieldset>
                <br><br>
                <input type="submit" value="eintragen" id="submitButton"><br><br>
                <input type="button" id="resetButton" value="Zurücksetzen">
            </form>
            <?php
        }
        ?>
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
