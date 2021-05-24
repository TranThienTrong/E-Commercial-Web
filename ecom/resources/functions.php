<?php

function last_id()
{
    global $connection;
    return mysqli_insert_id($connection);
}

function ErrorMessage()
{
    if (isset($_SESSION["ErrorMessage"])) {
        $Output = "<div class=\"alert alert-danger\">";
        $Output .= htmlentities($_SESSION["ErrorMessage"]);
        $Output .= "</div>";
        $_SESSION["ErrorMessage"] = null;

        return $Output;
    }
}
function SuccessMessage()
{
    if (isset($_SESSION["SuccessMessage"])) {
        $Output = "<div class=\"alert alert-success\">";
        $Output .= htmlentities($_SESSION["SuccessMessage"]);
        $Output .= "</div>";
        $_SESSION["SuccessMessage"] = null;

        return $Output;
    }
}


function set_message($msg)
{
    if (!empty($msg)) {
        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function redirect($location)
{
    header("Location: $location ");
}

function query($sql)
{
    global $connection; // From config.php
    return mysqli_query($connection, $sql);
}

function confirm($result_set)
{
    global $connection;
    if (!$result_set) {
        exit("Database query failed." . mysqli_error($connection));
    }
}


function escape_string($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result)
{
    return mysqli_fetch_assoc($result);
}


/************************************ FRONT END FUNCTION *************************************/




// get product
function get_products()
{
    $query = query(" SELECT * FROM products WHERE product_quantity >= 1");
    confirm($query);
    $rows = mysqli_num_rows($query);
    /********************************* Pagination *******************************/

    if (isset($_GET['page'])) {
        $page = preg_replace('#[^0-9]#', '', $_GET['page']);
    } else {
        $page = 1;
    }

    $perPage = 6;
    $lastPage = ceil($rows / $perPage);


    if ($page < 1) {
        $page = 1;
    } elseif ($page > $lastPage) {
        $page = $lastPage;
    }

    $middleNumbers = '';

    $sub1 = $page - 1;
    $sub2 = $page - 2;
    $add1 = $page + 1;
    $add2 = $page + 2;

    if ($page == 1) {

        $middleNumbers .= '
            <li class="page-item active">
                <a>' . $page . '</a>
            </li>';
        $middleNumbers .= '
            <li class="page-item">
                <a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a>
            </li>';
    } elseif ($page == $lastPage) {
        $middleNumbers .= '
            <li class="page-item">
                <a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a>
            </li>';
        $middleNumbers .= '
            <li class="page-item active">
                <a>' . $page . '</a>
            </li>';
    } elseif ($page > 2 && $page < ($lastPage - 1)) {
        $middleNumbers .= '
            <li class="page-item">
                <a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub2 . '">' . $sub2 . '</a>
            </li>';
        $middleNumbers .= '
            <li class=" page-item">
                <a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a>
            </li>';
        $middleNumbers .= '
            <li class="page-item active">
                <a>' . $page . '</a>
            </li>';
        $middleNumbers .= '
            <li class="page-item">
                <a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a>
            </li>';
        $middleNumbers .= '
            <li class="page-item">
                <a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add2 . '">' . $add2 . '</a>
            </li>';
    } elseif ($page > 1 && $page < $lastPage) {
        $middleNumbers .= '
            <li class="page-item">
                <a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a>
            </li>';
        $middleNumbers .= '
            <li class=" page-item active">
                <a>' . $page . '</a>
            </li>';
        $middleNumbers .= '
            <li class="page-item">
                <a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a>
            </li>';
    }

    $limit = "LIMIT " . ($page - 1) * $perPage . ',' . $perPage;
    $query2 = query(" SELECT * FROM products $limit");
    confirm($query2);

    $outputPagination = "";
    if ($page != 1) {
        $prev = $page - 1;
        $outputPagination .= '
            <li class="page-item">
                <a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $prev . '">Previous</a>
            </li>';
    }

    $outputPagination .= $middleNumbers;

    if ($page != $lastPage) {
        $next = $page + 1;
        $outputPagination .= '
            <li class="page-item">
                <a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $next . '">Next</a>
            </li>';
    }





    /********************************* Get Product *******************************/

    while ($row = fetch_array($query2)) {


        $product_image = display_image($row["product_image"]);


        $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="item.php?id={$row["product_id"]}"><img style="height:250px" src="../resources/{$product_image}" alt=""></a>
                <div class="caption">
                    <h4 class="pull-right">&#36;{$row["product_price"]}</h4>
                    <h4><a href="item.php?id={$row["product_id"]}">{$row["product_title"]}</a>
                    </h4>
                    <h5 class="">{$row["short_desc"]}</h4>  
                    <hr>       
                    <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row["product_id"]}">Add To Cart<span> <img style="height:23px; width:23px" src="assets/icon/cart.png"></span></a>
                    <a class="btn btn-default pull-right" target="_blank" href="item.php?id={$row["product_id"]}">More Info</a>
                    </div>
                     
            </div>
        </div>
DELIMETER;
        echo $product;
    }


    echo "<div class='col-sm-12 col-md-12 col-lg-12 text-center'>
            <ul class='pagination center-text'>{$outputPagination}</ul>
        </div>";
}


function get_categories()
{
    $query = query("SELECT * FROM categories");
    confirm($query);

    while ($row = fetch_array($query)) {
        $category_icon = display_images($row["cat_icon"], "assets/icon");
        $category_links = <<<DELIMETER
        <a href='category.php?id={$row["cat_id"]}' class='list-group-item'><img src='../public/{$category_icon}' width='30px' height='30px'>  {$row['cat_title']}</a>
DELIMETER;
        echo $category_links;
    }
}



function get_products_in_cat_page()
{
    $sql = " SELECT * FROM products ";
    $sql .= "WHERE product_category_id='" . escape_string($_GET['id']) . "' AND product_quantity >= 1";

    $result = query($sql);
    confirm($result);

    while ($row = fetch_array($result)) {
        $product_image = display_image($row["product_image"]);
        $product = <<<DELIMETER
        <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <a href="item.php?id={$row["product_id"]}"><img style="height:250px" src="../resources/{$product_image}" alt=""></a>
            <div class="caption">
                <h3>{$row["product_title"]}</h3>
                <p>{$row["short_desc"]}</p>
                <p>
                    <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row["product_id"]}" class="btn btn-default">More
                        Info</a>
                </p>
            </div>
        </div>
    </div>
DELIMETER;
        echo $product;
    }
}


