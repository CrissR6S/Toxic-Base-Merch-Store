<?php 
include("includes/dbconnect.php");
$con = Connect();

function All(){
$con = Connect();
$sql = "SELECT * FROM user";
$result = mysqli_query($con,$sql);
return $result;
mysqli_close($con);
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Toxic Base </title>
    <link rel="icon" type="image/x-icon" href=".//img/logo.ico">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/mystyle.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    
</head>

<body class="d-flex flex-column min-vh-100">
<div class="container-fluid sticky-top bg-dark">
        <nav class="container navbar navbar-expand-sm bg-dark navbar-dark"> 
            <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" href="./"><img class="img-fluid" style="width: 94px; height: 94px;" src=".//img/logo.png" alt=""></a>
            </li>
            </ul>    

            <ul class="navbar-nav mx-auto fs-5">
           
            <li class="nav-item">
                    <a class="nav-link h-link" href="index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link h-link" href="mouse.php">Mouse</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link h-link" href="jersey.php">Jersey</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link h-link" href="mousepad.php">Mousepad</a>
                </li> 
            </ul>

            <ul class="navbar-nav fs-6">
           <?php 
            if(!isset($_SESSION['username'])){
           ?>
               <li class="nav-item">
                   <a class="nav-link " href="login.php">Login/register</a>
               </li>

               <li class="nav-item">
                   <a class="nav-link link2" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
               </li>
               <?php } else{?>
                <?php 
                $username = $_SESSION['username'];
                $result = mysqli_query($con, "SELECT permission FROM toxicbase.user where username = '$username'");
                while($row = mysqli_fetch_array($result)) { 
                    $permission = $row['permission'];
                    if ($permission == 1) {
                ?>
                <li class="nav-item">
                   <a class="nav-link link2" href="raktar.php"><i class="fas fa-box"></i></a>
               </li>
               <?php } }?>
               <li class="nav-item">
                   <a class="nav-link link2" href="myprofile.php"><i class="fas fa-user-tie"></i></a>
               </li>
               <li class="nav-item">
                   <a class="nav-link link2" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
               </li>
               <li class="nav-item">
                   <a class="nav-link link2" href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
               </li>

               <?php }?>
           </ul>
        </nav>
    </div>