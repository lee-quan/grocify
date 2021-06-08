<?php session_start(); ?>

<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<?php require "../template/connect.php"; ?>
<?php include "actionproduct.php"; ?>
<div class="container-fluid">
  <div class="row">

    <?php include "./templates/sidebar.php"; ?>

    <div class="row">
      <div class="col-10">
        <h2>Product List</h2>
        <div class="pagination">
          <?php
          if (isset($_GET["page"])) {
            $page  = $_GET["page"];
          } else {
            $page = 1;
          };
          $numrow = ($link->query("SELECT * FROM product"))->num_rows;
          for ($i = 0; $i < ceil($numrow / 10); $i++) {
            echo "<a href=product.php?page=" . $i + 1;
            if ($i + 1 == $page) {
              echo " class='active'";
            }
            echo ">" . $i + 1 . "</a>";
          }
          ?>
        </div>
      </div>
      <div class="col-2">
        <a href="#" data-toggle="modal" data-target="#add_product_modal" class="btn btn-primary btn-sm">Add Product</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Image</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Description</th>
            <th>Keywords</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="product_list">
          <?php include "tableproduct.php" ?>
        </tbody>
      </table>
    </div>

    </main>
  </div>
</div>



<!-- Add Product Modal start -->
<div class="modal fade" id="add_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="pname" class="form-control" placeholder="Enter Product Name">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Brand Name</label>
                <select class="form-control brand_list" name="pbrand">
                  <option value="0">Select Brand</option>
                  <?php
                  $brand = $link->query("SELECT * FROM brand");
                  if ($brand->num_rows > 0) {
                    while ($row = $brand->fetch_assoc()) {
                      $brandid = $row["brandid"];
                      $brandtitle = $row["brand"];
                      echo "<option value='$brandid'>$brandtitle</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Category Name</label>
                <select class="form-control category_list" name="pcat">
                  <option value="0">Select Category</option>
                  <?php
                  $category = $link->query("SELECT * FROM category WHERE catid=parentcatid");
                  while ($row = $category->fetch_assoc()) {
                    $catid = $row["catid"];
                    $cat = $row["cat"];
                    $sql = "SELECT * FROM category WHERE parentcatid=$catid";
                    $retrieve = $link->query($sql);
                    if ($retrieve->num_rows == 1) {
                      echo "<option value='$catid'>$cat</option>";
                    } else {
                      echo "<optgroup label='$cat'>";
                      while ($col = $retrieve->fetch_assoc()) {
                        $colcatid = $col["catid"];
                        $colparentcatid = $col["parentcatid"];
                        $colcat = $col["cat"];
                        if ($colcatid == $catid) {
                        } else {
                          echo "<option value='$colcatid'>$colcat</option>";
                        }
                      }
                      echo "</optgroup>";
                    }
                  }
                  ?>

                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Description</label>
                <textarea class="form-control" name="pdescription" placeholder="Enter product desc"></textarea>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Qty</label>
                <input type="number" name="pquantity" class="form-control" placeholder="Enter Product Quantity">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Price</label>
                <input type="number" name="pprice" class="form-control" placeholder="Enter Product Price" step="0.01">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Keywords <small>(eg: apple, iphone, mobile)</small></label>
                <input type="text" name="pkeywords" class="form-control" placeholder="Enter Product Keywords">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Image <small>(format: jpg, jpeg, png)</small></label>
                <input type="file" name="image" class="form-control">
              </div>
            </div>
            <div class="col-12">
              <input type="submit" class="btn btn-primary add-product" name="submit" value="Add Product">
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Product Modal end -->

<!-- Edit Product Modal start -->
<div class="modal fade" id="edit_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-product-form" method="POST">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="e_product_name" class="form-control" placeholder="Enter Product Name">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Brand Name</label>
                <select class="form-control brand_list" name="e_brand_id">
                  <option value="">Select Brand</option>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Category Name</label>
                <select class="form-control category_list" name="e_category_id">
                  <option value="">Select Category</option>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Description</label>
                <textarea class="form-control" name="e_product_desc" placeholder="Enter product desc"></textarea>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Qty</label>
                <input type="number" name="e_product_qty" class="form-control" placeholder="Enter Product Quantity">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Price</label>
                <input type="number" name="e_product_price" class="form-control" placeholder="Enter Product Price">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Keywords <small>(eg: apple, iphone, mobile)</small></label>
                <input type="text" name="e_product_keywords" class="form-control" placeholder="Enter Product Keywords">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Image <small>(format: jpg, jpeg, png)</small></label>
                <input type="file" name="e_product_image" class="form-control">
              </div>
            </div>
            <input type="hidden" name="pid">
            <input type="hidden" name="edit_product" value="1">
            <div class="col-12">
              <button type="submit" name="addproduct" class="btn btn-primary submit-edit-product">Add Product</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<!-- Edit Product Modal end -->

<?php include_once("./templates/footer.php"); ?>



<!-- <script type="text/javascript" src="./js/products.js"></script> -->