function get_products_in_provider_page()
{
    $sql = " SELECT * FROM products ";
    $sql .= "WHERE provider_id='" . escape_string($_GET['id']) . "' AND product_quantity >= 1";

    $result = query($sql);
    confirm($result);

    while ($row = fetch_array($result)) {
        $product_image = display_image($row["product_image"]);
        $product = <<<DELIMETER
        <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <a href="item.php?id={$row["product_id"]}"><img style="height:250px" src="../resources/{$product_image}" alt=""></a>
            <div class="caption">
                <h3>{$row["product_title"]}</h3>
                <p>{$row["short_desc"]}</p>
                <p>
                    <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row["product_id"]}" class="btn btn-default">More
                        Info</a>
                </p>
            </div>
        </div>
    </div>
DELIMETER;
        echo $product;
    }
}



function get_categories_in_cat_page()
{
    $sql = " SELECT * FROM categories ";

    $result = query($sql);
    confirm($result);

    while ($row = fetch_array($result)) {
        $cat_image = display_image($row["cat_image"]);



        $cat = <<<DELIMETER
        <div class="col-md-4 col-sm-6 hero-feature">
        <div class="thumbnail">
            <a href="category.php?id={$row["cat_id"]}"><img style="height:250px" src="../resources/{$cat_image}" alt=""></a>
            <div class="caption">
                <h3>{$row["cat_title"]}</h3>
                <p>{$row["cat_desc"]}</p>
                <p>
                    <a href="category.php?id={$row["cat_id"]}" class="btn btn-primary">Explore!</a>
                </p>
            </div>
        </div>
    </div>
DELIMETER;
        echo $cat;
    }
}


function get_providers_in_provider_page()
{
    $sql = " SELECT * FROM providers ";

    $result = query($sql);
    confirm($result);

    while ($row = fetch_array($result)) {
        $provider_image = display_image($row["provider_image"]);
        $provider = <<<DELIMETER
        <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <a href="provider.php?id={$row["provider_id"]}"><img style="height:250px" src="../resources/{$provider_image}" alt=""></a>
            <div class="caption">
                <h3>{$row["name"]}</h3>
                <p>
                <a href="provider.php?id={$row["provider_id"]}" class="btn btn-primary">Visit Store</a>
                </p>
            </div>
        </div>
    </div>
DELIMETER;
        echo $provider;
    }
}

