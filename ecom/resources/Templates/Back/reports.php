<h1 class="page-header">
    All Reports
</h1>

<h3 class="bg-success"><?php display_message(); ?></h3>
<table class="table table-hover">


    <thead>

        <tr>
            <th>Id</th>
            <th>Product Id</th>
            <th>Order Id</th>
            <th>Price</th>
            <th>Product title</th>
            <th>Product quantity</th>
            <th>Customer Username</th>
            <th>Customer Email</th>
            <th>Customer Phone Number</th>
            <th>Customer Address</th>
        </tr>
    </thead>
    <tbody>


        <?php get_reports(); ?>


    </tbody>
</table>