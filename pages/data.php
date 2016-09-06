<html>
<body>
<?php
$con = mysqli_connect("","root");
mysqli_select_db($con, "studienplaner");

$userid = $_REQUEST['userid'];
$res = mysqli_query($con, "select * from leistungsschein WHERE userid=$userid");

$xml = new DOMDocument();
$xml_leistungen = $xml->createElement("leistungen");
$xml->appendChild( $xml_leistungen );


while($schein = mysqli_fetch_assoc($res)){
    $xml_schein = $xml->createElement("schein");
    $xml_ects = $xml->createElement("ects");
    $xml_fachnr = $xml->createElement("fachnr");
    $xml_semester = $xml->createElement("semester");
    $xml_note = $xml->createElement("note");
    $xml_leistungen->appendChild( $xml_schein );
    $xml_schein->appendChild( $xml_note );
    $xml_schein->appendChild( $xml_ects );
    $xml_schein->appendChild( $xml_fachnr );
    $xml_schein->appendChild( $xml_semester );
    $xml_note->nodeValue=$schein['note'];
    $xml_ects->nodeValue=$schein["ects"];
    $xml_fachnr->nodeValue=$schein["fachnr"];
    $xml_semester->nodeValue=$schein["semester"];
};

$xml->save("../xml/leistungen.xml");
?>
</body>
</html>