function provider_authentication()
{
    if (isset($_SESSION["ProviderName"])) {
        // $query = query("SELECT username FROM providers");
        // while ($row = fetch_array($query)) {
        //     if ($_SESSION["UserName"] == $row["username"]) {
        $provider = <<<DELIMETER
                <li>
                    <a href="Dashboard/index.php"><i class="fa fa-fw fa-power-off"></i>Dashboard</a>
                </li>
DELIMETER;
    } else {
        $provider = <<<DELIMETER
                <li>
                    <a href="Registration/provider_registration.php"><i class="fa fa-fw fa-power-off"></i> Register To Be The Provider</a>
                </li>
                <li>
                    <a href="login_provider.php"><i class="fa fa-fw fa-power-off"></i> Login As Provider</a>
                </li>
DELIMETER;
    }

    echo $provider;
}



function get_products_in_shop_page()
{
    $sql = " SELECT * FROM products WHERE product_quantity >= 1 ORDER BY product_id DESC";

    $result = query($sql);
    confirm($result);

    while ($row = fetch_array($result)) {
        $product_image = display_image($row["product_image"]);
        $product = <<<DELIMETER
        <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <a href="item.php?id={$row["product_id"]}"><img style="height:250px" src="../resources/{$product_image}" alt=""></a>
            <div class="caption">
                <h3>{$row["product_title"]}</h3>
                <p>{$row["short_desc"]}</p>
                <p>
                    <a href="../resources/cart.php?add={$row["product_id"]}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row["product_id"]}" class="btn btn-default">More
                        Info</a>
                </p>
            </div>
        </div>
    </div>
DELIMETER;
        echo $product;
    }
}

function login_user($UserName, $Password)
{
    $sql = "SELECT * FROM users WHERE username = '$UserName' AND password = '$Password' LIMIT 1";
    $result = query($sql);
    confirm($result);
    $Result = mysqli_num_rows($result);
    if ($Result == 1) {
        return $Found_Account = fetch_array($result);
    } else {
        return null;
    }
}


function login_provider($Email, $Password)
{
    $sql = "SELECT * FROM providers WHERE email = '$Email' AND password = '$Password' LIMIT 1";
    $result = query($sql);
    confirm($result);
    $Result = mysqli_num_rows($result);
    if ($Result == 1) {
        return $Found_Account = fetch_array($result);
    } else {
        return null;
    }
}



