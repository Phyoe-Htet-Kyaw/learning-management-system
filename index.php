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
    <div class="main-section">
        <div class="main-section-header">
            <h1>Schedule</h1>
        </div>
        <div class="main-section-body">
            <?php
                $i = 15;
                while($i > 0){
                    $general = new General; 
                    $min_date = date("d-m-Y (l)", time() - (86400 * $i));
                    $assingment = $general->fetchAssignmentByDate(date("Y-m-d", time() - (86400 * $i)));
                    $journal = $general->fetchJournalByDate(date("Y-m-d", time() - (86400 * $i)));
                    $quiz = $general->fetchQuizByDate(date("Y-m-d", time() - (86400 * $i)));
                    if(count($assingment) > 0 || count($journal) > 0 || count($quiz) > 0){
                    ?>
                        <h3 class="date-title"><?php echo $min_date ; ?></h3>
                        <div class="card-group">
                            <?php
                                foreach($assingment as $value){
                                    ?>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3><?php echo $value->assignment_title	; ?></h3>
                                                <span class="bg-crimson badge">Assignment</span>
                                                <?php
                                                    if($general->checkAssignmentDone($value->id)->count > 0){
                                                        ?>
                                                            <i class="fa fa-check" style="color: green;"></i>
                                                            <?php
                                                    }else{
                                                        ?>
                                                            <i class="fa fa-times" style="color: red;"></i>
                                                        <?php
                                                    }
                                                ?>
                                                <p style="margin: 3% 0;"><?php echo $value->start_date . " <i class='fa fa-arrow-right'></i> " . $value->end_date; ?></p>
                                            </div>
                                            <div class="card-body">
                                                <p><?php echo $value->instruction; ?></p>
                                                <a href="assignment.php?id=<?php echo $value->id; ?>"><button class="bg-crimson button">Read More</button></a>
                                            </div>
                                        </div>
                                    <?php
                                }

                                foreach($journal as $value){
                                    ?>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3><?php echo $value->journal_title; ?></h3>
                                                <span class="bg-crimson badge">Journal</span>
                                                <?php
                                                    if($general->checkJournalDone($value->id)->count > 0){
                                                        ?>
                                                            <i class="fa fa-check" style="color: green;"></i>
                                                            <?php
                                                    }else{
                                                        ?>
                                                            <i class="fa fa-times" style="color: red;"></i>
                                                        <?php
                                                    }
                                                ?>
                                                <p style="margin: 3% 0;"><?php echo $value->start_date . " <i class='fa fa-arrow-right'></i> " . $value->end_date; ?></p>
                                            </div>
                                            <div class="card-body">
                                                <p><?php echo $value->instruction; ?></p>
                                                <a href="journal.php?id=<?php echo $value->id; ?>"><button class="bg-crimson button">Read More</button></a>
                                            </div>
                                        </div>
                                    <?php
                                }

                                foreach($quiz as $value){
                                    ?>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3><?php echo $value->quize_title; ?></h3>
                                                <span class="bg-crimson badge">Quiz</span>
                                                <?php
                                                    if($general->checkQuizDone($value->id)->count > 0){
                                                        ?>
                                                            <i class="fa fa-check" style="color: green;"></i>
                                                            <?php
                                                    }else{
                                                        ?>
                                                            <i class="fa fa-times" style="color: red;"></i>
                                                        <?php
                                                    }
                                                ?>
                                                <p style="margin: 3% 0;"><?php echo $value->start_date . " <i class='fa fa-arrow-right'></i> " . $value->end_date; ?></p>
                                            </div>
                                            <div class="card-body">
                                                <p>You need to answer quiz.</p>
                                                <a href="quiz.php?id=<?php echo $value->id; ?>"><button class="bg-crimson button">Read More</button></a>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                    <?php
                    }
                    $i--;
                } 

                $j = 0;
                while($j < 15){
                    $max_date = date("d-m-Y (l)", time() + (86400 * $j));
                    $general = new General;
                    $assingment = $general->fetchAssignmentByDate(date("Y-m-d", time() + (86400 * $j)));
                    $journal = $general->fetchJournalByDate(date("Y-m-d", time() + (86400 * $j)));
                    $quiz = $general->fetchQuizByDate(date("Y-m-d", time() + (86400 * $j)));
                    if(count($assingment) > 0 || count($journal) > 0 || count($quiz) > 0){
                    ?>
                        <h3 class="date-title" <?php if($max_date == date("d-m-Y (l)")){ ?> id="current" <?php } ?>><?php echo $max_date ; ?></h3>
                        <div class="card-group">
                        <?php
                                foreach($assingment as $value){
                                    ?>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3><?php echo $value->assignment_title	; ?></h3>
                                                <span class="bg-crimson badge">Assignment</span>
                                                <?php
                                                    if($general->checkAssignmentDone($value->id)->count > 0){
                                                        ?>
                                                            <i class="fa fa-check" style="color: green;"></i>
                                                            <?php
                                                    }else{
                                                        ?>
                                                            <i class="fa fa-times" style="color: red;"></i>
                                                        <?php
                                                    }
                                                ?>
                                                <p style="margin: 3% 0;"><?php echo $value->start_date . " <i class='fa fa-arrow-right'></i> " . $value->end_date; ?></p>
                                            </div>
                                            <div class="card-body">
                                                <p><?php echo $value->instruction; ?></p>
                                                <a href="assignment.php?id=<?php echo $value->id; ?>"><button class="bg-crimson button">Read More</button></a>
                                            </div>
                                        </div>
                                    <?php
                                }

                                foreach($journal as $value){
                                    ?>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3><?php echo $value->journal_title; ?></h3>
                                                <span class="bg-crimson badge">Journal</span>
                                                <?php
                                                    if($general->checkJournalDone($value->id)->count > 0){
                                                        ?>
                                                            <i class="fa fa-check" style="color: green;"></i>
                                                            <?php
                                                    }else{
                                                        ?>
                                                            <i class="fa fa-times" style="color: red;"></i>
                                                        <?php
                                                    }
                                                ?>
                                                <p style="margin: 3% 0;"><?php echo $value->start_date . " <i class='fa fa-arrow-right'></i> " . $value->end_date; ?></p>
                                            </div>
                                            <div class="card-body">
                                                <p><?php echo $value->instruction; ?></p>
                                                <a href="journal.php?id=<?php echo $value->id; ?>"><button class="bg-crimson button">Read More</button></a>
                                            </div>
                                        </div>
                                    <?php
                                }

                                foreach($quiz as $value){
                                    ?>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3><?php echo $value->quize_title; ?></h3>
                                                <span class="bg-crimson badge">Quiz</span>
                                                <?php
                                                    if($general->checkQuizDone($value->id)->count > 0){
                                                        ?>
                                                            <i class="fa fa-check" style="color: green;"></i>
                                                            <?php
                                                    }else{
                                                        ?>
                                                            <i class="fa fa-times" style="color: red;"></i>
                                                        <?php
                                                    }
                                                ?>
                                                <p style="margin: 3% 0;"><?php echo $value->start_date . " <i class='fa fa-arrow-right'></i> " . $value->end_date; ?></p>
                                            </div>
                                            <div class="card-body">
                                                <p>You need to answer quiz.</p>
                                                <a href="quiz.php?id=<?php echo $value->id; ?>"><button class="bg-crimson button">Read More</button></a>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                    <?php
                    }
                    $j++;
                } 
            ?>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>