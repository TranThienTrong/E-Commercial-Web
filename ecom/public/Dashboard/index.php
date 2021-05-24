<?php require_once("../../resources/config.php"); ?>
<?php include(TEMPLATE_BACK . "/header.php"); ?>


<?php

if (!isset($_SESSION["ProviderName"])) {
    redirect("../../public");
}
Confirm_Login("../../public/index.php");

?>



<div class="container-fluid">
    <!-- FIRST ROW WITH PANELS -->

    <?php
    # $_SERVER["REQUEST_URI"]; // Path of this file in Folder
    # __DIR__; // Path of this file in the Computer

    if ($_SERVER["REQUEST_URI"] == "/ecom/public/Dashboard/" || $_SERVER["REQUEST_URI"] == "/ecom/public/Dashboard/index.php") {
        include(TEMPLATE_BACK . "/admin_content.php");
    }
    if (isset($_GET["orders"])) {
        include(TEMPLATE_BACK . "/orders.php");
    }
    if (isset($_GET["products"])) {
        include(TEMPLATE_BACK . "/products.php");
    }
    if (isset($_GET["users"])) {
        include(TEMPLATE_BACK . "/users.php");
    }
    if (isset($_GET["delete_user"])) {
        include(TEMPLATE_BACK . "/delete_user.php");
    }
    if (isset($_GET["add_product"])) {
        include(TEMPLATE_BACK . "/add_product.php");
    }
    if (isset($_GET["edit_product"])) {
        include(TEMPLATE_BACK . "/edit_product.php");
    }
    if (isset($_GET["delete_product_id"])) {
        include(TEMPLATE_BACK . "/delete_product.php");
    }
    if (isset($_GET["reports"])) {
        include(TEMPLATE_BACK . "/reports.php");
    }
    if (isset($_GET["delete_order_id"])) {
        include(TEMPLATE_BACK . "/delete_order.php");
    }

    if (isset($_GET["slides"])) {
        include(TEMPLATE_BACK . "/slides.php");
    }
    if (isset($_GET["delete_slide_id"])) {
        include(TEMPLATE_BACK . "/delete_slide.php");
    }

    ?>




    <?php include(TEMPLATE_BACK . "/footer.php"); ?>