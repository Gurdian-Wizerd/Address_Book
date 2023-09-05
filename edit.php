<?php
session_start();
if(!$_SESSION['loggedInUser']){
 header("Location:index.php");
}
$clientId=$_GET['id'];
include('includes/functions.php');

include('includes/connection.php');
include('includes/header.php');
$query="SELECT * FROM clients WHERE id='$clientId'";
$result=mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result)){
        $clientsName=$row['name'];
        $clientsEmail=$row['email'];
        $clientsPhone=$row['contact'];
        $clientsAddress=$row['address'];
        $clientsShop=$row['shop_name'];
        $clientsNotes=$row['notes'];
    
    }

}else{
    $alertMessage="<div class='alert alert-warning'> Nothing to see here.<a href='clients.php'> Head back</a></div>";
}
if(isset($_POST['update'])){
    $clientsName=validateFormData($_POST['clientName']);
    $clientsEmail=validateFormData($_POST['clientEmail']);
    $clientsPhone=validateFormData($_POST['clientPhone']);
    $clientsAddress=validateFormData($_POST['clientAddress']);
    $clientsShop=validateFormData($_POST['clientShop']);
    $clientsNotes=validateFormData($_POST['clientNotes']);

    $query="UPDATE clients
    SET name='$clientsName',
    email='$clientsEmail',
    contact='$clientsPhone',
    address='$clientsAddress',
    notes='$clientsNotes',
    shop_name='$clientsShop'
    WHERE id ='$clientId'";
    $result=mysqli_query($conn, $query);
    if($result){
        $alertMessage="<div class='alert alert-success'>Data updated successfully!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }else{
        echo "Error updating record:".mysqli_errno($conn);
    }
}
if(isset($_POST['delete'])){
    $alertMessage = "<div class='alert alert-danger'>
                        <p>Are you sure you want to delete this client? No take backs!</p><br>
                        <form action='". htmlspecialchars( $_SERVER["PHP_SELF"] )."?id=$clientId' method='post'>
                            <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, delete!'>
                            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!</a>
                        </form>
                    </div>";

}
if(isset($_POST['confirm-delete'])){
    
    $query="DELETE FROM `clients` WHERE id='$clientId'";
    $result=mysqli_query($conn,$query);
    if($result){
        header("Location:clients.php?alert=deleted");
       
    }
}
?>

<h1>Edit Client</h1>
<?php echo $alertMessage;?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?id=<?php echo $clientId;?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="<?php echo $clientsName;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email</label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="<?php echo $clientsEmail;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="<?php echo $clientsPhone;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address</label>
        <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="<?php echo $clientsAddress;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Shop Name</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientShop" value="<?php echo $clientsShop;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"><?php echo $clientsNotes;?></textarea>
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Delete</button>
        <div class="pull-right">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>