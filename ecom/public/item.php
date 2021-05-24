<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>
<!-- Page Content -->
<?php $SearchQueryParameter = $_GET['id']; ?>





<?php

global $ConnectingDB;
if (isset($_POST["Submit"])) {

    $Name = $_POST["CommenterName"];
    $Email = $_POST["CommenterEmail"];
    $Comment = $_POST["CommenterThoughts"];




    if (empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION["ErrorMessage"] = "Must Filled Out";
        redirect("item.php?id=$SearchQueryParameter");
    } elseif (strlen($Comment) >= 500) {
        $_SESSION["ErrorMessage"] = "Must less than 500 charactes";
        redirect("item.php?id=$SearchQueryParameter");
    } else {
        $sql = "INSERT INTO review(name,email,comment,status,product_id) ";
        $sql .= "VALUES(:name,:email,:comment,'OFF',:product_id)";

        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':name', $Name);
        $stmt->bindValue(':email', $Email);
        $stmt->bindValue(':comment', $Comment);
        $stmt->bindValue(':product_id', $SearchQueryParameter);

        $Execute = $stmt->execute();


        if ($Execute) {
            $_SESSION["Message"] = "WRONG";
            redirect("item.php?id=$SearchQueryParameter");
        } else {
            $_SESSION["Message"] = "TRUE";
            redirect("item.php?id=$SearchQueryParameter");
        }
    }
}
?>



<div class="container">

    <!-- Side Navigation -->
    <?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>
    <!-- End Side Navigation -->

    <?php
    $sql = "SELECT * FROM products ";
    $sql .= "WHERE product_id ='" . escape_string($_GET['id']) . "'";

    $result = query($sql);
    confirm($result);
    while ($row = fetch_array($result)) :
    ?>

    <?php
        $sql_provider = "SELECT * FROM providers ";
        $sql_provider .= "WHERE provider_id ='" . escape_string($row["provider_id"]) . "'";

        $result_provider = query($sql_provider);

        while ($provider_row = fetch_array($result_provider)) {
            $provider_name = $provider_row['name'];
        }

        $sql_category = "SELECT * FROM categories ";
        $sql_category .= "WHERE cat_id ='" . escape_string($row["product_category_id"]) . "'";

        $result_category = query($sql_category);

        while ($category_row = fetch_array($result_category)) {
            $category_name = $category_row['cat_title'];
        }

        ?>

    <div class="col-md-9">

        <!--Row For Image and Short Description-->

        <div class="row">

            <div class="col-md-7">
                <img class="img-responsive" src="../resources/<?= display_image($row["product_image"]); ?>"
                    alt="<?= $row["product_image"]; ?>" width="100%">
            </div>
            <div class="col-md-5">
                <div class="thumbnail">
                    <div class="caption-full">
                        <h2><?= $row["product_title"]; ?></h2>
                        <h4>in <a href="category.php?id= <?= $row["product_category_id"]; ?>">
                                <?= $category_name; ?></a>
                        </h4>
                        <hr>
                        <h4 class="">Price: <?= "$" . $row["product_price"]; ?></h4>

                        <div class="ratings">

                            <p>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                            </p>
                        </div>

                        <p><?= $row["short_desc"]; ?></p>

                        <br>
                        <h4>Provider: <a href="provider.php?id=<?= $row["provider_id"]; ?>"> <?= $provider_name; ?></a>
                        </h4>
                        <hr>
                        <form action="">
                            <div class=" form-group">
                                <a href="../resources/cart.php?add=<?= $row["product_id"]; ?>"
                                    class="btn btn-primary">Add to Cart</a>
                            </div>
                        </form>

                    </div>

                </div>

            </div>


        </div>
        <!--Row For Image and Short Description-->


        <hr>


        <!--Row for Tab Panel-->

        <div class="row">

            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                            data-toggle="tab">Description</a>
                    </li>
                    <li role="presentation"><a href="#review" aria-controls="review" role="tab"
                            data-toggle="tab">Reviews</a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <p></p>
                        <p><?= $row["product_description"] ?></p>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="review">
                        <div class="col-md-6">
                            <?php
                                global $ConnectingDB;
                                $sql_comment = "SELECT * FROM review WHERE product_id=$SearchQueryParameter AND status='ON'";
                                $stmt_comment = $ConnectingDB->query($sql_comment);
                                while ($DataRows = $stmt_comment->fetch()) :
                                    $CommenterName = $DataRows["name"];
                                    $CommentContent = $DataRows["comment"];

                                ?>
                            <div>
                                <div class="media CommentBlock">
                                    <img class="d-block img-fluid align-self-start" src="Images/comment.png" alt=""
                                        sizes="" srcset="">
                                    <div class="media-body ml-2">
                                        <h6 class="lead"><?= $CommenterName; ?></h6>

                                        <p><?= $CommentContent; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>


                        <div class="col-md-6">
                            <form action="item.php?id=<?= $SearchQueryParameter; ?>" method="post">
                                <div class="card mb-3">

                                    <div class="card-header">
                                        <h5 class="FieldInfo">Share Your Thought About This Post</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user fw"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="CommenterName"
                                                    placeholder="Name" value="">
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="CommenterEmail"
                                                    placeholder="Email" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <textarea class="form-control" name="CommenterThoughts" rows="6"
                                                    cols="80"> </textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>


        </div>
        <!--Row for Tab Panel-->




    </div>

    <?php endwhile; ?>

</div>
<!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>