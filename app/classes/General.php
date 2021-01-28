<?php

class General extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function showAssignment($id){
        $sql = "SELECT * FROM assignment WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function showJournal($id){
        $sql = "SELECT * FROM journal WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function showQuiz($id){
        $sql = "SELECT * FROM quize_title WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function checkAssignmentDone($id){
        $sql = "SELECT COUNT(*) AS count FROM assignment_done WHERE assignment_id=:id AND user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function checkJournalDone($id){
        $sql = "SELECT COUNT(*) AS count FROM journal_done WHERE journal_id=:id AND user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function checkQuizDone($id){
        $sql = "SELECT COUNT(*) AS count FROM quiz_done WHERE quiz_title_id=:id AND user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function quizeRender($id){
        $sql = "SELECT * FROM quize_question WHERE quize_title_id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function checkAnswer($request, $id, $quiz_id){
        if(isset($request['submit'])){
            if(isset($request['answer'])){
                $answer = $request['answer'];
                if($answer == ""){
                    echo "<p class='alert alert-danger'>Please choose answer!</p>";
                }else{
                    if(isset($_SESSION['result'])){
                        $result_arr = $_SESSION['result'];
                        $sql = "SELECT * FROM quize_question WHERE id=:id";
                        $stmt = $this->con->prepare($sql);
                        $stmt->bindParam("id", $id, PDO::PARAM_INT);
                        $stmt->execute();
                        $res = $stmt->fetch(PDO::FETCH_OBJ);
                        if($res->true_answer_no ==  $request['answer']){
                            array_push($result_arr, ["quiz_id" => $quiz_id, "question_id" => $id, "result" => 1, "user_id" => $_SESSION['user_id']]);
                            $_SESSION['result'] = $result_arr;
                        }else{
                            array_push($result_arr, ["quiz_id" => $quiz_id, "question_id" => $id, "result" => 0, "user_id" => $_SESSION['user_id']]);
                            $_SESSION['result'] = $result_arr;
                        }
                        return true;
                    }else{
                        $_SESSION['result'] = [];
                        $sql = "SELECT * FROM quize_question WHERE id=:id";
                        $stmt = $this->con->prepare($sql);
                        $stmt->bindParam("id", $id, PDO::PARAM_INT);
                        $stmt->execute();
                        $res = $stmt->fetch(PDO::FETCH_OBJ);
                        if($res->true_answer_no ==  $request['answer']){
                            array_push($_SESSION['result'], ["quiz_id" => $quiz_id, "question_id" => $id, "result" => 1, "user_id" => $_SESSION['user_id']]);
                        }else{
                            array_push($_SESSION['result'], ["quiz_id" => $quiz_id, "question_id" => $id, "result" => 0, "user_id" => $_SESSION['user_id']]);
                        }
                        return true;
                    }
                }
            }else{
                echo "<p class='alert alert-danger'>Please choose answer!</p>";
            }
        }
    }

    public function calculateQuizMark(){
        $quiz_result = $_SESSION['result'];
        $marks = 0;
        foreach($quiz_result as $value){
            $marks += $value['result'];
        }

        $quiz_title_id = $quiz_result[count($quiz_result) - 1]['quiz_id'];
        $user_id = $quiz_result[count($quiz_result) - 1]['user_id'];

        $sql = "INSERT INTO quiz_done (quiz_title_id, user_id, marks) VALUES (:quiz_title_id, :user_id, :marks)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("quiz_title_id", $quiz_title_id, PDO::PARAM_INT);
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam("marks", $marks, PDO::PARAM_INT);
        $stmt->execute();

        foreach($quiz_result as $value){
            $sec_sql = "INSERT INTO quiz_result (quiz_title_id, question_id, result, user_id) VALUES (:quiz_title_id, :question_id, :result, :user_id)";
            $sec_stmt = $this->con->prepare($sec_sql);
            $sec_stmt->bindParam("quiz_title_id", $value['quiz_id'], PDO::PARAM_INT);
            $sec_stmt->bindParam("question_id", $value['question_id'], PDO::PARAM_INT);
            $sec_stmt->bindParam("result", $value['result'], PDO::PARAM_INT);
            $sec_stmt->bindParam("user_id", $value['user_id'], PDO::PARAM_INT);
            $sec_stmt->execute();
        }

        $_SESSION['result'] = [];
        return true;
    }

    public function checkQuizFinishOrNot($quiz_title_id){
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM quiz_done WHERE quiz_title_id=:quiz_title_id AND user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("quiz_title_id", $quiz_title_id, PDO::PARAM_INT);
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function showMarks($quiz_title_id){
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM quiz_done WHERE quiz_title_id=:quiz_title_id AND user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("quiz_title_id", $quiz_title_id, PDO::PARAM_INT);
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function countAssignment(){
        $sql = "SELECT COUNT(*) AS count FROM assignment";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function countQuiz(){
        $sql = "SELECT COUNT(*) AS count FROM quize_title";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function countGrade(){
        $sql = "SELECT COUNT(*) AS count FROM grade";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function countJournal(){
        $sql = "SELECT COUNT(*) AS count FROM journal";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function countUser(){
        $sql = "SELECT COUNT(*) AS count FROM users";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function countAssignmentByUser(){
        $sql = "SELECT COUNT(*) AS count FROM assignment WHERE user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("user_id", $_SESSION['admin_id'], PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function countQuizByUser(){
        $sql = "SELECT COUNT(*) AS count FROM quize_title WHERE user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("user_id", $_SESSION['admin_id'], PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function countJournalByUser(){
        $sql = "SELECT COUNT(*) AS count FROM journal WHERE user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("user_id", $_SESSION['admin_id'], PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function fetchAssignmentByDate($date){
        $user = $this->getUserData();
        $sql = "SELECT * FROM assignment WHERE start_date=:start_date AND grade_id=:grade_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("start_date", $date, PDO::PARAM_STR);
        $stmt->bindParam("grade_id", $user->grade_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function fetchJournalByDate($date){
        $user = $this->getUserData();
        $sql = "SELECT * FROM journal WHERE start_date=:start_date AND grade_id=:grade_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("start_date", $date, PDO::PARAM_STR);
        $stmt->bindParam("grade_id", $user->grade_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function fetchQuizByDate($date){
        $user = $this->getUserData();
        $sql = "SELECT * FROM quize_title WHERE start_date=:start_date AND grade_id=:grade_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("start_date", $date, PDO::PARAM_STR);
        $stmt->bindParam("grade_id", $user->grade_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function getUserData(){
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }
}

?>