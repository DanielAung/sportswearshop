<?php
$db = mysqli_connect("localhost", "root", "", "sportdb");
/// IP address code starts /////
function getRealUserIp()
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
/// IP address code Ends /////
function getManufactures($id = null)
{
    $data = [];
    global $db;
    $get_manufactures = "select * from manufacturers";
    if (!empty($id)) {
        $get_manufactures = $get_manufactures . " where manufacturer_id  = '$id'";
    }
    $run_manufactures = mysqli_query($db, $get_manufactures);
    while ($row_manufactures = mysqli_fetch_array($run_manufactures)) {
        array_push($data, [
            'id' => $row_manufactures['manufacturer_id'],
            'title' => $row_manufactures['manufacturer_title'],
            'image' => $row_manufactures['manufacturer_image'],
            'top' => $row_manufactures['manufacturer_top']
        ]);
    }
    return $data;
}
function getCategories($id = null)
{
    $data = [];
    global $db;
    $get_categories = "select * from categories";
    if (!empty($id)) {
        $get_categories = $get_categories . " where cat_id  = '$id'";
    }
    $run_cart = mysqli_query($db, $get_categories);
    while ($row_cart = mysqli_fetch_array($run_cart)) {
        array_push($data, [
            'id' => $row_cart['cat_id'],
            'title' => $row_cart['cat_title'],
            'image' => $row_cart['cat_image'],
            'top' => $row_cart['cat_top']
        ]);
    }
    return $data;
}
// items function Starts ///
function items()
{
    global $db;
    $ip_add = getRealUserIp();
    $get_items = "select * from cart where ip_add='$ip_add'";
    $run_items = mysqli_query($db, $get_items);
    $count_items = mysqli_num_rows($run_items);
    echo $count_items;
}

