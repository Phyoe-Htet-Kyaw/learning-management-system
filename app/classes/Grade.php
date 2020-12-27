<?php

class Grade extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function index(){
        $sql = "SELECT * FROM grade ORDER BY id DESC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function store($request){
        if(isset($request['submit'])){
            $grade_name = $request['grade_name'];

            if($grade_name == ""){
                echo "<p class='alert alert alert-danger'>Please enter year!</p>";
            }else{
                $sql = "INSERT INTO grade (grade_name) VALUES (:grade_name)";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam("grade_name", $grade_name, PDO::PARAM_STR);
                $stmt->execute();
                return true;
            }
        }
    }

    public function fetchById($id){
        $sql = "SELECT * FROM grade WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($request, $id){
        if(isset($request['submit'])){
            $grade_name = $request['grade_name'];

            if($grade_name == ""){
                echo "<p class='alert alert-danger'>Please enter year!</p>";
            }else{
                $sql = "UPDATE grade SET grade_name=:grade_name WHERE id=:id";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam("grade_name", $grade_name, PDO::PARAM_STR);
                $stmt->bindParam("id", $id, PDO::PARAM_INT);
                $stmt->execute();
                return true;
            }
        }
    }

    public function delete($id){
        $sql = "DELETE FROM grade WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>