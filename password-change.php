<?php
session_start();
include('includes/header.php');
$con = Connect();
$username = $_SESSION['username'];

$error = false;
if (isset($_POST["btn-change"]))
{

    $password = $_POST['password'];
    $password = strip_tags($password);
    $password = htmlspecialchars($password);

    $repeat = $_POST['repeat'];
    $repeat= strip_tags($repeat);
    $repeat = htmlspecialchars($repeat);

    if(empty($password)){
        $error = true;
        $errorPassword = 'Kérlek adj meg egy új jelszót!';
    }elseif(strlen($password) < 6){
        $error = true;
        $errorPassword = 'A jelszó minimum 6 karakteres.';
    }

    if(empty($repeat))
    {
        $error = true;
        $errorRepeat = "A mező nem maradhat üres.";
    }
    elseif($repeat !== $password)
    {
        $error = true;
        $MatchError = 'Nem egyeznek.';
    }

    $password = md5($password);

    if(!$error){
        $sql = "UPDATE toxicbase.user
                SET password = '$password' where username ='$username';";
        if(mysqli_query($con, $sql)){
            $successMsg = 'Sikeres jelszó változtatás!';
        }else{
            echo 'Error '.mysqli_error($con);
        }
    }
}
?>

<div class="container pb-2">
    <h1 class="text-center display-6 py-3">Password Change</h1>
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
    <label for="password" class="form-label">Password:</label>
    <input type="password" name="password" class="form-control" placeholder="•••••••••">
    <span class="text-danger"><?php if(isset($errorPassword)) echo $errorPassword; ?></span>
    </div>
    <label for="password" class="form-label">Re-password:</label>
    <input type="password" name="repeat" class="form-control" placeholder="•••••••••">
    <span class="text-danger"><?php if(isset($errorRepeat)) echo $errorRepeat; ?></span>
    <span class="text-danger"><?php if(isset($MatchError)) echo $MatchError; ?></span>
    </div>
        <button type="submit" name="btn-change" href="#" class="btn btn-danger d-block mx-auto">Change</button>
    

    </form>
        </div>
    </div>
</div>

<?php 
include('includes/footer.php');
?>