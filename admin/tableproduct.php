<?php require "../template/connect.php" ?>
<?php

if (isset($_GET["page"])) {
  $page  = $_GET["page"];
} else {
  $page = 1;
};
$start = ($page - 1) * 10;
// $displayproduct = $link->query("SELECT * FROM product p JOIN category c ON c.catid=p.pcatid JOIN brand b ON b.brandid=p.pbrandid");
$displayproduct = $link->query("SELECT * FROM product p JOIN category c ON c.catid=p.pcatid JOIN brand b ON b.brandid=p.pbrandid ORDER BY pid ASC LIMIT $start, 10");
if ($displayproduct->num_rows > 0) {
  while ($row = $displayproduct->fetch_assoc()) {
    $pid = $row["pid"];
    $pname = $row["pname"];
    $pbrand = $row["brand"];
    $pbrandid = $row["brandid"];
    $pcategory = $row["cat"];
    $pcategoryid = $row["catid"];
    $pdescription = $row["pdescription"];
    $pquantity = $row["pquantity"];
    $pprice = $row["pprice"];
    $pkeywords = $row["pkeywords"];
    $picture = "productimage/" . $row["picture"];

    echo "<tr>
        <td >$pid</td><td>$pname</td>
<td><img width='60' height='60' src='$picture'></td>
<td>$pprice</td>
<td>$pquantity</td>
<td>$pcategory</td>
<td>$pbrand</td>
<td>$pdescription</td>
<td>$pkeywords</td>
<td>
<a href='#' data-toggle='modal' data-target='#edit_product_modal$pid' class='btn btn-primary btn-sm'><i class='fas fa-pencil-alt'></i></a>&nbsp;
<a href='actionproduct.php?action=delete&id=$pid&picture=$picture'class='btn btn-sm btn-danger delete-product' style='color:#fff;' onclick='return confirm(`are you sure?`)'><i class='fas fa-trash-alt'></i></a>
</td>
</tr>

<div class='modal fade' id='edit_product_modal$pid' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>Add Product</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body'>
      <form action='";
    echo htmlspecialchars($_SERVER['PHP_SELF']);
    echo "' method='post' enctype='multipart/form-data'>
          <div class='row'>
            <div class='col-12'>
              <div class='form-group'>
                <label>Product Name</label>
                <input type='text' name='e_product_name' class='form-control' placeholder='Enter Product Name' value='$pname'>
              </div>
            </div>
            <div class='col-12'>
              <div class='form-group'>
                <label>Brand Name</label>
                <select class='form-control brand_list' name='e_brand_id' value='$pbrand'>
                  <option value=''>Select Brand</option>";
    $brand = $link->query("SELECT * FROM brand");
    if ($brand->num_rows > 0) {
      while ($row = $brand->fetch_assoc()) {
        $brandid = $row["brandid"];
        $brandtitle = $row["brand"];
        $selected = "";
        if ($brandid == $pbrandid) {
          $selected = "selected";
        }
        echo "<option value='$brandid' $selected>$brandtitle</option>";
      }
    }
    echo "</select>
              </div>
            </div>
            <div class='col-12'>
              <div class='form-group'>
                <label>Category Name</label>
                <select class='form-control category_list' name='e_category_id' value='$pcategory'>
                  <option value='0'>Select Category</option>";
                  $category = $link->query("SELECT * FROM category WHERE catid=parentcatid");
                  while ($row = $category->fetch_assoc()) {
                    $catid = $row["catid"];

                    
                    $cat = $row["cat"];
                    $sql = "SELECT * FROM category WHERE parentcatid=$catid";
                    $retrieve = $link->query($sql);
                    if ($retrieve->num_rows == 1) {
                      echo "<option value='$catid' $selected>$cat</option>";
                    } else {
                      echo "<optgroup label='$cat'>";
                      while ($col = $retrieve->fetch_assoc()) {
                        $selected = "";
                        $colcatid = $col["catid"];
                        $colparentcatid = $col["parentcatid"];
                        $colcat = $col["cat"];
                        if($pcategoryid==$colcatid){
                          echo $pcategoryid. " -> " . $colcatid. " -> ".$catid;
                          $selected = "Selected";
                        }
                        if ($colcatid == $catid) {
                        } else {
                          echo "<option value='$colcatid' $selected>$colcat</option>";
                        }
                      }
                      echo "</optgroup>";
                    }
                  }
    echo "</select>
              </div>
            </div>
            <div class='col-12'>
              <div class='form-group'>
                <label>Product Description</label>
                <textarea class='form-control' name='e_product_desc' placeholder='Enter product desc'>$pdescription</textarea>
              </div>
            </div>
            <div class='col-12'>
              <div class='form-group'>
                <label>Product Qty</label>
                <input type='number' name='e_product_qty' class='form-control' placeholder='Enter Product Quantity' value='$pquantity'>
              </div>
            </div>
            <div class='col-12'>
              <div class='form-group'>
                <label>Product Price</label>
                <input type='number' name='e_product_price' class='form-control' placeholder='Enter Product Price' value='$pprice'>
              </div>
            </div>
            <div class='col-12'>
              <div class='form-group'>
                <label>Product Keywords <small>(eg: apple, iphone, mobile)</small></label>
                <input type='text' name='e_product_keywords' class='form-control' placeholder='Enter Product Keywords' value='$pkeywords'>
              </div>
            </div>
            <div class='col-12'>
              <div class='form-group'>
                <label>Product Image <small>(format: jpg, jpeg, png)</small></label>
                <input type='file' name='e_product_image' class='form-control'>
                <label>Current Picture:</label><img src='$picture' class='img-fluid' width='50'>
              </div>
            </div>
            <input type='hidden' name='pid' value='$pid'>
            <input type='hidden' name='currentpicture' value='$picture'>
            <div class='col-12'>
              <button type='submit' name='update' class='btn btn-primary submit-edit-product'>Update Product</button>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>";
  }
}
?>



