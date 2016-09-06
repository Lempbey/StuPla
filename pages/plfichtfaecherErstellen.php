<html>
<body>
<?php

class Fach
{
    public $semester;
    public $name;
    public $studiengang;
    public $ects;

    function __construct(
        $semester, $name, $studiengang, $ects)
    {
        $this->semester = $semester;
        $this->name = $name;
        $this->studiengang = $studiengang;
        $this->ects = $ects;
    }
}

$faecher = array(
    new Fach(
        "1",
        "Mathematik",
        "WI",
        "5"
    ),
    new Fach(
        "2",
        "Statistik",
        "WI",
        "5"
    ),
    new Fach(
        "1",
        "Netzwerke",
        "WI",
        "5"
    ),
    new Fach(
        "2",
        "ATW",
        "WI",
        "5"
    ),
    new Fach(
        "2",
        "Programmierung",
        "WI",
        "5"
    ),
    new Fach(
        "2",
        "Finanzierung",
        "BWL",
        "5"
    ),
    new Fach(
        "1",
        "International Business (Englisch/Französisch/Spanisch) 2",
        "IB",
        "5"
    ),
    new Fach(
        "1",
        "International Business (Englisch/Französisch/Spanisch) 1",
        "IB",
        "5"
    ),
    new Fach(
        "1",
        "Operations Research / Datenverarbeitung",
        "BWL",
        "5"
           ),
    new Fach(
        "1",
        "Grundlagen Wirtschaftsprivatrecht",
        "BWL",
        "5"
    ),
    new Fach(
        "2",
        "Jahresabschluss",
        "BWL",
        "5"
    ),
    new Fach(
        "2",
        "Grundlagen der Volkswirtschaftslehre: Mikroökonomie",
        "BWL",
        "5"
    ),
        new Fach(
            "1",
            "Klassische und moderne Physik",
            "WIng",
            "5"
        ),
    new Fach(
        "2",
        "Spezielle Themen der Physik",
        "WIng",
        "5"
    ),
    new Fach(
        "2",
        "Grundlagenlabor",
        "WIng",
        "5"
    )
);

$xml = new DOMDocument();
$xml_pflichtfaecher = $xml->createElement("pflichtfaecher");
$xml_pflichtfaecher = $xml->appendChild( $xml_pflichtfaecher );

for($i=1;$i<=4;$i++){
    switch($i){
        case "1":

            $xml_studiengang1 = $xml->createElement("studiengang");
            $xml_attribut1 = $xml_studiengang1->setAttributeNode(new DOMAttr('name', 'WI'));
            for($j=1;$j<=6;$j++){
                $xml_semester1 = $xml->createElement("semester");
                $xml_attribut1 = $xml_semester1->setAttributeNode(new DOMAttr('nr',$j));
                $xml_semester1 = $xml_studiengang1->appendChild($xml_semester1);
            }
            $xml_studiengang1 = $xml_pflichtfaecher->appendChild($xml_studiengang1);
            break;
        case "2":
            $xml_studiengang2 = $xml->createElement("studiengang");
            $xml_attribut2 = $xml_studiengang2->setAttributeNode(new DOMAttr('name', 'BWL'));
            for($k=1;$k<=6;$k++){
                $xml_semester2 = $xml->createElement("semester");
                $xml_attribut2 = $xml_semester2->setAttributeNode(new DOMAttr('nr',$k));
                $xml_semester2 = $xml_studiengang2->appendChild($xml_semester2);
            }
            $xml_studiengang2 = $xml_pflichtfaecher->appendChild($xml_studiengang2);
            break;
        case "3":
            $xml_studiengang3 = $xml->createElement("studiengang");
            $xml_attribut3 = $xml_studiengang3->setAttributeNode(new DOMAttr('name', 'IB'));
            for($l=1;$l<=6;$l++){
                $xml_semester3 = $xml->createElement("semester");
                $xml_attribut3 = $xml_semester3->setAttributeNode(new DOMAttr('nr',$l));
                $xml_semester3 = $xml_studiengang3->appendChild($xml_semester3);
            }
            $xml_studiengang3 = $xml_pflichtfaecher->appendChild($xml_studiengang3);
            break;
        case "4":
            $xml_studiengang4 = $xml->createElement("studiengang");
            $xml_attribut4 = $xml_studiengang4->setAttributeNode(new DOMAttr('name', 'WIng'));
            for($m=1;$m<=6;$m++){
                $xml_semester4 = $xml->createElement("semester");
                $xml_attribut4 = $xml_semester4->setAttributeNode(new DOMAttr('nr',$m));
                $xml_semester4 = $xml_studiengang4->appendChild($xml_semester4);
            }
            $xml_studiengang4 = $xml_pflichtfaecher->appendChild($xml_studiengang4);
            break;
    }
}
foreach($faecher as $einFach)
{
    if($einFach->studiengang="WI"){

        switch($einFach->semester){
            case "1":
                //create a fach element
                $fach = $xml_studiengang1->childNodes->item(0)->appendChild(
                    $xml->createElement("fach"));
                //create the name element
                $fach->appendChild(
                    $xml->createElement("name", $einFach->name));

                //create the ects element
                $fach->appendChild(
                    $xml->createElement("ects", $einFach->ects));
                break;
            case "2":
                $fach = $xml_studiengang1->childNodes->item(1)->appendChild(
                    $xml->createElement("fach"));

                $fach->appendChild(
                    $xml->createElement("name", $einFach->name));

                $fach->appendChild(
                    $xml->createElement("ects", $einFach->ects));
                break;
        }


    }
    elseif($einFach->studiengang="BWL"){
        //create a tutorial element
        $fach = $semester2->appendChild(
            $xml->createElement("fach"));

        //create the title element
        $fach->appendChild(
            $xml->createElement("name", $einFach->name));

        //create the date element
        $fach->appendChild(
            $xml->createElement("ects", $einFach->ects));
    }
    elseif($einFach->studiengang="IB"){
        //create a tutorial element
        $fach = $semester3->appendChild(
            $xml->createElement("fach"));


        //create the title element
        $fach->appendChild(
            $xml->createElement("name", $einFach->name));

        //create the date element
        $fach->appendChild(
            $xml->createElement("ects", $einFach->ects));
    }
    elseif($einFach->studiengang="WIng"){
        //create a tutorial element
        $fach = $semester4->appendChild(
            $xml->createElement("fach"));


        //create the title element
        $fach->appendChild(
            $xml->createElement("name", $einFach->name));

        //create the date element
        $fach->appendChild(
            $xml->createElement("ects", $einFach->ects));
    }

}
/*$xml_semester->nodeValue=$schein["semester"];*/
$xml->save("../xml/pflichtfaecher.xml");
?>
</body>
</html>