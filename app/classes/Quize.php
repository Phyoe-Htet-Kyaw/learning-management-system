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

    public function QuizDoneUploader($id){
        $first_sql = "SELECT * FROM quize_title WHERE id=:id";
        $first_stmt = $this->con->prepare($first_sql);
        $first_stmt->bindParam('id', $id, PDO::PARAM_INT);
        $first_stmt->execute();
        $first_res = $first_stmt->fetch(PDO::FETCH_OBJ);
        $user_id = $first_res->user_id;


        $sec_sql = "SELECT * FROM users WHERE id=:user_id";
        $sec_stmt = $this->con->prepare($sec_sql);
        $sec_stmt->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $sec_stmt->execute();
        $sec_res = $sec_stmt->fetch(PDO::FETCH_OBJ);
        return $sec_res;
    }

    public function userQuizDone(){
        $sql = "SELECT * FROM quize_title WHERE user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("user_id", $_SESSION['admin_id'], PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

}

?>