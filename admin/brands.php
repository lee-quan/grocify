<?php session_start(); ?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<?php include "actionbrand.php" ?>

<div class="container-fluid">
  <div class="row">

    <?php include "./templates/sidebar.php"; ?>


    <div class="row">
      <div class="col-10">
        <h2>Manage Brand</h2>
      </div>
      <div class="col-2">
        <a href="#" data-toggle="modal" data-target="#add_brand_modal" class="btn btn-primary btn-sm">Add Brand</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-sm" style="table-layout: fixed;">
        <thead>
          <tr>
            <th style="width: 10%;">#</th>
            <th style="width: 70%;">Name</th>
            <th style="width: 20%;">Action</th>
          </tr>
        </thead>
        <tbody id="brand_list">
        <?php include "tablebrand.php"?>
        
        </tbody>
      </table>
      <script>
      
      </script>
    </div>
    </main>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="add_brand_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Brand Name</label>
                <input type="text" name="brand_title" class="form-control" placeholder="Enter Brand Name">
              </div>
            </div>
            <div class="col-12">
              <input type="submit" class="btn btn-primary add-brand" name="addbrand" value="Add Brand">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once("./templates/footer.php"); ?>