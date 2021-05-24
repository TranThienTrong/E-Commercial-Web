<div class="col-md-12">
    <div class="row">
        <header class="bg-dark text-white py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>
                            <i class="fas fa-store" style="color:#27aae1"></i> Manage Provider
                        </h1>
                    </div>
                </div>
            </div>
        </header>


        <!-- MAIN -->


        <div class="row">
            <div class="offset-lg-1 col-lg-10">

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <h2>Add New Provider</h2>
                            <?php add_provider(); ?>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Username"><span class="FieldInfo"> Username: </span></label>
                                <input class="form-control" type="text" name="Username" id="Username">
                            </div>

                            <div class="form-group">
                                <label for="Name"><span class="FieldInfo"> Name: </span></label>
                                <input class="form-control" type="text" name="Name" id="Name">
                            </div>

                            <div class="form-group">
                                <label for="Email"><span class="FieldInfo"> Email: </span></label>
                                <input class="form-control" type="email" name="Email" id="Email">
                            </div>

                            <div class="form-group">
                                <label for="Address"><span class="FieldInfo"> Address: </span></label>
                                <input class="form-control" type="text" name="Address" id="Address">
                            </div>

                            <div class="form-group">
                                <label for="Phone"><span class="FieldInfo"> Phone Number: </span></label>
                                <input class="form-control" type="number" name="Phone" id="Phone">
                            </div>


                            <div class="form-group">
                                <label for="Password"><span class="FieldInfo"> Password: </span></label>
                                <input class="form-control" type="password" name="Password" id="Password">
                            </div>

                            <div class="form-group">
                                <label for="ConfirmPassword"><span class="FieldInfo"> Confirm Password:
                                    </span></label>
                                <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword">
                            </div>

                            <div class="form-group">
                                <label for="Provider_logo">Provider Logo</label>
                                <input type="file" name="file">
                            </div>


                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="submit" name="Add_Provider" class="btn btn-primary btn-lg"
                                        value="Add Provider">
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Provider Name</th>
                            <th>Provider Email</th>
                            <th>Provider Address</th>
                            <th>Provider Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>



                    <?php



                    $sql = "SELECT * FROM providers ORDER BY provider_id DESC";
                    $result = query($sql);
                    $SrNo = 0;
                    while ($DataRows = fetch_array($result)) :
                        $Provider_Id = $DataRows["provider_id"];
                        $Provider_UserName = $DataRows["username"];
                        $Provider_Name = $DataRows["name"];
                        $Provider_Email = $DataRows["email"];
                        $Provider_Address = $DataRows["address"];
                        $Provider_Phone = $DataRows["phone_number"];
                        $SrNo++;
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $SrNo; ?></td>
                            <td><?= $Provider_UserName; ?></td>
                            <td><?= $Provider_Name; ?></td>
                            <td><?= $Provider_Email; ?></td>
                            <td><?= $Provider_Address; ?></td>
                            <td><?= $Provider_Phone; ?></td>
                            <td><a class="btn btn-danger" href="DeleteAdmin.php?id=<?= $AdminId; ?>">Delete</a>
                            </td>
                        </tr>

                    </tbody>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
</div>