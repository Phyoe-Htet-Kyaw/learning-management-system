<?php 
    include "template/header.php"; 
    if(!isset($_GET['id'])){
        echo "<script>location.href='journal.php'</script>";
    }
    $journal = new Journal;
    $data = $journal->fetchById($_GET['id']);
    if(!is_object($data)){
        echo "<script>location.href='journal.php'</script>";
    }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Edit Journal</h1>
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
            if($journal->update($_POST, $_GET['id'])){
                echo "<script>location.href='journal.php'</script>";
            }
          ?>
            <form action="#" method="post">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="journal_title">Journal Title <span class="text-danger">*</span>:</label>
                            <input type="text" name="journal_title" value="<?php echo $data->journal_title; ?>" placeholder="Enter Journal Title" id="journal_title" required class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="grade">Grade <span class="text-danger">*</span>:</label>
                            <select name="grade_id" id="grade" required class="form-control form-control-sm">
                                <?php 
                                    $grade_arr = $journal->fetchGrade();
                                    foreach($grade_arr as $value){
                                        ?>
                                            <option value="<?php echo $value->id; ?>" <?php if($data->grade_id == $value->id){ echo "selected"; } ?>><?php echo $value->grade_name; ?></option>   
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date <span class="text-danger">*</span>:</label>
                            <input type="date" name="start_date" value="<?php echo $data->start_date; ?>" id="start_date" required class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date <span class="text-danger">*</span>:</label>
                            <input type="date" name="end_date" id="end_date" value="<?php echo $data->end_date; ?>" required class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="incstruction">Instruction <span class="text-danger">*</span>:</label>
                            <textarea name="instruction" id="instruction" cols="30" rows="13" class="form-control form-control-sm" required placeholder="Enter Instruction"><?php echo $data->instruction; ?></textarea>
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