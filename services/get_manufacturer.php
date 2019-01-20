<?php

include_once("../classes/Manufacturer.php");

$manufacturer = new Manufacturer();

echo json_encode($manufacturer->fetch_record());
