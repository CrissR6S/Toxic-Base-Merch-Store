<?php 
session_start();
include("includes/header.php");
$con = Connect();

$username = $_SESSION['username'];
$sql = "select * from toxicbase.user where username = '$username'";
$result = mysqli_query($con, $sql);
$count = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
?>

<div class="container pb-2">
<form action="password-change.php" method="get">
    <h1 class="text-center display-6 py-3">My Profile</h1>
    <div class="card m-auto" style="width: 20rem;">
        <div class="card-body">


          <div class="card-body">
            <img class="card-img-top img-fluid" src=".//img/img_avatar.png" alt="<?php echo $row["username"]?>" title="<?php echo $row["username"]?>">
           </div>
           <div class="mb-3">
           <p>Vezetéknév: <?php echo $row["lastname"];?></p>
           <p>Keresztnév: <?php echo $row["firstname"]; ?></p>
           <p>Felhasználónév: <?php echo $row["username"];?></p>
           <p>Email: <?php echo $row["email"]; ?></p>
           </div>
           <button type="submit" name="btn-jelszovaltoztat" href="#" class="btn btn-danger">Jelszo változtatás</button>
        </div>
    </div>
</div>
</form>

<div class="container">
  <h1 class="text-center display-6 py-3">Vásárlási előzmény:</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Termék:</th>
      <th scope="col">Darab:</th>
      <th scope="col">Ár:</th>
      <th scope="col">Idő:</th>

      
    </tr>
  </thead>
  <tbody>
  <?php
        $username = $_SESSION['username'];
        $result = mysqli_query($con, "SELECT * FROM toxicbase.log where logusername ='$username'");
        while($row = mysqli_fetch_array($result)) {
    ?>
    <tr>
      <td><?php echo $row['logname'];?></td>
      <td><?php echo $row['logpiece'];?></td>
      <td><?php echo $row['logprice'];?></td>
      <td><?php echo $row['datetime'];?></td>

    </tr>
    <?php }?>
  </tbody>
</table>
</div>

 <?php 
include("includes/footer.php");
?>