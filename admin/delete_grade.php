<?php 
    include "../init/admin_init.php"; 

    if(!isset($_GET['id'])){
        echo "<script>location.href='grade.php'</script>";
    }
    $grade = new Grade;
    $data = $grade->fetchById($_GET['id']);
    if(!is_object($data)){
        echo "<script>location.href='grade.php'</script>";
    }

    if($grade->delete($_GET['id'])){
        echo "<script>location.href='grade.php'</script>";
    }
?>