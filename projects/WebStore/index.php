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
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <title>Premium Videos | Index</title>
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
            <h1 class="text-xl">
                Premium
            </h1>
            <h2 class="text-l">
                Videos
            </h2>

        </div>
        <!--End of Banner-->

        <!--Info

            <section class="box-a text-center pd-l">
                <h3 class="text-m">
                    Medium Text
                </h3>
                <p class="text-s">
                    Small text
                </p>
            </section>-->
            <div class="info">
            <h2 class="text-l headers pd-xxl">Best Sellers</h2>
            <section class="box-b pd-l">
                <img class="item-disp" src="images/purge.jpg" alt="The Purge Movie" style="width:200px;">
                <div class="desc pd-m">
                    <h3 class="text-m">
                        The Purge
                    </h3>
                    <p class="text-s">
                        It has been two years since Leo Barnes (Frank Grillo) stopped himself from a regrettable act of
                        revenge on Purge Night - the 12 hours of lawlessness. This year, the annual ritual comes at the
                        eve of a heated presidential election with the nation deeply divided between those who are pro-
                        and anti-Purge.
                    </p>
                </div>
            </section>
            <section class="box-b pd-l">
                <img class="item-disp" src="images/movies/junglecruise.jpg" alt="Jungle Cruise" style="width:200px;">
                <div class="desc pd-m">
                    <h3 class="text-m">
                        Jungle Cruise
                    </h3>
                    <p class="text-s">
                        Seeking an ancient tree with healing abilities, Dr. Lily Houghton and wisecracking skipper Frank
                        Wolff team up for the adventure-of-a lifetime on Disney’s Jungle Cruise, a rollicking ride down
                        the Amazon. Amidst danger and supernatural forces lurking in the jungle, secrets of the lost
                        tree unfold as their fate—and mankind’s—hangs in the balance.
                    </p>
                </div>
            </section>
            <section class="box-b pd-l">
                <img class="item-disp" src="images/movies/jurassic1.jpg" alt="Jurassic Park" style="width:200px;">
                <div class="desc pd-m">
                    <h3 class="text-m">
                        Jurassic Park
                    </h3>
                    <p class="text-s">
                        Owen (Chris Pratt) and Claire (Bryce Dallas Howard) race to restore order at Jurassic World
                        theme park when a ferocious genetically modified dinosaur escapes.
                    </p>
                </div>
            </section>

           <h2 class="text-l headers xxxx1">Promotional Deals (50% off)</h2><br/>
            <div class="promo">
			
          
            
			<section class="box-c text-center pd-s">
			<?php
			foreach ($CATALOG as $k => $v) if ($v['desc']=="The Last Crusade")
          {
      				
      				echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center'>";
      				
              //code to insert images from database file
              echo "<img src='images/movies/ij-a.jpg' style='height:200px;'/>";
              echo "<p style='display:none' class='text-s pd-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
              echo "<input type='number' style='display:none;' class='text-s pd-s' value=1 min=1 max=100 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
			  echo "<h3 class='text-s2'>Indiana Jones </h3>";
			  echo"<input type='submit' formaction='product.php' name='add' value='View Item' style='font-size:10pt'/>";
              echo "</section>";
			  echo "</form>";}
			  ?>
			  </section>
			  
			 
			<?php
			foreach ($CATALOG as $k => $v) if ($v['desc']=="Ghostbusters Afterlife")
          {
			echo"<section class='box-c text-center pd-s'>";	
      		echo "<div >";		
			echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center''>";
					
            //code to insert images from database file
            echo "<img src=" . $v['image'] . "style='height:200px;'/>";
            echo "<p style='display:none' class='text-s pd-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
            echo "<input type='number' style='display:none;' class='text-s pd-s' value=1 min=1 max=100 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
			echo "<h3 class='text-s2'>Ghostbusters </h3>";
			echo"<input type='submit' formaction='product.php' name='add' value='View Item' style='font-size:10pt'/>";
            echo "</form>";
			echo "</div>";
			echo "</section>";}
			  ?>
			  </section>
			  <section class="box-c text-center pd-s">
			<?php
			foreach ($CATALOG as $k => $v) if ($v['desc']=="Robin Hood")
          {
      				
      				echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center'>";
      				
              //code to insert images from database file
              echo "<img src=" . $v['image'] . "style='height:200px;'/>";
              echo "<p style='display:none' class='text-s pd-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
              echo "<input type='number' style='display:none;' class='text-s pd-s' value=1 min=1 max=100 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
			  echo "<h3 class='text-s2'>Robin Hood </h3>";
			  echo"<input type='submit' formaction='product.php' name='add' value='View Item' style='font-size:10pt'/>";
           
              echo "</section>";
		  echo "</form>";}
			  ?>
			  </section>
			  <section class="box-c text-center pd-s">
			<?php
			foreach ($CATALOG as $k => $v) if ($v['desc']=="Hereditary")
          {
      				
      				echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center'>";
      				
              //code to insert images from database file
              echo "<img src=" . $v['image'] . "style='height:200px;'/>";
              echo "<p style='display:none' class='text-s pd-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
              echo "<input type='number' style='display:none;' class='text-s pd-s' value=1 min=1 max=100 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
			  echo "<h3 class='text-s2'>Hereditary </h3>";
			  echo"<input type='submit' formaction='product.php' name='add' value='View Item' style='font-size:10pt'/>";
           
              echo "</section>";
		  echo "</form>";}
			  ?>
			  </section>
			  </div>
			
        </div>
        <!--End of Info-->
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
