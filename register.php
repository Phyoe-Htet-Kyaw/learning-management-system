<?php include "template/header.php"; ?>

    <div class="login-bg-color">
        <div class="login">
            <h1 class="register-header">Sign Up</h1>
            <?php
                $auth = new Authentication;
                if($auth->register($_POST)){
                    echo "<script>location.href='index.php'</script>";
                }
            ?>
            <div class="login-form">
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="username">Username <span class="text-red">*</span>: </label>
                        <input type="text" placeholder="Enter Username" id="username" required name="username" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="text-red">*</span>: </label>
                        <input type="email" placeholder="Enter Email" id="email" required name="email" />
                    </div>
                    <div class="form-group">
                        <label for="roll_no">Roll <span class="text-red">*</span>: </label>
                        <input type="text" placeholder="Enter Roll" id="roll_no" required name="roll_no" />
                    </div>
                    <div class="form-group">
                        <label for="grade-id">Year <span class="text-red">*</span>: </label>
                        <select name="grade_id" id="grade-id">
                            <option value="0">- Select -</option>
                            <?php
                                $grade = new Grade;
                                $fetch = $grade->index();

                                foreach($fetch as $value){
                                    ?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->grade_name; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password <span class="text-red">*</span>: </label>
                        <input type="password" placeholder="Enter Password" id="password" required name="password" />
                    </div>
                    <div class="form-group">
                        <label for="con_password">Confirm Password <span class="text-red">*</span>: </label>
                        <input type="password" placeholder="Enter Confirm Password" id="con_password" required name="con_password" />
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit"><i class="fa fa-sign-in-alt"></i> Sign Up</button>
                    </div>
                    <p>
                        If you have already an account, please <a href="login.php">sign in</a>.
                    </p>
                </form>
            </div>
        </div>
        <div class="main-header">
            <div class="header-part">
                <h1>Learning Management System</h1>
            </div>
        </div>
    </div>

<?php include "template/footer.php"; ?>