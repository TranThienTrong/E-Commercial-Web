<div class="col-md-12">
    <div class="row">
        <h1 class="page-header">
            All Orders

        </h1>

        <h4 class="bg-success"><?php display_message(); ?></h4>
    </div>

    <div class="row">
        <table class="table table-hover">
            <thead>

                <tr>
                    <th>id</th>
                    <th>Transaction</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Phone Number</th>
                    <th>Customer Address</th>
                    <th>Currency</th>
                    <th>Sattus</th>

                </tr>
            </thead>
            <tbody>
                <?php display_orders(); ?>
            </tbody>
        </table>
    </div>