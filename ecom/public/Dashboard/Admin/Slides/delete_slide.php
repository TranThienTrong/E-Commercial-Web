<?php require_once("../../../../resources/config.php");


if (isset($_GET['id'])) {



    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;

    $sql = "DELETE FROM slides WHERE slide_id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Deleted";
        redirect("../index.php?slides");
    } else {
        $_SESSION["ErrorMessage"] = "Something went Wrong";
        redirect("../index.php?slides");
    }
}