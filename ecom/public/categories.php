<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php")


?>
<!-- Page Content -->
<div class="container">


    <!-- Jumbotron Header -->
    <header>
        <header class="jumbotron hero-spacer">
            <h1>Categories</h1>
            <p>Various of Categories are waiting for you</p>

        </header>
    </header>

    <hr>


    <!-- Page Features -->
    <div class="row text-center">
        <?= get_categories_in_cat_page(); ?>
    </div>
    <!-- /.row -->

    <hr>
</div>

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>