function send_message()
{
    if (isset($_POST["submit"])) {

        $to = "tranthientrong@gmail.com";

        $from_name = $_POST["name"];
        $subject   = $_POST["subject"];
        $email     = $_POST["email"];
        $message   = $_POST["message"];



        $headers = "From: {$from_name} {$email}";

        $result = mail($to, $subject, $message, $headers);
        if (!$result) {
            echo "False";
        } else {
            set_message("Sent");
            redirect("contact.php");
        }
    }
}
function Password_Check($Password, $Existing_Hash)
{
    $Hash = crypt($Password, $Existing_Hash);
    if ($Hash === $Existing_Hash) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function login_attempt($Email, $Password)
{
    $sql = "SELECT * FROM users WHERE email = '$Email'";
    $result = query($sql);
    if ($row = fetch_array($result)) {
        if (Password_Check($Password, $row["password"])) {
            return $row;
        }
    } else
        return null;
}

function login_attempt_provider($Email, $Password)
{
    $sql = "SELECT * FROM providers WHERE email = '$Email' AND username = '{$_SESSION['UserName']}'";
    $result = query($sql);
    if ($row = fetch_array($result)) {
        if (Password_Check($Password, $row["password"])) {
            return $row;
        }
    } else
        return null;
}



function CheckExisting($table, $row, $data)
{
    $query = query(" SELECT * FROM $table WHERE $row = '$data'");
    confirm($query);
    $rows = mysqli_num_rows($query);
    if ($rows > 0) {
        return true;
    } else {
        return false;
    }
}

function Password_Encription($Password)
{
    $Salt_Length = 22;
    $Salt = Generate_Salt($Salt_Length);
    $Hash = crypt($Password, $Salt);
    return $Hash;
}

function Generate_Salt($length)
{
    $Unique_Random_String = md5(uniqid(mt_rand(), true));
    $Base64_String = base64_encode($Unique_Random_String);
    $Modified_Base64_String = str_replace('+', '.', $Base64_String);
    $Salt = substr($Modified_Base64_String, 0, $length);
    return $Salt;
}

/************************************ BACK END FUNCTION *************************************/


function  display_orders()
{
    $query = query("SELECT * FROM orders");
    confirm($query);


    while ($row = fetch_array($query)) {
        $orders = <<<DELIMETER
            <tr>
                <td>{$row["order_id"]}</td>
                <td>{$row["order_transaction"]}</td>
                <td>{$row["customer_username"]}</td>
                <td>{$row["customer_email"]}</td>
                <td>{$row["customer_phone"]}</td>
                <td>{$row["customer_address"]}</td>
                <td>{$row["order_currency"]}</td>
                <td>{$row["order_status"]}</td>
                <td><a class="btn btn-danger" href="index.php?delete_order_id={$row["order_id"]}"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
DELIMETER;

        # Our current path: /ecom/public/Dashboard/index.php?orders
        echo $orders;
    }
}



/************************************ Dashboard Product *************************************/
$upload_directory = "uploads";

function display_image($picture)
{
    global $upload_directory;
    return  $upload_directory . DS . $picture;
}

function display_images($picture, $custom_directory)
{
    return  $custom_directory . DS . $picture;
}



function get_products_in_dashboard()
{

    $query = query(" SELECT * FROM products WHERE provider_id='{$_SESSION["UserId"]}'");
    confirm($query);

    while ($row = fetch_array($query)) {

        $category = show_product_category_title($row["product_category_id"]);
        $product_image = display_image($row["product_image"]);

        $product = <<<DELIMETER
        <tr>
            <td>{$row["product_id"]}</td>
            <td>{$row["product_title"]}<br>
            <a href="index.php?edit_product&id={$row["product_id"]}"><img width="200px" src="../../resources/{$product_image}" alt=""></a>
            </td>
            <td>{$category}</td>
            <td>{$row["product_price"]}</td>
            <td>{$row["product_quantity"]}</td>
            <td><a class="btn btn-danger" href="index.php?delete_product_id={$row["product_id"]}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMETER;
        echo $product;
    }
}



function show_product_category_title($product_category_id)
{
    $category_query = query("SELECT * FROM categories WHERE cat_id='{$product_category_id}'");
    confirm($category_query);

    while ($category_row = fetch_array($category_query)) {
        return $category_row["cat_title"];
    }
}



/************************************ Adding Dashboard Product *************************************/



function add_product()
{
    if (isset($_POST["publish"])) {

        $provider_id       = escape_string($_SESSION["UserId"]);
        $product_title          =   escape_string($_POST["product_title"]);
        $product_category_id    =   escape_string($_POST["product_category_id"]);
        $product_price          =   escape_string($_POST["product_price"]);
        $product_description     =  escape_string($_POST["product_description"]);
        $short_desc             =   escape_string($_POST["short_desc"]);
        $product_quantity       =   escape_string($_POST["product_quantity"]);

        $product_image          =   escape_string($_FILES["file"]["name"]);

        $image_temp_location    =   escape_string($_FILES["file"]["tmp_name"]);
        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);



        $query = query("INSERT INTO products(provider_id,product_title, product_category_id, product_price, product_description, short_desc, product_quantity,product_image) VALUES('{$provider_id}' ,'{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$short_desc}', '{$product_quantity}','{$product_image}')");
        confirm($query);
        $last_id = last_id();
        $_SESSION["SuccessMessage"] = "New Product ID:" . $last_id . "Added";
        redirect("index.php?products");
    }
}

