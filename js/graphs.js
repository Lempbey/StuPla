var schein = [];

$(document).ready(function(){

    $("#hidden").load("data.php",{userid:1});
    $(".datenLaden").click(function(){$.ajax({
        url: '../xml/leistungen.xml',
        type:'GET',
        dataType: 'xml',
        beforeSend: function(){
            /*checkForUpdates();*/
            /*createLabel();*/
            /*createSeries();*/
        },
        complete:function(){
            var data = {
                // A labels array that can contain any sort of values
                labels: [1,2,3,4],
            // Our series array that contains series objects or in this case series data arrays
            series: [[
                schein[0][0],schein[1][0],4,3
            ]]
        };

            // Create a new line chart object where as first parameter we pass in a selector
            // that is resolving to our chart container element. The Second parameter
            // is the actual data object.
            new Chartist.Line('#chart2', data);
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
    })});




    new Chartist.Bar('#chart1', {labels:['1.Semester','2.Semester','3.Semester','4.Semester','5.Semester','6.Semester'],series:[['25','25','20','40','35','40']]});
});
