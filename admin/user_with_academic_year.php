<?php 
  include "template/header.php"; 
  $user = new User;
  $user_id = $user->fetchById($_SESSION['admin_id']);
  if($user_id->status != 2){
    echo "<script>location.href='index.php'</script>";
  }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Students (<?php echo $_GET['year'] - 1 . " - " . $_GET['year']; ?>)</h1>
          </div><!-- /.col -->
          <!-- /.col -->
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
                <table class="table table-sm" id="example">
                    <thead>
                        <tr>
                            <th>Options</th>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Roll</th>
                            <th>Email</th>
                            <th>Year</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $user = new User;
                            $user_arr = $user->index();
                            $index = 1;
                            foreach($user_arr as $value){
                                if(date("Y", strtotime($value->time_stamp)) == $_GET['year']){
                            ?>
                                <tr>
                                    <td>
                                        <?php
                                          if($value->status != 2){
                                            ?>
                                              <a href="switch_user.php?id=<?php echo $value->id; ?>"><button class="btn btn-info btn-sm"><i class="fa fa-exchange"></i></button></a>
                                            <?php
                                          }
                                        ?>
                                        <!-- <a href="#"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a> -->
                                    </td>
                                    <td><?php echo $index; $index++; ?></td>
                                    <td><?php echo $value->name; ?></td>
                                    <td><?php echo $value->roll_no; ?></td>
                                    <td><?php echo $value->email; ?></td>
                                    <td>
                                        <?php 
                                            if($value->status == 0){
                                                if($value->grade_id == 0){
                                                    echo "Teacher";
                                                }else{
                                                    $grade = new Grade;
                                                    $grade_data = $grade->fetchById($value->grade_id);
                                                    echo $grade_data->grade_name;
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                      <a href="user_with_academic_year.php?year=<?php echo date("Y", strtotime($value->time_stamp)); ?>">
                                      <?php
                                        if($value->status == 0){
                                          echo date("Y", strtotime($value->time_stamp)) - 1 . " - " . date("Y", strtotime($value->time_stamp));
                                        }
                                      ?>
                                      </a>
                                    </td>
                                    <td>
                                        <?php 
                                            if($value->status == 0){
                                                ?>
                                                    <span class="badge badge-success">Student</span>
                                                <?php
                                            }else if($value->status == 1){
                                                ?>
                                                    <span class="badge badge-primary">Teacher</span>
                                                <?php
                                            }else if($value->status == 2){
                                              ?>
                                                  <span class="badge badge-danger">Admin</span>
                                              <?php
                                          }
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