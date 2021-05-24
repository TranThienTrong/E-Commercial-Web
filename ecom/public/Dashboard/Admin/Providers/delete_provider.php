<?php require_once("../../../../resources/config.php"); ?>

<?php

if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];

    global $ConnectingDB;

    $sql = "DELETE FROM providers WHERE provider_id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Deleted";
        redirect("../index.php?Providers");
    } else {
        $_SESSION["ErrorMessage"] = "Something went Wrong";
        redirect("../index.php?Providers");
    }
}

?>