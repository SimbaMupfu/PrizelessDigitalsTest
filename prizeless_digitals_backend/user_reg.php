<?php
 
// Importing DBConfig.php file.
include 'dbconfig.php';
 
// Creating connection.
$con = mysqli_connect($host, $user, $password, $dbName);
 
// Getting the received JSON into $user_data variable.
$user_data = file_get_contents('php://input');
 
// decoding the received JSON and store into $obj variable.
$obj = json_decode($user_data,true);
 
 // Populate User name from JSON $obj array and store into $name.
$name = $obj['name'];

$last_name = $obj['last_name'];
 
// Populate User email from JSON $obj array and store into $email.
$email = $obj['email'];
 
// Populate Password from JSON $obj array and store into $password.
$password = $obj['password'];

$mobile_number = $obj['mobile_number'];
 
//Checking Email is already exist or not using SQL query.
$verify_query = "SELECT * FROM users WHERE email='$email';";
 
// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con, $verify_query));
 
 
if(isset($check)){
 
 $emailTakenMSG = 'This email already exists. Please try again with different credentials!!!';
 
 // Converting the message into JSON format.
$emailTakenJson = json_encode($emailTakenMSG);
 
// Echo the message.
 echo $emailTakenJson; 
 
 }
 else{
 
 // Query to insert user registration data
$reg_query = "INSERT INTO users (name, last_name, email, password, mobile_number) values ('$name', '$last_name', '$email','$password', '$mobile_number');";
 
 
 if(mysqli_query($con,$reg_query)){
 
 # notify user that registration was successful
$MSG = 'User Registered Successfully' ;
 
// convert message into JSON format.
$message_in_json = json_encode($MSG);
 
// Echo the message.
 echo $message_in_json ;
 
 }
 else{
 
 echo 'Registration not successful. Please try again with different details!';
 
 }
 }
 mysqli_close($con);
?>