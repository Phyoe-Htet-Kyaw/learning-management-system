<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Quize Question</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <a href="add_quize_question.php"><button class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i></button></a>
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
                            <th>Options</th>
                            <th>No.</th>
                            <th>Quize Title</th>
                            <th>Question</th>
                            <th>Answer 1</th>
                            <th>Answer 2</th>
                            <th>Answer 3</th>
                            <th>Teacher</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $quize_question = new QuizeQuestion;
                          $quize_question_arr = $quize_question->index();
                          $index = 1;
                          $admin_data = $quize_question->fetchUserById($_SESSION['admin_id']);
                          foreach($quize_question_arr as $value){
                            if($admin_data->status != 2){
                              if($value->user_id == $_SESSION['admin_id']){
                            ?>
                              <tr>
                                <td>
                                    <a href="edit_quize_question.php?id=<?php echo $value->id; ?>"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a>
                                    <a href="delete_quize_question.php?id=<?php echo $value->id; ?>"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>
                                </td>
                                <td><?php echo $index; $index++; ?></td>
                                <td>
                                    <?php
                                        $quize_title = new QuizeTitle;
                                        $quize = $quize_title->fetchById($value->quize_title_id);
                                        echo $quize->quize_title;
                                    ?>
                                </td>
                                <td><?php echo $value->question; ?></td>
                                <td>
                                    <?php 
                                        if($value->true_answer_no == 1){
                                            ?>
                                                <span class="badge badge-success"><?php echo $value->answer_1; ?></span>
                                            <?php
                                        }else{
                                            echo $value->answer_1;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if($value->true_answer_no == 2){
                                            ?>
                                                <span class="badge badge-success"><?php echo $value->answer_2; ?></span>
                                            <?php
                                        }else{
                                            echo $value->answer_2;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if($value->true_answer_no == 3){
                                            ?>
                                                <span class="badge badge-success"><?php echo $value->answer_3; ?></span>
                                            <?php
                                        }else{
                                            echo $value->answer_3;
                                        }
                                    ?>
                                </td>
                                <td>
                                  <?php
                                    $user_data = $quize_question->fetchUserById($value->user_id);
                                    echo $user_data->name;
                                  ?>
                                </td>
                            </tr>
                            <?php
                              }
                            }else{
                              ?>
                              <tr>
                                <td>
                                    <a href="edit_quize_question.php?id=<?php echo $value->id; ?>"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a>
                                    <a href="delete_quize_question.php?id=<?php echo $value->id; ?>"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>
                                </td>
                                <td><?php echo $index; $index++; ?></td>
                                <td>
                                    <?php
                                        $quize_title = new QuizeTitle;
                                        $quize = $quize_title->fetchById($value->quize_title_id);
                                        echo $quize->quize_title;
                                    ?>
                                </td>
                                <td><?php echo $value->question; ?></td>
                                <td>
                                    <?php 
                                        if($value->true_answer_no == 1){
                                            ?>
                                                <span class="badge badge-success"><?php echo $value->answer_1; ?></span>
                                            <?php
                                        }else{
                                            echo $value->answer_1;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if($value->true_answer_no == 2){
                                            ?>
                                                <span class="badge badge-success"><?php echo $value->answer_2; ?></span>
                                            <?php
                                        }else{
                                            echo $value->answer_2;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if($value->true_answer_no == 3){
                                            ?>
                                                <span class="badge badge-success"><?php echo $value->answer_3; ?></span>
                                            <?php
                                        }else{
                                            echo $value->answer_3;
                                        }
                                    ?>
                                </td>
                                <td>
                                  <?php
                                    $user_data = $quize_question->fetchUserById($value->user_id);
                                    echo $user_data->name;
                                  ?>
                                </td>
                            </tr>
                            <?php
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