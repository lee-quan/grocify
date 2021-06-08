<?php require "../template/connect.php" ?>
<?php
$displaycat = $link->query("SELECT a.catid as 'catid', a.parentcatid as 'parentcatid', b.cat as 'parentcat', a.cat as 'cat' FROM category a LEFT JOIN category b ON a.parentcatid=b.catid ORDER BY a.parentcatid, a.catid " );
if ($displaycat->num_rows == 0) {
} else {
    while ($row = $displaycat->fetch_assoc()) {
        $id = $row["catid"];
        $parentcat = $row["parentcat"];
        $parentcatid = $row["parentcatid"];
        $cat = $row["cat"];
        $disabled="";
        if($id==$parentcatid){
          $disabled=" disabled";
        }
        echo "<tr>
            <td>$id</td>";
        if($row["catid"]==$row["parentcatid"]){
          echo "<td>$cat</td>";
        }else{
          echo "<td>$parentcat</td>";
        }
        echo "<td>$cat</td>
            <td><form>
            <a class='btn btn-sm btn-info edit-brand' data-toggle='modal' data-target='#edit_category_modal$id' name='action' value='update'><i class='fas fa-pencil-alt'></i></a>&nbsp;
            <a href='actioncat.php?action=delete&id=$id' type='submit' name='action' value='delete' class='btn btn-sm btn-danger delete-brand' onclick='return confirm(`are you sure?`)'><i class='fas fa-trash-alt'></i></a>
            </form>
            </td>
            </tr>

            <div class='modal fade' id='edit_category_modal$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>Add Category</h5>
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
                <label>Parent Category</label>
                <select class='form-control category_list' name='categoryselection' onchange='get();' $disabled>
                  <option value='0'>NULL</option>";

                  $retrieve = $link->query('SELECT * FROM category WHERE parentcatid=catid');
                  while ($row = $retrieve->fetch_assoc()) {
                    $category = $row['cat'];

                    $selected="";
                    if($parentcatid == $row["catid"]){
                      $selected= " selected";
                    }
                    echo "<option value='$catid'$selected>$category</option>";
                  }

            echo "</select>
              </div>
            </div>
            <div class='col-12'>
              <input type='hidden' name='cat_id'>
              <div class='form-group'>
                <label>Category Name</label>
                <input type='text' name='e_cat_title' class='form-control' placeholder='Enter Category Name' value='$cat'>
              </div>
            </div>
            <input type='hidden' name='catid' value='$id'>
            <div class='col-12'>
              <input type='submit' class='btn btn-primary edit-category-btn' name='update' value='Update Category'>
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