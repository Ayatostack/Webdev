<?php

session_start();
include('connection.php'); 

$missingUsername = '<p><strong>Please enter a username!</strong></p>';
 $missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
$missingPassword = '<p><strong>Please enter a Password!</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and inlcude one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';
$missingfirstname = '<p><strong>Please enter your firstname!</strong></p>';
$missinglastname = '<p><strong>Please enter your lastname!</strong></p>';
$missingPhone = '<p><strong>Please enter your phone number!</strong></p>';
$invalidPhoneNumber = '<p><strong>Please enter a valid phone number (digits only and less than 15 long)!</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
$missinggender = '<p><strong>Please select your gender</strong></p>';


if(empty($_POST["username"])){
    $errors .= $missingUsername;
}else{
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);   
}

if(empty($_POST["firstname"])){
    $errors .= $missingfirstname;
}else{
    $firstname = filter_var($_POST["firstname"], FILTER_SANITIZE_STRING);
}

if(empty($_POST["lastname"])){
    $errors .= $missinglastname;
}else{
    $lastname = filter_var($_POST["lastname"], FILTER_SANITIZE_STRING);
}

if(empty($_POST["email"])){
    $errors .= $missingEmail;   
}else{
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;   
    }
}

if(empty($_POST["password"])){
    $errors .= $missingPassword; 
}elseif(!(strlen($_POST["password"])>6
         and preg_match('/[A-Z]/',$_POST["password"])
         and preg_match('/[0-9]/',$_POST["password"])
        )
       ){
    $errors .= $invalidPassword; 
}else{
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING); 
    if(empty($_POST["password2"])){
        $errors .= $missingPassword2;
    }else{
        $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
        if($password !== $password2){
            $errors .= $differentPassword;
        }
    }
}

if(empty($_POST["phonenumber"])){
    $errors .= $missingPhone;
}elseif(preg_match('/\D/',$_POST["phonenumber"])){
    $errors .= $invalidPhoneNumber;    
}else{
    $phonenumber = filter_var($_POST["phonenumber"], FILTER_SANITIZE_STRING);
}

if(empty($_POST["gender"])){
    $errors .= $missinggender;
}else{
    $gender = $_POST["gender"];
}

if(empty($_POST["moreinformation"])){
    // $moreinformation = filter_var($_POST["moreinformation"], FILTER_SANITIZE_STRING);
}

if($errors){
    $resultMessage = '<div class="alert alert-danger">' . $errors .'</div>';
    echo $resultMessage;
    exit;
}


$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);

$password = hash('sha256', $password);

$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>';

    exit;
}
$results = mysqli_num_rows($result);
if($results){
    echo '<div class="alert alert-danger">That username is already registered. Do you want to log in?</div>';  exit;
}

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>'; exit;
}
$results = mysqli_num_rows($result);
if($results){
    echo '<div class="alert alert-danger">That email is already registered. Do you want to log in?</div>';  exit;
}

$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
    
$sql = "INSERT INTO users (`username`, `email`, `password`, `activation`, `first_name`, `last_name`, `phonenumber`, `gender`, `moreinformation`) VALUES ('$username', '$email', '$password', '$activationKey', '$firstname', '$lastname', '$phonenumber', '$gender', '$moreinformation')";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">There was an error inserting the users details in the database!</div>'; 
    exit;
}


$message = "Please click on this link to activate your account:\n\n";
$message .= "http://projectest0184.host20.uk/Website/activate.php?email=" . urlencode($email) . "&key=$activationKey";
if(mail($email, 'Confirm your Registration', $message, 'From:'.'recipedevelopment@projectest0184.host20.uk')){
       echo "<div class='alert alert-success'>Thank for your registering! A confirmation email has been sent to $email. Please click on the activation link to activate your account.</div>";
}
        
        ?>