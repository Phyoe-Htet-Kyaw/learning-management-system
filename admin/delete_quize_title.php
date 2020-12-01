<?php 
    include "../init/admin_init.php"; 

    if(!isset($_GET['id'])){
        echo "<script>location.href='quize_title.php'</script>";
    }
    $quize_title = new QuizeTitle;
    $data = $quize_title->fetchById($_GET['id']);
    if(!is_object($data)){
        echo "<script>location.href='quize_title.php'</script>";
    }

    if($quize_title->delete($_GET['id'])){
        echo "<script>location.href='quize_title.php'</script>";
    }
?>