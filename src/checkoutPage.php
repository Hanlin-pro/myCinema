<?php
session_start();
include_once('connection.php');
require_once('./php/component.php');
require_once('./php/cartFunction.php');

if (isset($_POST["checkOut"])) {

  if (isset($_COOKIE['shopping_cart'])) {
    unset($_COOKIE['shopping_cart']);
    setcookie('shopping_cart', '', time() - 3600);
  }
}
?>
<!DOCTYPE html>
<html lang="en" class="background">


<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopster | CheckOut</title>
  <link href="./style/main.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="./favicon.ico">
  <link href="./style/misc-style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/866d4fbcee.js" crossorigin="anonymous"></script>
  <link href="./style/checkout.css" rel="stylesheet">
</head>


<body>
<nav>
     <a href="index.php"><span>
      <h1 class="logo">shopster.</h1>
     </span></a>
     <div class="navbar" id="navbarNavAltMarkup">
       <ul>
         <li><a class="button-header" href="./index.php"><i>home</a></li>
         <li><a class="button-header" href="./productPage.php">products</a></li>
         <li><a class="button-header" href="./aboutPage.php">about</a></li>
         <?php
           if (isset($_SESSION['logged_in']) && $_SESSION["logged_in"] = true) {
             echo '<li style="float:right"><a class="button-header" href="./logout.php">Log Out</a></li>';
             echo "<li style='margin:center'><a class='userHello'>Hello, " . $_SESSION['username'] . "</i></a></li>";
           } else {
             echo '<li style="float:right"><a class="button-header" href="./loginPage.php">Log In</i></a></li>';
           }
         ?>
       </ul>
     </div>
   </nav>
  
   <div class="todayHeader">
     <h3>- CHECKOUT -</h3>
   </div>

  <div class="row">
     <div class="col-75">
       <div class="container">
         <form action="./php/paymentSuccess.php" method="POST">
            <div class="row">
               <div class="col-50">
                 <h3>Shipping Address</h3>
                 <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                 <input type="text" id="fname" name="firstname" placeholder="full name">
                 <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                 <input type="text" id="adr" name="address" placeholder="address" >
                 <label for="city"><i class="fa fa-institution"></i> City</label>
                 <input type="text" id="city" name="city" placeholder="city">
                 <div class="row">
                    <div class="col-50">
                     <label for="state">State</label>
                     <input type="text" id="state" name="state" placeholder="state">
                   </div>
                   <div class="col-50">
                   <label for="zip">Zip</label>
                   <input type="text" id="zip" name="zip" placeholder="zip" >
                 </div>
               </div>
             </div>

          <div class="col-50">
            <h3>Payment</h3>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="name">
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="Exp month">

            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" placeholder="year">
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="cvv">
              </div>
            </div>
          </div>

        </div>
        <input type="submit" value="Continue to checkout" class="btn" >
      </form>
    </div>
  </div>


  <?php
 if (isset($_COOKIE["shopping_cart"])) {
     $quantity = 0;
     $total = 0;
     $cookie_data = stripslashes($_COOKIE['shopping_cart']);
     $cart_data = json_decode($cookie_data, true);
     foreach ($cart_data as $keys => $values) {
         $quantity += $values["product_quantity"];
         $total += $values["product_price"] * $values["product_quantity"];
     }
    // echo "<p> Items: ($quantity)</p>";
 } else {
    // echo "<h3>Items: (0)</h3>";
 }
 ?>

<div class="col-25">
  <div class="checkoutContainer">
      <h4>------------------------CHECKOUT DETAILS------------------------</h4>
          
        
          <?php
            if (isset($_COOKIE["shopping_cart"])) {
              $cookie_data = stripslashes($_COOKIE['shopping_cart']);
              $cart_data = json_decode($cookie_data, true);
              foreach ($cart_data as $keys => $values) {
               displayCheckOutItem($values['product_id'], $values['product_name'], $values['product_price'], $values['product_quantity'],$values['product_image']);
              }
            }
          ?> 
         <h3>Total :
           <?php
              if (isset($_COOKIE["shopping_cart"])) {
               echo "$$total";
              } else {
               echo '0';
              } 
            ?>   
         </h3>
        
    
  </div> 
</div>





    <footer>
  Shopster &copy; 2022
  </footer>



    </html> 
