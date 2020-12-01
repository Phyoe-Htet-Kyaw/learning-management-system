<?php
    if(!isset($_GET['page'])){
        echo "<script>location.href='index.php'</script>";
    }
?>
<div class="main-section">
    <div class="main-section-header">
        <h1><?php echo $data->quize_title; ?></h1>
    </div>
    <?php
        $quize_data = $general->quizeRender($data->id);
        $total = count($quize_data) - $_GET['page'];
        $i = $_GET['page'];
        if($total > 0){
            if($general->checkAnswer($_POST, $quize_data[$i]->id, $data->id)){
                $y = $i+1;
                echo "<script>location.href='next_quize.php?page=" . $y . "'</script>";
            }
            ?>
                <div class="quize">
                    <b>Question - <?php echo $i+1; ?>: </b>
                    <p><?php echo $quize_data[$i]->question; ?></p>
                    <b>Answers: </b>
                    <form action="#" method="POST">
                        <label for="answer_1"><input type="radio" name="answer" id="answer_1" value="1"> <?php echo $quize_data[$i]->answer_1; ?></label><br>
                        <label for="answer_2"><input type="radio" name="answer" id="answer_2" value="2"> <?php echo $quize_data[$i]->answer_2; ?></label><br>
                        <label for="answer_3"><input type="radio" name="answer" id="answer_3" value="3"> <?php echo $quize_data[$i]->answer_3; ?></label><br>

                        <button type="submit" name="submit">Next</button>
                    </form>
                </div>
            <?php
        }else{
            if($general->calculateQuizMark()){
                echo "<script>location.href='index.php'</script>";
            }
        }
    ?>
</div>