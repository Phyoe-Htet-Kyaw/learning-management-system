<?php include "template/header.php"; ?>

    <div class="login-bg-color">
        <div class="login">
            <h1 class="login-header">Sign In</h1>
            <?php
                $auth = new Authentication;
                if($auth->login($_POST)){
                    echo "<script>location.href='index.php'</script>";
                }
            ?>
            <div class="login-form">
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="email">Email <span class="text-red">*</span>: </label>
                        <input type="email" placeholder="Enter Email" id="email" required name="email" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password <span class="text-red">*</span>: </label>
                        <input type="password" placeholder="Enter Password" id="password" required name="password" />
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit"><i class="fa fa-sign-in-alt"></i> Sign In</button>
                    </div>
                    <p>
                        If you don't have already an account, please <a href="register.php">sign up</a>.
                    </p>
                </form>
            </div>
        </div>
        <div class="main-header">
            <div class="header-part">
                <h1>Learning Management System <span>with Agent</span></h1>
            </div>
        </div>
    </div>

<?php include "template/footer.php"; ?>