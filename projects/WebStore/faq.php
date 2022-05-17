<?php


// initialize session shopping cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
// look for catalog file
$catalogFile = "catalog.dat";
// file is available, extract data from it
// place into $CATALOG array, with SKU as key
if (file_exists($catalogFile)) {
    $data = file($catalogFile);
    foreach ($data as $line) {
        $lineArray = explode(':', $line);
        $sku = trim($lineArray[0]);
        $CATALOG[$sku]['desc'] = trim($lineArray[1]);
        $CATALOG[$sku]['price'] = trim($lineArray[2]);
        $CATALOG[$sku]['image'] = trim($lineArray[3]);
		 $CATALOG[$sku]['genre'] = trim($lineArray[4]);
		 $CATALOG[$sku]['duration'] = trim($lineArray[5]);
		 $CATALOG[$sku]['summary'] = trim($lineArray[6]);

    }
}
// file is not available
// stop immediately with an error
else {
    die("Could not find catalog file");
}
// check to see if the form has been submitted
// and which submit button was clicked
// if this is an add operation
// add to already existing quantities in shopping cart
if (isset($_POST['add'])) {
    foreach ($_POST['a_qty'] as $k => $v) {
        // if the value is 0 or negative
        // don't bother changing the cart
        if ($v > 0) {
            $_SESSION['cart'][$k] = $_POST['a_qty'][$k];
        }
    }
}
// if this is an update operation
// replace quantities in shopping cart with values entered
else if (isset($_POST["update"])) {
    foreach ($_POST['u_qty'] as $k => $v) {
        // if the value is empty, 0 or negative
        // don't bother changing the cart
        if ($v != "" && $v >= 0) {
            $_SESSION['cart'][$k] = $v;
        }
    }
}
// if this is a clear operation
// reset the session and the cart
// destroy all session data
else if (isset($_POST['clear'])) {
    $_SESSION = array();
    session_destroy();
}
else{
$_SESSION = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Premium Videos | FAQs</title>
</head>
<body>
    <!-- back to top anchor -->
    <a name="top"></a>
    <button onclick="topFunction()" id="backTop" title="Go to top">
        <img src="images/arrow_up.svg" alt="Back to Top Arrow" style="vertical-align: middle;">
    </button>

    <div class="content">
        <!--Nav-->
        <header class="pd-l">
            <a href="index.php"><img class="logo" src="images/premiumvidlogo.png" alt="Slipstream Logo"></a>
            <input type="checkbox" id="nav-toggle" class="nav-toggle">
            <nav>
                <ul>
                    <li><a href="store.php">Shop</a></li>
                    <li><a href="faq.php">FAQs</a></li>
                    <li><a href="contact.php">Contact</a></li>

                    <li>
                        <button type='submit' form="myform" class="shop-btn">Cart
                        <i class="fa fa-shopping-cart" aria-hidden="true" style="color: #1e47b6;;"></i>
                        </button>
                    </li>
                </ul>
            </nav>
            <label for="nav-toggle" class="nav-toggle-label">
                <span></span>
            </label>
        </header>
        <!--End of Nav-->

        <!--Banner-->
        <div class="banner text-center pd-xl">
            <h2 class="text-l">
                Frequently Asked Questions
            </h2>
        </div>
        <!--End of Banner-->

        <!--Info-->
        <div class="faq-content">
          <div class="faq-question">
            <input id="q1" type="checkbox" class="panel">
            <div class="plus">+</div>
            <label for="q1" class="panel-title">What is your return policy?</label>
            <div class="panel-content">We accept returns for up to 14 days after your purchase. If the product is unopened, we will accept it up to 21 days after the initial purchase.
            </div>
          </div>

          <div class="faq-question">
            <input id="q2" type="checkbox" class="panel">
            <div class="plus">+</div>
            <label for="q2" class="panel-title">Do I need a receipt to return an item?</label>
            <div class="panel-content">If the item is bought using a credit card, we can look up the date of your purchase to ensure it is in our 14 day return policy window. Otherwise, a receipt is required.
            </div>
          </div>

          <div class="faq-question">
            <input id="q3" type="checkbox" class="panel">
            <div class="plus">+</div>
            <label for="q3" class="panel-title">Do I have to pay with a card?</label>
            <div class="panel-content">No, cards, checks and cash are all accepted forms of payment, though if you think you may return the item, a card is advised.</div>
          </div>
          <div class="faq-question">
            <input id="q4" type="checkbox" class="panel">
            <div class="plus">+</div>
            <label for="q4" class="panel-title">The item I received is damaged. What do I do?</label>
            <div class="panel-content">We apologize for any inconvenience this may have caused. Bring your item back to us, either by mail or in person, and we will replace it free of charge.</div>
          </div>

          <div class="faq-question">
            <input id="q5" type="checkbox" class="panel">
            <div class="plus">+</div>
            <label for="q5" class="panel-title">I am buying a movie for a friend. Do you gift wrap?</label>
            <div class="panel-content">We do offer in store gift wrapping services for any products bought from us.</div>
          </div>

          <div class="faq-question">
            <input id="q6" type="checkbox" class="panel">
            <div class="plus">+</div>
            <label for="q6" class="panel-title">I am a teacher/principal. Do you offer any discounts to educators?</label>
            <div class="panel-content">We offer a 10% discount to teachers and principals on documentaries and select other inventory. This deal is only available on location however, as we require individuals to produce their school ID. </div>
          </div>
        </div>
        <!--End of Info-->
<div style="display:none">
	<?php
	foreach ($CATALOG as $k => $v){
                echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center'>";
				echo "<section class='box-c text-center pd-xl'><h3 class='text-s2'><input type='submit' formaction='product.php' name='add' value='" . $v['desc'] . "' style='background:transparent; color:#000000; font-size: 18px; letter-spacing: 1px; text-transform: uppercase; font-family: Oswald, sans-serif; font-weight:bold'/></h3></b><p class='pd-s'>";

                //code to insert images from database file
                echo "<img src=" . $v['image'] . "style='width:225px; height:320px;'/>";
                echo "<p style='color:#1e47b6; font-weight:800;' class='text-s pd-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
                echo "<p class='text-s' style='display:block;'>Quantity: ";
                echo "<input type='number' class='text-s pd-s' value=0 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
                echo "<input type='submit' formaction='cart.php' name='add' value='Add item to cart' class='pd-s'/>";
				echo "</section>";
                echo "</form>";


			}

	?>
	</div>
        <!--Footer-->
        <footer class="footer-basic">
            <p class="text-m">Need Help? <br> Customer Service: 111-111-1111</p>
            <p class="text-s pd-s">
                <a href="store.php" class="links">Shop</a>
                ·
                <a href="contact.php" class="links">Contact</a>
                ·
                <a href="faq.php" class="links">FAQs</a>
            </p>
            <p class="text-xs">Premium Videos &copy; 2021</p>
        </footer>
        <!--End of Footer-->
    </div>

    <script>
        //Get the button
        var mybutton = document.getElementById("backTop");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () { scrollFunction() };

        function scrollFunction() {
            if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</body>
</html>
