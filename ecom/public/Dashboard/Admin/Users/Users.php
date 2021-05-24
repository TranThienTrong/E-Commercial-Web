<?php require_once("../../../resources/config.php"); ?>
<div class="col-lg-12">


    <h1 class="page-header">
        Users
    </h1>
    <p class="bg-success">

    </p>

    <a href="index.php?add_user" class="btn btn-primary">Add User</a>


    <div class="col-md-12">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <?php
            global $ConnectingDB;
            $sql = "SELECT * FROM users ORDER BY user_id DESC ";

            $Execute = $ConnectingDB->query($sql);
            $SrNo = 0;
            while ($DataRows = $Execute->fetch()) :
                $user_id = $DataRows["user_id"];
                $username = $DataRows["username"];
                $email = $DataRows["email"];
                $SrNo++;
            ?>

            <tbody>
                <tr>
                    <td><?= $SrNo; ?></td>
                    <td><?= $user_id; ?></td>
                    <td><?= $username; ?></td>
                    <td><?= $email ?></td>

                    <td><a class="btn btn-danger" href="Users/delete_user.php?id=<?= $user_id; ?>">Delete</a>
                    </td>

                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <!--End of Table-->


    </div>


</div>