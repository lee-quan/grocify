<?php session_start(); ?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<?php include "actioncat.php" ?>

<div class="container-fluid">
  <div class="row">

    <?php include "./templates/sidebar.php"; ?>


    <div class="row">
      <div class="col-10">
        <h2>Manage Category</h2>
      </div>
      <div class="col-2">
        <a href="#" data-toggle="modal" data-target="#add_category_modal" class="btn btn-primary btn-sm">Add Category</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-sm" style="table-layout: fixed;">
        <thead>
          <tr>
            <th style="width: 10%;">#</th>
            <th style="width: 35%;">Parent Category</th>
            <th style="width: 35%;">Category</th>
            <th style="width: 20%;">Action</th>
          </tr>
        </thead>
        <tbody id="category_list">
          <?php include "tablecat.php" ?>

        </tbody>
      </table>
    </div>
    </main>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="add_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" name="addcat" id="addcat">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Parent Category</label>
                <select class="form-control category_list" name="categoryselection" onchange="get();">
                  <option value="0">NULL</option>
                  <?php
                  $retrieve = $link->query("SELECT * FROM category WHERE parentcatid=catid");
                  while ($row = $retrieve->fetch_assoc()) {
                    $cat = $row["cat"];
                    $catid = $row["catid"];
                    echo "<option value='$catid'>$cat</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-12">
              <table class="table" id="dynamic_field">
                <tr>
                  <td><input id="input" type='text' name='inputcat[]' placeholder='Enter Parent Category' class='form-control name_list'></td>
                  <td id="button"><button type='button' name='add' id='add' class='btn btn-success'>Add Sub Category</button></td>
                </tr>
              </table>
            </div>
            <div class="col-12">
        <input type="submit" class="btn btn-primary add-category" name="addcat" value="Add Category">
      </div>
          </div>
      </div>
      
    </div>

    </form>
  </div>
</div>
</div>
</div>
<!-- Modal -->

<?php include_once("./templates/footer.php"); ?>

<script>
  $(document).ready(function() {
    var i = 1;
    $('#add').click(function() {
      i++;
      $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="inputcat[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function() {
      var button_id = $(this).attr("id");
      $('#row' + button_id + '').remove();
    });
  });


  function get() {
    var e = document.getElementById("input");
    if (addcat.categoryselection[addcat.categoryselection.selectedIndex].value != 0) {
      e.setAttribute("placeholder", "Enter Sub Category")
    } else {
      e.setAttribute("placeholder", "Enter Parent Category")
    }

  }
</script>