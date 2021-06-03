<?php 
// Initialize shopping cart class 
include_once 'Cart.class.php'; 
$cart = new Cart; 
 
// Include the database config file 
require_once 'dbConfig.php'; 
// include('includes/navigation.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Stock Market Application</title>
<meta charset="utf-8">

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom style -->
<link href="css/style.css" rel="stylesheet">

<!-- Bootstrap Core CSS -->
<link href="./vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="./vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="./dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="./vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



<style>
.container{
width:1000px;
}

#page-wrapper{
    background-image: url('img/Background.jpg');
}
.page-header{
    color: white;
    padding-top:15px;
    margin-top:0px;
    
}
.card{
    width:30%;
    margin:10px;
    text-align:center;
    padding-left:30px;
}

.cart-view{
    color:white;
   
}

</style>



</head>

<body>
    <!-- Navigation -->
    <?php require_once 'includes/navigation.php'; ?> 
<div id="page-wrapper" style="min-height: 703px;">
<!-- <div class="container"> -->
    <h2 class="page-header">STOCKS</h2>
	
    <!-- Cart basket -->
    <div class="cart-view">
       <h4> <a href="viewCart.php" title="View Cart"><i class="icart"></i> <?php echo ($cart->total_items() > 0)?$cart->total_items().' Items':'ORDER BOOK'; ?></a></h4>
    </div>
    
    <!-- Product list -->
    <div class="row col-lg-12">
        <?php 
        // Get products from database 
        $result = $db->query("SELECT * FROM products ORDER BY id DESC LIMIT 10"); 
        if($result->num_rows > 0){  
            while($row = $result->fetch_assoc()){ 
        ?>
        <div class="card col-lg-4">
            <div class="card-body">
                <h4 class="card-title"><?php echo $row["name"]; ?></h5>
                <h4 class="card-subtitle mb-2 text-muted">Price: <?php echo 'RS'.$row["price"]; ?></h6>
                <p class="card-text"><?php echo $row["description"]; ?></p>
                <a href="cartAction.php?action=addToCart&id=<?php echo $row["id"]; ?>" class="btn btn-primary">BUY</a>
            </div>
        </div>
        <?php } }else{ ?>
        <p>Stocks(s) not found.....</p>
        <?php } ?>
    </div>
</div>
</body>
</html>