function add_provider()
{
    if (isset($_POST["Add_Provider"])) {

        $UserName = escape_string($_POST['Username']);
        $Name = escape_string($_POST['Name']);
        $Email = escape_string($_POST['Email']);
        $Address = escape_string($_POST['Address']);
        $Phone = escape_string($_POST['Phone']);
        $Password = escape_string($_POST['Password']);

        $product_image          =   escape_string($_FILES["file"]["name"]);
        $image_temp_location    =   escape_string($_FILES["file"]["tmp_name"]);

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);


        $sql = query("INSERT INTO providers(username,name,email,address,password,provider_image,phone_number) 
        VALUES('{$UserName}','{$Name}','{$Email}','{$Address}','{$Password}','{$product_image}','{$Phone}')");

        confirm($sql);
        set_message("New Provider Added");
        redirect('index.php?providers');
    }
}



function show_categories_add_product_page()
{
    $query = query("SELECT * FROM categories");
    confirm($query);

    while ($row = fetch_array($query)) {
        $category_options = <<<DELIMETER
        <option value="{$row["cat_id"]}">{$row["cat_title"]}</option>
DELIMETER;
        echo $category_options;
    }
}



/************************************ Update Admin Product *************************************/


function update_product()
{
    if (isset($_POST["update"])) {
        $product_title          =       escape_string($_POST["product_title"]);
        $product_category_id    =       escape_string($_POST["product_category_id"]);
        $product_price          =       escape_string($_POST["product_price"]);
        $product_description    =       escape_string($_POST["product_description"]);
        $short_desc             =       escape_string($_POST["short_desc"]);
        $product_quantity       =       escape_string($_POST["product_quantity"]);

        $product_image          =       escape_string($_FILES["file"]["name"]);
        $image_temp_location    =       escape_string($_FILES["file"]["tmp_name"]);


        if (empty($product_image)) {
            $get_pic = query("SELECT product_image FROM products WHERE product_id=" . escape_string($_GET["id"]) . "");
            confirm($get_pic);


            while ($pic = fetch_array($get_pic)) {
                $product_image = $pic["product_image"];
            }
        }


        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

        $query = "UPDATE products SET ";
        $query .= "product_title        =   '{$product_title}',         ";
        $query .= "product_category_id  =   '{$product_category_id}',   ";
        $query .= "product_price        =   '{$product_price}',         ";
        $query .= "product_description  =   '{$product_description}',   ";
        $query .= "short_desc           =   '{$short_desc}',            ";
        $query .= "product_quantity     =   '{$product_quantity}',      ";
        $query .= "product_image        =   '{$product_image}'          ";

        $query .= "WHERE product_id ='" . escape_string($_GET["id"]) . "' ";

        $send_update_query =  query($query);
        confirm($send_update_query);
        set_message("Product has been Updated");
        redirect("index.php?products");
    }
}


/************************************ Categories Admin *************************************/

function show_categories_in_dashboard()
{
    $category_query = query("SELECT * FROM categories");
    confirm($category_query);

    while ($row = fetch_array($category_query)) {
        $cat_id = $row["cat_id"];
        $cat_title = $row["cat_title"];


        $category = <<<DELIMETER
        <tr>
            <td>{$cat_id}</td>
            <td>{$cat_title}</td>
            <td><a class="btn btn-danger" href="../../resources/Templates/back/delete_category.php?id={$cat_id}"><span class="glyphicon glyphicon-remove"></span></a></td>
        
        </tr>

DELIMETER;
        echo $category;
    }
}


function add_category()
{
    if (isset($_POST["add_category"])) {
        $cat_title = escape_string($_POST["cat_title"]);
        if (empty($cat_title)) {
            echo "<p class=\"bg-danger\">Cannot be empty</p>";
        } else {
            $insert_cat = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}')");
            confirm($insert_cat);
            $_SESSION["SuccessMessage"] = "Category Added !";
        }
    }
}



/************************************ Users Admin *************************************/

function Confirm_Login($path)
{
    if (isset($_SESSION["UserId"])) {
        return TRUE;
    } else {
        $_SESSION["ErrorMessage"] = "Login Required";
        redirect($path);
    }
}



function display_users()
{
    $user_query = query("SELECT * FROM users");
    confirm($user_query);

    while ($row = fetch_array($user_query)) {
        $user_id = $row["user_id"];
        $username = $row["username"];
        $email = $row["email"];
        $user_photo = $row["user_photo"];
        $password = $row["password"];

        $user = <<<DELIMETER
        <tr>
            <td>{$user_id}</td>
            <td>{$username}</td>
            <td>{$email}</td>
            <td>{$user_photo}</td>
            <td><a class="btn btn-danger" href="index.php?delete_user_id={$row["user_id"]}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMETER;
        echo $user;
    }
}


