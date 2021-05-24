<?php require_once("../../../../resources/config.php"); ?>

<?php

if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    $Admin = $_SESSION["UserName"];
    global $ConnectingDB;

    $sql = "DELETE FROM review WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Deleted";
        redirect("../index.php?Reviews");
    } else {
        $_SESSION["ErrorMessage"] = "Something went Wrong";
        redirect("../index.php?Reviews");
    }
}

?>