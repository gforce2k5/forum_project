<div class="modal fade" style="text-align: right;" id="<?= $action ?>-post-modal" tabindex="-1" role="dialog" aria-labelledby="<?= $action ?>-post-form" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?= $action ?>-form-modal-title"><?= $parent == 'f' ? 'נושא חדש' : 'תגובה חדשה' ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 10px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="functions/<?= $action ?>_post.php" method="post" id="<?= $action ?>-post-form">
          <div class="form-group">
            <label for="<?= $action ?>-post-title" id="<?= $action ?>-post-title-label">
              כותרת:
            </label>
            <label class="error" id="<?= $action ?>-post-title-error">* לא הוכנסה כותרת</label>
            <input type="text" class="form-control" id="<?= $action ?>-post-title" name="title" required>
          </div>
          <div class="form-group">
            <label for="<?= $action ?>-form-content">תוכן הפוסט:</label>
            <label class="error" id="<?= $action ?>-post-content-error">* לא הוכנס תוכן</label>
            <textarea class="form-control bbcode" id="<?= $action ?>-post-content" name="content" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label for="<?= $action ?>-post-preview">תצוגה מקדימה</label>
            <div class="bbcode-preview"></div>
          </div>
          <input type="hidden" name="Submit" value="Submit">
          <input type="hidden" name="parent" value="<?= $parent ?>">
          <input type="hidden" name="parent_id" value="<?= $parent_id ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" form>Close</button>
        <button type="button" class="btn btn-primary" id="<?= $action ?>-post-submit">פרסם</button>
        <button type="button" class="btn btn-danger" id="<?= $action ?>-post-reset">נקה את הטופס</button>
      </div>
    </div>
  </div>
</div>