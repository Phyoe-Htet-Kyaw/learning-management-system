<?php

class General extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function checkMain(){
        $today = date('Y-m-d');

        $sql = "SELECT * FROM queue";
        $stmt = $this->con->prepare($sql);
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

            // printf("%d days", $days);  
            // echo $days;

            $i = 0;
            array_push($date_arr, ["id" => $value->id, "date" => $start_date->format('Y-m-d')]);
            do{
                $start_date->modify('+1 day');
                // echo $start_date->format('Y-m-d')."\n";
                array_push($date_arr, ["id" => $value->id, "date" => $start_date->format('Y-m-d')]);
                $i++;
            }while($i < $days);
        }
        // echo "<pre>";
        // print_r($date_arr);
        // echo "</pre>";

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
                    //
                }
            }
        }
    }
}

?>