<?php require_once("../resources/config.php"); ?>

<?php

$_SESSION["UserId"] = null;
$_SESSION["UserName"] = null;
$_SESSION["ProviderName"] = null;



session_destroy();
redirect("index.php");