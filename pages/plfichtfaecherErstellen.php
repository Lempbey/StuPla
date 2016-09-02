<html>
<body>
<?php

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
/*$xml_semester->nodeValue=$schein["semester"];*/
$xml->save("xml/pflichtfaecher.xml");
?>
</body>
</html>