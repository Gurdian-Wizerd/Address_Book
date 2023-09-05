<?php
session_start();
if(!$_SESSION['loggedInUser']){
    header("Location:index.php");
}
include('includes/header.php');
include('includes/connection.php');
$query= "SELECT * FROM supplier";
$result=mysqli_query($conn, $query);
if( isset( $_GET['alert'] ) ) {
    if( $_GET['alert'] == 'deleted' ) {
        $alertMessage = "<div class='alert alert-success'>Client deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}
?>

<h1>Supplier Address Book</h1>
<?php echo $alertMessage;?>
<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Shop Name</th>
        <th>Notes</th>
        <th>Edit</th>
    </tr>
    <?php
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>".$row['name']."</td><td>".$row['email']."</td><td>".$row['contact']."</td><td>".$row['address']."</td><td>".$row['shop_name']."</td><td>".$row['notes']."</td>";
            echo '<td><a href="edit_supplier.php?id='.$row['id'].'" type="button" class="btn btn-default btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a></td>';
            echo "</tr>";
        }
    }else{
        echo "<div class='alert alert-warning'>We have no supplier!</div>";
    }
    ?>

    <tr>
        <td colspan="7"><div class="text-center"><a href="add_supplier.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Client</a></div></td>
    </tr>
</table>

<?php
include('includes/footer.php');
?>