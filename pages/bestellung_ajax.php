<?php 
require_once("bestellung.class.php");

if (isset($_GET["gekochtesgerichtid"])) {
    $gekochtesgerichtid = $_GET["gekochtesgerichtid"];
    $bestellung = new Bestellung();
    $data = $bestellung->getRezeptKochByGekochtes($gekochtesgerichtid);

    if ($data) {
        echo json_encode($data);
    }
}
?>