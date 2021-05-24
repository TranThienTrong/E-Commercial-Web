<?php require_once("../resources/config.php"); ?>
<?php #require_once("../resources/cart.php"); Alreadey inlcude in config.php
?>

<?php include(TEMPLATE_FRONT .  "/header.php"); ?>

<!--http://192.168.64.2/ecom/public/thank_you.php?tx=1231233&amt=123&cc=USA&st=Completed -->



<?php

process_transaction();

?>

<div class="container text-center">

    <figure><img src="Registration/images/thank-you.jpg" alt="thank you image"></figure>
    <h1>THANK YOU</h1>
</div>


<?php include(TEMPLATE_FRONT .  "/footer.php"); ?>