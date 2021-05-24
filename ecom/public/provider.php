<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<!-- Page Content -->
<?php
$query = query("SELECT * FROM providers WHERE provider_id={$_GET['id']}");
confirm($query);
while ($row = fetch_array($query)) {
    $Provider_name = $row['name'];
    $Provider_address = $row['address'];
    $Provider_phone = $row['phone_number'];
    $Provider_email = $row['email'];
    $Provider_logo = $row['provider_image'];
}
?>
<div class="container">

    <!-- Jumbotron Header -->
    <header class="row jumbotron hero-spacer">
        <div class="col-md-3 col-sm-6">
            <img class="img-responsive" src="../resources/uploads/<?= $Provider_logo; ?>" style="height:300px">
        </div>
        <div class="col-md-9 col-sm-6">

            <h1><?= $Provider_name; ?></h1>

            <hr>
            <h3>Provider info</h3>
            <hr>
            <h6>Send Us At: <?= $Provider_email; ?></h6>
            <h6>Place: <?= $Provider_address; ?></h6>
            <h6>Contact: <?= $Provider_phone; ?></h6>
        </div>

    </header>

    <hr>
    <h1></h1>
    <!-- Title -->
    <div class="row">
        <div class="col-lg-12">
            <h3>Our Products</h3>
        </div>
    </div>
    <!-- /.row -->

    <!-- Page Features -->
    <div class="row text-center">
        <?php get_products_in_provider_page(); ?>
    </div>
    <!-- /.row -->

    <hr>
</div>

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>