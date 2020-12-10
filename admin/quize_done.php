<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Quize Done</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-sm"  id="example">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Quize Title</th>
                            <th>Student</th>
                            <th>Marks</th>
                            <th>Answer Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $quize = new Quize;
                          $quize_arr = $quize->quizDoneIndex();
                          $index = 1;
                          foreach($quize_arr as $value){
                            $user_data = $quize->QuizDoneUploader($value->quiz_title_id);
                            if($user_data->status == 2){
                            ?>
                              <tr>
                                <td><?php echo $index; $index++; ?></td>
                                <td>
                                  <?php
                                    $quiz_title = new Quizetitle;
                                    $quiz_title_data = $quiz_title->fetchById($value->quiz_title_id);
                                    echo $quiz_title_data->quize_title;
                                  ?>
                                </td>
                                <td>
                                  <?php
                                    $user = new User;
                                    $user_data = $user->fetchById($value->user_id);
                                    echo $user_data->name;
                                  ?>
                                </td>
                                <td>
                                    <?php 
                                        $quiz_question = $quize->quizQuestionCount($value->quiz_title_id);
                                        echo $value->marks . " / " . $quiz_question->count; 
                                    ?>
                                </td>
                                <td><?php echo $value->time_stamp; ?></td>
                            </tr>
                            <?php
                            }else if($user_data->status == 1){
                              $user_quize_data = $quize->userQuizDone();
                              foreach($user_quize_data as $data_A){
                                if($data_A->id == $value->quiz_title_id){
                                  ?>
                                  <tr>
                                    <td><?php echo $index; $index++; ?></td>
                                    <td>
                                      <?php
                                        $quiz_title = new Quizetitle;
                                        $quiz_title_data = $quiz_title->fetchById($value->quiz_title_id);
                                        echo $quiz_title_data->quize_title;
                                      ?>
                                    </td>
                                    <td>
                                      <?php
                                        $user = new User;
                                        $user_data = $user->fetchById($value->user_id);
                                        echo $user_data->name;
                                      ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $quiz_question = $quize->quizQuestionCount($value->quiz_title_id);
                                            echo $value->marks . " / " . $quiz_question->count; 
                                        ?>
                                    </td>
                                    <td><?php echo $value->time_stamp; ?></td>
                                </tr>
                            <?php
                                    
                                  }
                              }
                            }
                          }
                        ?>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  
<?php include "template/footer.php"; ?>