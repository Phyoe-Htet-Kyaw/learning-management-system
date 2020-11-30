<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">User</h1>
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
                            <th>Roll No</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $user = new User;
                            $user_arr = $user->index();
                            $index = 1;
                            foreach($user_arr as $value){
                            ?>
                                <tr>
                                    <td>
                                        <a href="switch_user.php?id=<?php echo $value->id; ?>"><button class="btn btn-primary btn-sm"><i class="fa fa-exchange"></i></button></a>
                                        <!-- <a href="#"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a> -->
                                    </td>
                                    <td><?php echo $index; $index++; ?></td>
                                    <td><?php echo $value->name; ?></td>
                                    <td><?php echo $value->roll_no; ?></td>
                                    <td><?php echo $value->email; ?></td>
                                    <td>
                                        <?php 
                                            if($value->status == 0){
                                                ?>
                                                    <span class="badge badge-success">Student</span>
                                                <?php
                                            }else if($value->status == 1){
                                                ?>
                                                    <span class="badge badge-danger">Teacher</span>
                                                <?php
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php
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