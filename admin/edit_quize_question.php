<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Edit Quize Question</h1>
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
            $quize_data = $quize_question->fetchById($_GET['id']);
            if($quize_question->update($_POST, $_GET['id'])){
                echo "<script>location.href='quize_question.php'</script>";
            }
          ?>
            <form action="#" method="post">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="quize_question">Question <span class="text-danger">*</span>:</label>
                            <input type="text" value="<?php echo $quize_data->question; ?>" name="quize_question" placeholder="Enter Question" id="quize_question" required class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="quize_title">Quize Title <span class="text-danger">*</span>:</label>
                            <select name="quize_title_id" id="quize_title" required class="form-control form-control-sm">
                                <?php 
                                    $quize_title = new QuizeTitle;
                                    $quize = $quize_title->index();
                                    foreach($quize as $value){
                                        ?>
                                            <option value="<?php echo $value->id; ?>" <?php if($value->id == $quize_data->quize_title_id){ echo "selected"; } ?>><?php echo $value->quize_title; ?></option>   
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="true_answer">True Answer <span class="text-danger">*</span>:</label>
                            <select name="true_answer" id="true_answer" class="form-control form-control-sm">
                                <option value="1" <?php if(1 == $quize_data->true_answer_no){ echo "selected"; } ?>>A</option>
                                <option value="2" <?php if(2 == $quize_data->true_answer_no){ echo "selected"; } ?>>B</option>
                                <option value="3" <?php if(3 == $quize_data->true_answer_no){ echo "selected"; } ?>>C</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="answer_a">Answer - A <span class="text-danger">*</span>:</label>
                            <input type="text" value="<?php echo $quize_data->answer_1; ?>" placeholder="Enter Answer A" name="answer_a" id="answer_a" required class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="answer_b">Answer - B <span class="text-danger">*</span>:</label>
                            <input type="text" value="<?php echo $quize_data->answer_2; ?>" placeholder="Enter Answer B" name="answer_b" id="answer_b" required class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="answer_c">Answer - C <span class="text-danger">*</span>:</label>
                            <input type="text" value="<?php echo $quize_data->answer_3; ?>" placeholder="Enter Answer C" name="answer_c" id="answer_c" required class="form-control form-control-sm">
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