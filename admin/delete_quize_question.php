<?php 
    include "../init/admin_init.php"; 

    if(!isset($_GET['id'])){
        echo "<script>location.href='quize_question.php'</script>";
    }
    $quize_question = new QuizeQuestion;
    $data = $quize_question->fetchById($_GET['id']);
    if(!is_object($data)){
        echo "<script>location.href='quize_question.php'</script>";
    }

    if($quize_question->delete($_GET['id'])){
        echo "<script>location.href='quize_question.php'</script>";
    }
?>