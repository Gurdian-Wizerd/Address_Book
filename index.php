
<?php
session_start();
include('includes/header.php');


if(isset($_POST['login'])){
  
    include('includes/functions.php');

    include('includes/connection.php');
    $formEmail=validateFormData($_POST['email']);
    $formPass=validateFormData($_POST['password']);

    $query="SELECT name,password,role FROM user WHERE email='$formEmail'";
    $result=mysqli_query($conn, $query);
if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result)){
        $name=$row['name'];
        $hashpass=$row['password'];
        $role=$row['role'];
    }
    if(password_verify($formPass,$hashpass)){
        $_SESSION['loggedInUser']=$name;
        $_SESSION['userRole']=$role;
        header("Location: clients.php");
    }else{
        $logInError="<div class='alert alert-danger'>Wrong username / Password</div>";
    }

}
else{
    $logInError="<div class='alert alert-danger'>Wrong username / Password<a class='close' data-dismiss='alert'>&times;</a></div>";
}
}
// mysqli_close($conn);
// $pass=password_hash("sam123", PASSWORD_DEFAULT);
// echo "$pass";
?>



<div class="container">
    <div class="row">
    <h1>Client Address Book</h1>
<p class="lead">Log in to your account.</p>

<?php echo $logInError;?>

<form class="form-group" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <div class="form-group">
        <label for="login-email" class="sr-only">Email</label>
        <input type="text" class="form-control" id="login-email" placeholder="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="login-password" class="sr-only">Password</label>
        <input type="password" class="form-control" id="login-password" placeholder="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary" name="login" style="width: 100%;">Login</button>
</form>
</div>
</div>
<?php
include('includes/footer.php');
?>