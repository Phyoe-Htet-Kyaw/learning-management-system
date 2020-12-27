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

                            $fourth_sql = "SELECT * FROM queue WHERE grade_id=:grade_id";
                            $fourth_stmt = $this->con->prepare($fourth_sql);
                            $fourth_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                            $fourth_stmt->execute();
                            $isset_quize = $fourth_stmt->fetchAll(PDO::FETCH_OBJ);

                            if(count($isset_quize) > 0){

                                $fifth_sql = "SELECT * FROM queue";
                                $fifth_stmt = $this->con->prepare($fifth_sql);
                                $fifth_stmt->execute();
                                $isset_queue = $fifth_stmt->fetchAll(PDO::FETCH_OBJ);
                                $date_arr = [];
                                foreach($isset_queue as $value){
                                    $start_date_cal = new DateTime($value->start_date);
                                    $end_date_cal = new DateTime($value->end_date);

                                    $date1 = strtotime($value->start_date);
                                    $date2 = strtotime($value->end_date);

                                    $diff = abs($date2 - $date1);  
                                    $years = floor($diff / (365*60*60*24));  
                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                                    
                                    $i = 0;
                                    array_push($date_arr, $start_date_cal->format('Y-m-d'));
                                    do{
                                        $start_date_cal->modify('+1 day');
                                        array_push($date_arr, $start_date_cal->format('Y-m-d'));
                                        $i++;
                                    }while($i < $days);
                                }
                                
                                $origin_date_arr = [];
                                $start_date_origin = new DateTime($start_date);
                                $end_date_origin = new DateTime($end_date);
                                
                                $date1 = strtotime($start_date);
                                $date2 = strtotime($end_date);
                                
                                $diff = abs($date2 - $date1);  
                                $years = floor($diff / (365*60*60*24));  
                                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
                                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                                
                                $i = 0;
                                array_push($origin_date_arr, $start_date_origin->format('Y-m-d'));
                                do{
                                    $start_date_origin->modify('+1 day');
                                    array_push($origin_date_arr, $start_date_origin->format('Y-m-d'));
                                    $i++;
                                }while($i < $days);

                                $date_status = true;
                                foreach($date_arr as $value_1){
                                    foreach($origin_date_arr as $value_2){
                                        if($value_1 == $value_2){
                                            $date_status = false;
                                        }
                                    }
                                }

                                if(!$date_status){
                                    echo "<p class='alert alert-danger'>Date duplicate! Please re-select start date and end date!</p>";
                                }else{
                                    $sql = "INSERT INTO quize_title (quize_title, grade_id, user_id, start_date, end_date) VALUES (:quize_title, :grade_id, :user_id, :start_date, :end_date)";
                                    $stmt = $this->con->prepare($sql);
                                    $stmt->bindParam("quize_title", $quize_title, PDO::PARAM_STR);
                                    $stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                    $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                    $stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                    $stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                    $stmt->execute();

                                    $sec_sql = "SELECT id FROM quize_title WHERE quize_title=:quize_title AND grade_id=:grade_id AND user_id=:user_id AND start_date=:start_date AND end_date=:end_date";
                                    $sec_stmt = $this->con->prepare($sec_sql);
                                    $sec_stmt->bindParam("quize_title", $quize_title, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                    $sec_stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                    $sec_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                    $sec_stmt->execute();
                                    $quize_res = $sec_stmt->fetch(PDO::FETCH_OBJ);
                                    $quize_id = $quize_res->id;

                                    $assignment_id = null;
                                    $journal_id = null;
                                    $third_sql = "INSERT INTO queue (name, grade_id, start_date, end_date, quize_id, assignment_id, journal_id) VALUES (:name, :grade_id, :start_date, :end_date, :quize_id, :assignment_id, :journal_id)";
                                    $third_stmt = $this->con->prepare($third_sql);
                                    $third_stmt->bindParam("name", $quize_title, PDO::PARAM_STR);
                                    $third_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                    $third_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                    $third_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                    $third_stmt->bindParam("quize_id", $quize_id, PDO::PARAM_INT);
                                    $third_stmt->bindParam("assignment_id", $assignment_id, PDO::PARAM_INT);
                                    $third_stmt->bindParam("journal_id", $journal_id, PDO::PARAM_INT);
                                    $third_stmt->execute();

                                    return true;
                                }
                                
                            }else{
                                $sql = "INSERT INTO quize (quize_title, grade_id, user_id, start_date, end_date) VALUES (:quize_title, :grade_id, :user_id, :start_date, :end_date)";
                                $stmt = $this->con->prepare($sql);
                                $stmt->bindParam("quize_title", $quize_title, PDO::PARAM_STR);
                                $stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                $stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                $stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                $stmt->execute();

                                $sec_sql = "SELECT id FROM quize_title WHERE quize_title=:quize_title AND instruction=:instruction AND grade_id=:grade_id AND user_id=:user_id AND start_date=:start_date AND end_date=:end_date";
                                $sec_stmt = $this->con->prepare($sec_sql);
                                $sec_stmt->bindParam("quize_title", $quize_title, PDO::PARAM_STR);
                                $sec_stmt->bindParam("instruction", $instruction, PDO::PARAM_STR);
                                $sec_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                $sec_stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                $sec_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                $sec_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                $sec_stmt->execute();
                                $quize_res = $sec_stmt->fetch(PDO::FETCH_OBJ);
                                $quize_id = $quize_res->id;

                                $assignment_id = null;
                                $journal_id = null;
                                $third_sql = "INSERT INTO queue (name, grade_id, start_date, end_date, quize_id, assignment_id, journal_id) VALUES (:name, :grade_id, :start_date, :end_date, :quize_id, :assignment_id, :journal_id)";
                                $third_stmt = $this->con->prepare($third_sql);
                                $third_stmt->bindParam("name", $quize_title, PDO::PARAM_STR);
                                $third_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                $third_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                $third_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                $third_stmt->bindParam("quize_id", $quize_id, PDO::PARAM_INT);
                                $third_stmt->bindParam("assignment_id", $assignment_id, PDO::PARAM_INT);
                                $third_stmt->bindParam("journal_id", $journal_id, PDO::PARAM_INT);
                                $third_stmt->execute();

                                return true;
                            }
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
                            $fourth_sql = "SELECT * FROM queue WHERE grade_id=:grade_id";
                            $fourth_stmt = $this->con->prepare($fourth_sql);
                            $fourth_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                            $fourth_stmt->execute();
                            $isset_quize = $fourth_stmt->fetchAll(PDO::FETCH_OBJ);

                            if(count($isset_quize) > 0){

                                $fifth_sql = "SELECT * FROM queue";
                                $fifth_stmt = $this->con->prepare($fifth_sql);
                                $fifth_stmt->execute();
                                $isset_queue = $fifth_stmt->fetchAll(PDO::FETCH_OBJ);
                                $date_arr = [];
                                foreach($isset_queue as $value){
                                    $start_date_cal = new DateTime($value->start_date);
                                    $end_date_cal = new DateTime($value->end_date);

                                    $date1 = strtotime($value->start_date);
                                    $date2 = strtotime($value->end_date);

                                    $diff = abs($date2 - $date1);  
                                    $years = floor($diff / (365*60*60*24));  
                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                                    
                                    $i = 0;
                                    array_push($date_arr, $start_date_cal->format('Y-m-d'));
                                    do{
                                        $start_date_cal->modify('+1 day');
                                        array_push($date_arr, $start_date_cal->format('Y-m-d'));
                                        $i++;
                                    }while($i < $days);
                                }
                                
                                $origin_date_arr = [];
                                $start_date_origin = new DateTime($start_date);
                                $end_date_origin = new DateTime($end_date);
                                
                                $date1 = strtotime($start_date);
                                $date2 = strtotime($end_date);
                                
                                $diff = abs($date2 - $date1);  
                                $years = floor($diff / (365*60*60*24));  
                                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
                                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                                
                                $i = 0;
                                array_push($origin_date_arr, $start_date_origin->format('Y-m-d'));
                                do{
                                    $start_date_origin->modify('+1 day');
                                    array_push($origin_date_arr, $start_date_origin->format('Y-m-d'));
                                    $i++;
                                }while($i < $days);

                                $date_status = true;
                                foreach($date_arr as $value_1){
                                    foreach($origin_date_arr as $value_2){
                                        if($value_1 == $value_2){
                                            $date_status = false;
                                        }
                                    }
                                }

                                if(!$date_status){
                                    $fourth_sql = "SELECT * FROM quize_title WHERE id=:id";
                                    $fourth_stmt = $this->con->prepare($fourth_sql);
                                    $fourth_stmt->bindParam("id", $id, PDO::PARAM_INT);
                                    $fourth_stmt->execute();
                                    $fourth_res = $fourth_stmt->fetch(PDO::FETCH_OBJ);

                                    if($start_date == $fourth_res->start_date){
                                        if($end_date == $fourth_res->end_date){
                                            $sql = "UPDATE quize_title SET quize_title=:quize_title, grade_id=:grade_id, user_id=:user_id, start_date=:start_date, end_date=:end_date WHERE id=:id";
                                            $stmt = $this->con->prepare($sql);
                                            $stmt->bindParam("quize_title", $quize_title, PDO::PARAM_STR);
                                            $stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                            $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                            $stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                            $stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                            $stmt->bindParam("id", $id, PDO::PARAM_INT);
                                            $stmt->execute();

                                            $assignment_id = null;
                                            $journal_id = null;
                                            $sec_sql = "UPDATE queue SET name=:name, grade_id=:grade_id, start_date=:start_date, end_date=:end_date, assignment_id=:assignment_id, journal_id=:journal_id WHERE quize_id=:quize_id";
                                            $sec_stmt = $this->con->prepare($sec_sql);
                                            $sec_stmt->bindParam("name", $quize_title, PDO::PARAM_STR);
                                            $sec_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                            $sec_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                            $sec_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                            $sec_stmt->bindParam("quize_id", $id, PDO::PARAM_INT);
                                            $sec_stmt->bindParam("journal_id", $journal_id, PDO::PARAM_INT);
                                            $sec_stmt->bindParam("assignment_id", $assignment_id, PDO::PARAM_INT);
                                            $sec_stmt->execute();
                                            return true;
                                        }
                                    }else{
                                        echo "<p class='alert alert-danger'>Date duplicate! Please re-select start date and end date!</p>";
                                    }
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

                                    $assignment_id = null;
                                    $journal_id = null;
                                    $sec_sql = "UPDATE queue SET name=:name, grade_id=:grade_id, start_date=:start_date, end_date=:end_date, assignment_id=:assignment_id, journal_id=:journal_id WHERE quize_id=:quize_id";
                                    $sec_stmt = $this->con->prepare($sec_sql);
                                    $sec_stmt->bindParam("name", $quize_title, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                    $sec_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("quize_id", $id, PDO::PARAM_INT);
                                    $sec_stmt->bindParam("journal_id", $journal_id, PDO::PARAM_INT);
                                    $sec_stmt->bindParam("assignment_id", $assignment_id, PDO::PARAM_INT);
                                    $sec_stmt->execute();
                                    return true;
                                }
                                
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

                                $assignment_id = null;
                                $journal_id = null;
                                $sec_sql = "UPDATE queue SET name=:name, grade_id=:grade_id, start_date=:start_date, end_date=:end_date, assignment_id=:assignment_id, journal_id=:journal_id WHERE quize_id=:quize_id";
                                $sec_stmt = $this->con->prepare($sec_sql);
                                $sec_stmt->bindParam("name", $quize_title, PDO::PARAM_STR);
                                $sec_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                $sec_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                $sec_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                $sec_stmt->bindParam("quize_id", $id, PDO::PARAM_INT);
                                $sec_stmt->bindParam("journal_id", $journal_id, PDO::PARAM_INT);
                                $sec_stmt->bindParam("assignment_id", $assignment_id, PDO::PARAM_INT);
                                $sec_stmt->execute();
                                return true;
                            }
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