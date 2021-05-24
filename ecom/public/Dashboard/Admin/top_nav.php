<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Admin</span>

        </button>
        <a class="navbar-brand" href="index.php">Home</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                    <?php
                    if (isset($_SESSION['UserName'])) {
                        echo $_SESSION['UserName'];
                    }
                    ?>
            </li>
        </ul>
    </div>

    <!-- /.navbar-collapse -->
</div>
<!-- /.container -->