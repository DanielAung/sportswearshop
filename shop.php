<?php
session_start();
include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");


if (isset($_GET['add_cart'])) {
  echo "works!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
  $ip_add = getRealUserIp();
  $p_id = $pro_id;
  $product_qty = 1;
  $product_size = $_POST['product_size'];
  $check_product = "select * from cart where ip_add='$ip_add' AND p_id='$p_id'";
  $run_check = mysqli_query($con, $check_product);

  if (mysqli_num_rows($run_check) > 0) {
    echo "<script>alert('This Product is already added in cart')</script>";
    echo "<script>window.open('shop.php,'_self')</script>";
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
    echo "<script>window.open('shop.php','_self')</script>";
  }
}
?>
<!-- MAIN -->
<main>
  <!-- HERO -->
  <div class="nero">
    <div class="nero__heading">
      <span class="nero__bold">shop</span> AT The Direction
    </div>
    <p class="nero__text">
    </p>
  </div>
</main>
<div id="content">
  <!-- content Starts -->
  <div class="container">
    <div class="row">
      <!-- container Starts -->
      <!--- col-md-12 Ends -->
      <div class="col-md-3">
        <!-- col-md-3 Starts -->
        <?php include("includes/sidebar.php"); ?>
      </div><!-- col-md-3 Ends -->

      <div class="col-md-9">
        <!-- col-md-9 Starts --->
        <div class="row" id="Products">
          <div id="wait"></div>
          <?php getProducts('shop'); ?>
        </div>
        <div class="row">
          <div class="col-12">
            <nav class="d-flex mt-4" aria-label="Page navigation example">
              <ul class="pagination mx-auto">
                <?php getPaginator(); ?>
              </ul>
            </nav>
          </div>
        </div>
      </div><!-- row Ends -->
    </div>

    <!-- center Starts -->
  </div><!-- col-md-9 Ends --->
</div>

<!--- wait Ends -->
</div><!-- container Ends -->
</div><!-- content Ends -->
<?php
include("includes/footer.php");
?>

<script src="js/jquery.min.js"> </script>
<script src="js/bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    /// Hide And Show Code Starts ///
    $('.nav-toggle').click(function() {
      $(".panel-collapse,.collapse-data").slideToggle(700, function() {
        if ($(this).css('display') == 'none') {
          $(".hide-show").html('Show');
        } else {
          $(".hide-show").html('Hide');
        }
      });
    });
    /// Hide And Show Code Ends ///

    /// Search Filters code Starts ///
    $(function() {
      $.fn.extend({
        filterTable: function() {
          return this.each(function() {
            $(this).on('keyup', function(e) {
              search = e.target.value.trim().toLowerCase();
              target = $(this).attr('data-filters');
              handle = $(target);
              rows = handle.find('li a');
              if (search !== '') {
                rows.each(function(e) {
                  if ($(rows[e]).text().trim().toLowerCase().indexOf(search) == -1) {
                    $(rows[e]).hide();
                  } else {
                    $(rows[e]).show();
                  }
                });
              } else {
                rows.each(function(e) {
                  $(rows[e]).show();
                });
              }
            });
          });
        }
      });
      $('[data-action="filter"][id="dev-table-filter"]').filterTable();
    });
    /// Search Filters code Ends ///
  });
</script>
<script>
  $(document).ready(function() {
    // getProducts Function Code Starts
    function getProducts() {
      // Manufacturers Code Starts
      var sPath = '';
      var aInputs = $('li').find('.get_manufacturer');
      var aKeys = Array();
      var aValues = Array();
      iKey = 0;
      $.each(aInputs, function(key, oInput) {
        if (oInput.checked) {
          aKeys[iKey] = oInput.value
        };
        iKey++;
      });

      if (aKeys.length > 0) {
        var sPath = '';
        for (var i = 0; i < aKeys.length; i++) {
          sPath = sPath + 'man[]=' + aKeys[i] + '&';
        }
      }
      // Manufacturers Code ENDS
      // Products Categories Code Starts
      var aInputs = Array();
      var aInputs = $('li').find('.get_p_cat');
      var aKeys = Array();
      var aValues = Array();
      iKey = 0;
      $.each(aInputs, function(key, oInput) {
        if (oInput.checked) {
          aKeys[iKey] = oInput.value
        };
        iKey++;
      });

      if (aKeys.length > 0) {
        for (var i = 0; i < aKeys.length; i++) {
          sPath = sPath + 'p_cat[]=' + aKeys[i] + '&';
        }
      }
      // Products Categories Code ENDS
      // Categories Code Starts
      var aInputs = Array();
      var aInputs = $('li').find('.get_cat');
      var aKeys = Array();
      var aValues = Array();
      iKey = 0;

      $.each(aInputs, function(key, oInput) {
        if (oInput.checked) {
          aKeys[iKey] = oInput.value
        };
        iKey++;
      });

      if (aKeys.length > 0) {
        for (var i = 0; i < aKeys.length; i++) {
          sPath = sPath + 'cat[]=' + aKeys[i] + '&';
        }
      }

      // Categories Code ENDS
      // Loader Code Starts
      $('#wait').html('<img src="images/load.gif">');
      // Loader Code ENDS
      // ajax Code Starts
      $.ajax({
        url: "load.php",
        method: "POST",
        data: sPath + 'sAction=getProducts',
        success: function(data) {
          console.log($('#Products'));
          $('#Products').html('');
          $('#Products').html(data);
          $("#wait").empty();
        }
      });

      $.ajax({
        url: "load.php",
        method: "POST",
        data: sPath + 'sAction=getPaginator',
        success: function(data) {
          $('.pagination').html('');
          $('.pagination').html(data);
        }
      });
      // ajax Code Ends
    }
    // getProducts Function Code Ends
    $('.get_manufacturer').click(function() {
      getProducts();
    });


    $('.get_p_cat').click(function() {
      getProducts();
    });

    $('.get_cat').click(function() {
      getProducts();

    });
  });
</script>
</body>

</html>