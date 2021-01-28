<?php

class Assignment extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function index(){
        $sql = "SELECT * FROM assignment ORDER BY id DESC";
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
            $assignment_title = $request['assignment_title'];
            $instruction = $request['instruction'];
            $grade_id = $request['grade_id'];
            $user_id = $_SESSION['user_id'];
            $start_date = $request['start_date'];
            $end_date = $request['end_date'];

            if($assignment_title == ""){
                echo "<p class='alert alert-danger'>Please enter assignment title!</p>";
            }else{
                if($instruction == ""){
                    echo "<p class='alert alert-danger'>Please enter instruction!</p>";
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

                                $sql = "INSERT INTO assignment (assignment_title, instruction, grade_id, user_id, start_date, end_date) VALUES (:assignment_title, :instruction, :grade_id, :user_id, :start_date, :end_date)";
                                $stmt = $this->con->prepare($sql);
                                $stmt->bindParam("assignment_title", $assignment_title, PDO::PARAM_STR);
                                $stmt->bindParam("instruction", $instruction, PDO::PARAM_STR);
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
    }

    public function fetchById($id){
        $sql = "SELECT * FROM assignment WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($request, $id){
        if(isset($request['submit'])){
            $assignment_title = $request['assignment_title'];
            $instruction = $request['instruction'];
            $grade_id = $request['grade_id'];
            $user_id = $_SESSION['user_id'];
            $start_date = $request['start_date'];
            $end_date = $request['end_date'];

            if($assignment_title == ""){
                echo "<p class='alert alert-danger'>Please enter assignment title!</p>";
            }else{
                if($instruction == ""){
                    echo "<p class='alert alert-danger'>Please enter instruction!</p>";
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
                                $sql = "UPDATE assignment SET assignment_title=:assignment_title, instruction=:instruction, grade_id=:grade_id, user_id=:user_id, start_date=:start_date, end_date=:end_date WHERE id=:id";
                                $stmt = $this->con->prepare($sql);
                                $stmt->bindParam("assignment_title", $assignment_title, PDO::PARAM_STR);
                                $stmt->bindParam("instruction", $instruction, PDO::PARAM_STR);
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
    }

    public function delete($id){
        $sql = "DELETE FROM assignment WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $sql = "DELETE FROM queue WHERE assignment_id=:id";
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

    public function assignmentUploader($id){
        $first_sql = "SELECT * FROM assignment WHERE id=:id";
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

    public function userAssignment(){
        $sql = "SELECT * FROM assignment WHERE user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("user_id", $_SESSION['admin_id'], PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
}

?>