<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

//Open a new connection to the MySQL server
// $dsn = 'mysql:host=localhost;dbname=stock-market';
// $mysqli = new PDO($dsn, 'root', '');
$mysqli = new mysqli('localhost', 'root', '', 'stock-market');


//Output any connection error
if ($mysqli->connect_error) {
    die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$query = "SELECT * FROM members WHERE email='$email'";
$result = mysqli_query($mysqli, $query) or die(mysqli_error());
$num_row = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

if ($num_row >= 1) {

    if (password_verify($password, $row['password'])) {

        $_SESSION['login'] = $row['id'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];

        echo 'true';
    }
    else {
        echo 'false';
    }

} else {
    echo 'false';
}

?>