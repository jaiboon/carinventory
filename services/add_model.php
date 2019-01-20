<?php

include_once("../classes/Model.php");

$model = new Model();

$image1 = explode('.', $_FILES['image_file1']['name']);
$image1 = $image1[0] . "_" . time() . "." . end($image1);
$image2 = explode('.', $_FILES['image_file2']['name']);
$image2 = $image2[0] . "_" . time() . "." . end($image2);

if ($_FILES['image_file1']['error'] > 0) {
    echo 'Error: ' . $_FILES['image_file1']['error'] . '<br>';
} else {
    if (move_uploaded_file($_FILES['image_file1']['tmp_name'], '../images/' . $image1)) {
      //  echo "File11  Uploaded Successfully";
    }
}

if ($_FILES['image_file2']['error'] > 0) {
    echo 'Error: ' . $_FILES['image_file2']['error'] . '<br>';
} else {
    if (move_uploaded_file($_FILES['image_file2']['tmp_name'], '../images/' . $image2)) {
      //  echo "File12 Uploaded Successfully";
    }
}

$fields = [
    "manufacturer_id" => $_REQUEST["manufacturer_id"],
    "model_name" => $_REQUEST["model_name"],
    "model_color" => $_REQUEST["model_color"],
    "model_year" => $_REQUEST["model_year"],
    "model_regno" => $_REQUEST["model_regno"],
    "model_note" => $_REQUEST["model_note"],
    "model_count" => $_REQUEST["model_count"],
    "image1" => $image1,
    "image2" => $image2,
    "model_status" => '1'
];

echo $model->insert_record($fields);
