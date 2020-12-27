<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Journal Done</h1>
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
                            <th>Journal Title</th>
                            <th width="500">Instruction</th>
                            <th>Student</th>
                            <th>Readed DateTime</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $journal = new Journal;
                          $journal_arr = $journal->selectJournalDone();
                          $index = 1;
                          foreach($journal_arr as $value){
                            ?>
                              <tr>
                                <td><?php echo $index; $index++; ?></td>
                                <td>
                                    <?php 
                                        $a_data = $journal->fetchById($value->journal_id);
                                        echo $a_data->journal_title;
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