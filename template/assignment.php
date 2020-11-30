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
                echo "<script>location.reload()</script>";
            }
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
            echo "<p class='alert alert-success'>Assignment Uploaded!</p>";
        }
    ?>
</div>
