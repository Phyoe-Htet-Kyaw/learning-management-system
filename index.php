<?php 
    include "template/header.php"; 
    define ('SITE_ROOT', realpath(dirname(__FILE__)));
    $auth = new Authentication;
    $auth->checkSession();

    $user = new User;
    $current_user = $user->currentUser();
?>

<div class="index-bg">
    <div class="index-header">
        <div class="user-profile-panel">
            <p>
                <i class="fa fa-user"></i>&nbsp;
                <span><?php echo $current_user->name; ?></span>
            </p>
        </div>
        <div class="user-profile-panel" id="logout">
            <p>
                <i class="fa fa-sign-out-alt"></i>&nbsp;
                <span>Log Out</span>
            </p>
        </div>
    </div>
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