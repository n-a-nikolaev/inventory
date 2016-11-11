<?php

class DB
{
    protected $db_name = 'inventory';
    protected $db_user = 'root';
    protected $db_pass = '';
    protected $db_host = 'localhost';


    function __construct() {
    }

    public function connect() {
        $connection = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        mysqli_set_charset($connection,'utf8');
        if (!$connection) {
            die("Unable to connect to MySQL");
            exit();
        }
        mysqli_select_db($connection, $this->db_name);

        return $connection;
    }

    public function procces_row_set($row_set){
        $result_arr = array();

        while ($row = mysqli_fetch_assoc($row_set)) {
            array_push($result_arr, $row);
        }

        return $result_arr;
    }


    public function select($query){
        $result = mysqli_query($this->connect(), $query);
        $row_cnt = mysqli_num_rows($result);

        return $this->procces_row_set($result);
    }

    public function update($data, $table, $where){
        foreach ($data as $column => $value) {
            $query = "UPDATE $table SET $column = $value WHERE $where";
            mysqli_query($this->connect(), $query) or die(mysqli_error($this->connect()));
        }
        return true;
    }

    public function insert($data, $table){
        $connection = $this->connect();
        $columns = "";
        $values = "";

        foreach ($data as $column => $value) {
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $column;
            $values .= ($values == "") ? "" : ", ";
            $values .= $value;
        }

        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        mysqli_query($connection, $query) or die(mysqli_error($this->connect()));

        //return the ID of the user in the database.
        return mysqli_insert_id($connection);
    }
}
