<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<!-- Page Content -->
<?php
$query = query("SELECT * FROM categories WHERE cat_id={$_GET['id']}");
confirm($query);
while ($row = fetch_array($query)) {
    $Category_title = $row['cat_title'];
}
?>
<div class="container">

    <!-- Jumbotron Header -->
    <header class="jumbotron hero-spacer">
        <h1><?= $Category_title; ?></h1>
        <p></p>
    </header>

    <hr>
    <h1>Hello</h1>
    <!-- Title -->
    <div class="row">
        <div class="col-lg-12">
            <h3>Latest Features</h3>
        </div>
    </div>
    <!-- /.row -->

    <!-- Page Features -->
    <div class="row text-center">
        <?php get_products_in_cat_page(); ?>
    </div>
    <!-- /.row -->

    <hr>
</div>

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>