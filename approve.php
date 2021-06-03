<?php

// Include the database config file 
require_once 'dbConfig.php'; 

$eid=$_REQUEST['id'];
echo $eid;
$sql="SELECT c.email FROM orders as r LEFT JOIN customers as c ON c.id = r.customer_id WHERE r.id = '$eid' ";
$res=mysqli_query($db,$sql);
$row=mysqli_fetch_assoc($res);

// Fetch order details from database 
// $result = $db->query("SELECT r.*, c.first_name, c.last_name, c.email, c.phone FROM orders as r LEFT JOIN customers as c ON c.id = r.customer_id WHERE r.id = ".$_REQUEST['id']); 
 
// if($result->num_rows > 0){ 
//     $orderInfo = $result->fetch_assoc(); 
// }else{ 
//     header("Location: index.php"); 
// } 

require_once 'C:\xampp\htdocs\Stock-Market-Application\mailer\mailer\class.phpmailer.php'; 
// creates object
$mail = new PHPMailer(true); 
try
 {
  $mail->IsSMTP(); 
  $mail->isHTML(true);
  $mail->SMTPDebug  = 2;                     
  $mail->SMTPAuth   = true;                  
  $mail->SMTPSecure = "tls";                 
  $mail->Host       = "smtp.gmail.com";      
  $mail->Port        = '587';             
  $mail->AddAddress($row['email']);
  $mail->Username   ="stockmarketapplication99@gmail.com";  
  $mail->Password   ="abcd@1234";            
  $mail->SetFrom('stockmarketapplication99@gmail.com','StockMarketApplication');
  $mail->AddReplyTo("stockmarketapplication99@gmail.com","StockMarketApplication");
  $mail->Subject    = "Transaction Notification";
  $mail->Body    = "Dear Customer,<br><br>Order Successfully Placed<br><br>Thanking you.<br>Yours faithfully.";
  $mail->AltBody    = "Dear Customer,<br><br>Order Successfully Placed<br><br>Thanking you.<br>Yours faithfully";

  if($mail->Send())
  {
   
   $msg = "Hi, Your mail successfully sent to ";
   
  }
 }
 catch(phpmailerException $ex)
 {
  $msg = "<div class='alert alert-warning'>".$ex->errorMessage()."</div>";
 }
 
 header('location:orderSuccess.php');
	die();

?>
