<?php require_once("../../../../resources/config.php");


if (isset($_GET['id'])) {

    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;

    $sql = "DELETE FROM categories WHERE cat_id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Deleted";
        redirect("../index.php?categories");
    } else {
        $_SESSION["ErrorMessage"] = "Something went Wrong";
        redirect("../index.php?categories");
    }
}