<?php

// start session
session_start();
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title> Premium Videos | Shopping Cart </title>
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

        <div class="banner text-center pd-xl">
            <h2 class="text-l">Cart</h2>
        </div>
        <div class="info">
            <form action="cart.php" method="post">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // initialize a variable to hold total cost
                    $total = 0;
                    // check the shopping cart
                    // if it contains values
                    // look up the SKUs in the $CATALOG array
                    // get the cost and calculate subtotals and totals
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $k => $v) {

                            // only display items that have been selected
                            // that is, quantities > 0
                            if ($v > 0) {
                                $subtotal = $v * $CATALOG[$k]['price'];
                                $total += $subtotal;
                                echo "<table class='box-d pd-s'><tr><td class='pd-s' style='width:30%;'>";
                                echo "<p class='text-s2'>". $CATALOG[$k]['desc'] . "</p><br/>";
                                //brings over images in database file
                                echo "<img src=" . $CATALOG[$k]['image'] . " class='cart-img'/>";
                                echo "</td><td>";
                                echo "<p class='text-s pd-s'><b>Quantity: $v </b></p>";
                                echo "<p>New quantity: <input type='number' class='text-s pd-s' min=0 max=100 size=4  type=text  name=\"u_qty[" . $k . "]\"></p>";
                                echo "</td><td>";
                                echo "<p style='color:#1e47b6; font-weight:800;' class='text-s pd-s'>Price: " . $CATALOG[$k]['price'] . "</p>";
                                echo "<p>Sub-total: " . sprintf("%0.2f", $subtotal) . "</p>";
                                echo "</td></tr></table>";
                            }
                        }
                    }
                }
                ?>
                <?php

                if ($total == "0") {
					          echo "<div style='text-align:center; margin-top:50px;'>";
                    echo "<p style='font-size:16pt;'>Your cart is empty <br/><br/>";
                    echo "<input type='button' name='continue' value='Start Shopping' class='pd-s' id='continue'>";
					          echo "</div>";
                } else {
                    echo "<table class='align-r'><tr><td></td><td></td><td>";
                    echo "<p><b>TOTAL= " . sprintf('%0.2f', $total) . "</b></p>
                    <input type='submit' name='update' value='Update Cart' class='pd-s'>
                    <input type='submit' name='clear' value='Clear Cart' class='pd-s'>
                    <input type='button' name='continue' value='Continue Shopping' class='pd-s' id='continue'>";
                    echo "</td></tr></table>";
                }
                ?>
                <script>
                    var btn = document.getElementById('continue');
                    btn.addEventListener('click', function() {
                        document.location.href = '<?php echo "store.php"; ?>';
                    });
                </script>
            </form>
        </div>
    </div>

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
