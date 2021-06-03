<?php

require_once('includes/connect.php');
$mysqlia = new mysqli('localhost', 'root', '', 'stock-market');
//Initialize Session
session_start();

if (isset($_SESSION['login'])) {

    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    // $email = $_SESSION['email'];

    $query = "SELECT email FROM members WHERE fname='$fname' and lname='$lname'";
    $result = mysqli_query($mysqlia, $query) or die(mysqli_error());
    $row = mysqli_fetch_assoc($result);
    $email=$row['email'];


    $query1 = "SELECT id FROM customers WHERE email='$email'";
    $result1 = mysqli_query($mysqlia, $query1) or die(mysqli_error());   
    $num_row = mysqli_num_rows($result1);
    $ids= [];
    $i=1;
    while($row1 = mysqli_fetch_assoc($result1)){
        // echo $id=$row1['id'];
        array_push($ids,$row1['id']);
        $i++;
    }
    // echo count($ids);
    // print_r($ids);

    // Database configuration 
    $dbHost     = "localhost"; 
    $dbUsername = "root"; 
    $dbPassword = ""; 
    $dbName     = "stock-market"; 
    
    // Create database connection 
    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
    
    $x=1;
    // echo $ids[$x];
    
    

include('includes/header.php');
include('includes/navigation.php');

?>

<div id="page-wrapper" style="min-height: 703px;">
<!-- <h1 style="float:right">HELLO</h1> -->
<h2 class="text-center page-header" style="margin-top: 0px;">Welcome <?php echo $fname; echo " "; echo $lname; ?> - <a class="page-header" href="logout.php">Logout</a></h2>
<!-- <?php echo $email; ?> -->
<!-- <?php echo $id; ?> -->
<!-- <div class="container" style="margin-left:20%;"> -->

<h2 class="page-header">PORTFOLIO</h2>
<?php
for($x=0; $x<count($ids); $x++){
        if(!isset($ids[$x])){ 
            echo "error";
        } 
        
        $result = $db->query("SELECT r.*, c.first_name, c.last_name, c.email, c.phone FROM orders as r LEFT JOIN customers as c ON c.id = r.customer_id WHERE r.id = ".$ids[$x]);
        if($result->num_rows > 0){     
            $orderInfo = $result->fetch_assoc(); 
        }
        ?>
    

            <!-- Order items -->
            <div class="row col-lg-12">
            <div class="box" style="background-color:white;">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>QTY</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Get order items from the database 
                        $result = $db->query("SELECT i.*, p.name, p.price FROM order_items as i LEFT JOIN products as p ON p.id = i.product_id WHERE i.order_id = ".$orderInfo['id']); 
                        if($result->num_rows > 0){  
                            while($item = $result->fetch_assoc()){ 
                                $price = $item["price"]; 
                                $quantity = $item["quantity"]; 
                                $sub_total = ($price*$quantity); 
                        ?>
                        <tr>
                            <td><?php echo $item["name"]; ?></td>
                            <td><?php echo $price.' RS'; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo $sub_total.' RS'; ?></td>
                        </tr>
                        <?php } 
                        } ?>
                    </tbody>
                </table>
            </div>
            </div>
    <?php } 
?>

</div>
                    
                
<!-- /.container -->
    

<?php
include('includes/footer.php');

} else {
    header("location:view-stocks.php ");
}
?>
