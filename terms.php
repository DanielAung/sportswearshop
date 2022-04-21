<?php
session_start();
include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");


$contents = [];
$count_terms = "select * from terms";
$run_count = mysqli_query($con, $count_terms);
$count = mysqli_num_rows($run_count);
$get_terms = "select * from terms LIMIT 1,$count";
$run_terms = mysqli_query($con, $get_terms);
while ($row_terms = mysqli_fetch_array($run_count)) {
  array_push($contents, $row_terms);
}

?>
<!-- MAIN -->
<main>
  <!-- HERO -->
  <div class="nero">
    <div class="nero__heading">
      <span class="nero__bold">Terms</span> of use
    </div>
    <p class="nero__text">
    </p>
  </div>
</main>
<div id="content">
  <!-- content Starts -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
      <div class="accordion my-5" id="accordionPanelsStayOpenExample">
        <?php
          for ($i = 0; $i < count($contents); $i++) {
        ?>
        <div class="accordion-item">
          <h3 class="accordion-header" id="panelsStayOpen-headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $contents[$i]['term_link'] ?>" aria-expanded="true" aria-controls="<?php echo $contents[$i]['term_link'] ?>">
              <?php echo $contents[$i]['term_title'] ?>
            </button>
          </h3>
          <div id="<?php echo $contents[$i]['term_link'] ?>" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
            <div class="accordion-body">
              <strong> <?php echo $contents[$i]['term_desc'] ?> </strong>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
       
        </div>
      </div><!-- col-md-9 Ends -->
    </div>
  </div><!-- container Ends -->
</div><!-- content Ends -->

<?php
include("includes/footer.php");
?>
<script src="js/jquery.min.js"> </script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>