<?php

class DB{
    private $localhost = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "lms";


    public function connect(){
        try{
            $pdo = new PDO("mysql:host=$this->localhost;dbname=$this->dbname", $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }catch(PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }
}

?>