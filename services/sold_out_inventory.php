<?php
include_once("../classes/Model.php");

$model = new Model();

echo $model->soldOut($_REQUEST['id']);