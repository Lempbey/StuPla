<?php
    session_start();
    $pdo = new PDO('mysql:host=localhost;dbname=studienplaner', 'root', '');

    if(!isset($_SESSION['userid'])) {
        die('Bitte zuerst <a href="login.php">einloggen</a>');
    }
    $userid = /*$_SESSION['userid'];*/1;
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
                        <label for="ectsSoll">ECTS-Soll</label></br>

                        <input type="radio" id="notenverteilung" class="datenLaden" name="charts" value="5">
                        <label for="notenverteilung">Notenverteilung</label>
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
    <script>
        var schein = [];

        $(document).ready(function(){

            $.ajax({
                url: '../xml/leistungen.xml',
                type:'POST',
                dataType: 'xml',
                beforeSend: function(){
                },
                complete:function(){
                    //Beispieldiagramm laden, wenn AJAX-Abfrage komplett
                    new Chartist.Bar('#chart1', {labels:['1.Semester','2.Semester','3.Semester','4.Semester','5.Semester','6.Semester'],series:[['25','25','20','40','35','40']]});
                },
                success: function(xml){
                    // Extract relevant data from XML
                    var i=0;
                    //Die einzelnen Scheine werden als Array(mit note,ects...) in das Array schein[] geschrieben
                    $(xml).find('schein').each(function() {
                        var t = [];
                        var note = $(this).find("note").text();
                        var ects = $(this).find("ects").text();
                        var fachnr = $(this).find("fachnr").text();
                        var semester = $(this).find("semester").text();
                        t.push(note);
                        t.push(ects);
                        t.push(fachnr);
                        t.push(semester);
                        schein[i]=t;
                        i++;
                    });

                }
                ,
                error: function(data){
                    alert('Error loading XML data');
                }
            });
            // Was passiert, wenn ein Radiobutton gedrückt wird
            $(".datenLaden").click(function(){
                //Erkennen, welcher Button aktiv ist
                var option=$('input[type="radio"]:checked').val();
                switch (option){
                    case "1":
                        var summe=[0,0,0,0,0,0];
                        //Alle Scheine auslesen und für jedes Semester die ECTS summieren
                        for(var i=0;i<=schein.length-1;i++){
                            var a = schein[i][3];
                            summe[a]=parseInt(schein[i][1],10)+parseInt(summe[a],10);
                        }
                        var data = {
                            // A labels array that can contain any sort of values
                            labels: ["1.Semester","2.Semester","3.Semester","4.Semester","5.Semester","6.Semester"],
                            // Our series array that contains series objects or in this case series data arrays
                            series: [[
                                summe[0],summe[1],summe[2],summe[3],summe[4],summe[5]
                            ]]
                        };
                        var options = {
                            axisY: {
                                type: Chartist.FixedScaleAxis,
                                ticks: [0, 5, 10, 15, 20,25,30,35,40,45,50],
                                low: 0
                            },
                            lineSmooth: Chartist.Interpolation.step(),
                            showPoint: false,
                            width: 700,
                            height: 500
                        };
                        new Chartist.Line('#chart2', data,options);
                        break;
                    case "2":
                        var summe=[0,0,0,0,0,0];
                        var ects=[0,0,0,0,0,0];
                        var ectsGew=[0,0,0,0,0,0];
                        //Alle Scheine auslesen und für jedes Semester die ECTS summieren
                        for(var i=0;i<=schein.length-1;i++){
                            var a = schein[i][3];
                            summe[a]=parseInt(schein[i][1],10)+parseInt(summe[a],10);
                            ects[a]=parseInt(schein[i][1],10)+parseInt(ects[a],10);
                            ectsGew[a]=(parseInt(schein[i][1],10)*parseInt(schein[i][0],10))+parseInt(ectsGew[a],10);
                        }
                        var durchschnittsnote=[];
                        for(var i=1;i<=6;i++){
                            durchschnittsnote[i]=parseInt(ectsGew[i],10)/parseInt(ects[i],10);
                        }
                        var data = {
                            // A labels array that can contain any sort of values
                            labels: ["1.Semester","2.Semester","3.Semester","4.Semester","5.Semester","6.Semester"],
                            // Our series array that contains series objects or in this case series data arrays
                            series: [[
                                durchschnittsnote[0],durchschnittsnote[1],durchschnittsnote[2],durchschnittsnote[3],durchschnittsnote[4],durchschnittsnote[5]
                            ]]
                        };
                        var options = {
                            width: 700,
                            height: 500
                        };
                        new Chartist.Line('#chart2', data,options);
                        break;
                    case "3":
                        var ectsSumme=0;
                        var geschafft=0;
                        var nochOffen=0;
                        //Alle Scheine auslesen und für jedes Semester die ECTS summieren
                        for(var i=0;i<=schein.length-1;i++){

                            ectsSumme =parseInt(schein[i][1],10)+parseInt(ectsSumme,10);
                        }
                        geschafft = Math.round(parseFloat(ectsSumme)/180*100);
                        nochOffen = Math.round(100-parseFloat(geschafft));
                        new Chartist.Pie('#chart2', {
                                series:[geschafft,nochOffen]},
                            {
                                chartPadding: 30,
                                labelOffset: 50,
                                labelDirection: 'explode'
                            }
                        );
                        break;
                    case "4":
                        var summe=[0,0,0,0,0];
                        var insg=0;
                        //Alle Scheine auslesen und für jedes Semester die ECTS summieren
                        for(var i=0;i<=schein.length-1;i++){
                            var a = schein[i][3];
                            summe[a]=parseInt(schein[i][1],10)+parseInt(insg);
                            insg = summe[a];
                        }
                        var data = {
                            // A labels array that can contain any sort of values
                            labels: ["1.Semester","2.Semester","3.Semester","4.Semester","5.Semester","6.Semester"],
                            // Our series array that contains series objects or in this case series data arrays
                            series: [
                                [summe[0],summe[1],summe[2],summe[3],summe[4],summe[5]],
                                [30,60,90,120,150,180]
                            ]
                        };
                        var options = {
                            axisY: {
                                type: Chartist.FixedScaleAxis,
                                ticks: [30, 60, 90, 120, 150,180],
                                low: 0
                            },
                            width: 700,
                            height: 500
                        };
                        new Chartist.Bar('#chart2', data,options);
                        break;
                    case "5":
                        var $1=0;
                        var $2=0;
                        var $3=0;
                        var $4=0;
                        var $5=0;
                        var $6=0;
                        var $7=0;
                        var $8=0;
                        var $9=0;
                        var $10=0;
                        for(var z=0;z<=schein.length-1;z++){
                            switch(schein[z][0]){
                                case "1":
                                    $1++;
                                    break;
                                case "1.3":
                                    $2++;
                                    break;
                                case "1.7":
                                    $3++;
                                    break;
                                case "2":
                                    $4++;
                                    break;
                                case "2.3":
                                    $5++;
                                    break;
                                case "2.7":
                                    $6++;
                                    break;
                                case "3":
                                    $7++;
                                    break;
                                case "3.3":
                                    $8++;
                                    break;
                                case "3.7":
                                    $9++;
                                    break;
                                case "4":
                                    $10++;
                                    break;
                            }
                        }
                        var chart = new Chartist.Pie('#chart2', {
                            series: [parseInt($1,10),parseInt($2,10),parseInt($3,10),parseInt($4,10),parseInt($5,10),parseInt($6,10),parseInt($7,10),parseInt($8,10),parseInt($9,10),parseInt($10,10)],
                            labels: [1.0,1.3,1.7, 2.0, 2.3,2.7,3.0,3.3,3.7, 4.0]
                        }, {
                            labelOffset: 50,
                            labelDirection: 'explode',
                            donut: true,
                            showLabel: true
                        });

                        chart.on('draw', function(data) {
                            if(data.type === 'slice') {
                                // Get the total path length in order to use for dash array animation
                                var pathLength = data.element._node.getTotalLength();

                                // Set a dasharray that matches the path length as prerequisite to animate dashoffset
                                data.element.attr({
                                    'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
                                });

                                // Create animation definition while also assigning an ID to the animation for later sync usage
                                var animationDefinition = {
                                    'stroke-dashoffset': {
                                        id: 'anim' + data.index,
                                        dur: 1000,
                                        from: -pathLength + 'px',
                                        to:  '0px',
                                        easing: Chartist.Svg.Easing.easeOutQuint,
                                        // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
                                        fill: 'freeze'
                                    }
                                };

                                // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
                                if(data.index !== 0) {
                                    animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
                                }

                                // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us
                                data.element.attr({
                                    'stroke-dashoffset': -pathLength + 'px'
                                });

                                // We can't use guided mode as the animations need to rely on setting begin manually
                                // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
                                data.element.animate(animationDefinition, false);
                            }
                        });
                        break;
                }
            });
        });
    </script>
    </body>
</html>
