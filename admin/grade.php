<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Grade</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <a href="add_grade.php"><button class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i></button></a>
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
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $grade = new Grade;
                          $grade_arr = $grade->index();
                          $index = 1;
                          foreach($grade_arr as $value){
                            ?>
                              <tr>
                                <td>
                                    <a href="edit_grade.php?id=<?php echo $value->id; ?>"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a>
                                    <a href="delete_grade.php?id=<?php echo $value->id; ?>"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>
                                </td>
                                <td><?php echo $index; $index++; ?></td>
                                <td><?php echo $value->grade_name; ?></td>
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