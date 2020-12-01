<?php

class QuizeQuestion extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function index(){
        $sql = "SELECT * FROM quize_question ORDER BY id DESC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function fetchGrade(){
        $sql = "SELECT * FROM grade";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function store($request){
        if(isset($request['submit'])){
            $quize_question = $request['quize_question'];
            $quize_title_id = $request['quize_title_id'];
            $answer_a = $request['answer_a'];
            $answer_b = $request['answer_b'];
            $answer_c = $request['answer_c'];
            $true_answer = $request['true_answer'];
            $user_id = $_SESSION['user_id'];

            if($quize_question == ""){
                echo "<p class='alert alert-danger'>Please enter assignment title!</p>";
            }else{
                if($quize_title_id == ""){
                    echo "<p class='alert alert-danger'>Please enter Quize Title!</p>";
                }else{
                    if($answer_a == ""){
                        echo "<p class='alert alert-danger'>Please enter answer a!</p>";
                    }else{
                        if($answer_b == ""){
                            echo "<p class='alert alert-danger'>Please enter answer b!</p>";
                        }else{
                            if($answer_c == ""){
                                echo "<p class='alert alert-danger'>Please enter answer c!</p>";
                            }else{
                                if($true_answer == ""){
                                    echo "<p class='alert alert-danger'>Please select true answer!</p>";
                                }else{
                                    $sql = "INSERT INTO quize_question (quize_title_id, question, answer_1, answer_2, answer_3, true_answer_no, user_id) VALUES (:quize_title_id, :question, :answer_1, :answer_2, :answer_3, :true_answer_no, :user_id)";
                                    $stmt = $this->con->prepare($sql);
                                    $stmt->bindParam("quize_title_id", $quize_title_id, PDO::PARAM_INT);
                                    $stmt->bindParam("question", $quize_question, PDO::PARAM_STR);
                                    $stmt->bindParam("answer_1", $answer_a, PDO::PARAM_STR);
                                    $stmt->bindParam("answer_2", $answer_b, PDO::PARAM_STR);
                                    $stmt->bindParam("answer_3", $answer_c, PDO::PARAM_STR);
                                    $stmt->bindParam("true_answer_no", $true_answer, PDO::PARAM_INT);
                                    $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                    $stmt->execute();
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function fetchById($id){
        $sql = "SELECT * FROM quize_question WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($request, $id){
        if(isset($request['submit'])){
            $quize_question = $request['quize_question'];
            $quize_title_id = $request['quize_title_id'];
            $answer_a = $request['answer_a'];
            $answer_b = $request['answer_b'];
            $answer_c = $request['answer_c'];
            $true_answer = $request['true_answer'];
            $user_id = $_SESSION['user_id'];

            if($quize_question == ""){
                echo "<p class='alert alert-danger'>Please enter assignment title!</p>";
            }else{
                if($quize_title_id == ""){
                    echo "<p class='alert alert-danger'>Please enter Quize Title!</p>";
                }else{
                    if($answer_a == ""){
                        echo "<p class='alert alert-danger'>Please enter answer a!</p>";
                    }else{
                        if($answer_b == ""){
                            echo "<p class='alert alert-danger'>Please enter answer b!</p>";
                        }else{
                            if($answer_c == ""){
                                echo "<p class='alert alert-danger'>Please enter answer c!</p>";
                            }else{
                                if($true_answer == ""){
                                    echo "<p class='alert alert-danger'>Please select true answer!</p>";
                                }else{
                                    $sql = "UPDATE quize_question SET quize_title_id=:quize_title_id, question=:question, answer_1=:answer_1, answer_2=:answer_2, answer_3=:answer_3, true_answer_no=:true_answer_no, user_id=:user_id WHERE id=:id";
                                    $stmt = $this->con->prepare($sql);
                                    $stmt->bindParam("quize_title_id", $quize_title_id, PDO::PARAM_INT);
                                    $stmt->bindParam("question", $quize_question, PDO::PARAM_STR);
                                    $stmt->bindParam("answer_1", $answer_a, PDO::PARAM_STR);
                                    $stmt->bindParam("answer_2", $answer_b, PDO::PARAM_STR);
                                    $stmt->bindParam("answer_3", $answer_c, PDO::PARAM_STR);
                                    $stmt->bindParam("true_answer_no", $true_answer, PDO::PARAM_INT);
                                    $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                    $stmt->bindParam("id", $id, PDO::PARAM_INT);
                                    $stmt->execute();
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function delete($id){
        $sql = "DELETE FROM quize_question WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public function fetchGradeById($id){
        $sql = "SELECT * FROM grade WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function fetchUserById($id){
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function reportAssignment($request, $file){
        if(isset($request['submit'])){
            $assignment_id = $request['assignment_id'];
            $user_id = $_SESSION['user_id'];
            $file_name = $file['assignment']['name'];
            $file_tmp = $file['assignment']['tmp_name'];
            $file_ext_3 = explode('.',$file['assignment']['name']);
            $file_ext_2 = end($file_ext_3);
            $file_ext = strtolower($file_ext_2);
            $uploads = 'assets/uploads/';

            $extensions= array("pdf");

            if($file_name == ""){
                echo "<p class='alert alert-danger'>Please choose file!</p>";
            }else{
                if(in_array($file_ext,$extensions) === false){
                    echo "<p class='alert alert-danger'>Please choose pdf file!</p>";
                }else{
                    move_uploaded_file($file_tmp, $uploads.$file_name);


                    $sql = "INSERT INTO assignment_done (assignment_id, user_id, file) VALUES (:assignment_id, :user_id, :file)";
                    $stmt = $this->con->prepare($sql);
                    $stmt->bindParam('assignment_id', $assignment_id, PDO::PARAM_INT);
                    $stmt->bindParam('user_id', $user_id, PDO::PARAM_INT);
                    $stmt->bindParam('file', $file_name, PDO::PARAM_STR);
                    $stmt->execute();
                    return true;
                }
            }
        }
    }

    public function checkAssignmentReportOrNot($id){
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM assignment_done WHERE assignment_id=:assignment_id AND user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("assignment_id", $id, PDO::PARAM_INT);
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        if(is_object($res)){
            return true;
        }else{
            return false;
        }
    }

    public function selectAssignmentDone(){
        $sql = "SELECT * FROM assignment_done ORDER BY id DESC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
}

?>