<?php

class QuizeTitle extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function index(){
        $sql = "SELECT * FROM quize_title ORDER BY id DESC";
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
            $quize_title = $request['quize_title'];
            $grade_id = $request['grade_id'];
            $user_id = $_SESSION['user_id'];
            $start_date = $request['start_date'];
            $end_date = $request['end_date'];

            if($quize_title == ""){
                echo "<p class='alert alert-danger'>Please enter quize title!</p>";
            }else{
                if($grade_id == ""){
                    echo "<p class='alert alert-danger'>Please select Year!</p>";
                }else{
                    if($start_date == ""){
                        echo "<p class='alert alert-danger'>Please select start date!</p>";
                    }else{
                        if($end_date == ""){
                            echo "<p class='alert alert-danger'>Please select end date!</p>";
                        }else{
                            $sql = "INSERT INTO quize_title (quize_title, grade_id, user_id, start_date, end_date) VALUES (:quize_title, :grade_id, :user_id, :start_date, :end_date)";
                            $stmt = $this->con->prepare($sql);
                            $stmt->bindParam("quize_title", $quize_title, PDO::PARAM_STR);
                            $stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                            $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                            $stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                            $stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                            $stmt->execute();
                            return true;
                        }
                    }
                }
            }
        }
    }

    public function fetchById($id){
        $sql = "SELECT * FROM quize_title WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($request, $id){
        if(isset($request['submit'])){
            $quize_title = $request['quize_title'];
            $grade_id = $request['grade_id'];
            $user_id = $_SESSION['user_id'];
            $start_date = $request['start_date'];
            $end_date = $request['end_date'];

            if($quize_title == ""){
                echo "<p class='alert alert-danger'>Please enter quize title!</p>";
            }else{
                if($grade_id == ""){
                    echo "<p class='alert alert-danger'>Please select Year!</p>";
                }else{
                    if($start_date == ""){
                        echo "<p class='alert alert-danger'>Please select start date!</p>";
                    }else{
                        if($end_date == ""){
                            echo "<p class='alert alert-danger'>Please select end date!</p>";
                        }else{
                            $sql = "UPDATE quize_title SET quize_title=:quize_title, grade_id=:grade_id, user_id=:user_id, start_date=:start_date, end_date=:end_date WHERE id=:id";
                            $stmt = $this->con->prepare($sql);
                            $stmt->bindParam("quize_title", $quize_title, PDO::PARAM_STR);
                            $stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                            $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                            $stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                            $stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                            $stmt->bindParam("id", $id, PDO::PARAM_INT);
                            $stmt->execute();
                            return true;
                        }
                    }
                }
            }
        }
    }

    public function delete($id){
        $sql = "DELETE FROM quize_title WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $sql = "DELETE FROM queue WHERE quize_id=:id";
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