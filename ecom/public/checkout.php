<!-- Configuration-->
<?php require_once("../resources/config.php"); ?>
<!-- Header-->
<?php include(TEMPLATE_FRONT .  "/header.php"); ?>


<!-- Page Content -->
<div class="container">
    <!-- /.row -->
    <div class="row">
        <h4 class="text-center bg-danger"><?php display_message(); ?></h4>
        <h1>Checkout</h1>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>

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
                    <?php analyzing_cart(); ?>
                </tbody>
            </table>
            <?php
            if (isset($_SESSION["item_quantity"]) && $_SESSION["item_quantity"] >= 1) {
                echo " <a class='btn btn-primary' href='order_detail.php'>Order Information</a>";
            }
            ?>


        </form>


        <!--  ***********CART TOTALS*************-->

        <div class="col-xs-4 pull-right ">
            <h2>Cart Totals</h2>

            <table class="table table-bordered" cellspacing="0">

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

        </div><!-- CART TOTALS-->


    </div>
</div>


<!-- Footer -->
<?php include(TEMPLATE_FRONT .  "/footer.php"); ?>