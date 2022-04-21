<?php
  session_start();
  include("includes/db.php");
  include("includes/header.php");
  include("functions/functions.php");
  include("includes/main.php");
?>
<!-- MAIN -->
<main>
  <!-- HERO -->
  <div class="nero">
    <div class="nero__heading">
      <span class="nero__bold">Local </span>Stores
    </div>
    <p class="nero__text">
    </p>
  </div>
</main>

<div id="content">
  <!-- content Starts -->
  <div class="container">
    <!-- container Starts -->
    <div class="col-md-12">
      <!-- col-md-12 Starts -->
      <div class="services row">
        <!-- services row Starts -->
        <?php
          $get_services = "select * from store";
          $run_services = mysqli_query($con, $get_services);
          while ($row_stores = mysqli_fetch_array($run_services)) {
            $store_id = $row_stores['store_id'];
            $store_title = $row_stores['store_title'];
            $store_image = $row_stores['store_image'];
            $store_desc = $row_stores['store_desc'];
            $store_button = $row_stores['store_button'];
            $store_url = $row_stores['store_url'];
        ?>
          <div class="col-md-4 col-sm-6 box">
            <!-- col-md-4 col-sm-6 box Starts -->
            <img src="admin_area/store_images/<?php echo $store_image; ?>" class="img-responsive">
            <h2 align="center"> <?php echo $store_title; ?> </h2>
            <p>
              <?php echo $store_desc; ?>
            </p>
            <center>
              <a href="<?php echo $store_url; ?>" class="btn btn-primary">
                <?php echo $store_button; ?>
              </a>
            </center>
          </div><!-- col-md-4 col-sm-6 box Ends -->
        <?php } ?>
      </div><!-- services row Ends -->
    </div><!-- col-md-12 Ends -->
  </div><!-- container Ends -->
</div><!-- content Ends -->

<?php
  include("includes/footer.php");
?>
<script src="js/jquery.min.js"> </script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>