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
            ?>
                <div class="main-section-button">
                    <a href="admin/assets/uploads/<?php echo $data->pdf; ?>" target="_blank"><button style="display: inline-block;">Open Journal.</button></a>
                    <a href="journal_done.php?journal_id=<?php echo $data->id ?>&&user_id=<?php echo $_SESSION['user_id']; ?>"><button style="display: inline-block;">I've read it.</button></a>
                </div>
            <?php
        }else{
            echo "<p class='alert alert-success'>Journal Readed!</p>";
        }
    ?>
</div>