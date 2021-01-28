<?php

class Journal extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function index(){
        $sql = "SELECT * FROM journal ORDER BY id DESC";
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

    public function store($request, $file){
        if(isset($request['submit'])){
            $journal_title = $request['journal_title'];
            $instruction = $request['instruction'];
            $grade_id = $request['grade_id'];
            $user_id = $_SESSION['user_id'];
            $start_date = $request['start_date'];
            $end_date = $request['end_date'];
            $file_name = $file['pdf']['name'];
            $file_tmp = $file['pdf']['tmp_name'];
            $file_ext_3 = explode('.',$file['pdf']['name']);
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


                    if($journal_title == ""){
                        echo "<p class='alert-danger'>Please enter journal title!</p>";
                    }else{
                        if($instruction == ""){
                            echo "<p class='alert-danger'>Please enter instruction!</p>";
                        }else{
                            if($grade_id == ""){
                                echo "<p class='alert-danger'>Please select Year!</p>";
                            }else{
                                if($start_date == ""){
                                    echo "<p class='alert-danger'>Please select start date!</p>";
                                }else{
                                    if($end_date == ""){
                                        echo "<p class='alert-danger'>Please select end date!</p>";
                                    }else{
                                        $sql = "INSERT INTO journal (journal_title, instruction, grade_id, user_id, start_date, end_date, pdf) VALUES (:journal_title, :instruction, :grade_id, :user_id, :start_date, :end_date, :file)";
                                        $stmt = $this->con->prepare($sql);
                                        $stmt->bindParam("journal_title", $journal_title, PDO::PARAM_STR);
                                        $stmt->bindParam("instruction", $instruction, PDO::PARAM_STR);
                                        $stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                        $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                        $stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                        $stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                        $stmt->bindParam('file', $file_name, PDO::PARAM_STR);
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
    }

    public function fetchById($id){
        $sql = "SELECT * FROM journal WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($request, $file, $id){
        if(isset($request['submit'])){
            $journal_title = $request['journal_title'];
            $instruction = $request['instruction'];
            $grade_id = $request['grade_id'];
            $user_id = $_SESSION['user_id'];
            $start_date = $request['start_date'];
            $end_date = $request['end_date'];
            $file_name = $file['pdf']['name'];
            $file_tmp = $file['pdf']['tmp_name'];
            $file_ext_3 = explode('.',$file['pdf']['name']);
            $file_ext_2 = end($file_ext_3);
            $file_ext = strtolower($file_ext_2);
            $uploads = 'assets/uploads/';

            $extensions= array("pdf");

            if($file_name == ""){
                if($journal_title == ""){
                    echo "<p class='alert-danger'>Please enter journal title!</p>";
                }else{
                    if($instruction == ""){
                        echo "<p class='alert-danger'>Please enter instruction!</p>";
                    }else{
                        if($grade_id == ""){
                            echo "<p class='alert-danger'>Please select Year!</p>";
                        }else{
                            if($start_date == ""){
                                echo "<p class='alert-danger'>Please select start date!</p>";
                            }else{
                                if($end_date == ""){
                                    echo "<p class='alert-danger'>Please select end date!</p>";
                                }else{
                                    $sql = "UPDATE journal SET journal_title=:journal_title, instruction=:instruction, grade_id=:grade_id, user_id=:user_id, start_date=:start_date, end_date=:end_date WHERE id=:id";
                                    $stmt = $this->con->prepare($sql);
                                    $stmt->bindParam("journal_title", $journal_title, PDO::PARAM_STR);
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
            }else{
                if(in_array($file_ext,$extensions) === false){
                    echo "<p class='alert alert-danger'>Please choose pdf file!</p>";
                }else{

                    $unlink_sql = "SELECT * FROM journal WHERE id=:id";
                    $unlink_stmt = $this->con->prepare($unlink_sql);
                    $unlink_stmt->bindParam("id", $id, PDO::PARAM_INT);
                    $unlink_stmt->execute();
                    $unlink_res = $unlink_stmt->fetch(PDO::FETCH_OBJ);

                    unlink("assets/uploads/".$unlink_res->pdf);

                    move_uploaded_file($file_tmp, $uploads.$file_name);


                    if($journal_title == ""){
                        echo "<p class='alert-danger'>Please enter journal title!</p>";
                    }else{
                        if($instruction == ""){
                            echo "<p class='alert-danger'>Please enter instruction!</p>";
                        }else{
                            if($grade_id == ""){
                                echo "<p class='alert-danger'>Please select Year!</p>";
                            }else{
                                if($start_date == ""){
                                    echo "<p class='alert-danger'>Please select start date!</p>";
                                }else{
                                    if($end_date == ""){
                                        echo "<p class='alert-danger'>Please select end date!</p>";
                                    }else{
                                        $sql = "UPDATE journal SET journal_title=:journal_title, instruction=:instruction, grade_id=:grade_id, user_id=:user_id, start_date=:start_date, end_date=:end_date, pdf=:file WHERE id=:id";
                                        $stmt = $this->con->prepare($sql);
                                        $stmt->bindParam("journal_title", $journal_title, PDO::PARAM_STR);
                                        $stmt->bindParam("instruction", $instruction, PDO::PARAM_STR);
                                        $stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                        $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                        $stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                        $stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                        $stmt->bindParam('file', $file_name, PDO::PARAM_STR);
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
    }

    public function delete($id){

        $unlink_sql = "SELECT * FROM journal WHERE id=:id";
        $unlink_stmt = $this->con->prepare($unlink_sql);
        $unlink_stmt->bindParam("id", $id, PDO::PARAM_INT);
        $unlink_stmt->execute();
        $unlink_res = $unlink_stmt->fetch(PDO::FETCH_OBJ);

        unlink("assets/uploads/".$unlink_res->pdf);
        
        $sql = "DELETE FROM journal WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $sql = "DELETE FROM queue WHERE journal_id=:id";
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

    public function reportJournal($journal_id, $user_id){
        $sql = "INSERT INTO journal_done (journal_id, user_id) VALUES (:journal_id, :user_id)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("journal_id", $journal_id, PDO::PARAM_INT);
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public function checkJournalReportOrNot($id){
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM journal_done WHERE journal_id=:journal_id AND user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("journal_id", $id, PDO::PARAM_INT);
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        if(is_object($res)){
            return true;
        }else{
            return false;
        }
    }

    public function selectJournalDone(){
        $sql = "SELECT * FROM journal_done ORDER BY id DESC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function journalUploader($id){
        $first_sql = "SELECT * FROM journal WHERE id=:id";
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

    public function userJournal(){
        $sql = "SELECT * FROM journal WHERE user_id=:user_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("user_id", $_SESSION['admin_id'], PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
}

?>