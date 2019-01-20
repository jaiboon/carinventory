<?php

//include "db.php";

class Manufacturer {

    private $table = 'manufacturers';
    private $con;

    function __construct() {
        include_once("db.php");
        $db = new Database();
        $this->con = $db->connect();
    }

    public function insert_record($fields, $name) {
        $sel = "SELECT * FROM manufacturers WHERE manufacturer_name = '$name'";

        $query = mysqli_query($this->con, $sel);
        if ($query->num_rows > 0) {
            return "duplicate";
        }
        $sql = "";
        $sql .= "INSERT INTO " . $this->table;
        $sql .= " (" . implode(",", array_keys($fields)) . ") VALUES ";
        $sql .= "('" . implode("','", array_values($fields)) . "')";

        $result = mysqli_query($this->con, $sql);
        if ($result) {
            return "success";
        } else {
            return "failure";
        }
    }

    public function fetch_record() {
        $sql = "SELECT manufacturer_id,manufacturer_name FROM " . $this->table;
        $array = array();
        $query = mysqli_query($this->con, $sql);
        if ($query->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $rows[] = $row;
            }
            return $rows;
        }
    }
 
    public function select_record($where) {
        $sql = "";
        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= $key . "='" . $value . "' AND ";
        }
        $condition = substr($condition, 0, -5);
        $sql .= "SELECT * FROM " . $this->table . " WHERE " . $condition;
        $query = mysqli_query($this->con, $sql);
        $row = mysqli_fetch_array($query);
        return $row;
    }

    public function update_record($where, $fields) {
        $sql = "";
        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= $key . "='" . $value . "' AND ";
        }
        $condition = substr($condition, 0, -5);
        foreach ($fields as $key => $value) {
            $sql .= $key . "='" . $value . "', ";
        }
        $sql = substr($sql, 0, -2);
        $sql = "UPDATE " . $this->table . " SET " . $sql . " WHERE " . $condition;
        if (mysqli_query($this->con, $sql)) {
            return true;
        }
    }

    public function delete_record($where) {
        $sql = "";
        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= $key . "='" . $value . "' AND ";
        }
        $condition = substr($condition, 0, -5);
        $sql = "DELETE FROM " . $this->table . " WHERE " . $condition;
        if (mysqli_query($this->con, $sql)) {
            return true;
        }
    }

}

?>