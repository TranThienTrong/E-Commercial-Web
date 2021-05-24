<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>
<script src="js/jquery.min.js"></script>
<script src="assets/js/login-register.js" type="text/javascript"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<?php
if (isset($_SESSION["ErrorLogin"])) {

    if ($_SESSION["ErrorLogin"] == "Invalid") {
        echo "<script type='text/javascript'>
    $(document).ready(function() {
        openLoginModal();
        shakeModal('Invalid Email/Phone or Password');
    });
    </script>";
        $_SESSION["ErrorLogin"] = null;
    } elseif ($_SESSION["ErrorLogin"] == "Email / Phone number is empty") {
        echo "<script type='text/javascript'>
    $(document).ready(function() {
        openLoginModal();
        shakeModal('Email / Phone number is empty');
    });
    </script>";
        $_SESSION["ErrorLogin"] = null;
    } elseif ($_SESSION["ErrorLogin"] = "Password Empty") {
        echo "<script type='text/javascript'>
    $(document).ready(function() {
        openLoginModal();
        shakeModal('Password is empty');
    });
    </script>";
        $_SESSION["ErrorLogin"] = null;
    }
}

?>
</body>
<hr>
<div class="container">
    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; PateCan 2020</p>
                <p>--- Tran Thien Trong ---</p>
            </div>
        </div>
    </footer>
</div>

</html>