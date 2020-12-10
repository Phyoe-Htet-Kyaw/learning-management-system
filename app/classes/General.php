<?php

class General extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function checkMain(){
        $today = date('Y-m-d');
        
        $user_id = $_SESSION['user_id'];
        $user_sql = "SELECT * FROM users WHERE id=:id";
        $user_stmt = $this->con->prepare($user_sql);
        $user_stmt->bindParam("id", $user_id, PDO::PARAM_INT);
        $user_stmt->execute();
        $user_res = $user_stmt->fetch(PDO::PARAM_INT);
        $grade_id = $user_res->grade_id;

        $sql = "SELECT * FROM queue WHERE grade_id=:grade_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        $date_arr = [];
        foreach($res as $value){
            $start_date = new DateTime($value->start_date);
            $end_date = new DateTime($value->end_date);


            $date1 = strtotime($value->start_date);
            $date2 = strtotime($value->end_date);

            $diff = abs($date2 - $date1);  
            $years = floor($diff / (365*60*60*24));  
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 

            $i = 0;
            array_push($date_arr, ["id" => $value->id, "date" => $start_date->format('Y-m-d')]);
            do{
                $start_date->modify('+1 day');
                array_push($date_arr, ["id" => $value->id, "date" => $start_date->format('Y-m-d')]);
                $i++;
            }while($i < $days);
        }

        foreach($date_arr as $value){
            if($value['date'] == $today){
                $queue_id = $value['id'];

                $sec_sql = "SELECT * FROM queue WHERE id=:id";
                $sec_stmt = $this->con->prepare($sec_sql);
                $sec_stmt->bindParam("id", $queue_id, PDO::PARAM_INT);
                $sec_stmt->execute();
                $sec_res = $sec_stmt->fetch(PDO::FETCH_OBJ);
                if($sec_res->quize_id == null){
                    if($sec_res->assignment_id == null){
                        if($sec_res->journal_id == null){
                            return false;
                        }else{
                            $journal_id = $sec_res->journal_id;
                            $fourth_sql = "SELECT * FROM journal WHERE id=:id";
                            $fourth_stmt = $this->con->prepare($fourth_sql);
                            $fourth_stmt->bindParam("id", $journal_id, PDO::PARAM_INT);
                            $fourth_stmt->execute();
                            $fourth_res = $fourth_stmt->fetch(PDO::FETCH_OBJ);
                            return $fourth_res;
                        }
                    }else{
                        $assignment_id = $sec_res->assignment_id;
                        $third_sql = "SELECT * FROM assignment WHERE id=:id";
                        $third_stmt = $this->con->prepare($third_sql);
                        $third_stmt->bindParam("id", $assignment_id, PDO::PARAM_INT);
                        $third_stmt->execute();
                        $third_res = $third_stmt->fetch(PDO::FETCH_OBJ);
                        return $third_res;
                    }
                }else{
                    $quize_id = $sec_res->quize_id;
                    $fifth_sql = "SELECT * FROM quize_title WHERE id=:id";
                    $fifth_stmt = $this->con->prepare($fifth_sql);
                    $fifth_stmt->bindParam("id", $quize_id, PDO::PARAM_INT);
                    $fifth_stmt->execute();
                    $fifth_res = $fifth_stmt->fetch(PDO::FETCH_OBJ);
                    return $fifth_res;
                }
            }
        }
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
}

?>