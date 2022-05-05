<?php
session_start();
include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");

$products = getProductNew();

if (isset($_GET['add_cart'])) {
  $ip_add = getRealUserIp();
  $p_id = $pro_id;
  $product_qty = $_POST['product_qty'];
  $product_size = $_POST['product_size'];
  $check_product = "select * from cart where ip_add='$ip_add' AND p_id='$p_id'";
  $run_check = mysqli_query($con, $check_product);

  if (mysqli_num_rows($run_check) > 0) {
    echo "<script>alert('This Product is already added in cart')</script>";
    echo "<script>window.open('index.php','_self')</script>";
  } else {
    $get_price = "select * from products where product_id='$p_id'";
    $run_price = mysqli_query($con, $get_price);
    $row_price = mysqli_fetch_array($run_price);

    $pro_price = $row_price['product_price'];
    $pro_psp_price = $row_price['product_psp_price'];
    $pro_label = $row_price['product_label'];

    if ($pro_label == "Sale" or $pro_label == "Gift") {
      $product_price = $pro_psp_price;
    } else {
      $product_price = $pro_price;
    }
    $query = "insert into cart (p_id,ip_add,qty,p_price,size) values ('$p_id','$ip_add','$product_qty','$product_price','$product_size')";
    $run_query = mysqli_query($db, $query);
    echo "<script>window.open('$pro_url','_self')</script>";
  }
}
?>
<!-- Preloader -->
<div class="preloader">
  <div class="preloader-inner">
    <div class="preloader-icon">
      <span></span>
      <span></span>
    </div>
  </div>
</div>
<!-- /End Preloader -->
<!-- Cover -->
<!-- Start Trending Product Area -->
<section class="trending-product section" style="margin-top: 12px;">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title">
          <h2>Trending Product</h2>
          <p>There are many variations of passages of the directionsportswear available, but the shop have
            suffered alteration in some form.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <?php

      for ($i = 0; $i < count($products); $i++) {
      ?>
        <div class="col-lg-3 col-md-6 col-12">
          <!-- Start Single Product -->
          <div class="single-product">
            <div class="product-image">
              <img src="admin_area/product_images/<?php echo $products[$i]['pro_img1'] ?>" alt="#">
              <div class="button">
                <a href="index.php?add_cart=<?php echo $products[$i]['pro_id'] ?>" class="btn"><i class="lni lni-cart"></i>
                  Add to Cart
                </a>
              </div>
            </div>
            <div class="product-info">
              <span class="category"><?php echo $products[$i]['manufacturer']['title'] ?></span>
              <h4 class="title">
                <a href="details.php?pro_id=<?php echo $products[$i]['pro_id'] ?>"><?php echo $products[$i]['pro_title'] ?></a>
              </h4>
              <div class="price">
                <span class="fs-5">$ <?php echo $products[$i]['product_psp_price'] ?>.00</span>
                <span class="text-decoration-line-through fs-6">$ <?php echo $products[$i]['pro_price'] ?>.00</span>
              </div>
            </div>
          </div>
          <!-- End Single Product -->
        </div>
      <?php } ?>
    </div>
  </div>
</section>
<!-- End Trending Product Area -->
<?php include("includes/footer.php"); ?>