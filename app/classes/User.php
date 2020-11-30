<?php

class User extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function index(){
        $sql = "SELECT * FROM users";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
}

?>