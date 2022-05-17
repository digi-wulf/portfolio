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
		$CATALOG[$sku]['genre'] = trim($lineArray[4]);
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
	  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <title>Premium Videos | Shop</title>
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
            <a href="index.php"><img class="logo" src="images/premiumvidlogo.png" alt="Premium Videos Logo"></a>
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
			<form method="get">
				<input type="submit" name="all" value="All" style="background:transparent;"/> |
				<input type="submit" name="adventure" value="Adventure" style="background:transparent;"/> |
				<input type="submit" name="historical" value="Historical" style="background:transparent;"/> |
				<input type="submit" name="horror" value="Horror" style="background:transparent;"/>



			</form>
        </div>
		<form method="get" style=" padding-top:20px; padding-bottom:20px; margin:auto; width:60%">
		<button type='submit' class="searchbutton">Search</button><input type="search" name="searchformovie" placeholder="Search for movies..." class="searchbar" required/>

		</form>

        <div class="info">

            <div class="promo" style="background-image:none;">

            <?php
			if(isset($_GET['searchformovie']))
      {
    			$moviesearchlower=strtolower($_GET['searchformovie']);
    			$moviesearch=ucwords($moviesearchlower);
    			$x=0;
    			$matchfound=false;
    			foreach ($CATALOG as $k => $v) if ($moviesearch == $v['desc'])
          {
      				$matchfound=true;
      				echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center'>";
      				echo "<section class='box-c text-center pd-xl'><h3 class='text-s2'><input type='submit' formaction='product.php' name='add' value='" . $v['desc'] . "' style='background:transparent; color:#000000; font-size: 18px; letter-spacing: 1px; text-transform: uppercase; font-family: Oswald, sans-serif; font-weight:bold'/></h3></b><p class='pd-s'>";
              //code to insert images from database file
              echo "<img src=" . $v['image'] . "style='width:225px; height:320px;'/>";
              echo "<p style='color:#1e47b6; font-weight:800;' class='text-s pd-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
              echo "<input type='number' class='text-s pd-s' value=1 min=1 max=100 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
              echo "<input type='submit' name='add' value='Add item to cart' class='pd-s'/>";
              echo "</section>";
              echo "</form>";

    			}if ($matchfound==false){
    			     echo "<p>Sorry, no match found. Please check your spelling and try again.</p>";
    			}

			}

			elseif(isset($_GET['adventure'])) {
            foreach ($CATALOG as $k => $v) if ($v['genre'] == 'adventure')  {
                echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center'>";
				        echo "<section class='box-c text-center pd-xl'><h3 class='text-s2'><input type='submit' formaction='product.php' name='add' value='" . $v['desc'] . "' style='background:transparent; color:#000000; font-size: 18px; letter-spacing: 1px; text-transform: uppercase; font-family: Oswald, sans-serif; font-weight:bold'/></h3></b><p class='pd-s'>";
                //code to insert images from database file
                echo "<img src=" . $v['image'] . "style='width:225px; height:320px;'/>";
                echo "<p style='color:#1e47b6; font-weight:800;' class='text-s pd-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
                echo "<input type='number' class='text-s pd-s' value=1 min=1 max=100 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
                echo "<input type='submit' name='add' value='Add item to cart' class='pd-s'/>";
                echo "</section>";
                echo "</form>";
				}
			}elseif(isset($_GET['horror'])){
				foreach ($CATALOG as $k => $v) if ($v['genre'] == 'horror')  {

                echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center'>";
				        echo "<section class='box-c text-center pd-xl'><h3 class='text-s2'><input type='submit' formaction='product.php' name='add' value='" . $v['desc'] . "' style='background:transparent; color:#000000; font-size: 18px; letter-spacing: 1px; text-transform: uppercase; font-family: Oswald, sans-serif; font-weight:bold'/></h3></b><p class='pd-s'>";
                //code to insert images from database file
                echo "<img src=" . $v['image'] . "style='width:225px; height:320px;'/>";
                echo "<p style='color:#1e47b6; font-weight:800;' class='text-s pd-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
                echo "<p class='text-s' style='display:block;'>Quantity: ";
                echo "<input type='number' class='text-s pd-s' value=1 min=1 max=100 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
                echo "<input type='submit' name='add' value='Add item to cart' class='pd-s'/>";
                echo "</section>";
                echo "</form>";
			}}elseif(isset($_GET['historical'])){
				foreach ($CATALOG as $k => $v) if ($v['genre'] == 'historical')  {

                echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center'>";
                echo "<section class='box-c text-center pd-xl'><h3 class='text-s2'><input type='submit' formaction='product.php' name='add' value='" . $v['desc'] . "' style='background:transparent; color:#000000; font-size: 18px; letter-spacing: 1px; text-transform: uppercase; font-family: Oswald, sans-serif; font-weight:bold'/></h3></b><p class='pd-s'>";

                //code to insert images from database file
                echo "<img src=" . $v['image'] . "style='width:225px; height:320px;'/>";
                echo "<p style='color:#1e47b6; font-weight:800;' class='text-s pd-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
                echo "<p class='text-s' style='display:block;'>Quantity: ";
                echo "<input type='number' class='text-s pd-s' value=1 min=1 max=100 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
                echo "<input type='submit' name='add' value='Add item to cart' class='pd-s'/>";
                echo "</section>";
                echo "</form>";
			}}
			else{
			foreach ($CATALOG as $k => $v){
                echo "<form action='cart.php' method='post' id='myform' class='product-spc text-center'>";
				        echo "<section class='box-c text-center pd-xl'><h3 class='text-s2'><input type='submit' formaction='product.php' name='add' value='" . $v['desc'] . "' style='background:transparent; color:#000000; font-size: 18px; letter-spacing: 1px; text-transform: uppercase; font-family: Oswald, sans-serif; font-weight:bold'/></h3></b><p class='pd-s'>";

                //code to insert images from database file
                echo "<img src=" . $v['image'] . "style='width:225px; height:320px;'/>";
                echo "<p style='color:#1e47b6; font-weight:800;' class='text-s pd-s'>Price: $" . $CATALOG[$k]['price'] . "</p>";
                echo "<p class='text-s' style='display:block;'>Quantity: ";
                echo "<input type='number' class='text-s pd-s' value=1 min=1 max=100 size=4 type=text name=\"a_qty[" . $k . "]\"></p><br/>";
                echo "<input type='submit' formaction='cart.php' name='add' value='Add item to cart' class='pd-s'/>";
				        echo "</section>";
                echo "</form>";
			}
			}
            ?>
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
