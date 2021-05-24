<!-- Configuration-->
<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT .  "/header.php"); ?>
<?php
Confirm_Login("checkout.php");

if (isset($_SESSION["item_quantity"]) && $_SESSION["item_quantity"] < 1) {
    redirect("checkout.php");
}
?>


<?php
$query = query("SELECT * FROM users WHERE username='{$_SESSION['UserName']}'");
while ($row = fetch_array($query)) {
    $UserAddress = $row['address'];
    $UserPhoneNumber = $row['phone_number'];
    $UserEmail = $row['email'];
}

?>

<!-- Page Content -->
<div class="container">


    <!-- /.row -->

    <div class="row">
        <h4 class="text-center bg-danger"><?php display_message(); ?></h4>
        <div class="col-lg-12">
            <h1>Order Infomation</h1>

            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="business" value="business@ecomphp.com.vn">
                <input type="hidden" name="upload" value="1">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Sub-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php order_detail(); ?>
                    </tbody>
                </table>
                <p>Buy with Paypal
                    <?= show_paypal(); ?>
                </p>

            </form>

        </div>




        <div class="col-lg-6">
            <h3>Cart Totals</h3>
            <table class="table table-bordered" cellspacing="0">
                <tbody>
                    <tr class="cart-subtotal">
                        <th>Items:</th>
                        <td>
                            <span class="amount">
                                <?= isset($_SESSION["item_quantity"]) ? $_SESSION["item_quantity"] : $_SESSION["item_quantity"] = '0'; ?>
                            </span>
                        </td>
                    </tr>

                    <tr class="order-total">
                        <th>Order Total</th>
                        <td>
                            <strong>
                                <span class="amount">
                                    <?= isset($_SESSION["item_total"]) ? $_SESSION["item_total"] : $_SESSION["item_total"] = ""; ?>
                                </span>
                            </strong>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>

<hr>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h1>Customer Information</h1>
            <form method="POST" action="order_detail.php" class="text-center">
                <div class="form-group">
                    <div class="input-group">
                        <input type="email" class="form-control" name="Phone Number" placeholder="Phone Number"
                            value="<?= $UserEmail; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="Email" placeholder="Email"
                            value="<?= $UserPhoneNumber; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <textarea class="form-control" name="address" rows="6" cols="80"
                            value="<?= $UserAddress; ?>"> <?= $UserAddress; ?>  </textarea>
                    </div>
                </div>
                <button type="submit">Change Info</button>
            </form>
        </div>

    </div>

    <div class="row">


        <div class="col-lg-6 text-center form-group form-button">
            <a class="btn btn-success"
                href="thank_you.php?username=<?= $_SESSION['UserName']; ?>&email=<?= $UserEmail; ?>&phone=<?= $UserPhoneNumber ?>&tx=1231233&cc=VND&ad=<?= $UserAddress; ?>&st=Completed">Complete
                Payment
            </a>


        </div>
    </div>

</div>






<!--  ***********CART TOTALS*************-->





<!--Main Content-->


</div>

</div>
<hr>

<!-- Footer -->
<?php include(TEMPLATE_FRONT .  "/footer.php"); ?>