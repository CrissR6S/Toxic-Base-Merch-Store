<?php 
include("includes/header.php");
$con = Connect();

$error = false;
if(isset($_POST["btn-register"]))
{
    $lastname = $_POST['lastname'];
    $lastname = strip_tags($lastname);
    $lastname = htmlspecialchars($lastname);

    $firstname = $_POST['firstname'];
    $firstname = strip_tags($firstname);
    $firstname = htmlspecialchars($firstname);

    $username = $_POST['username'];
    $username = strip_tags($username);
    $username = htmlspecialchars($username);

    $email = $_POST['email'];
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $password = $_POST['password'];
    $password = strip_tags($password);
    $password = htmlspecialchars($password);
    
    if(empty($lastname)){
        $error = true;
        $errorLastname = 'Kérlek add meg a neved!';
    }
    if(empty($firstname)){
        $error = true;
        $errorFirstname = 'Kérlek add meg a családneved!';
    }
    if(empty($username)){
        $error = true;
        $errorUsername = 'Kérlek add meg a felhasználóneved!';
    }elseif(strlen($username) < 3){
        $error = true;
        $errorUsername = 'A felhasználónév minimum 3 karakter.';
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $errorEmail = 'Kérlek add meg a működő email címed!';
    }

    if(empty($password)){
        $error = true;
        $errorPassword = 'Kérlek add meg a jelszavad!';
    }elseif(strlen($password) < 6){
        $error = true;
        $errorPassword = 'A jelszó minimum 6 karakter.';
    }


    $password = md5($password);

    $result = mysqli_query($con, "SELECT * FROM toxicbase.user WHERE email = '$email'");
    while($row = mysqli_fetch_assoc($result))
    {
        if ($row['email'] == $email)
        {
            $error = true;
            $foglalt = "Ez az email foglalt";
            break; 
        }
    }

    if(!$error){
        $sql = "insert into toxicbase.user(lastname,firstname,username,email,password)
                values('$lastname','$firstname','$username','$email','$password')";
        if(mysqli_query($con, $sql)){
            $successMsg = 'Sikeres regisztráció. <a href="login.php">Belépés</a>';
        }else{
            echo 'Error '.mysqli_error($con);
        }
    }



}
?>

<div class="container pb-2">
    <h1 class="text-center display-6 py-3">Create new account</h1>
    <div class="card m-auto" style="width: 20rem;">
        <div class="card-body">
    <form action="" method="post">

    <?php
                    if(isset($successMsg)){
                 ?>
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo $successMsg; ?>
                        </div>
                <?php
                    }
                ?>

    <div class="mb-3">
    <label for="lastname" class="form-label">Lastname:</label>
    <input type="text" name="lastname" class="form-control" placeholder="lastname">
    <span class="text-danger"><?php if(isset($errorLastname)) echo $errorLastname; ?></span>
    </div>

    <div class="mb-3">
    <label for="firstname" class="form-label">Firstname:</label>
    <input type="text" name="firstname" class="form-control" placeholder="firstname">
    <span class="text-danger"><?php if(isset($errorFirstname)) echo $errorFirstname; ?></span>
    </div>

    <div class="mb-3">
    <label for="username" class="form-label">Username:</label>
    <input type="text" name="username" class="form-control" placeholder="username">
    <span class="text-danger"><?php if(isset($errorUsername)) echo $errorUsername; ?></span>
    </div>

    <div class="mb-3">
    <label for="email" class="form-label">Email:</label>
    <input type="email" name="email" class="form-control" placeholder="xyz@gmail.com">
    <span class="text-danger"><?php if(isset($errorEmail)) echo $errorEmail; ?></span>
    <span class="text-danger"><?php if(isset($foglalt)) echo $foglalt; ?> </span>
    </div>

    <div class="mb-3">
    <label for="password" class="form-label">Password:</label>
    <input type="password" name="password" class="form-control" placeholder="•••••••••">
    <span class="text-danger"><?php if(isset($errorPassword)) echo $errorPassword; ?></span>
    </div>
        <button type="submit" name="btn-register" class="btn btn-danger d-block mx-auto">Register</button>
        <p class="fs-6 text-center"><a href="login.php">Already registered? Click here.</a></p>
    </form>
        </div>
    </div>
</div>

<?php 
include("includes/footer.php");
?>
