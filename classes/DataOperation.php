<?php

class DataOperation {

    private $con;

    function __construct() {
        include_once("db.php");
        $db = new Database();
        $this->con = $db->connect();
    }

    public function selectAll() {
        $sql = "SELECT m.model_id AS model_id, m.model_name AS model_name, 
                        mf.manufacturer_name AS manufacturer_name, 
                        IF(m.model_count = NULL OR m.model_count = '0', 'Sold Out', m.model_count) AS model_count 
                        FROM models m INNER JOIN manufacturers mf ON mf.manufacturer_id = m.manufacturer_id";

        $result = mysqli_query($this->con, $sql);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            return $rows;
        }
    }

    public function select($id) {
        $sql = "SELECT m.model_id AS model_id, m.model_name AS model_name, 
                        mf.manufacturer_name AS manufacturer_name, m.model_color AS model_color, m.model_year,
                        m.model_regno, m.model_note, m.image1, m.image2,
                        m.model_count AS model_count 
                        FROM manufacturers mf LEFT JOIN models m ON mf.manufacturer_id = m.manufacturer_id 
                        WHERE m.model_id = $id";
        $result = mysqli_query($this->con, $sql);
        if ($result->num_rows == 1) {
            $row = mysqli_fetch_assoc($result);
        }
        return $row;
    }

    public function manageRecordWithPagination($table, $pno) {
        $a = $this->pagination($this->con, $table, $pno, 5);

        if ($table == "categories") {
            $sql = "SELECT p.cid,p.category_name as category, c.category_name as parent, p.status FROM categories p LEFT JOIN categories c ON p.parent_cat=c.cid " . $a["limit"];
        } else if ($table == "products") {
            $sql = "SELECT p.pid,p.product_name,c.category_name,b.brand_name,p.product_price,p.product_stock,p.added_date,p.p_status FROM products p,brands b,categories c WHERE p.bid = b.bid AND p.cid = c.cid " . $a["limit"];
        } else if ($table == "models") {
            $sql = "SELECT m.model_id,m.model_name,manufacturer.manufacturer_name,m.model_count FROM models m,manufacturers manufacturer WHERE m.manufacturer_id = manufacturer.manufacturer_id " . $a["limit"];
        } else {
            $sql = "SELECT * FROM " . $table . " " . $a["limit"];
        }
        //  echo $sql;   exit;
        $result = $this->con->query($sql) or die($this->con->error);
        $rows = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return ["rows" => $rows, "pagination" => $a["pagination"]];
    }

    private function pagination($con, $table, $pno, $n) {
        $query = $con->query("SELECT COUNT(*) as rows FROM " . $table);
        $row = mysqli_fetch_assoc($query);
        //$totalRecords = 100000;
        $pageno = $pno;
        $numberOfRecordsPerPage = $n;

        $last = ceil($row["rows"] / $numberOfRecordsPerPage);

        $pagination = "<ul class='pagination'>";

        if ($last != 1) {
            if ($pageno > 1) {
                $previous = "";
                $previous = $pageno - 1;
                $pagination .= "<li class='page-item'><a class='page-link' pn='" . $previous . "' href='#' style='color:#333;'> Previous </a></li></li>";
            }
            for ($i = $pageno - 5; $i < $pageno; $i++) {
                if ($i > 0) {
                    $pagination .= "<li class='page-item'><a class='page-link' pn='" . $i . "' href='#'> " . $i . " </a></li>";
                }
            }
            $pagination .= "<li class='page-item'><a class='page-link' pn='" . $pageno . "' href='#' style='color:#333;'> $pageno </a></li>";
            for ($i = $pageno + 1; $i <= $last; $i++) {
                $pagination .= "<li class='page-item'><a class='page-link' pn='" . $i . "' href='#'> " . $i . " </a></li>";
                if ($i > $pageno + 4) {
                    break;
                }
            }
            if ($last > $pageno) {
                $next = $pageno + 1;
                $pagination .= "<li class='page-item'><a class='page-link' pn='" . $next . "' href='#' style='color:#333;'> Next </a></li></ul>";
            }
        }
        //LIMIT 0,10
        //LIMIT 20,10
        $limit = "LIMIT " . ($pageno - 1) * $numberOfRecordsPerPage . "," . $numberOfRecordsPerPage;

        return ["pagination" => $pagination, "limit" => $limit];
    }

    public function insert_record($table, $fileds) {

        $sql = "";
        $sql .= "INSERT INTO " . $table;
        $sql .= " (" . implode(",", array_keys($fileds)) . ") VALUES ";
        $sql .= "('" . implode("','", array_values($fileds)) . "')";

        $query = mysqli_query($this->con, $sql);
        if ($query) {
            return true;
        }
    }


    public function fetch_record() {
        $sql = "SELECT * FROM " . $this->table;
        $array = array();
        $query = mysqli_query($this->con, $sql);

        if ($query->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $rows[] = $row;
            }
            return $rows;
        }
        return "NO_DATA";
    }

    public function select_record($table, $where) {
        $sql = "";
        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= $key . "='" . $value . "' AND ";
        }
        $condition = substr($condition, 0, -5);
        $sql .= "SELECT * FROM " . $table . " WHERE " . $condition;
        $query = mysqli_query($this->con, $sql);


        if ($query->num_rows == 1) {
            $row = mysqli_fetch_assoc($query);
        }
        return $row;
    }

   
    public function update_record($table, $where, $fields) {
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
        $sql = "UPDATE " . $table . " SET " . $sql . " WHERE " . $condition;
        if (mysqli_query($this->con, $sql)) {
            return true;
        }
    }

    public function delete_record($table, $where) {
        $sql = "";
        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= $key . "='" . $value . "' AND ";
        }
        $condition = substr($condition, 0, -5);
        $sql = "DELETE FROM " . $table . " WHERE " . $condition;
//        if (mysqli_query($this->con, $sql)) {
//            return true;
//        }
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            return "DELETED";
        }
    }

}

?>