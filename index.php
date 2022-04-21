<?php
session_start();
include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");
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
          <p>There are many variations of passages of Lorem Ipsum available, but the majority have
            suffered alteration in some form.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <?php
      $products = getProductNew();
      for ($i = 0; $i < count($products); $i++) {
      ?>
        <div class="col-lg-3 col-md-6 col-12">
          <!-- Start Single Product -->
          <div class="single-product">
            <div class="product-image">
              <img src="admin_area/product_images/<?php echo $products[$i]['pro_img1'] ?>" alt="#">
              <div class="button">
                <a href="details.php?pro_id=<?php echo $products[$i]['pro_id'] ?>" class="btn"><i class="lni lni-cart"></i>
                  Add to Cart
                </a>
              </div>
            </div>
            <div class="product-info">
              <span class="category"><?php echo $products[$i]['manufacturer']['title'] ?></span>
              <h4 class="title">
                <a href="product-grids.html"><?php echo $products[$i]['pro_title'] ?></a>
              </h4>
              <!-- <ul class="review">
                  <li><i class="lni lni-star-filled"></i></li>
                  <li><i class="lni lni-star-filled"></i></li>
                  <li><i class="lni lni-star-filled"></i></li>
                  <li><i class="lni lni-star-filled"></i></li>
                  <li><i class="lni lni-star"></i></li>
                  <li><span>4.0 Review(s)</span></li>
                </ul> -->
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