var schein = [];

$(document).ready(function(){



    $.ajax({
        url: '../xml/leistungen.xml',
        type:'POST',
        dataType: 'xml',
        beforeSend: function(){
            $("#hidden").load("data.php",{userid:1});
        },
        complete:function(){

            new Chartist.Bar('#chart1', {labels:['1.Semester','2.Semester','3.Semester','4.Semester','5.Semester','6.Semester'],series:[['25','25','20','40','35','40']]});
        },
        success: function(xml){
            // Extract relevant data from XML
            var i=0;
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

    $("#submit_vote").click(function(e){

        $.ajax( {
            type: "POST",
            url: "ajax_submit_vote.php",
            data: $('#poll_form').serialize(),
            success: function( response ) {}
        });

    });
    $(".datenLaden").click(function(){
        var option=$('input[type="radio"]:checked').val();
        switch (option){
            case "1":
                var summe=[0,0,0,0,0];
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
                new Chartist.Line('#chart2', data);
                break;
        }
    });
});






