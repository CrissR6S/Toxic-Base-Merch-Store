<?php 
session_start();
include("includes/header.php");
$con = Connect();

$error = false;
if (isset($_POST["btn-login"]))
{
    $email = trim($_POST['email']);
    $email = htmlspecialchars(strip_tags($email));

    $password = trim($_POST['password']);
    $password = htmlspecialchars(strip_tags($password));

    if(empty($email)){
        $error = true;
        $errorEmail = 'Kérlek működő email címet adj meg';
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $errorEmail = 'Hibás email cím.';
    }

    if(empty($password)){
        $error = true;
        $errorPassword = 'Hibás jelszó.';
    }elseif(strlen($password)< 6){
        $error = true;
        $errorPassword = 'A jelszónak minimum 6 karakteresnek kell lennie.';
    }
    
    $password = md5($password);
    $result = mysqli_query($con, "SELECT * FROM toxicbase.user WHERE email = '$email'");

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($password == $row["password"]) {
            $_SESSION['username'] = $row['username'];
            header('location: index.php');
        } else {
            $errorPassword = "Hibás jelszó";
        }
    }

    if(!$error){
        $password = md5($password);
        $sql = "select * from toxicbase.user where email='$email'";
        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        if($count==1 && $row['password'] == $password){
            $_SESSION['username'] = $row['username'];
            header('location: index.php');
        }else{
            $errorMsg = 'Hibás email cím vagy jelszó, próbáld újra!';
        }
    }

}
?>

<div class="container pb-2">
    <h1 class="text-center display-6 py-3">Login</h1>
    <div class="card m-auto" style="width: 20rem;">
        <div class="card-body">
    <form action="" method="post">


    <div class="mb-3">
    <label for="email" class="form-label">Email:</label>
    <input type="email" name="email" class="form-control" placeholder="xyz@gmail.com">
    <span class="text-danger"><?php if(isset($errorEmail)) echo $errorEmail; ?></span>
    </div>

    <div class="mb-3">
    <label for="password" class="form-label">Password:</label>
    <input type="password" name="password" class="form-control" placeholder="•••••••••">
    <span class="text-danger"><?php if(isset($errorPassword)) echo $errorPassword; ?></span>
    </div>
        <button type="submit" name="btn-login" href="#" class="btn btn-danger d-block mx-auto">Login</button>
        <p class="fs-6 text-center"><a href="register.php">Create an account</a></p>
    </form>
        </div>
    </div>
</div>

<?php 
include("includes/footer.php");
?>