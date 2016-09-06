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
    <title>Userpanel</title>
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
    <script src="../js/xepOnline.jqPlugin.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        $(document).ready(function(){
            var pflichtfaecher=[];
            $.ajax({
                url: '../xml/pflichtfaecher.xml',
                type:'GET',
                dataType: 'xml',
                beforeSend: function(){
                },
                complete:function(){
                    pflichtfaecher.sort();
                    var faecherString ="<select id='faecherSelect'>";
                    for(var i=0;i<=pflichtfaecher.length-1;i++){
                        faecherString+="<option value='"+pflichtfaecher[i]+"'>"+pflichtfaecher[i]+"</option>";
                    }
                    faecherString+="</select>";
                    $("#optionen").append(faecherString);
                },
                success: function(xml){
                    // Extract relevant data from XML
                    $(xml).find("fach").each(function() {
                        var fach = $(this).find("name").text();
                        pflichtfaecher.push(fach);
                    });
                }
                ,
                error: function(data){
                    alert('Error loading XML data');
                }
            });

            $(document).find(".semesterReihe").each(function(){
                $(this).children("#element7").css("display","none");
                $(this).children("#element8").css("display","none");
            });
            $(".semesterReihe").css("display","float");
            $("#modulplan").find("label").each(function(){
                $(this).css("transform","rotate(-90deg)");
            });
            $("#fachwahlBox").css({display:"flex","justify-content":"center"});
            $(".fachItem").css({"width":"90px","height":"90px",backgroundColor:"orange",display:"flex"}).draggable({revert:"invalid", helper:"clone"});
            setTimeout(textSetter,100);
            function textSetter(){
                $("#faecherSelect").selectmenu({width:150}).on( "selectmenuselect", function( event, ui ) {
                    var $value = $("#faecherSelect option:selected").val();
                    $("#fachName").text($value).css({"font-size":"1.2em","word-wrap":"break-word","align-self":"center"});
                } );
                $( "#faecherSelect" ).selectmenu( "option", "icons", { button: "ui-icon-circle-triangle-s" } );
            }

            $(".status").on("change",function(){
                if($("#done").is(":checked"))
                {
                    $(".fachItem").css({backgroundColor:"lightgreen"});
                }
                else
                {
                    $(".fachItem").css({backgroundColor:"IndianRed"});
                }

            });
            $("#modulplan").css({display:"flex","flex-direction":"column"});
            $(".semesterReihe").css({display:"flex","flex-direction":"row"});
            $(".droppableFach").css({width:"90px",height:"90px",border:"1px solid black"}).droppable({drop: function(event, ui){
                //Wie verschwindet übergebener Gegenstand
                ui.helper.hide("clip");
                //Wert des übergebenen Elements auslesen und zu einer Zahl parsen
                var $fach = $(ui.draggable).text();
                $(this).html($fach);
                var $farbe = $(ui.draggable).css("background-color");
                alert($farbe);
                if($farbe!="rgb(255, 165, 0)")
                {
                    $(this).css({backgroundColor:$farbe});
                }
                else
                {
                    alert("Bitte Status des Faches auswählen");
                }

            }});



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
    <main>
        <div id="fachwahlBox">
            <div id="optionen"></div>
            <div class="status">
                <input class="status" type="radio" id="done" name="status" checked="checked">
                <label for="done">Bestanden</label>
                </br>
                <input class="status" type="radio" id="todo" name="status">
                <label for="todo">Nicht bestanden</label>
            </div>

            <div class="fachItem" value="">
                <p id="fachName">Bitte Fach wählen</p>
            </div>
        </div>

        <div id="modulplan">

                <div class="semesterReihe" id="semester1">
                    <label for="semester1">1.Semester</label>
                    <div id="element1" class="droppableFach">TEXT</div>
                    <div id="element2" class="droppableFach"></div>
                    <div id="element3" class="droppableFach"></div>
                    <div id="element4" class="droppableFach"></div>
                    <div id="element5" class="droppableFach"></div>
                    <div id="element6" class="droppableFach"></div>
                    <div id="element7" class="droppableFach"></div>
                    <div id="element8" class="droppableFach"></div>
                </div>


            <div class="semesterReihe" id="semester2">
                <label for="semester2">2.Semester</label>
                <div id="element1" class="droppableFach"></div>
                <div id="element2" class="droppableFach"></div>
                <div id="element3" class="droppableFach"></div>
                <div id="element4" class="droppableFach"></div>
                <div id="element5" class="droppableFach"></div>
                <div id="element6" class="droppableFach"></div>
                <div id="element7" class="droppableFach"></div>
                <div id="element8" class="droppableFach"></div>
            </div>

            <div class="semesterReihe" id="semester3">
                <label for="semester3">3.Semester</label>
                <div id="element1" class="droppableFach"></div>
                <div id="element2" class="droppableFach"></div>
                <div id="element3" class="droppableFach"></div>
                <div id="element4" class="droppableFach"></div>
                <div id="element5" class="droppableFach"></div>
                <div id="element6" class="droppableFach"></div>
                <div id="element7" class="droppableFach"></div>
                <div id="element8" class="droppableFach"></div>
            </div>

            <div class="semesterReihe" id="semester4">
                <label for="semester4">4.Semester</label>
                <div id="element1" class="droppableFach"></div>
                <div id="element2" class="droppableFach"></div>
                <div id="element3" class="droppableFach"></div>
                <div id="element4" class="droppableFach"></div>
                <div id="element5" class="droppableFach"></div>
                <div id="element6" class="droppableFach"></div>
                <div id="element7" class="droppableFach"></div>
                <div id="element8" class="droppableFach"></div>
            </div>

            <div class="semesterReihe" id="semester5">
                <label for="semester5">5.Semester</label>
                <div id="element1" class="droppableFach"></div>
                <div id="element2" class="droppableFach"></div>
                <div id="element3" class="droppableFach"></div>
                <div id="element4" class="droppableFach"></div>
                <div id="element5" class="droppableFach"></div>
                <div id="element6" class="droppableFach"></div>
                <div id="element7" class="droppableFach"></div>
                <div id="element8" class="droppableFach"></div>
            </div>

            <div class="semesterReihe" id="semester6">
                <label for="semester6">6.Semester</label>
                <div id="element1" class="droppableFach"></div>
                <div id="element2" class="droppableFach"></div>
                <div id="element3" class="droppableFach"></div>
                <div id="element4" class="droppableFach"></div>
                <div id="element5" class="droppableFach"></div>
                <div id="element6" class="droppableFach"></div>
                <div id="element7" class="droppableFach"></div>
                <div id="element8" class="droppableFach"></div>
            </div>
        </div>
        <a href="#" onclick="return xepOnline.Formatter.Format('modulplan',{render:'download'});">
            <i id="diskette" class="fa fa-save"></i>
            Plan als PDF speichern
        </a>


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
