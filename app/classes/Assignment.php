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
                        echo "<p class='alert alert-danger'>Please select Grade!</p>";
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
                                $isset_assignment = $fourth_stmt->fetchAll(PDO::FETCH_OBJ);

                                if(count($isset_assignment) > 0){

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
                                        $sql = "INSERT INTO assignment (assignment_title, instruction, grade_id, user_id, start_date, end_date) VALUES (:assignment_title, :instruction, :grade_id, :user_id, :start_date, :end_date)";
                                        $stmt = $this->con->prepare($sql);
                                        $stmt->bindParam("assignment_title", $assignment_title, PDO::PARAM_STR);
                                        $stmt->bindParam("instruction", $instruction, PDO::PARAM_STR);
                                        $stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                        $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                        $stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                        $stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                        $stmt->execute();

                                        $sec_sql = "SELECT id FROM assignment WHERE assignment_title=:assignment_title AND instruction=:instruction AND grade_id=:grade_id AND user_id=:user_id AND start_date=:start_date AND end_date=:end_date";
                                        $sec_stmt = $this->con->prepare($sec_sql);
                                        $sec_stmt->bindParam("assignment_title", $assignment_title, PDO::PARAM_STR);
                                        $sec_stmt->bindParam("instruction", $instruction, PDO::PARAM_STR);
                                        $sec_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                        $sec_stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                        $sec_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                        $sec_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                        $sec_stmt->execute();
                                        $assignment_res = $sec_stmt->fetch(PDO::FETCH_OBJ);
                                        $assignment_id = $assignment_res->id;

                                        $quize_id = null;
                                        $journal_id = null;
                                        $third_sql = "INSERT INTO queue (name, grade_id, start_date, end_date, quize_id, assignment_id, journal_id) VALUES (:name, :grade_id, :start_date, :end_date, :quize_id, :assignment_id, :journal_id)";
                                        $third_stmt = $this->con->prepare($third_sql);
                                        $third_stmt->bindParam("name", $assignment_title, PDO::PARAM_STR);
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
                                    $sql = "INSERT INTO assignment (assignment_title, instruction, grade_id, user_id, start_date, end_date) VALUES (:assignment_title, :instruction, :grade_id, :user_id, :start_date, :end_date)";
                                    $stmt = $this->con->prepare($sql);
                                    $stmt->bindParam("assignment_title", $assignment_title, PDO::PARAM_STR);
                                    $stmt->bindParam("instruction", $instruction, PDO::PARAM_STR);
                                    $stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                    $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                    $stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                    $stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                    $stmt->execute();

                                    $sec_sql = "SELECT id FROM assignment WHERE assignment_title=:assignment_title AND instruction=:instruction AND grade_id=:grade_id AND user_id=:user_id AND start_date=:start_date AND end_date=:end_date";
                                    $sec_stmt = $this->con->prepare($sec_sql);
                                    $sec_stmt->bindParam("assignment_title", $assignment_title, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("instruction", $instruction, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                    $sec_stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                                    $sec_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                    $sec_stmt->execute();
                                    $assignment_res = $sec_stmt->fetch(PDO::FETCH_OBJ);
                                    $assignment_id = $assignment_res->id;

                                    $quize_id = null;
                                    $journal_id = null;
                                    $third_sql = "INSERT INTO queue (name, grade_id, start_date, end_date, quize_id, assignment_id, journal_id) VALUES (:name, :grade_id, :start_date, :end_date, :quize_id, :assignment_id, :journal_id)";
                                    $third_stmt = $this->con->prepare($third_sql);
                                    $third_stmt->bindParam("name", $assignment_title, PDO::PARAM_STR);
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
                        echo "<p class='alert alert-danger'>Please select Grade!</p>";
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
                                $isset_assignment = $fourth_stmt->fetchAll(PDO::FETCH_OBJ);

                                if(count($isset_assignment) > 0){

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
                                        $fourth_sql = "SELECT * FROM assignment WHERE id=:id";
                                        $fourth_stmt = $this->con->prepare($fourth_sql);
                                        $fourth_stmt->bindParam("id", $id, PDO::PARAM_INT);
                                        $fourth_stmt->execute();
                                        $fourth_res = $fourth_stmt->fetch(PDO::FETCH_OBJ);

                                        if($start_date == $fourth_res->start_date){
                                            if($end_date == $fourth_res->end_date){
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

                                                $quize_id = null;
                                                $journal_id = null;
                                                $sec_sql = "UPDATE queue SET name=:name, grade_id=:grade_id, start_date=:start_date, end_date=:end_date, quize_id=:quize_id, journal_id=:journal_id WHERE assignment_id=:assignment_id";
                                                $sec_stmt = $this->con->prepare($sec_sql);
                                                $sec_stmt->bindParam("name", $assignment_title, PDO::PARAM_STR);
                                                $sec_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                                $sec_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                                $sec_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                                $sec_stmt->bindParam("quize_id", $quize_id, PDO::PARAM_INT);
                                                $sec_stmt->bindParam("journal_id", $journal_id, PDO::PARAM_INT);
                                                $sec_stmt->bindParam("assignment_id", $id, PDO::PARAM_INT);
                                                $sec_stmt->execute();
                                                return true;
                                            }
                                        }else{
                                            echo "<p class='alert alert-danger'>Date duplicate! Please re-select start date and end date!</p>";
                                        }
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

                                        $quize_id = null;
                                        $journal_id = null;
                                        $sec_sql = "UPDATE queue SET name=:name, grade_id=:grade_id, start_date=:start_date, end_date=:end_date, quize_id=:quize_id, journal_id=:journal_id WHERE assignment_id=:assignment_id";
                                        $sec_stmt = $this->con->prepare($sec_sql);
                                        $sec_stmt->bindParam("name", $assignment_title, PDO::PARAM_STR);
                                        $sec_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                        $sec_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                        $sec_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                        $sec_stmt->bindParam("quize_id", $quize_id, PDO::PARAM_INT);
                                        $sec_stmt->bindParam("journal_id", $journal_id, PDO::PARAM_INT);
                                        $sec_stmt->bindParam("assignment_id", $id, PDO::PARAM_INT);
                                        $sec_stmt->execute();
                                        return true;
                                    }
                                    
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

                                    $quize_id = null;
                                    $journal_id = null;
                                    $sec_sql = "UPDATE queue SET name=:name, grade_id=:grade_id, start_date=:start_date, end_date=:end_date, quize_id=:quize_id, journal_id=:journal_id WHERE assignment_id=:assignment_id";
                                    $sec_stmt = $this->con->prepare($sec_sql);
                                    $sec_stmt->bindParam("name", $assignment_title, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("grade_id", $grade_id, PDO::PARAM_INT);
                                    $sec_stmt->bindParam("start_date", $start_date, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("end_date", $end_date, PDO::PARAM_STR);
                                    $sec_stmt->bindParam("quize_id", $quize_id, PDO::PARAM_INT);
                                    $sec_stmt->bindParam("journal_id", $journal_id, PDO::PARAM_INT);
                                    $sec_stmt->bindParam("assignment_id", $id, PDO::PARAM_INT);
                                    $sec_stmt->execute();
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
}

?>