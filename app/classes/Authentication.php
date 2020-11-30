<?php

class Authentication extends DB{

    private $con;

    public function __construct(){
        $this->con = $this->connect();
    }

    public function register($request){
        if(isset($request['submit'])){
            $username = $request['username'];
            $email = $request['email'];
            $roll_no = $request['roll_no'];
            $password_origin = $request['password'];
            $password = password_hash($request['password'], PASSWORD_BCRYPT);
            $con_password = $request['con_password'];
            $status = 0;

            if($username == ""){
                echo "<p class='alert alert-danger'>Please enter username!</p>";
            }else{
                if($email == ""){
                    echo "<p class='alert alert-danger'>Please enter email!</p>";
                }else{
                    if($roll_no == ""){
                        echo "<p class='alert alert-danger'>Please enter roll_no!</p>";
                    }else{
                        if($password == ""){
                            echo "<p class='alert alert-danger'>Please enter password!</p>";
                        }else{
                            if($con_password == ""){
                                echo "<p class='alert alert-danger'>Please enter confirm password!</p>";
                            }else{
                                if(strlen($password) < 8){
                                    echo "<p class='alert alert-danger'>Please enter password length more than 8!</p>";
                                }else{
                                    if($password_origin != $con_password){
                                        echo "<p class='alert alert-danger'>Password and confirm password didn't match!</p>";
                                    }else{
                                        $sql = "INSERT INTO users (name, roll_no, email, password, status) VALUES (:name, :roll_no, :email, :password, :status)";
                                        $stmt = $this->con->prepare($sql);
                                        $stmt->bindParam(":name", $username, PDO::PARAM_STR);
                                        $stmt->bindParam(":roll_no", $roll_no, PDO::PARAM_STR);
                                        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                                        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
                                        $stmt->bindParam(":status", $status, PDO::PARAM_INT);
                                        $stmt->execute();
                                        $this->setSession($email);
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

    public function login($request){
        if(isset($request['submit'])){
            $email = $request['email'];
            $password_origin = $request['password'];
            $password = password_hash($request['password'], PASSWORD_BCRYPT);

            if($email == ""){
                echo "<p class='alert alert-danger'>Please enter email!</p>";
            }else{
                if($password_origin == ""){
                    echo "<p class='alert alert-danger'>Please enter password!</p>";
                }else{
                    if(strlen($password_origin) < 8){
                        echo "<p class='alert alert-danger'>Please enter password length more than 8!</p>";
                    }else{

                        $sql = "SELECT * FROM users WHERE email=:email";
                        $stmt = $this->con->prepare($sql);
                        $stmt->bindParam("email", $email, PDO::PARAM_STR);
                        $stmt->execute();
                        $res = $stmt->fetch(PDO::FETCH_OBJ);

                        if(is_object($res)){
                            if($email != $res->email){
                                echo "<p class='alert alert-danger'>Email is invalid!</p>";
                            }else{
                                if(!password_verify($password_origin, $res->password)){
                                    echo "<p class='alert alert-danger'>Password is invalid!</p>";
                                }else{
                                    $this->setSession($email);
                                    return true;
                                }
                            }
                        }else{
                            echo "<p class='alert alert-danger'>Email is invalid!</p>";
                        }
                    }
                }
            }            
        }
    }

    public function setSession($email){
        $sql = "SELECT * FROM users WHERE email=:email";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        $_SESSION['user_id'] = $res->id;
    }

    public function checkSession(){
        if(!isset($_SESSION['user_id'])){
            echo "<script>location.href='login.php'</script>";
        }
    }

    public function logout(){
        session_destroy();
        return true;
    }
}

?>