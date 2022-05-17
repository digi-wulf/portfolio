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
<html>

<head>
    <title> Premium Videos | Shopping Cart </title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>

<body>
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
            <h2 class="text-l">Shop</h2>
        </div>
        <div class="info">
            <form action="cart.php" method="post">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {   
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $k => $v) {
                            if ($v > 0) {
                         
                                echo "<table class='box-d pd-s' style='box-shadow:none; background-image:url(\"images/filmreel2.png\"); background-size: auto 100%; padding-top:40px; padding-bottom:80px;'><tr><td class='pd-s' style='width:50%;'>";
                                echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center'>";
                                //brings over images in database file
								
                                echo "<img src=" . $CATALOG[$k]['image'] . " style='width:60%;'/>";
                                echo "</td><td style='vertical-align:top; text-align:left; padding-top:100px; padding-bottom:100px;'>";
								echo "<p class='text-s2' style='font-size:28pt;'>". $CATALOG[$k]['desc'] . "</p><br/>";
								echo "<p style='font-weight:bold;'>Description:</p><p style='font-style:italic'>" . $CATALOG[$k]['summary'] . "</p><br/>";
                                echo "<p style='font-weight:bold;'>Duration:</p><p>" . $CATALOG[$k]['duration'] . "</p><br/>";
								echo "<p style='color:#1e47b6; font-weight:800; padding-top:10px; padding-bottom:10px;' class='text-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
                                echo "<input type='number' class='text-s pd-s' value=1 min=1 max=100 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
								echo "<input type='submit' formaction='cart.php' name='add' value='Add item to cart' class='pd-s'/>";
								echo "</form>";
                                echo "</td></tr></table>";
								
                               
                           
                              
                            }
                        }
                    }
                }
                ?>
                
                
            </form>
        </div>
    </div>

    </div>
	<div style="display:none">
    	<?php
    	foreach ($CATALOG as $k => $v)
          {
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

</body>

</html>