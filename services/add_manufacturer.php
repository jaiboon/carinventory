<?php

include_once("../classes/Manufacturer.php");

$manufacturer = new Manufacturer();
$myArray = array(
    "manufacturer_name" => $_POST["manufacturer_name"],
    "status" => '1'
);
$result = $manufacturer->insert_record($myArray,$_POST["manufacturer_name"]);
echo $result;



