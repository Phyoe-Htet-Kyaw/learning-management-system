<?php 
    include "template/header.php"; 
    $auth = new Authentication;
    $auth->checkSession();
?>

<div class="index-bg">
    <?php
        $general = new General;
        if($general->checkMain()){
            $data = $general->checkMain();
            if(isset($data->assignment_title)){
                include "template/assignment.php";
            }else if(isset($data->journal_title)){
                include "template/journal.php";
            }
        }else{
            include "template/no_question.php";
        }
    ?>
</div>

<?php include "template/footer.php"; ?>