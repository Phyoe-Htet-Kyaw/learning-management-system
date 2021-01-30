<?php 
    include "template/header.php"; 
    
    
    define ('SITE_ROOT', realpath(dirname(__FILE__)));
    $auth = new Authentication;
    $auth->checkSession();

    $user = new User;
    $current_user = $user->currentUser();

    $assignment = new General;
    $data = $assignment->showAssignment($_GET['id']);
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
            <h1><?php echo $data->assignment_title; ?></h1>
        </div>
        <div class="main-section-para">
            <p>Instruction:</p>
            <p><?php echo $data->instruction; ?></p>
        </div>
        <?php
            $assignment = new Assignment;
            if(!$assignment->checkAssignmentReportOrNot($data->id)){
                if($assignment->reportAssignment($_POST, $_FILES)){
                    echo "<script>location.href='index.php#current'</script>";
                }
                if(strtotime($data->start_date) <= strtotime(date("Y-m-d"))){
                    if(strtotime($data->end_date) >= strtotime(date("Y-m-d"))){
                        ?>
                            <div class="main-section-button">
                                <form action="#" method="post" enctype="multipart/form-data">
                                    <input type="hidden" value="<?php echo $data->id; ?>" name="assignment_id">
                                    <label for="upload_file" class="btn" id="select">Select Assignment</label>
                                    <input type="file" name="assignment" id="upload_file" hidden>
                                    <button type="submit" name="submit" class="btn" id="submit">Upload</button>
                                </form>
                            </div>
                        <?php
                    }else{
                        echo "<p class='alert alert-danger'>Assignment Date is expired!</p>";
                    }
                }else{
                    echo "<p class='alert alert-danger'>Assignment Date is not avaliable!</p>";
                }
            }else{
                echo "<p class='alert alert-success'>Assignment Uploaded!</p>";
            }
        ?>
        <a href="index.php#current"><button class="bg-crimson" style="border: none; border-radius: 5px; cursor: pointer; padding: 1%;">Back</button></a>
    </div>

</div>

<?php include "template/footer.php"; ?>