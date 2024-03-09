<?php
//start session and connect
session_start();
include('connection.php');

//define error messages
$missingrecipename = '<p><strong>Please enter the title!</strong></p>';
$invalidrecipename = '<p><strong>Please enter a valid title!</strong></p>';
$missingpreparationtime = '<p><strong>Please enter the preparation time!</strong></p>';
$missingcookingtime = '<p><strong>Please enter the cooking time!</strong></p>';
$missingserving = '<p><strong>Please select the number of serving!</strong></p>';
$missingingredient = '<p><strong>Please enter the ingredient!</strong></p>';
$missinginstruction = '<p><strong>Please enter the instruction!</strong></p>';
$missingdifficulty = '<p><strong>Please select the difficulty for the recipe!</strong></p>';


//Get inputs:
$recipename = $_POST["recipename"];
$preparationtime = $_POST["preparationtime"];
$cookingtime = $_POST["cookingtime"];
$serving = $_POST["serving"];
$ingredient = $_POST["ingredient"];
$instruction = $_POST["instruction"];
$difficulty = $_POST["difficulty"];

$pattern = '/^[a-zA-Z\s]+$/';



if(!isset($_POST["recipename"]) || !preg_match($pattern, $_POST["recipename"]) { 
    if(!isset($_POST["recipename"]){
    $errors .= £missingrecipename;   
    }else{
    $errors .= $invalidrecipename;
}else{
    $recipename = $_POST["recipename"];
}

if(!$preparationtime){
    $errors .= $missingpreparationtime;   
}else{
    $preparationtime = filter_var($preparationtime, FILTER_SANITIZE_STRING); 
}

if(!$cookingtime){
    $errors .= $missingcookingtime;   
}else{
    $cookingtime = filter_var($cookingtime, FILTER_SANITIZE_STRING); 
}

if(!$serving){
    $errors .= $missingserving;   
}else{
    $cookingtime = filter_var($serving, FILTER_SANITIZE_STRING); 
}

if(!$ingredient){
    $errors .= $missingingredient; 
}else{
    $ingredient = filter_var($ingredient, FILTER_SANITIZE_STRING);    
}

if(!$instruction){
    $errors .= $missingcookingtime;   
}else{
    $instruction = filter_var($instruction, FILTER_SANITIZE_STRING); 
}
       
if(!isset($_POST["difficulty"])){
    $errors .= $missingdifficulty;    
}else{
    $difficulty .= $_POST["difficulty"];
}


if($errors){
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;
}else{
    //no errors, prepare variables for the query
    $tbl_name = 'recipesharingdata';
    $recipename = mysqli_real_escape_string($link, $recipename);
    $preparationtime = mysqli_real_escape_string($link, $preparationtime);
    $cookingtime =
    mysqli_real_escape_string($link, $cookingtime);
    $serving =
    mysqli_real_escape_string($link, $serving);
    $ingredient =
    mysqli_real_escape_string($link, $recipename);
    $instruction =
    mysqli_real_escape_string($link, $instruction);
    $difficulty =
    mysqli_real_escape_string($link, $difficulty);
    
    $sql = "INSERT INTO $tbl_name (`user_id`,`recipename`, `preparationtime`, `cookingtime`, `serving`, `ingredient`, `instruction`, `difficulty`) VALUES ('".$_SESSION['user_id']."', '$receipename','$preparationtime','$cookingtime','$serving','$ingredient','$instruction','$difficulty')";   
    }
    
    $results = mysqli_query($link, $sql);
    //check if query is successful
    if(!$results){
        echo '<div class=" alert alert-danger">There was an error! The recipe could not be added to database!</div>';        
    }
}

?>