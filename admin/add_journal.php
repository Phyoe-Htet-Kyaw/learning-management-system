<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Add Journal</h1>
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
          <?php
            $journal = new Journal;
            if($journal->store($_POST, $_FILES)){
                echo "<script>location.href='journal.php'</script>";
            }
          ?>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="journal_title">Journal Title <span class="text-danger">*</span>:</label>
                            <input type="text" name="journal_title" placeholder="Enter Journal Title" id="journal_title" required class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="grade">Year <span class="text-danger">*</span>:</label>
                            <select name="grade_id" id="grade" required class="form-control form-control-sm">
                                <?php 
                                    $grade_arr = $journal->fetchGrade();
                                    foreach($grade_arr as $value){
                                        ?>
                                            <option value="<?php echo $value->id; ?>"><?php echo $value->grade_name; ?></option>   
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date <span class="text-danger">*</span>:</label>
                            <input type="date" name="start_date" id="start_date" required class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date <span class="text-danger">*</span>:</label>
                            <input type="date" name="end_date" id="end_date" required class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="incstruction">Instruction <span class="text-danger">*</span>:</label>
                            <textarea name="instruction" id="instruction" cols="30" rows="9" class="form-control form-control-sm" required placeholder="Enter Instruction"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="pdf">PDF <span class="text-danger">*</span>:</label>
                            <input type="file" name="pdf" id="pdf" required class="form-control-file form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="journal.php"><button type="button" class="btn-danger btn-sm btn"><i class="fa fa-times"></i></button></a>
                        <button type="submit" name="submit" class="btn-success btn-sm btn"><i class="fa fa-check"></i></button>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  
<?php include "template/footer.php"; ?>