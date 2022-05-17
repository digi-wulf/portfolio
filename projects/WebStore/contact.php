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
    <title>Premium Videos | Contact</title>
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
                Get in touch
            </h2>
        </div>
        <!--End of Banner-->

        <!--Info-->

        <div class="aboutmain">

            <h1 class="blog-post_title1">Get in Touch</h1>

            <div class="container123">
              <form action="/action_page.php">
                <label for="fname" class="text-s">First Name</label>
                <input type="text" id="fname" name="firstname" placeholder="Johnny...">

                <label for="lname" class="text-s">Last Name</label>
                <input type="text" id="lname" name="lastname" placeholder="Cash...">



                <label for="subject" class="text-s">How can we improve</label>
                <textarea id="subject" name="subject" placeholder="Tell us how you feel.."
                  style="height:200px"></textarea>

                <input type="submit" value="Submit">
              </form>
            </div>
			<h1 class="blog-post_title1">About us</h1>
              <p class="text-s">
                Premium Videos is an American video rental company specializing in DVD, Blu-ray, 4K UHD rentals, and formerly video games via automated retail kiosks. Redbox kiosks feature the company's signature red color and are located at convenience stores, fast food restaurants, grocery stores, mass retailers, and pharmacies.
        <br><br>

              </p>
              <p class="text-s">
                Premium Videos was initially started by McDonald's Corporation business development team. Originally the kiosks sold convenience store products under the name Ticktok Easy Shop, however in late 2003 McDonald's ended its use of the kiosks for these products. Instead, Gregg Kaplan decided to use the kiosks for DVD rentals which was tested in Denver in 2004. The company also employed a ‘return anywhere’ policy, different from competitors, which allowed consumers to return their rental to any Redbox kiosk, not just the one from which they originally rented the unit. Kiosks offered both films and video games for rent.
              </p>
			<h1 class="blog-post_title1">Our Location</h1>


            <div style="width: 100%"><iframe width="100%" height="600" frameborder="0"
                scrolling="no" marginheight="0" marginwidth="0"
                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Houston%20main%20street+(Black%20Box%20Theater)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a
                  href="http://www.gps.ie/">gps systems</a></iframe></div>
				  <div class="wrapper">
				  
              
            </div>

        </div>
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
