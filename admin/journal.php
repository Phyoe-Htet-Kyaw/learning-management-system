<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Journal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <a href="add_journal.php"><button class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i></button></a>
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
                            <th>Journal Title</th>
                            <th width="500">Instruction</th>
                            <th>Year</th>
                            <th>Teacher</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $journal = new Journal;
                          $journal_arr = $journal->index();
                          $index = 1;
                          foreach($journal_arr as $value){
                            ?>
                              <tr>
                                <td>
                                    <a href="assets/uploads/<?php echo $value->pdf; ?>" target="_blank"><button class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button></a>
                                    <a href="edit_journal.php?id=<?php echo $value->id; ?>"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a>
                                    <a href="delete_journal.php?id=<?php echo $value->id; ?>"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>
                                </td>
                                <td><?php echo $index; $index++; ?></td>
                                <td><?php echo $value->journal_title; ?></td>
                                <td><?php echo $value->instruction; ?></td>
                                <td>
                                  <?php
                                    $grade_data = $journal->fetchGradeById($value->grade_id);
                                    echo $grade_data->grade_name;
                                  ?>
                                </td>
                                <td>
                                  <?php
                                    $user_data = $journal->fetchUserById($value->user_id);
                                    echo $user_data->name;
                                  ?>
                                </td>
                                <td><?php echo $value->start_date; ?></td>
                                <td><?php echo $value->end_date; ?></td>
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