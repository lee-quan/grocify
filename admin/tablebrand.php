
<?php require "../template/connect.php" ?>
<?php
$displaybrands = $link->query("SELECT * FROM brand");

if($displaybrands->num_rows==0){
}else{
    while($row=$displaybrands->fetch_assoc()){
        $id = $row["brandid"];
        $brand = $row["brand"];
        echo "<tr>
        <td>$id</td>
        <td>$brand</td>
        <td><form>
        <a class='btn btn-sm btn-info edit-brand' data-toggle='modal' data-target='#edit_brand_modal$id' name='action' value='update'><i class='fas fa-pencil-alt'></i></a>&nbsp;
        <a href='actionbrand.php?action=delete&id=$id' type='submit' name='action' value='delete' class='btn btn-sm btn-danger delete-brand' onclick='return confirm(`are you sure?`)'><i class='fas fa-trash-alt'></i></a>
        </form>
        </td>
        </tr>";
        echo "<div class='modal fade' id='edit_brand_modal$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>Edit Brand</h5>
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
              <input type='hidden' name='brand_id'>
              <div class='form-group'>
                <label>Brand Name</label>
                <input type='text' name='e_brand_title' class='form-control' placeholder='Enter Brand Name' value='$brand'>
                <input type='hidden' name='brandid' value='$id'>
              </div>
            </div>
            <div class='col-12'>
              <input type='submit' class='btn btn-primary edit-brand-btn' name='update' value='Update Brand'>
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




