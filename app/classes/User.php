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

    public function currentUser(){
        $id = $_SESSION['user_id'];
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function switchUser($id){

        $status_sql = "SELECT * FROM users WHERE id=:id";
        $status_stmt = $this->con->prepare($status_sql);
        $status_stmt->bindParam("id", $id, PDO::PARAM_INT);
        $status_stmt->execute();
        $status_res = $status_stmt->fetch(PDO::FETCH_OBJ);

        if($status_res->status == 0){
            $status = 1;
        }else{
            $status = 0;
        }

        $sql = "UPDATE users SET status=:status WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("status", $status, PDO::PARAM_INT);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public function fetchById($id){
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }
}

?>