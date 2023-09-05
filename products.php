<?php
include('includes/header.php');
session_start();
if(!$_SESSION['loggedInUser']){
    header("Location:index.php");
}
include('includes/header.php');
include('includes/connection.php');
$query= "SELECT * FROM product";
$result=mysqli_query($conn, $query);
if( isset( $_GET['alert'] ) ) {
    if( $_GET['alert'] == 'deleted' ) {
        $alertMessage = "<div class='alert alert-success'>Client deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}
?>

<h1>My Products</h1>

<table class="table table-striped table-bordered">
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Description</th>
        <th>Purchase Price</th>
        <th>Seal Price</th>
        <th>Quantity</th>
        <th>Product Type</th>
        <th>Sealer Name</th>
        <th>Sealer Contact</th>
        
    </tr>
   
    <?php
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo '<td><img src="products_images/'.$row['image'].'" height="100" width="100">'

           . "</td><td>".$row['name']."</td><td>".$row['description']."</td><td>".$row['purchase_price']."</td><td>".$row['seal_price'].
            "</td><td>".$row['quantity']."</td><td>".$row['product_type']."</td><td>".$row['sealer_name']."</td><td>".$row['sealer_contact'];
            echo '<td><a href="edit_products.php?id='.$row['id'].'" type="button" class="btn btn-default btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a></td>';
            echo "</tr>";
        }
    }else{
        echo "<div class='alert alert-warning'>We have no products!</div>";
    }
    ?>

    <tr>
        <td colspan="9"><div class="text-center"><a href="add_products.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Product</a></div></td>
    </tr>
</table>

<?php
include('includes/footer.php');
?>