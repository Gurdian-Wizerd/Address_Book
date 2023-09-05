<?php
 session_start();
 if($_SESSION['loggedInUser']){
    header("Locaion: index.php");
 }
 include('includes/functions.php');
 include('includes/connection.php');
 $query1="SELECT `name` FROM supplier";
 $result1=mysqli_query($conn,$query1);
 $productId=$_GET['id'];
 $query="SELECT * FROM product WHERE id='$productId'";
 $result=mysqli_query($conn,$query);
 if(mysqli_num_rows($result)>0){
     while($row=mysqli_fetch_assoc($result)){
         $productName=$row['name'];
         $productDescription=$row['description'];
         $productPPrice=$row['purchase_price'];
         $productSPrice=$row['seal_price'];
         $productQuantity=$row['quantity'];
         $productType=$row['product_type'];
         $productSealerName=$row['sealer_name'];
         $productImageName=$row['image'];

     }
 
 }else{
     $alertMessage="<div class='alert alert-warning'> Nothing to see here.<a href='clients.php'> Head back</a></div>";
 }


 if(isset($_POST['update'])){
       
 
    $productName=$productDescription=$productPPrice=$productSPrice=$productQuantity=$productType=$productSealerName="";

    $productName=validateFormData($_POST['productName']);
    $productDescription=validateFormData($_POST['productDescription']);
    $productPPrice=validateFormData($_POST['productPPrice']);
    $productSPrice=validateFormData($_POST['productSPrice']);
    $productQuantity=validateFormData($_POST['productQuantity']);
    $productType=validateFormData($_POST['productType']);
    $productSealerName=validateFormData($_POST['productSealer']);
 
    $query2="SELECT `contact` FROM `supplier` WHERE `name`='$productSealerName'";
    $result2=mysqli_query($conn,$query2);

    if(mysqli_num_rows($result2)>0){
        while($row2=mysqli_fetch_assoc($result2)){
            $productSealerContact= $row2['contact'];
        }
    }

//  Image upload php
 $filename = $_FILES["productImage"]["name"];
 // Select file type
 $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
 // valid file extensions
 $extensions_arr = array("jpg","jpeg","png","gif");
 // Check extension
 if( in_array($imageFileType,$extensions_arr) ){
 if(move_uploaded_file($_FILES["productImage"]["tmp_name"],"products_images/".$filename)){
    
     $productImageName=$filename;

 }else{
     echo 'Error in uploading file - '.$_FILES["productImage"]["name"].'';
 }
 }

 $query="UPDATE `product`
 SET name='$productName',
 description='$productDescription',
 purchase_price='$productPPrice',
 seal_price='$productSPrice',
 product_type='$productType',
 sealer_name='$productSealerName',
 sealer_contact='$productSealerContact',
 quantity='$productQuantity',
 image='$productImageName'
 WHERE id ='$productId'";
 $result=mysqli_query($conn, $query);
 if($result){
     $alertMessage="<div class='alert alert-success'>Data updated successfully!<a class='close' data-dismiss='alert'>&times;</a></div>";
 }else{
     echo "Error updating record:".mysqli_errno($conn);
 }


}

if(isset($_POST['delete'])){
    $alertMessage = "<div class='alert alert-danger'>
                        <p>Are you sure you want to delete this product? No take backs!</p><br>
                        <form action='". htmlspecialchars( $_SERVER["PHP_SELF"] ) ."?id=$productId' method='post'>
                            <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, delete!'>
                            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!</a>
                        </form>
                    </div>";

}
if(isset($_POST['confirm-delete'])){
    
    $query="DELETE FROM `product` WHERE id='$productId';";
    $result=mysqli_query($conn,$query);
    if($result){
        header("Location:products.php?alert=deleted");
    }
}
include('includes/header.php');

?>

<h1>Update Product</h1>
<?php echo"$alertMessage";?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?id=<?php echo $productId;?>" method="post" class="row" enctype="multipart/form-data">
    <div class="form-group col-sm-6">
        <label for="product-name">Product Name *</label>
        <input type="text" class="form-control input-lg" id="product-name" name="productName" value="<?php echo $productName;?>" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="product-description">Product Description *</label>
        <textarea type="text" class="form-control input-lg" id="product-description" name="productDescription" required><?php echo $productDescription;?></textarea>
    </div>
    <div class="form-group col-sm-6">
        <label for="product-PPrice">Purchase Price *</label>
        <input type="number" class="form-control input-lg" id="product-PPrice" name="productPPrice" value="<?php echo $productPPrice;?>" required>
    </div> 
    <div class="form-group col-sm-6">
        <label for="product-SPrice">Seal Price *</label>
        <input type="number" class="form-control input-lg" id="product-SPrice" name="productSPrice" value="<?php echo $productSPrice;?>" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="product-quantity">Quantity *</label>
        <input type="number" class="form-control input-lg" id="product-quantity" name="productQuantity" value="<?php echo $productQuantity;?>" required>
    </div>

    <div class="form-group col-sm-6">
        <label for="product-company">Product Type *</label>
        <select class="form-control input-lg" id="productType"name="productType" value="" required>
	<option value="<?php echo $productType;?>"><?php echo $productType;?></option>
	<option value="decor">decor</option>
	<option value="gifting">gifting</option>
	<option value="accsoceries">accsoceries</option>
</select></div>
<div class="form-group col-sm-6">
        <label for="product-company">Supplier Name *</label>
        <select class="form-control input-lg" id="productSealer"name="productSealer" value="" required>
	<option value="<?php echo $productSealerName;?>"><?php echo $productSealerName;?></option>
    <?php 
    if(mysqli_num_rows($result1)>0){
        while($row=mysqli_fetch_assoc($result1)){
            $s_name=$row['name'];
        
            echo "<option value='$s_name'>";
            echo "$s_name";
            echo "</option>";
        }

    }else{
        echo "No Supplier Added <br> <a href='add_supplier.php' class='btn btn-lg btn-success pull-right'>Add Supplier</a>";
    }
    
    ?>

</select>    </div>
<div class="form-group col-sm-6">
        <label for="product-image">Product Image *</label>
        <img src="products_images/<?php echo $productImageName;?>" height=100px width=100px>
        <input type="file" class="form-control input-lg" id="product-image" name="productImage" value="" >
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Delete</button>
        <div class="pull-right">
            <a href="products.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>
