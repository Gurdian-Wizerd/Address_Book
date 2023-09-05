 <?php
 session_start();
 if($_SESSION['loggedInUser']){
    header("Locaion: index.php");
 }
 include('includes/functions.php');
 include('includes/connection.php');
 $query1="SELECT `name` FROM supplier";
 $result1=mysqli_query($conn,$query1);
 if(isset($_POST['add'])){
       
 
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



    if($productName !='' && $productDescription!='' && $productType!='' && $productImageName!=''){

        $query="INSERT INTO `product` (`id`, `name`, `description`, `purchase_price`, `seal_price`, `product_type`, `sealer_name`, `sealer_contact`, `quantity`, 
        `image`, `date_added`) VALUES
         (NULL,'$productName','$productDescription','$productPPrice','$productSPrice','$productType','$productSealerName','$productSealerContact',
         '$productQuantity','$productImageName',CURRENT_TIMESTAMP)";
        $result=mysqli_query($conn, $query);
        if($result){
           $alertMessage="<div class='alert alert-success'>New product added!<a class='close' data-dismiss='alert'>&times;</a></div>";
        }else{
            echo "Error:".$query."<br>".mysqli_errno($conn);
        }
    }else{
        echo"Cant Upload <a href='add_products.php'>Hello</a>";
  
    }

}
include('includes/header.php');

?>

<h1>Add Product</h1>
<?php echo"$alertMessage";?>
<form action="add_products.php" method="post" class="row" enctype="multipart/form-data">
    <div class="form-group col-sm-6">
        <label for="product-name">Product Name *</label>
        <input type="text" class="form-control input-lg" id="product-name" name="productName" value="" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="product-description">Product Description *</label>
        <textarea type="text" class="form-control input-lg" id="product-description" name="productDescription" required></textarea>
    </div>
    <div class="form-group col-sm-6">
        <label for="product-PPrice">Purchase Price *</label>
        <input type="number" class="form-control input-lg" id="product-PPrice" name="productPPrice" value="" required>
    </div> 
    <div class="form-group col-sm-6">
        <label for="product-SPrice">Seal Price *</label>
        <input type="number" class="form-control input-lg" id="product-SPrice" name="productSPrice" value="" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="product-quantity">Quantity *</label>
        <input type="number" class="form-control input-lg" id="product-quantity" name="productQuantity" value="" required>
    </div>

    <div class="form-group col-sm-6">
        <label for="product-company">Product Type *</label>
        <select class="form-control input-lg" id="productType"name="productType" value="" required>
	<option value="">--- Choose Product Type ---</option>
	<option value="decor">decor</option>
	<option value="gifting">gifting</option>
	<option value="accsoceries">accsoceries</option>
</select></div>
<div class="form-group col-sm-6">
        <label for="product-company">Supplier Name *</label>
        <select class="form-control input-lg" id="productSealer"name="productSealer" value="" required>
	<option value="">--- Choose Sealer ---</option>
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
        <input type="file" class="form-control input-lg" id="product-image" name="productImage" value="" required>
    </div>
    <div class="col-sm-12">
            <a href="products.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add product</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>