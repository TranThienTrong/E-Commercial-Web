<?php require_once("../../../resources/config.php"); ?>

<header class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <i class="fas fa-comments" style="color:#27aae1"></i> Manage Reviews
                </h1>
            </div>
        </div>
    </div>
</header>

<section class="container py-2 mb-4">
    <div class="row">
        <div class="col-lg-12">
            <h2>Un-Approved Reviews</h2>
            <?php
            echo SuccessMessage();
            echo ErrorMessage();
            ?>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Date & Time</th>
                        <th>Comment</th>
                        <th>Approve</th>
                        <th>Delete</th>

                        <th>Details</th>

                    </tr>
                </thead>
                <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM review WHERE status='OFF' ORDER BY id DESC ";

                $Execute = $ConnectingDB->query($sql);
                $SrNo = 0;
                while ($DataRows = $Execute->fetch()) :
                    $CommentId = $DataRows["id"];
                    $DateTimeOfComment = $DataRows["datetime"];
                    $CommenterName = $DataRows["name"];
                    $CommenterContent = $DataRows["comment"];
                    $CommenterPostId = $DataRows["product_id"];
                    $SrNo++;


                ?>
                <tbody>
                    <tr>
                        <td><?= $SrNo; ?></td>
                        <td><?= $CommenterName; ?></td>
                        <td><?= $DateTimeOfComment; ?></td>
                        <td><?= $CommenterContent; ?></td>
                        <td><a class="btn btn-success"
                                href="Reviews/ApproveComment.php?id=<?= $CommentId; ?>">Approve</a>
                        </td>
                        <td><a class="btn btn-danger" href="Reviews/DeleteComment.php?id=<?= $CommentId; ?>">Delete</a>
                        </td>
                        <td><a class="btn btn-primary" href="../../item.php?id=<?= $CommenterPostId; ?>"
                                target="_blank">Preview Product</a>
                        </td>
                    </tr>

                </tbody>
                <?php endwhile; ?>
            </table>

            <h2>Approved Previews</h2>
            <?php
            echo SuccessMessage();
            echo ErrorMessage();
            ?>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Date & Time</th>
                        <th>Comment</th>
                        <th>Revert</th>
                        <th>Delete</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM review WHERE status='ON' ORDER BY id DESC ";

                $Execute = $ConnectingDB->query($sql);
                $SrNo = 0;
                while ($DataRows = $Execute->fetch()) :
                    $CommentId = $DataRows["id"];
                    $DateTimeOfComment = $DataRows["datetime"];
                    $CommenterName = $DataRows["name"];
                    $CommenterContent = $DataRows["comment"];
                    $CommenterPostId = $DataRows["product_id"];
                    $SrNo++;
                ?>
                <tbody>
                    <tr>
                        <td><?= $SrNo; ?></td>
                        <td><?= $CommenterName; ?></td>
                        <td><?= $DateTimeOfComment; ?></td>
                        <td><?= $CommenterContent; ?></td>
                        <td><a class="btn btn-warning"
                                href="Reviews/DisApproveComment.php?id=<?= $CommentId; ?>">Dis-Approve</a>
                        </td>
                        <td><a class="btn btn-danger" href="Reviews/DeleteComment.php?id=<?= $CommentId; ?>">Delete</a>
                        </td>
                        <td><a class="btn btn-primary" href="../../item.php?id=<?= $CommenterPostId; ?>"
                                target="_blank">Preview
                                Product</a>
                        </td>
                    </tr>

                </tbody>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</section> <!-- FOOTER-->