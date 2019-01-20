<?php

include_once("../classes/DataOperation.php");


$inventory = new DataOperation();

if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
    echo json_encode($inventory->select($_REQUEST['id']));
} else {
    echo json_encode($inventory->selectAll());
}
