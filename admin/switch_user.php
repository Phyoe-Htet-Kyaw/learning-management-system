<?php
    include "../init/admin_init.php"; 

    $user = new User;
    if($user->switchUser($_GET['id'])){
        echo "<script>location.href='user.php'</script>";
    }
?>