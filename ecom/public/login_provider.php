<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<?php

if (isset($_POST["signin"])) {

    $Email = $_POST['Email'];
    $Password = $_POST['Password'];


    if (empty($Email) || empty($Password)) {
        set_message("Empty");
        // redirect("login_provider.php");
    } else {
        $Found_Account = login_attempt_provider($Email, $Password);

        if ($Found_Account) {
            $_SESSION["UserId"] = $Found_Account["provider_id"];
            $_SESSION["ProviderName"] = $Found_Account["username"];
            $_SESSION["ShopName"] = $Found_Account["name"];
            $_SESSION["SuccessMessage"] = "Welcome" . $_SESSION["ShopName"];
            redirect("index.php");
        } else {
            $_SESSION["ErrorMessage"] = "Invalid Email / Password";
        }
    }
}

?>
<!-- Page Content -->
<div class="container">
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="Registration/images/signin-image.jpg" alt="sing up image"></figure>
                    <a href="Registration/provider_registration.php" class="signup-image-link">Create an provider
                        account</a>
                </div>

                <div class="signin-form">
                    <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    ?>
                    <h2 class="form-title">Provider Sign In</h2>

                    <form method="POST" action="login_provider.php" class="register-form" id="login-form">
                        <div class="form-group">
                            <label for="Email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="email" name="Email" id="Email" placeholder="Providers Email" />
                        </div>
                        <div class="form-group">
                            <label for="Password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="Password" name="Password" id="Password" placeholder="Password" />
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                            <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember
                                me</label>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>


</div>

</div>
<!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>