<?php 
    include "../init/admin_init.php"; 

    if(!isset($_GET['id'])){
        echo "<script>location.href='journal.php'</script>";
    }
    $journal = new Journal;
    $data = $journal->fetchById($_GET['id']);
    if(!is_object($data)){
        echo "<script>location.href='journal.php'</script>";
    }

    if($journal->delete($_GET['id'])){
        echo "<script>location.href='journal.php'</script>";
    }
?>