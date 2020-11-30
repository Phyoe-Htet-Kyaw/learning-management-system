<?php 
    include "../init/admin_init.php"; 

    if(!isset($_GET['id'])){
        echo "<script>location.href='assignment.php'</script>";
    }
    $assignment = new Assignment;
    $data = $assignment->fetchById($_GET['id']);
    if(!is_object($data)){
        echo "<script>location.href='assignment.php'</script>";
    }

    if($assignment->delete($_GET['id'])){
        echo "<script>location.href='assignment.php'</script>";
    }
?>