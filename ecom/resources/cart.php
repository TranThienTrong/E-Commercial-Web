<!-- Configuration-->
<?php require_once("config.php"); ?>



<?php

if (isset($_GET["add"])) {
    $query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET["add"]));
    confirm($query);


    while ($row = fetch_array($query)) {
        if ($_SESSION["product_" . $_GET["add"]] != $row["product_quantity"]) {
            $_SESSION["product_" . $_GET["add"]] += 1;
            redirect("../public/checkout.php");
        } else {
            set_message("We only have " . $row["product_quantity"] . " " . $row["product_title"] . " available");
            redirect("../public/checkout.php");
        }
    }
}


if (isset($_GET["remove"])) {
    $_SESSION["product_" . $_GET["remove"]]--;
    if ($_SESSION["product_" . $_GET["add"]] < 1) {
        redirect("../public/checkout.php");
        unset($_SESSION["item_total"]);
        unset($_SESSION["item_quantity"]);
    } else {
    }
}

if (isset($_GET["delete"])) {
    $_SESSION["product_" . $_GET["delete"]] = '0';
    redirect("../public/checkout.php");
    unset($_SESSION["item_total"]);
    unset($_SESSION["item_quantity"]);
}


function analyzing_cart()
{
    $total = 0;
    $item_quantity = 0;
    $sub_total = 0;
    //For Paypal Table
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $quantity = 1;

    // Loop every key_name in $_SESSION to find id, value is quantity;
    // $_SESSION["product_1"] = 3
    foreach ($_SESSION as $name => $value) {
        if ($value > 0) {
            if (substr($name, 0, 8) == "product_") {

                $id = substr($name, 8, strlen($name) - 8);

                $query = query("SELECT * FROM products WHERE product_id='" . escape_string($id) . "'");
                confirm($query);
                while ($row = fetch_array($query)) {

                    $product_image = display_image($row["product_image"]);
                    $sub_total = $row["product_price"] * $value;
                    $item_quantity += $value;


                    $product = <<<DELIMETER
                <tr>
                    <td>{$row["product_title"]}<br>
                    
                    <img width="150px" src="../resources/{$product_image}">
                    </td>
                    <td>&#36;{$row["product_price"]}</td>
                    <td>{$value}</td>
                    <td>&#36;{$sub_total}</td>
                    <td>
                        <a class="btn btn-warning" href="../resources/cart.php?remove={$row["product_id"]}">
                            <span class="glyphicon glyphicon-minus"></span>
                        </a>
                        <a class="btn btn-success" href="../resources/cart.php?add={$row["product_id"]}">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                        <a class="btn btn-danger" href="../resources/cart.php?delete={$row["product_id"]}">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
DELIMETER;

                    echo $product;
                    $item_name++;
                    $item_number++;
                    $amount++;
                    $quantity++;
                }
                $_SESSION["item_total"] = $total += $sub_total;
                $_SESSION["item_quantity"] = $item_quantity;
            }
        }
    }
}


function order_detail()
{
    $total = 0;
    $item_quantity = 0;
    $sub_total = 0;
    //For Paypal Table
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $quantity = 1;

    foreach ($_SESSION as $name => $value) {
        if ($value > 0) {
            if (substr($name, 0, 8) == "product_") {

                $id = substr($name, 8, strlen($name));

                $query = query("SELECT * FROM products WHERE product_id='" . escape_string($id) . "'");
                confirm($query);
                while ($row = fetch_array($query)) {

                    $product_image = display_image($row["product_image"]);
                    $sub_total = $row["product_price"] * $value;
                    $item_quantity += $value;


                    $product = <<<DELIMETER
                <tr>
                    <td>{$row["product_title"]}<br>
                    
                    <img width="150px" src="../resources/{$product_image}">
                    </td>
                    <td>&#36;{$row["product_price"]}</td>
                    <td>{$value}</td>
                    <td>&#36;{$sub_total}</td>
                 
                </tr>
                
                <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
                <input type="hidden" name="quantity_{$quantity}" value="{$value}">
                <input type="hidden" name="currency_code" value="USD">
DELIMETER;

                    echo $product;
                    $item_name++;
                    $item_number++;
                    $amount++;
                    $quantity++;


                    $_SESSION["item_name"] = $row['product_title'];
                    $_SESSION["item_number"] = $row['product_id'];
                    $_SESSION["amount"] = $row['product_price'];
                    $_SESSION["quantity"] = $value;
                }
            }
        }
    }
}


function show_paypal()
{
    if (isset($_SESSION["item_quantity"]) && $_SESSION["item_quantity"] >= 1) {

        $paypal_button = <<<DELIMETER
    
        <input style="width:175px" type="image" name="upload" border="0"
    src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online!">
DELIMETER;
        return $paypal_button;
    }
}






function process_transaction()
{
    if (isset($_GET["tx"])) {
        $username = $_GET["username"];
        $email = $_GET["email"];
        $phone = $_GET["phone"];
        $transaction = $_GET["tx"];
        $currency = $_GET["cc"];
        $address = $_GET["ad"];
        $status = $_GET["st"];



        $total = 0;
        $item_quantity = 0;


        // Loop every key_name in $_SESSION to find id, value is quantity;
        // $_SESSION["product_1"] = 3
        foreach ($_SESSION as $name => $value) {
            if ($value > 0) {
                if (substr($name, 0, 8) == "product_") {

                    $id = substr($name, 8, strlen($name) - 8);

                    $send_order = query("INSERT INTO orders (order_transaction,customer_username,customer_email,customer_phone,customer_address,order_currency, order_status) VALUES('{$transaction}','{$username}','{$email}','{$phone}','{$address}','{$currency}','{$status}')");
                    $last_id = last_id();
                    confirm($send_order);

                    $query = query("SELECT * FROM products WHERE product_id='" . escape_string($id) . "'");
                    confirm($query);

                    while ($row = fetch_array($query)) {

                        $product_price = $row["product_price"];
                        $product_title = $row["product_title"];
                        $provider = $row["provider_id"];
                        $sub_total = $row["product_price"] * $value;
                        $item_quantity += $value;

                        $insert_report = query("INSERT INTO reports (product_id,order_id,provider_id,product_price,product_title,product_quantity,customer_username,customer_email,customer_phone,customer_address) VALUES('{$id}','{$last_id}','{$provider}','{$product_price}','{$product_title}','{$value}','{$username}','{$email}','{$phone}','{$address}')");
                        confirm($insert_report);
                    }
                    $total += $sub_total;
                    echo $item_quantity;
                }
            }
        }
        session_destroy();
    } else {
        redirect("index.php");
    }
}
?>