// items function Ends ///
// total_price function Starts //
function total_price()
{
    global $db;
    $ip_add = getRealUserIp();
    $total = 0;
    $select_cart = "select * from cart where ip_add='$ip_add'";
    $run_cart = mysqli_query($db, $select_cart);

    while ($record = mysqli_fetch_array($run_cart)) {
        $pro_id = $record['p_id'];
        $pro_qty = $record['qty'];
        $sub_total = $record['p_price'] * $pro_qty;
        $total += $sub_total;
    }
    echo "$" . $total;
}
// total_price function Ends //
// getPro function Starts //
function getProductNew()
{
    $data = [];
    global $db;

    $get_products = "select * from products";
    $run_products = mysqli_query($db, $get_products);

    while ($row_products = mysqli_fetch_array($run_products)) {
        $manufacturer = getManufactures($row_products['manufacturer_id'])[0];
        $category = getCategories($row_products['cat_id'])[0];
        array_push($data, [
            'pro_id' => $row_products['product_id'],
            'pro_title' => $row_products['product_title'],
            'pro_img1' =>  $row_products['product_img1'],
            'pro_img2' =>  $row_products['product_img2'],
            'pro_img3' =>  $row_products['product_img3'],
            'pro_price' => $row_products['product_price'],
            'product_psp_price' => $row_products['product_psp_price'],
            'product_desc' => $row_products['product_desc'],
            'product_features' => $row_products['product_features'],
            'product_video' => $row_products['product_video'],
            'product_keywords' => $row_products['product_keywords'],
            'product_label' => $row_products['product_label'],
            'status' => $row_products['status'],
            'manufacturer' => $manufacturer,
            'category' => $category
        ]);
    }
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    return $data;
}
function getPro()
{
    global $db;
    $get_products = "select * from products order by 1 DESC LIMIT 0,8";
    $run_products = mysqli_query($db, $get_products);
    
    while ($row_products = mysqli_fetch_array($run_products)) {
        $pro_id = $row_products['product_id'];
        $pro_title = $row_products['product_title'];
        $pro_price = $row_products['product_price'];
        $pro_img1 = $row_products['product_img1'];
        $pro_label = $row_products['product_label'];

        $manufacturer_id = $row_products['manufacturer_id'];
        $get_manufacturer = "select * from manufacturers where manufacturer_id='$manufacturer_id'";
        $run_manufacturer = mysqli_query($db, $get_manufacturer);
        $row_manufacturer = mysqli_fetch_array($run_manufacturer);
        $manufacturer_name = $row_manufacturer['manufacturer_title'];
        $pro_psp_price = $row_products['product_psp_price'];
        $pro_url = $row_products['product_url'];

        if ($pro_label == "Sale" or $pro_label == "Gift") {
            $product_price = "<del> $$pro_price </del>";
            $product_psp_price = "| $$pro_psp_price";
        } else {
            $product_psp_price = "";
            $product_price = "$$pro_price";
        }

        if ($pro_label == "") {
        } else {
            $product_label = "
                    <a class='label sale' href='#' style='color:black;'>
                        <div class='thelabel'>$pro_label</div>
                        <div class='label-background'> </div>
                    </a>
            ";
        }
        echo "
                <div class='col-md-4 col-sm-6 single'>
                <div class='product'>
                <a href='$pro_url'>
                    <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                </a>
                <div class='text'>
                    <center>
                        <p class='btn btn-warning'> $manufacturer_name </p>
                    </center>
                    <hr>
                    <h3><a href='$pro_url'>$pro_title</a></h3>
                    <p class='price'> $product_price $product_psp_price </p>
                    <p class='buttons'>
                        <a href='$pro_url' class='btn btn-default'>View Details</a>
                        <a href='$pro_url' class='btn btn-danger'>
                            <i class='fa fa-shopping-cart'></i> Add To Cart
                        </a>
                    </p>
                </div>
                     $product_label
                </div>
            </div>
        ";
    }
}
// getPro function Ends //
/// getProducts Function Starts ///
function getProducts($pageName)
{
    /// getProducts function Code Starts ///
    global $db;
    $aWhere = array();
    /// Manufacturers Code Starts ///
    if (isset($_REQUEST['man']) && is_array($_REQUEST['man'])) {
        foreach ($_REQUEST['man'] as $sKey => $sVal) {
            if ((int)$sVal != 0) {

                $aWhere[] = 'manufacturer_id=' . (int)$sVal;
            }
        }
    }
    /// Manufacturers Code Ends ///
    /// Products Categories Code Starts ///
    if (isset($_REQUEST['p_cat']) && is_array($_REQUEST['p_cat'])) {
        foreach ($_REQUEST['p_cat'] as $sKey => $sVal) {
            if ((int)$sVal != 0) {
                $aWhere[] = 'p_cat_id=' . (int)$sVal;
            }
        }
    }
    /// Products Categories Code Ends ///

    /// Categories Code Starts ///
    if (isset($_REQUEST['cat']) && is_array($_REQUEST['cat'])) {
        foreach ($_REQUEST['cat'] as $sKey => $sVal) {
            if ((int)$sVal != 0) {
                $aWhere[] = 'cat_id=' . (int)$sVal;
            }
        }
    }
    /// Categories Code Ends ///

    $per_page = 6;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    $start_from = ($page - 1) * $per_page;
    $sLimit = " order by 1 DESC LIMIT $start_from,$per_page";
    $sWhere = (count($aWhere) > 0 ? ' WHERE ' . implode(' or ', $aWhere) : '') . $sLimit;
    $get_products = "select * from products  " . $sWhere;
    $run_products = mysqli_query($db, $get_products);
    while ($row_products = mysqli_fetch_array($run_products)) {
        $pro_id = $row_products['product_id'];
        $pro_title = $row_products['product_title'];
        $pro_price = $row_products['product_price'];
        $pro_img1 = $row_products['product_img1'];
        $pro_label = $row_products['product_label'];

        $manufacturer_id = $row_products['manufacturer_id'];
        $get_manufacturer = "select * from manufacturers where manufacturer_id='$manufacturer_id'";
        $run_manufacturer = mysqli_query($db, $get_manufacturer);
        $row_manufacturer = mysqli_fetch_array($run_manufacturer);
        $manufacturer_name = $row_manufacturer['manufacturer_title'];
        $pro_psp_price = $row_products['product_psp_price'];
        $pro_url = $row_products['product_url'];
        if ($pro_label == "Sale" or $pro_label == "Gift") {
            $product_price = "<del> $$pro_price </del>";
            $product_psp_price = "| $$pro_psp_price";
        } else {
            $product_psp_price = "";
            $product_price = "$$pro_price";
        }

        if ($pro_label == "") {
        } else {
            $product_label = "
                <a class='label sale' href='#' style='color:black;'>
                    <div class='thelabel'>$pro_label</div>
                    <div class='label-background'> </div>
                </a>
            ";
        }
        echo "
        <div class='col-lg-3 col-md-6 col-12'>
          <!-- Start Single Product -->
          <div class='single-product'>
            <div class='product-image'>
              <img src='admin_area/product_images/$pro_img1' alt='#'>
              <div class='button'>
                <a href='details.php?pro_id=$pro_id' class='btn'><i class='lni lni-eye'></i>
                  View Detail
                </a>
              </div>
            </div>
            <div class='product-info'>
              <span class='category'>$manufacturer_name</span>
              <h4 class='title'>
                <a href='details.php?pro_id=$pro_id'>$pro_title</a>
              </h4>
              <div class='price'>
                <span class='fs-5'>$product_price</span>
                <span class='text-decoration-line-through fs-6'> $pro_psp_price</span>
              </div>
            </div>
          </div>
          <!-- End Single Product -->
        </div>

        ";
    }
    /// getProducts function Code Ends ///
}
/// getProducts Function Ends ///
/// getPaginator Function Starts ///
function getPaginator()
{
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    /// getPaginator Function Code Starts ///
    $per_page = 6;
    global $db;
    $aWhere = array();
    $aPath = '';
    /// Manufacturers Code Starts ///
    if (isset($_REQUEST['man']) && is_array($_REQUEST['man'])) {
        foreach ($_REQUEST['man'] as $sKey => $sVal) {
            if ((int)$sVal != 0) {
                $aWhere[] = 'manufacturer_id=' . (int)$sVal;
                $aPath .= 'man[]=' . (int)$sVal . '&';
            }
        }
    }
    /// Manufacturers Code Ends ///

    /// Products Categories Code Starts ///
    if (isset($_REQUEST['p_cat']) && is_array($_REQUEST['p_cat'])) {
        foreach ($_REQUEST['p_cat'] as $sKey => $sVal) {
            if ((int)$sVal != 0) {
                $aWhere[] = 'p_cat_id=' . (int)$sVal;
                $aPath .= 'p_cat[]=' . (int)$sVal . '&';
            }
        }
    }
    /// Products Categories Code Ends ///

    /// Categories Code Starts ///
    if (isset($_REQUEST['cat']) && is_array($_REQUEST['cat'])) {
        foreach ($_REQUEST['cat'] as $sKey => $sVal) {
            if ((int)$sVal != 0) {
                $aWhere[] = 'cat_id=' . (int)$sVal;
                $aPath .= 'cat[]=' . (int)$sVal . '&';
            }
        }
    }
    /// Categories Code Ends ///
    $sWhere = (count($aWhere) > 0 ? ' WHERE ' . implode(' or ', $aWhere) : '');
    $query = "select * from products " . $sWhere;
    $result = mysqli_query($db, $query);
    $total_records = mysqli_num_rows($result);
    $total_pages = ceil($total_records / $per_page);

    echo "<li class='page-item'><a class='page-link' href='shop.php?page=1";
    if (!empty($aPath)) {
        echo "&" . $aPath;
    }
    echo "' >" . 'First Page' . "</a></li>";
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($page == $i) {
            $className = 'active';
        } else {
            $className = '';
        }
        echo "<li class='page-item $className'><a class='page-link' href='shop.php?page=" . $i . (!empty($aPath) ? '&' . $aPath : '') . "' >" . $i . "</a></li>";
    };
    echo "<li class='page-item'><a class='page-link' href='shop.php?page=$total_pages";
    if (!empty($aPath)) {
        echo "&" . $aPath;
    }
    echo "' >" . 'Last Page' . "</a></li>";
    /// getPaginator Function Code Ends ///
}
/// getPaginator Function Ends ///
