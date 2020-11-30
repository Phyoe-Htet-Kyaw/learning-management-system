<?php
include "init/init.php";

$auth = new Authentication;
if($auth->logout()){
    echo "<script>location.href='login.php'</script>";
}
?>