function add_user()
{
    if (isset($_POST["add_user"])) {
        $username =  escape_string($_POST["username"]);
        $email = escape_string($_POST["email"]);
        $password =  escape_string($_POST["password"]);


        $user_photo = escape_string($_FILES["file"]["name"]);
        $photo_temp = escape_string($_FILES["file"]["tmp_name"]);

        move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);

        $query = query("INSERT INTO users(username,email,password,user_photo) VALUES('{$username}','{$email}','{$password}','{$user_photo}')");
        confirm($query);
        set_message("User Created");
        redirect("index.php?users");
    }
}





/************************************ Report Admin *************************************/

function get_reports()
{
    $query = query(" SELECT * FROM reports WHERE provider_id='{$_SESSION['UserId']}'");
    confirm($query);

    while ($row = fetch_array($query)) {

        $report = <<<DELIMETER
        <tr>
            <td>{$row["report_id"]}</td>
            <td>{$row["product_id"]}</td>
            <td>{$row["order_id"]}</td>
            <td>{$row["product_price"]}</td>
            <td>{$row["product_title"]}</td>
            <td>{$row["product_quantity"]}</td>
            <td>{$row["customer_username"]}</td>
            <td>{$row["customer_email"]}</td>
            <td>{$row["customer_phone"]}</td>
            <td>{$row["customer_address"]}</td>
            <td><a class="btn btn-danger" href="../../resources/Templates/back/delete_report.php?id={$row["report_id"]}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMETER;
        echo $report;
    }
}


/************************************ Slides Function *************************************/

function add_slides()
{
    if (isset($_POST["add_slide"])) {
        $slide_title        = escape_string($_POST["slide_title"]);
        $slide_image        = escape_string($_FILES["file"]["name"]);
        $slide_image_loc    = escape_string($_FILES["file"]["tmp_name"]);


        if (empty($slide_title) || empty($slide_image)) {
            echo "<p class='bg-danger'>This field cannot be empty</p>";
        } else {
            move_uploaded_file($slide_image_loc, UPLOAD_DIRECTORY . DS . $slide_image);


            $query = query("INSERT INTO slides(slide_title,slide_image) VALUES('{$slide_title}','{$slide_image}')");
            confirm($query);
            $_SESSION["SuccessMessage"] = "Slide Added";
            redirect("index.php?slides");
        }
    }
}

function get_current_slide_in_dashboard()
{
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);

    while ($row = fetch_array($query)) {
        $slide_image = display_image($row['slide_image']);
        $slide_active_dashboard = <<<DELIMETER
        
  
        <img style="width:350px" class="img-responsive" src="../../../resources/{$slide_image}" alt="">
  
    
DELIMETER;
        echo $slide_active_dashboard;
    }
}

function get_active_slide()
{
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);

    while ($row = fetch_array($query)) {
        $slide_image = display_image($row['slide_image']);
        $slide_active = <<<DELIMETER
        
    <div class="item active">
        <img class="slide-image" src="../resources/{$slide_image}" alt="">
    </div>
    
DELIMETER;
        echo $slide_active;
    }
}

function get_slides()
{
    $query = query("SELECT * FROM slides");
    confirm($query);

    while ($row = fetch_array($query)) {
        $slide_image = display_image($row['slide_image']);
        $slides = <<<DELIMETER
        
    <div class="item">
        <img class="slide-image" src="../resources/{$slide_image}" alt="">
    </div>
    
DELIMETER;
        echo $slides;
    }
}


function get_slide_thumbnails()
{
    $query = query("SELECT * FROM slides ORDER BY slide_id ASC");
    confirm($query);

    while ($row = fetch_array($query)) {
        $slide_image = display_image($row['slide_image']);
        $slide_thumb_dashboard = <<<DELIMETER
        <div class="col-xs-6 col-md-3">
            <a class="btn btn-danger image_container" href="Slides/delete_slide.php?id={$row['slide_id']}"></a>
                <img class="img-responsive slide_image" src="../../../resources/{$slide_image}" alt="">
            <div class="caption">
            <p class="">{$row['slide_title']}</p>
            </div>
        </div>
    
DELIMETER;
        echo $slide_thumb_dashboard;
    }
}