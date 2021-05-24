<?php require_once("../../../resources/config.php"); ?>

<?php include("header.php"); ?>

<?php

// if (!isset($_SESSION["ProviderName"])) {
//     redirect("../../public");
// }

//Confirm_Login("../../login_user.php");

?>


<!-- Page Heading -->

<!-- /.row -->
<div class="container-fluid">
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>

    <!-- FIRST ROW WITH PANELS -->

    <?php
    # $_SERVER["REQUEST_URI"]; // Path of this file in Folder
    # __DIR__; // Path of this file in the Computer

    if ($_SERVER["REQUEST_URI"] == "/ecom/public/Dashboard/Admin/" || $_SERVER["REQUEST_URI"] == "/ecom/public/Dashboard/Admin/index.php") {
        include(TEMPLATE_BACK . "/admin_content.php");
    }


    if (isset($_GET["categories"])) {
        include(TEMPLATE_BACK . "/categories.php");
    }
    if (isset($_GET["Users"])) {
        include("Users/Users.php");
    }
    if (isset($_GET["add_user"])) {
        include(TEMPLATE_BACK . "/add_user.php");
    }
    if (isset($_GET["edit_user"])) {
        include(TEMPLATE_BACK . "/edit_user.php");
    }
    if (isset($_GET["delete_user"])) {
        include(TEMPLATE_BACK . "/delete_user.php");
    }
    if (isset($_GET["Providers"])) {
        include("Providers/add_providers.php");
    }
    if (isset($_GET["slides"])) {
        include(TEMPLATE_BACK . "/slides.php");
    }
    if (isset($_GET["Reviews"])) {
        include("Reviews/Reviews.php");
    }
    if (isset($_GET["delete_slide_id"])) {
        include(TEMPLATE_BACK . "/delete_slide.php");
    }

    ?>

    <?php include("footer.php"); ?>