<?php 
    include "template/header.php"; 
    
    
    define ('SITE_ROOT', realpath(dirname(__FILE__)));
    $auth = new Authentication;
    $auth->checkSession();

    $user = new User;
    $current_user = $user->currentUser();

    $journal = new General;
    $data = $journal->showJournal($_GET['id']);
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
    <div class="main-section">
        <div class="main-section-header">
            <h1><?php echo $data->journal_title; ?></h1>
        </div>
        <div class="main-section-para">
            <p>Instruction:</p>
            <p><?php echo $data->instruction; ?></p>
        </div>
        <?php
            $journal = new Journal;
            if(!$journal->checkJournalReportOrNot($data->id)){
                if(strtotime($data->start_date) <= strtotime(date("Y-m-d"))){
                    if(strtotime($data->end_date) >= strtotime(date("Y-m-d"))){
                        ?>
                            <div class="main-section-button">
                                <a href="admin/assets/uploads/<?php echo $data->pdf; ?>" target="_blank"><button style="display: inline-block;">Open Journal.</button></a>
                                <a href="journal_done.php?journal_id=<?php echo $data->id ?>&&user_id=<?php echo $_SESSION['user_id']; ?>"><button style="display: inline-block;">I've read it.</button></a>
                            </div>
                        <?php
                    }else{
                        echo "<p class='alert alert-danger'>Journal Date is expired!</p>";
                    }
                }else{
                    echo "<p class='alert alert-danger'>Journal Date is not avaliable!</p>";
                }
            }else{
                echo "<p class='alert alert-success'>Journal Readed!</p>";
            }
        ?>
        <a href="index.php#current"><button class="bg-crimson" style="border: none; border-radius: 5px; cursor: pointer; padding: 1%;">Back</button></a>
    </div>
</div>

<?php include "template/footer.php"; ?>