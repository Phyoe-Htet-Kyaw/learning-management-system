<?php 
    include "template/header.php"; 
    
    
    define ('SITE_ROOT', realpath(dirname(__FILE__)));
    $auth = new Authentication;
    $auth->checkSession();

    $user = new User;
    $current_user = $user->currentUser();

    $general = new General;
    $data = $general->showQuiz($_GET['id']);
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
            <h1><?php echo $data->quize_title; ?></h1>
        </div>
        <?php
            $checking = $general->checkQuizFinishOrNot($data->id);
            if(is_object($checking)){
                $marks = $general->showMarks($data->id);
            ?>
                <div class="quize">
                    <p class='alert alert-success'>Quize Completed! Your result was <?php echo $marks->marks; ?>.</p>
                </div>
            <?php
            }else{
                $quize_data = $general->quizeRender($data->id);
                $total = count($quize_data);
                if($total > 0){
                    $i = 0;

                    if($general->checkAnswer($_POST, $quize_data[$i]->id, $data->id)){
                        $y = $i+1;
                        echo "<script>location.href='next_quize.php?page=" . $y . "&&id=".$_GET['id']."'</script>";
                    }
                    if(strtotime($data->start_date) <= strtotime(date("Y-m-d"))){
                        if(strtotime($data->end_date) >= strtotime(date("Y-m-d"))){
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
                            echo "<p class='alert alert-danger'>Quiz Date is expired!</p>";
                        }
                    }else{
                        echo "<p class='alert alert-danger'>Quiz Date is not avaliable!</p>";
                    }
                }else{
                    ?>
                        <div class="quize">
                            <p class='alert alert-danger'>Quiz questions are not avaliable!</p>
                        </div>
                    <?php
                }
            }
        ?>
        <a href="index.php#current"><button class="bg-crimson" style="border: none; border-radius: 5px; cursor: pointer; padding: 1%;">Back</button></a>
    </div>
</div>

<?php include "template/footer.php"; ?>