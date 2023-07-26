<?php 
session_start();
ini_set('display_errors',0);
ini_set('display_startup_errors',0);
include("includes/header.php");
$con = Connect();


if(isset($_POST["add"])){
 
  if(isset($_SESSION["cart"])){
  
      $items_id = array_column($_SESSION["cart"],"product_id");
  
      if(in_array($_POST["product_id"],$items_id)){
  
          $id = $_POST["product_id"];
          header("Location: cart.php");
  
      } else {
  
        $length = count($_SESSION["cart"]);
        $items["product_id"] = $_POST["product_id"];
        $items["db"] = 1;
        $_SESSION["cart"][$length] = $items;
  
      }
    }
    } else {
      $items["product_id"] = $_POST["product_id"];
      $items["db"] = 1;
      $_SESSION["cart"][0] = $items;
    }
?>

 <div class="text-center">
    <div class="container">
        <div class="row "> 
    <?php
        $result = mysqli_query($con, "SELECT * FROM toxicbase.items where Tipus = 'eger'");
        while($row = mysqli_fetch_array($result)) {
    ?>
        <div class="col-sm-4 py-3">
        <form action="" method="post">
         <div class="card m-auto" style="width: 18rem;">
          <div class="card-body">
            <img class="card-img-top img-fluid" src="<?php echo $row['img'];?>">
              <?php echo $row['name']; ?><br>
              <?php echo $row['size']; ?><br>
              <?php echo $row['price']; ?> Ft<br>
              <input type="hidden" name="product_id" value="<?php echo $row["itemnumber"]; ?>">
              <?php 
                $count_prod = $row['piece'];
                $result2 = mysqli_query($con, "SELECT sum(piece) FROM toxicbase.items WHERE piece = '$count_prod'");
                while($row2 = mysqli_fetch_array($result2)) {
                $count = $row['piece'];
                if($count <= 0)
                {
              ?>
                <p class="btn btn-danger">OUT OF STOCK</p>                        
              <?php
                }
                else {
              ?>
                <button class="btn btn-dark" type="submit" name="add">Kosárba rakom.</button>
              <?php
                      } 
              }
              ?>
           </div>
          </div>
         </div>
    </form>
     <?php
        }
     ?>
        </div>
    </div>
 </div>

<?php 
include("includes/footer.php");
?>