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
                //Alle Scheine auslesen und für jedes Semester die ECTS summieren
                for(var i=0;i<=schein.length-1;i++){
                    var a = schein[i][3];
                    summe[a]=parseInt(schein[i][1],10)+parseInt(summe[a],10);
                    alert(summe[i]);
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
                    width: 700,
                    height: 500
                };
                new Chartist.Line('#chart2', data,options);
                break;
        }
    });
});






