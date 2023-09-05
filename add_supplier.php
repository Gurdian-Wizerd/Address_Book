<?php
session_start();
if(!$_SESSION['loggedInUser']){
 header("Location:index.php");
}
include('includes/header.php');

if(isset($_POST['add'])){
    include('includes/functions.php');
    include('includes/connection.php');
    $clientsName=$clientsEmail=$clientsPhone=$clientsAddress=$clientsShop=$clientsNotes="";

    $clientsName=validateFormData($_POST['clientName']);
    $clientsEmail=validateFormData($_POST['clientEmail']);
    $clientsPhone=validateFormData($_POST['clientPhone']);
    $clientsAddress=validateFormData($_POST['clientAddress']);
    $clientsShop=validateFormData($_POST['clientShop']);
    $clientsNotes=validateFormData($_POST['clientNotes']);

    if($clientsName !='' && $clientsPhone!='' && $clientsAddress!=''){
        $query="INSERT INTO `supplier` (`id`, `name`, `email`, `contact`, `address`, `notes`, `date_added`, `shop_name`) VALUES (NULL,'$clientsName','$clientsEmail','$clientsPhone',
        '$clientsAddress','$clientsNotes',CURRENT_TIMESTAMP,' $clientsShop')";
        $result=mysqli_query($conn, $query);
        if($result){
           $alertMessage="<div class='alert alert-success'>New supplier added!<a class='close' data-dismiss='alert'>&times;</a></div>";
        }else{
            echo "Error:".$query."<br>".mysqli_errno($conn);
        }
    }
}
?>

<h1>Add Supplier</h1>
<?php echo $alertMessage; ?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name *</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email </label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone *</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address *</label>
        <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Shope Name</label>
        <input type="text" class="form-control input-lg" id="client-shop" name="clientShop" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"></textarea>
    </div>
    <div class="col-sm-12">
            <a href="supplier.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add Supplier</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>