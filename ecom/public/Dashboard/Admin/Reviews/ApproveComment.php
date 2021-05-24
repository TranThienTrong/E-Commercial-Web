<?php require_once("../../../../resources/config.php"); ?>

<?php

if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;

    $sql = "UPDATE review SET status='ON' WHERE id=$SearchQueryParameter";

    $Execute = $ConnectingDB->query($sql);


    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Approve Succesfull";
        redirect("../index.php?Reviews");
    } else {
        $_SESSION["ErrorMessage"] = "Something went Wrong";
        redirect("../index.php?Reviews");
    }
}

?>