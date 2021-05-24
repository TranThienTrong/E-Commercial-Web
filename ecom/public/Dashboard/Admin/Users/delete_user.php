<?php require_once("../../../../resources/config.php"); ?>

<?php

if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;

    $sql = "DELETE FROM users WHERE user_id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Deleted";
        redirect("../index.php?users");
    } else {
        $_SESSION["ErrorMessage"] = "Something went Wrong";
        redirect("../index.php?users");
    }
}

?>