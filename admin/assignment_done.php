<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Assignment Done</h1>
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
                            <th>Option</th>
                            <th>No.</th>
                            <th>Assignment Title</th>
                            <th width="500">Instruction</th>
                            <th>Student</th>
                            <th>Uploaded DateTime</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $assignment = new Assignment;
                          $assignment_arr = $assignment->selectAssignmentDone();
                          $index = 1;
                          foreach($assignment_arr as $value){
                            $user_data = $assignment->assignmentUploader($value->assignment_id);
                            if($user_data->status == 2){
                              ?>
                                <tr>
                                  <td>
                                    <a href="../assets/uploads/<?php echo $value->file; ?>" target="_blank"><button class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button></a>
                                  </td>
                                  <td><?php echo $index; $index++; ?></td>
                                  <td>
                                      <?php 
                                          $a_data = $assignment->fetchById($value->assignment_id);
                                          echo $a_data->assignment_title;
                                      ?>
                                  </td>
                                  <td><?php echo $a_data->instruction; ?></td>
                                  <td>
                                    <?php
                                      $user = new User;
                                      $user_data = $user->fetchById($value->user_id);
                                      echo $user_data->name;
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                      echo $value->time_stamp;
                                    ?>
                                  </td>
                                  <td><?php echo $a_data->start_date; ?></td>
                                  <td><?php echo $a_data->end_date; ?></td>
                              </tr>
                              <?php
                            }else if($user_data->status == 1){
                              $user_assignment_data = $assignment->userAssignment();
                              foreach($user_assignment_data as $data_A){
                                if($data_A->id == $value->assignment_id){
                                  ?>
                                    <tr>
                                      <td>
                                        <a href="../assets/uploads/<?php echo $value->file; ?>" target="_blank"><button class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button></a>
                                      </td>
                                      <td><?php echo $index; $index++; ?></td>
                                      <td>
                                          <?php 
                                              $a_data = $assignment->fetchById($value->assignment_id);
                                              echo $a_data->assignment_title;
                                          ?>
                                      </td>
                                      <td><?php echo $a_data->instruction; ?></td>
                                      <td>
                                        <?php
                                          $user = new User;
                                          $user_data = $user->fetchById($value->user_id);
                                          echo $user_data->name;
                                        ?>
                                      </td>
                                      <td>
                                        <?php
                                          echo $value->time_stamp;
                                        ?>
                                      </td>
                                      <td><?php echo $a_data->start_date; ?></td>
                                      <td><?php echo $a_data->end_date; ?></td>
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