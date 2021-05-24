<?php require_once("../resources/config.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
//Confirm_Login(); 
?>

<?php

$UserId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM users WHERE user_id='$UserId'";
$stmt = $ConnectingDB->query($sql);

while ($DataRows = $stmt->fetch()) {
    $ExistingName = $DataRows['name'];
    $ExistingUsername = $DataRows['username'];
    $ExistingAddress = $DataRows['address'];
    $ExistingImage = $DataRows['user_photo'];
}


if (isset($_POST["Submit"])) {
    $Name = $_POST["Name"];
    $Address = $_POST["Address"];
    $Image     = $_FILES["Image"]["name"];
    $tmp_Image = $_FILES["Image"]["tmp_name"];
    $Target    = "../resources/images/" . basename($_FILES["Image"]["name"]);


    // Query to update Admin in DB
    global $ConnectingDB;

    if (!empty($Image)) {
        $sql = "UPDATE users 
            SET name='$Name', address='$Address',user_photo='$Image' 
            WHERE user_id=$UserId";
    } else {
        $sql = "UPDATE users 
        SET name='$Name', address='$Address'
        WHERE user_id=$UserId";
    }
    $Execute = $ConnectingDB->query($sql);
    move_uploaded_file($tmp_Image, $Target);


    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Updated Completed !";
        redirect("MyProfile.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
        redirect("MyProfile.php");
    }
} //Ending of Submit Button If-Condition
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>My Profile</title>
</head>
<!-- HEADER END -->

<!-- Main Area -->
<section class="container py-2 mb-4">

    <div class="row">
        <!-- Left Area -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h3><?= $ExistingName; ?></h3>
                </div>
                <div class="card-body text-center">
                    <img src="../resources/images/<?= $ExistingImage; ?>" class="block img-fluid mb-3">
                    <div>
                        <?= $ExistingAddress; ?>
                    </div>
                </div>
            </div>

        </div>
        <!-- Right Area -->
        <div class="col-md-9" style="min-height:400px;">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form class="bg-light" action="MyProfile.php" method="post" enctype="multipart/form-data">
                <div class="card text-light mb-3">
                    <div class="card-header bg-secondary text-light">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input class="form-control" type="text" name="Name" id="title" placeholder="Your Name"
                                value="">
                        </div>
                        <label class="text-dark" for="Address">Your Address:</label>
                        <div class="form-group">
                            <textarea class="form-control" id="Address" name="Address" rows="8" cols="80"></textarea>
                        </div>
                        <div class="form-group">

                            <div class="custom-file">
                                <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image </label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="index.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>
                                    Back To Home</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Publish
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>



<!-- End Main Area -->
<!-- FOOTER -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
</script>
<?php include(TEMPLATE_FRONT .  "/footer.php"); ?>