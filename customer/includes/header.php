<?php
$total = 0;
function getRealUserIpLocal()
{
  switch (true) {
    case (!empty($_SERVER['HTTP_X_REAL_IP'])):
      return $_SERVER['HTTP_X_REAL_IP'];
    case (!empty($_SERVER['HTTP_CLIENT_IP'])):
      return $_SERVER['HTTP_CLIENT_IP'];
    case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
      return $_SERVER['HTTP_X_FORWARDED_FOR'];
    default:
      return $_SERVER['REMOTE_ADDR'];
  }
}
$ip_add = getRealUserIpLocal();
$select_cart = "select * from cart inner join products where ip_add='$ip_add' and cart.p_id=products.product_id";
$con = mysqli_connect("localhost", "root", "", "sportdb");
$run_cart = mysqli_query($con, $select_cart);
$count = mysqli_num_rows($run_cart);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CRoboto" rel="stylesheet">
  <meta http-equiv="x-ua-compatible" content="IE=edge, chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" sizes="180x180" href="./images/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon/favicon-16x16.png">
  <link rel="manifest" href="./images/favicon/site.webmanifest">
  <link rel="mask-icon" href="./images/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <title>The Direction</title>

  <link href="styles/backend.css" rel="stylesheet">
  <link href="styles/style.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <link rel="stylesheet" href="~/../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="~/../assets/css/LineIcons.3.0.css" />
  <link rel="stylesheet" href="~/../assets/css/tiny-slider.css" />
  <link rel="stylesheet" href="~/../assets/css/glightbox.min.css" />
  <link rel="stylesheet" href="~/../assets/css/main.css" />

