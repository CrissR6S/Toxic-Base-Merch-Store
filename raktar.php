<?php 
session_start();
ini_set('display_errors',0);
ini_set('display_startup_errors',0);
include('includes/header.php');
$con = Connect();


$error = false;
if(isset($_POST["btn-update"]))
{
  $item_name = $_POST['name'];
  $item_name = strip_tags($item_name);
  $item_name = htmlspecialchars($item_name);

  $item_price = $_POST['price'];
  $item_price = strip_tags($item_price);
  $item_price = htmlspecialchars($item_price);

  $item_db = $_POST['piece'];
  $item_db = strip_tags($item_db);
  $item_db = htmlspecialchars($item_db);

  $item_size = $_POST['size'];
  $item_size = strip_tags($item_size);
  $item_size = htmlspecialchars($item_size);

  $item_color = $_POST['color'];
  $item_color = strip_tags($item_color);
  $item_color = htmlspecialchars($item_color);

  $item_Tipus = $_POST['Tipus'];
  $item_Tipus = strip_tags($item_Tipus);
  $item_Tipus = htmlspecialchars($item_Tipus);

  $item_img = $_POST['img'];
  $item_img = strip_tags($item_img);
  $item_img = htmlspecialchars($item_img);

if(empty($item_name)){
  $error = true;
  $errorName = 'Ne hagyd üresen a Termék név mezőt!';
}
if(empty($item_price)){
  $error = true;
  $errorPrice = 'Ne hagyd üresen a Termék ár mezőt!';
}
if(empty($item_db)){
  $error = true;
  $errorDb = 'Ne hagyd üresen a Darab mezőt!';
}
if(empty($item_size)){
  $error = true;
  $errorSize = 'Ne hagyd üresen a Méret mezőt!';
}
if(empty($item_color)){
  $error = true;
  $errorColor = 'Ne hagyd üresen a Szín mezőt!';
}
if(empty($item_Tipus)){
  $error = true;
  $errorTipus = 'Ne hagyd üresen a Tipus mezőt!';
}
if(empty($item_img)){
  $error = true;
  $errorImg = 'Ne hagyd üresen a Img mezőt!';
}

if(!$error){
  $sql = "insert into toxicbase.items (name, price, piece, size, color, Tipus, img)
          values('$item_name','$item_price','$item_db','$item_size','$item_color','$item_Tipus','$item_img')";
  if(mysqli_query($con, $sql)){
      $successMsg = 'Sikeresen felvitted az adatokat';
  }else{
      echo 'Error '.mysqli_error($con);
  }
}
}
?>
<div class="container pb-2">
    <h1 class="text-center display-6 py-3">Raktár feltöltése:</h1>
    <div class="card m-auto" style="width: 20rem;">
        <div class="card-body">
    <form action="" method="post">


    <?php
if(isset($msg)){
?>
<div class="alert alert-success">
<span class="glyphicon glyphicon-info-sign"></span>
<?php echo $msg; ?>
</div>

<?php
}
?>

    <div class="mb-3">
    <label for="name" class="form-label">Termék neve:</label>
    <input type="text" name="name" class="form-control" placeholder="Logitech fejhalgato">
    <span class="text-danger"><?php if(isset($errorName)) echo $errorName; ?></span>
    </div>

    <div class="mb-3">
    <label for="price" class="form-label">Termék ára:</label>
    <input type="number" name="price" class="form-control" placeholder="Ft">
    <span class="text-danger"><?php if(isset($errorPrice)) echo $errorPrice; ?></span>
    </div>

    <div class="mb-3">
    <label for="piece" class="form-label">Darab:</label>
    <input type="number" name="piece" class="form-control" placeholder="1-2-3-4">
    <span class="text-danger"><?php if(isset($errorDb)) echo $errorDb; ?></span>
    </div>

    <div class="mb-3">
    <label for="size" class="form-label">Méret:</label>
    <input type="text" name="size" class="form-control" placeholder="S-L-M-XL-XXL">
    <span class="text-danger"><?php if(isset($errorSize)) echo $errorSize; ?></span>
    </div>

    <div class="mb-3">
    <label for="color" class="form-label">Szín:</label>
    <input type="text" name="color" class="form-control" placeholder="piros, sárga, fekete, kék">
    <span class="text-danger"><?php if(isset($errorColor)) echo $errorColor; ?></span>
    </div>

    <div class="mb-3">
    <label for="Tipus" class="form-label">Tipus:</label>
    <input type="text" name="Tipus" class="form-control" placeholder="eger, egerpad, mez">
    <span class="text-danger"><?php if(isset($errorTipus)) echo $errorTipus; ?></span>
    </div>
    <div class="mb-3">
    <label for="img" class="form-label">Img:</label>
    <input type="text" name="img" class="form-control" placeholder="img/xxxx.jpg">
    <span class="text-danger"><?php if(isset($errorImg)) echo $errorImg; ?></span>

    </div>
        <button type="submit" name="btn-update" href="#" class="btn btn-outline-secondary d-block mx-auto">Feltöltés</button>
    </form>
        </div>
    </div>
</div>

<div class="container">
  <h1 class="text-center display-6 py-3">Raktár:</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Termék neve:</th>
      <th scope="col">Termék ára:</th>
      <th scope="col">Darab:</th>
      <th scope="col">Méret:</th>
      <th scope="col">Szín:</th>
      <th scope="col">Tipus:</th>
      <th scope="col">Img:</th>
      
    </tr>
  </thead>
  <tbody>
  <?php
        $result = mysqli_query($con, "SELECT * FROM toxicbase.items");
        while($row = mysqli_fetch_array($result)) {
    ?>
    <tr>
      <th scope="row"><?php echo $row['itemnumber'];?></th>
      <td><?php echo $row['name'];?></td>
      <td><?php echo $row['price'];?></td>
      <td><?php echo $row['piece'];?></td>
      <td><?php echo $row['size'];?></td>
      <td><?php echo $row['color'];?></td>
      <td><?php echo $row['Tipus'];?></td>
      <td><?php echo $row['img'];?></td>
    </tr>
    <?php }?>
  </tbody>
</table>
</div>

<?php include('includes/footer.php');?>