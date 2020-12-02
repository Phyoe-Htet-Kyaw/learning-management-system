<?php

class Quize extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function quizDoneIndex(){
        $sql = "SELECT * FROM quiz_done ORDER BY id DESC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function quizQuestionCount($id){
        $sql = "SELECT COUNT(*) AS count FROM quize_question WHERE quize_title_id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function quizResultIndex(){
        $sql = "SELECT * FROM quiz_result ORDER BY id DESC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

}

?>