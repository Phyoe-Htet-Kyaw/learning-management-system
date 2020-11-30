<?php 
    include "template/header.php"; 
    if(!isset($_GET['id'])){
        echo "<script>location.href='grade.php'</script>";
    }
    $grade = new Grade;
    $data = $grade->fetchById($_GET['id']);
    if(!is_object($data)){
        echo "<script>location.href='grade.php'</script>";
    }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Edit Grade</h1>
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
            if($grade->update($_POST, $_GET['id'])){
                echo "<script>location.href='grade.php'</script>";
            }
          ?>
            <form action="#" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="grade">Grade <span class="text-danger">*</span>:</label>
                            <input type="text" name="grade_name" value="<?php echo $data->grade_name; ?>" placeholder="Enter Grade" id="grade" required class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="grade.php"><button type="button" class="btn-danger btn-sm btn"><i class="fa fa-times"></i></button></a>
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