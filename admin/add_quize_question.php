<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Add Quize Question</h1>
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
            $quize_question = new QuizeQuestion;
            if($quize_question->store($_POST)){
                echo "<script>location.href='quize_question.php'</script>";
            }
          ?>
            <form action="#" method="post">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="quize_question">Question <span class="text-danger">*</span>:</label>
                            <input type="text" name="quize_question" placeholder="Enter Question" id="quize_question" required class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="quize_title">Quize Title <span class="text-danger">*</span>:</label>
                            <select name="quize_title_id" id="quize_title" required class="form-control form-control-sm">
                                <?php 
                                    $quize_title = new QuizeTitle;
                                    $quize = $quize_title->index();
                                    foreach($quize as $value){
                                        ?>
                                            <option value="<?php echo $value->id; ?>"><?php echo $value->quize_title; ?></option>   
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="true_answer">True Answer <span class="text-danger">*</span>:</label>
                            <select name="true_answer" id="true_answer" class="form-control form-control-sm">
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">C</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="answer_a">Answer - A <span class="text-danger">*</span>:</label>
                            <input type="text" placeholder="Enter Answer A" name="answer_a" id="answer_a" required class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="answer_b">Answer - B <span class="text-danger">*</span>:</label>
                            <input type="text" placeholder="Enter Answer B" name="answer_b" id="answer_b" required class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="answer_c">Answer - C <span class="text-danger">*</span>:</label>
                            <input type="text" placeholder="Enter Answer C" name="answer_c" id="answer_c" required class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="quize_question.php"><button type="button" class="btn-danger btn-sm btn"><i class="fa fa-times"></i></button></a>
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