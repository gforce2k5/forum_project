<form action="functions/<?= $action ?>_post.php" method="POST">
  <input type="text" name="title" placeholder="כותרת"><br/>
  <p><textarea name="content" placeholder="תוכן הפוסט"></textarea></p>
  <input type="hidden" name="parent" value="<?= $parent ?>">
  <input type="hidden" name="parent_id" value="<?= $parent_id ?>">
  <input type="submit" name="Submit">
</form>