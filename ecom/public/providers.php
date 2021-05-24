<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php")


?>
<!-- Page Content -->
<div class="container">


    <!-- Jumbotron Header -->
    <header>
        <h1>Providers</h1>
    </header>

    <hr>
    <div class="row carousel-holder">

        <div class="col-md-12">
            <?php include(TEMPLATE_FRONT . DS . "slider.php") ?>
        </div>

    </div>

    <!-- Page Features -->
    <div class="row text-center">
        <?= get_providers_in_provider_page(); ?>
    </div>
    <!-- /.row -->

    <hr>
</div>

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>