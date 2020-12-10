<?php include "template/header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Home</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php
        $general = new General;
        $countAssignment = $general->countAssignment();
        $countQuiz = $general->countQuiz();
        $countGrade = $general->countGrade();
        $countJournal = $general->countJournal();
        $countUser = $general->countUser();

        $countAssignmentByUser = $general->countAssignmentByUser();
        $countQuizByUser = $general->countQuizByUser();
        $countJournalByUser = $general->countJournalByUser();

        $user = new User;
        $user_id = $user->fetchById($_SESSION['admin_id']);
    ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $countGrade->count; ?></h3>  

                <p>Years</p>
              </div>
              <div class="icon">
                <i class="fa fa-graduation-cap"></i>
              </div>
              <a href="grade.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <?php
                  if($user_id->status == 2){
                    ?>
                      <h3><?php echo $countQuiz->count; ?></h3>
                    <?php
                  }else if($user_id->status == 1){
                    ?>
                      <h3><?php echo $countQuizByUser->count; ?></h3>
                    <?php
                  }
                ?>
                

                <p>Quiz</p>
              </div>
              <div class="icon">
                <i class="fa fa-question-circle"></i>
              </div>
              <a href="quize_title.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <?php
                  if($user_id->status == 2){
                    ?>
                      <h3><?php echo $countAssignment->count; ?></h3>
                    <?php
                  }else if($user_id->status == 1){
                    ?>
                      <h3><?php echo $countAssignmentByUser->count; ?></h3>
                    <?php
                  }
                ?>

                <p>Assignment</p>
              </div>
              <div class="icon">
                <i class="fa fa-book"></i>
              </div>
              <a href="assignment.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php
                  if($user_id->status == 2){
                    ?>
                      <h3><?php echo $countJournal->count; ?></h3>
                    <?php
                  }else if($user_id->status == 1){
                    ?>
                      <h3><?php echo $countJournalByUser->count; ?></h3>
                    <?php
                  }
                ?>

                <p>Journal</p>
              </div>
              <div class="icon">
                <i class="fa fa-newspaper-o"></i>
              </div>
              <a href="journal.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <?php
            if($user_id->status == 2){
              ?>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-primary">
                    <div class="inner">
                    <h3><?php echo $countUser->count; ?></h3>

                      <p>User</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-users"></i>
                    </div>
                    <a href="user.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
              <?php
            }
          ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  
<?php include "template/footer.php"; ?>