<body>
  <!-- Start Header Area -->
  <header class="header navbar-area">
    <!-- Start Topbar -->
    <div class="topbar">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-4 col-md-4 col-12">
            <div class="top-left">

            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-12">
            <!-- <div class="top-middle">
              <ul class="useful-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="about-us.html">About Us</a></li>
                <li><a href="contact.html">Contact Us</a></li>
              </ul>
            </div> -->
          </div>
          <div class="col-lg-4 col-md-4 col-12">
            <div class="top-end">
              <div class="user">
                <i class="lni lni-user"></i>

                <?php
                if (isset($_SESSION['customer_email'])) {
                ?>
                  <a href="my_account.php?my_orders">
                    <?php echo $_SESSION['customer_email']; ?>
                  </a>
                  |
                  <a href="../logout.php">Logout</a>
                <?php
                } else {
                ?>
                  <ul class="user-login">
                    <li>
                      <a href="./customer/customer_login.php">Sign In</a>
                    </li>
                    <li>
                      <a href="customer_register.php">Register</a>
                    </li>
                  </ul>
                <?php
                }
                ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Topbar -->
    <!-- Start Header Middle -->
    <div class="header-middle">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-3 col-md-3 col-7">
            <!-- Start Header Logo -->
            <a class="navbar-brand" href="../index.php">
              <img src="./images/thedirection.png" alt="Logo" style="height: 100px; width: auto;">
            </a>
            <!-- End Header Logo -->
          </div>
          <div class="col-lg-5 col-md-7 d-xs-none">
            <!-- Start Main Menu Search -->

            <!-- End Main Menu Search -->
          </div>
          <div class="col-lg-4 col-md-2 col-5">
            <div class="middle-right-area">
              <div class="nav-hotline">
                <i class="lni lni-phone"></i>
                <h3>Hotline:
                  <span>(+100) 123 456 7890</span>
                </h3>
              </div>
              <div class="navbar-cart">
                <div class="cart-items">
                  <a href="javascript:void(0)" class="main-btn">
                    <i class="lni lni-cart"></i>
                    <span class="total-items"><?php echo $count ?></span>
                  </a>
                  <!-- Shopping Item -->
                  <div class="shopping-item">
                    <div class="dropdown-cart-header">
                      <span><?php echo $count ?> Items</span>
                      <?php
                      if ($count) {
                      ?>
                        <a href="../cart.php">View Cart</a>
                      <?php
                      }
                      ?>
                    </div>
                    <ul class="shopping-list">

                      <?php while ($row_products = mysqli_fetch_array($run_cart)) {

                        $p_id = $row_products['p_id'];
                        $product_title = $row_products['product_title'];
                        $product_img1 = $row_products['product_img1'];
                        $qty = $row_products['qty'];
                        $price = $row_products['product_price'];
                        $subtotal = $qty * $price;
                        $_SESSION['pro_qty'] = $qty;
                        $total += $subtotal;
                      ?>
                        <li>
                          <div class="cart-img-head">
                            <a class="cart-img" href="../details.php?pro_id=<?php echo $p_id ?>"><img src="../admin_area/product_images/<?php echo $product_img1 ?>" alt="#"></a>
                          </div>

                          <div class="content">
                            <h4><a href="details.php?pro_id=<?php echo $p_id ?>">
                                <?php echo $product_title ?></a></h4>
                            <p class="quantity"><?php echo $qty ?>x - <span class="amount"><?php echo $qty * $price ?>.00</span></p>
                          </div>
                        </li>
                      <?php } ?>
                    </ul>
                    <div class="bottom">
                      <div class="total">
                        <span>Total</span>
                        <span class="total-amount"><?php echo $total ?>.00</span>
                      </div>
                      <?php
                      if ($count) {
                        echo "<div class='button'>
                          <a href='../checkout.php' class='btn animate'>Checkout</a>
                        </div>";
                      }
                      ?>
                    </div>
                  </div>
                  <!--/ End Shopping Item -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Header Middle -->
    <!-- Start Header Bottom -->
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8 col-md-6 col-12">
          <div class="nav-inner">
            <!-- Start Mega Category Menu -->
            <!-- End Mega Category Menu -->
            <!-- Start Navbar -->
            <nav class="navbar navbar-expand-lg">
              <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                <ul id="nav" class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a href="../shop.php" class="active" aria-label="Toggle navigation">Shop</a>
                  </li>
                  <?php
                  if (isset($_SESSION['customer_email'])) {
                  ?>
                    <li class="nav-item">
                      <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#submenu-1-2" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">My Account</a>
                      <ul class="sub-menu collapse" id="submenu-1-2">
                        <li class="nav-item"><a href="my_account.php?my_orders">Orders</a></li>
                        <li class="nav-item"><a href="../cart.php">Cart</a></li>
                        <li class="nav-item"><a href="my_account.php?my_wishlist">Wishlist</a></li>
                        <li class="nav-item"><a href="my_account.php?edit_account">Account Info</a></li>
                        <li class="nav-item"><a href="my_account.php?change_pass">Change Password</a></li>
                      </ul>
                    </li>

                  <?php } ?>

                  <li class="nav-item">
                    <a href="../localstore.php" aria-label="Toggle navigation">Local store</a>
                  </li>
                  <li class="nav-item">
                    <a href="../terms.php" aria-label="Toggle navigation">Terms of Use</a>
                  </li>
                  <li class="nav-item">
                    <a href="../contact.php" aria-label="Toggle navigation">Contact Us</a>
                  </li>
                  <li class="nav-item">
                    <a href="../about.php" aria-label="Toggle navigation">About Us</a>
                  </li>
                </ul>
              </div> <!-- navbar collapse -->
            </nav>
            <!-- End Navbar -->
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <!-- Start Nav Social -->
          <div class="nav-social">
            <h5 class="title">Follow Us:</h5>
            <ul>
              <li>
                <a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a>
              </li>
              <li>
                <a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a>
              </li>
              <li>
                <a href="javascript:void(0)"><i class="lni lni-instagram"></i></a>
              </li>
              <li>
                <a href="javascript:void(0)"><i class="lni lni-skype"></i></a>
              </li>
            </ul>
          </div>
          <!-- End Nav Social -->
        </div>
      </div>
    </div>
    <!-- End Header Bottom -->
  </header>
  <!-- End Header Area -->