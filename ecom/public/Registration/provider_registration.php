<?php require_once("../../resources/config.php"); ?>



<?php

if (isset($_POST["signup"])) {
    $Username = $_SESSION["UserName"];

    $ShopName = $_POST["ShopName"];
    $Email = $_POST["Email"];
    $Address = $_POST["Address"];
    $Password = $_POST["Password"];
    $PhoneNumber = $_POST["PhoneNumber"];
    $ConfirmPassword = $_POST["ConfirmPassword"];

    $bytes = openssl_random_pseudo_bytes(10);
    $Token = bin2hex($bytes);


    if (empty($Username) && empty($Username) && empty($Username) && empty($Username)) {
        $_SESSION["ErrorMessage"] = "All Field Must be fill";
    } elseif ($Username == "") {
        $_SESSION["ErrorMessage"] = "Username missing";
    } elseif ($Password !== $ConfirmPassword) {
        $_SESSION["ErrorMessage"] = "Both Password Must be the same";
    } elseif (strlen($Password) < 4) {
        $_SESSION["ErrorMessage"] = "At least 4 character";
    } elseif (CheckExisting('providers', 'email', $Email)) {
        $_SESSION["ErrorMessage"] = "Email already use";
    } elseif (CheckExisting('providers', 'username', $Username)) {
        $_SESSION["ErrorMessage"] = "Username already use";
    } else {
        global $ConnectingDB;
        $Hashed_Password = Password_Encription($Password);
        $sql = "INSERT INTO providers(username,name,email,password,address,phone_number) VALUES('$Username','$ShopName','$Email','$Hashed_Password','$Address','$PhoneNumber')";
        $Execute = $ConnectingDB->query($sql);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Great";
            redirect("../index.php");
        } else {
            $_SESSION["ErrorMessage"] = "Wrong";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="../fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="form.css">
</head>

<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">

                    <div class="signup-form">

                        <h2 class="form-title">Sign Up To Be Our Provider</h2>
                        <?php

                        echo ErrorMessage();
                        echo SuccessMessage();
                        ?>
                        <form method="POST" action="provider_registration.php" class="register-form" id="register-form">

                            <div class="form-group">
                                <label for="ShopName"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="text" name="ShopName" id="ShopName" placeholder="Your Shop Name" />
                            </div>

                            <div class="form-group">
                                <label for="Email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="Email" id="Email" placeholder="Your Email" />
                            </div>

                            <div class="form-group">
                                <label for="PhoneNumber"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="number" name="PhoneNumber" id="PhoneNumber"
                                    placeholder="Your Phone Number" />
                            </div>

                            <div class="form-group">
                                <label for="Address"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="text" name="Address" id="Address" placeholder="Your Shop Address" />
                            </div>

                            <div class="form-group">
                                <label for="Pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="Password" id="Pass" placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <label for="ConfirmPassword"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="ConfirmPassword" id="ConfirmPassword"
                                    placeholder="Repeat your password" />
                            </div>

                            <div class="form-group">

                                <label for="agree-term" class="label-agree-term"><span><span></span></span>By
                                    Registration, you I agree all
                                    statements in <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/provider.png" alt="sing up image"></figure>

                    </div>
                </div>
            </div>
        </section>

        <!-- Sing in  Form -->
    </div>

    <!-- JS -->
    <script src="../js/jquery.min.js"></script>

</body>

</html>