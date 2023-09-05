<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login page
    header("Location: index.php");
}

// connect to database
include('includes/header.php');
if(isset($_POST['add'])){
    include('includes/functions.php');
    include('includes/connection.php');
    $userName=$userEmail=$userPassword="";

    $userName=validateFormData($_POST['userName']);
    $userEmail=validateFormData($_POST['userEmail']);
    $userPassword=validateFormData($_POST['userPassword']);
    $userRole=validateFormData($_POST['userRole']);

    
    $pass=password_hash($userPassword, PASSWORD_DEFAULT);
    if($userName !='' && $userPassword!='' && $userPassword!=''){
        $query="INSERT INTO `user` (`id`, `email`,`name`, `password`, `role`) VALUES (NULL,'$userEmail','$userName','$pass','$userRole')";
        $result=mysqli_query($conn, $query);
        if($result){
           $alertMessage="<div class='alert alert-success'>New User added!<a class='close' data-dismiss='alert'>&times;</a></div>";
        }else{
            echo "Error:".$query."<br>".mysqli_errno($conn);
        }
    }
}
?>
<h1>Add User</h1>
<?php echo $alertMessage; ?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name *</label>
        <input type="text" class="form-control input-lg" id="client-name" name="userName" value="" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email *</label>
        <input type="email" class="form-control input-lg" id="client-email" name="userEmail" value="" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Password *</label>
        <input type="text" class="form-control input-lg" id="client-shop" name="userPassword" value="" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Role *</label>
        <select class="form-control input-lg" id="userRole"name="userRole" value="" required>
	<option value="">--- Choose a Role ---</option>
	<option value="admin">admin</option>
	<option value="manager">manager</option>
	<option value="employee">employee</option>
</select>    </div>
 
    <div class="col-sm-12">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add Client</button>
    </div>
</form>
<?php
include('includes/footer.php');
?>