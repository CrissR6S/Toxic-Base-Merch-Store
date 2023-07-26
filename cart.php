<?php 
session_start();
include("includes/header.php");
$con = Connect();

   if(!isset($_SESSION['username']))
   {
     header('Location: login.php');
     exit();
   }

function Products(){
$con = Connect();
$sql = "SELECT * FROM items";
$result = mysqli_query($con,$sql);
return $result;
mysqli_close($con);
}

$result = Products();
$sum = 0;


if(isset($_POST["remove"])){
$id = $_POST["remove"];
foreach($_SESSION["cart"] as $key => $cart_items){
if($cart_items["product_id"] == $id){
unset($_SESSION["cart"][$key]);
}
}
if(count($_SESSION["cart"]) == 0){
unset($_SESSION["cart"]);
}
}


if(isset($_POST["p"])){
$id = $_POST["p"];
foreach($_SESSION["cart"] as $key => $cart_items){
if($cart_items["product_id"] == $id){
$_SESSION["cart"][$key]["db"] = $_SESSION["cart"][$key]["db"]+1;
}
}
}


if(isset($_POST["m"])){
$id = $_POST["m"];
foreach($_SESSION["cart"] as $key => $cart_items){
if($cart_items["product_id"] == $id){
if($_SESSION["cart"][$key]["db"]<>1){
$_SESSION["cart"][$key]["db"] = $_SESSION["cart"][$key]["db"]-1;
}
}
}
}

  if(isset($_SESSION["cart"])){
    $cart_db = count($_SESSION["cart"]);
} else {
    $cart_db = 0;
}
?>

<div class="container pb-2">
<form action="cart.php" method="post">
<?php if(isset($_SESSION["cart"])) { 
$items_id = array_column($_SESSION["cart"],"product_id");  
while($row = mysqli_fetch_array($result)){
foreach($items_id as $id){
if($row["itemnumber"] == $id){ 
foreach($_SESSION["cart"] as $key => $cart_items) {
if($cart_items["product_id"] == $row["itemnumber"]){
$db = $_SESSION["cart"][$key]['db'];
}
}
?>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <img class="img-fluid" src="<?php echo $row["img"]; ?>" alt="<?php echo $row["img"]; ?>" title="<?php echo $row["name"]; ?>">
            </div>
            <div class="col-md-4">
                <h3><?php echo $row["name"]; ?></h3>
                <p>Méret: <?php echo $row['size'];?></p>
                <p>Szín: <?php echo $row['color'];?></p>
                <p>Ár: <?php echo $row["price"]*$db; $sum = $sum + $row["price"]*$db; ?> Ft</p>
                <button class="btn btn-danger" type="submit" name="remove" value="<?php echo $row["itemnumber"]; ?>">Eltávolít</button>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary" type="submit" name="m" value="<?php echo $row["itemnumber"]; ?>"><i class="fas fa-minus"></i></button>
                <input class="form-control text-center d-inline" style="width: 3rem" type="text" value="<?php echo $db; ?>" name="db">
                <button class="btn btn-primary" type="submit" name="p" value="<?php echo $row["itemnumber"]; ?>"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        
        <?php } } } ?>
        <div class="row">
            <div class="col-md-6">
                <p class="fs-4 mt-2">
                    Összesen: <?php echo $sum; ?> Ft
                </p>
            </div>
            <div class="col-md-6 text-end">
                <a class="btn btn-primary" href="payment.php">Tovább a fizetéshez!</a>
            </div>
        </div>
        <?php } else { ?>
            <p class="fs-3 mt-2">A kosár üres!</p>
        <?php } ?>
    </form>
    </div>
<?php 
include("includes/footer.php");
?>