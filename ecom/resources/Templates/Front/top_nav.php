<div class="modal fade login" id="loginModal">
    <div class="modal-dialog login animated">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Login with</h4>
            </div>
            <div class="modal-body">
                <div class="box">
                    <div class="content">
                        <div class="social">
                            <a class="circle github" href="#">
                                <i class="fa fa-github fa-fw"></i>
                            </a>
                            <a id="google_login" class="circle google" href="#">
                                <i class="fa fa-google-plus fa-fw"></i>
                            </a>
                            <a id="facebook_login" class="circle facebook" href="#">
                                <i class="fa fa-facebook fa-fw"></i>
                            </a>
                        </div>
                        <div class="division">
                            <div class="line l"></div>
                            <span>or</span>
                            <div class="line r"></div>
                        </div>
                        <div class="error"><?= $_SESSION["ErrorLogin"]; ?></div>
                        <?php
                        if (isset($_POST["Login"])) {
                            $Email = $_POST["Email_PhoneNumber"];
                            $Password = $_POST["Password"];
                            $Phone_Number = $_POST["Email_PhoneNumber"];

                            if (empty($Email) || empty($Phone_Number)) {
                                $_SESSION["ErrorLogin"] = "Email / Phone number is empty";
                            } elseif (empty($Password)) {
                                $_SESSION["ErrorLogin"] = "Password Empty";
                            } else {
                                $Found_Account = login_attempt($Email, $Password);
                                if ($Found_Account) {
                                    $_SESSION["UserId"] = $Found_Account["user_id"];
                                    $_SESSION["UserName"] = $Found_Account["username"];
                                    $_SESSION["ProviderName"] = null;
                                    $_SESSION["AdminName"] = $Found_Account["name"];
                                } else {
                                    $_SESSION["ErrorLogin"] = "Invalid";
                                }
                            }
                        }
                        ?>
                        <div class="form loginBox">
                            <form method="post" action="index.php" accept-charset=" UTF-8">
                                <input id="email" name="Email_PhoneNumber" class="form-control" type="text"
                                    placeholder="Email">
                                <input id="password" name="Password" class="form-control" type="password"
                                    placeholder="Password">
                                <input class="btn btn-default btn-login" name="Login" type="submit" value="Login">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="content registerBox" style="display:none;">
                        <div class="form">
                            <form method="" html="{:multipart=>true}" data-remote="true" action=""
                                accept-charset="UTF-8">
                                <input id="email" class="form-control" type="text" placeholder="Email" name="email">
                                <input id="password" class="form-control" type="password" placeholder="Password"
                                    name="password">
                                <input id="password_confirmation" class="form-control" type="password"
                                    placeholder="Repeat Password" name="password_confirmation">
                                <input class="btn btn-default btn-register" type="button" value="Create account"
                                    name="commit">
                            </form>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <div class="forgot login-footer">
                    <span>Looking to
                        <a href="Registration/user_registration.php">create an account</a>
                        ?</span>
                </div>
                <div class="forgot register-footer" style="display:none">
                    <span>Already have an account?</span>
                    <a href="javascript: showLoginForm();">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>




<nav class="navbar navbar-default navbar-fixed-top">

    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="shop.php">Shop</a>
                </li>

                <li>
                    <a href="categories.php">Categories</a>
                </li>
                <li>
                    <a href="providers.php">Providers</a>
                </li>
                <li>
                    <a href="checkout.php">Checkout</a>
                </li>
                <li>
                    <a href="contact.php">Contact</a>
                </li>

            </ul>




            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                        <?php
                        if (isset($_SESSION['UserName'])) {
                            echo $_SESSION['UserName'];
                        } elseif (isset($_SESSION['ProviderName'])) {
                            echo $_SESSION['ProviderName'];
                        } else {
                            echo "Login Now";
                        }
                        ?>
                    </a>
                    <ul class="dropdown-menu">

                        <?php
                        if (!isset($_SESSION['UserName']) && !isset($_SESSION["ProviderName"])) {
                            echo " <li class='divider'></li>
                    <li>
                        <a class='btn big-login' data-toggle='modal' href='javascript:void(0)'
                            onclick='openLoginModal();'>Log
                            in</a>
                    </li>

                    <li class='divider'></li>
                    <li>
                        <a class='btn big-register' data-toggle='modal' href='Registration/user_registration.php'
                            onclick='openRegisterModal();'>Register</a>
                    </li>";
                        } else {
                            provider_authentication();
                            echo "<li class='divider'></li>";
                            echo "<li>
                        <a href='MyProfile.php'><i class='fa fa-fw fa-user'></i>Account Setting</a>
                    </li>
                    <li>
                        <a href='order_detail.php'><i class='fa fa-fw fa-user'></i>My Order</a>
                    </li>
                    <li class='divider'></li>
                    <li>
                        <a href='logout.php'><i class='fa fa-fw fa-power-off'></i> Log Out</a>
                    </li>";
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>


        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>