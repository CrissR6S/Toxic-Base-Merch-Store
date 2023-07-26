<?php 
    session_start();

    include('includes/header.php');
    $con = Connect();

    function Products(){
        $con = Connect();
        $sql = "SELECT * FROM toxicbase.items";
        $result = mysqli_query($con,$sql);
        return $result;
        mysqli_close($con);
        }
        
        $result = Products();
        $sum =0;
    $items_id = array_column($_SESSION["cart"],"product_id");  
    while($row = mysqli_fetch_array($result)){
    foreach($items_id as $id){
    if($row["itemnumber"] == $id){ 
    foreach($_SESSION["cart"] as $key => $cart_items) {
    if($cart_items["product_id"] == $row["itemnumber"]){
    $db = $_SESSION["cart"][$key]['db'];
    }
}
    if(isset($_POST['btn-pay'])){
    $itemnumber = $row['itemnumber'];
    $name = $row['name'];
    $piece = $db;
    $price = $row['price'];
    $size = $row['size'];
    $color = $row['color'];
    $username = $_SESSION['username'];
    mysqli_query($con,"INSERT INTO toxicbase.ordereditems(orderednumber,orderedname,orderedpiece,orderedprice,orderedsize,orderedcolor) 
    Values ('$itemnumber', '$name', '$piece', '$price' ,'$size', '$color')");
    $sv = $row['piece'] - $db;
    mysqli_query($con, "UPDATE toxicbase.items SET piece = '$sv' where itemnumber = '$itemnumber'");
    mysqli_query($con, "INSERT INTO toxicbase.log (logname, logprice, logpiece, logusername)
    Values ('$name', '$price','$piece', '$username')");

    $msg = 'Sikeres vásárlás!';
    unset($_SESSION['cart']);
    header("refresh: 5; url=index.php");
    }

?>
        
    <hr>
    <div class="container ">
    <?php if(!isset($msg)) { ?>
    <div class="row">
    <div class="col-md-4">
                <img class="rounded img-fluid" src="<?php echo $row["img"]; ?>" alt="<?php echo $row["img"]; ?>" title="<?php echo $row["name"]; ?>">
            </div>
            <div class="col-md-4">
                <h3><?php echo $row["name"]; ?></h3>
                <p>Méret: <?php echo $row['size'];?></p>
                <p>Szín: <?php echo $row['color'];?></p>
                <p>Ár: <?php echo $row["price"]*$db; $sum = $sum + $row["price"]*$db; ?> Ft</p>
            </div>
</div>
<?php } ?>
</div>
<?php 
    }
}
    }
?>

<form action="" method="post">

<?php
   if(isset($msg)){
    ?>
    <div class="alert alert-success container text-center">
     <span class="glyphicon glyphicon-info-sign"></span>
      <?php echo $msg; ?>
   </div>
        <?php
        }
    ?>

<?php
   if(!isset($_SESSION['cart']) && !isset($msg)){
    ?>
    <div class="alert alert-danger">
     <span class="glyphicon glyphicon-info-sign"></span>
      <?php echo 'Az ön kosara üres!'; ?>
   </div>
        <?php
      
    } 
    if(!isset($msg)) { ?> 

    <div class="py-5">
<button class="btn btn-primary d-block mx-auto btn-md" type="submit" name="btn-pay">Fizetés</button>
</div>
<?php
      
    }  ?>
</form>

<?php
include('includes/footer.php');
?>