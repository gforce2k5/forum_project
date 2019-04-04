<form action="functions/<?= $action ?>_forum.php" method="POST">
  <input type="text" name="name" placeholder="שם הפורום"><br/>
  <input type="text" name="description" placeholder="תיאור"><br/>
  <input type="cat_order" name="cat_order" placeholder="סידור בקטגוריה"><br/>
  <select name="cat_id" id="cat_id">
    <option value=''>בחר קטגוריה</option>
    <?= Category::show_category_list($link) ?>
    <option value="-1">אחר...</option>
  </select><br/>
  <input name="other" id="other" placeholder="אחר" disabled><br/>
  <select name="manager">
    <option value=''>בחר מנהל</option>
    <?= User::get_active_users($link) ?>
  </select><br/>
  <input type="Submit" name="Submit">
</form>