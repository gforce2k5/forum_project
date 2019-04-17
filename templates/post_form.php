<div class="modal fade" style="text-align: right;" id="create-post-modal" tabindex="-1" role="dialog" aria-labelledby="create-post-form" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="create-form-modal-title">
          <?= $parent == 'f' ? 'נושא חדש' : 'תגובה חדשה' ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 10px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="functions/create_post.php" method="post" id="create-post-form">
          <div class="form-group">
            <label for="create-post-title" id="create-post-title-label">
              כותרת:
            </label>
            <label class="error" id="create-post-title-error">* לא הוכנסה כותרת</label>
            <input type="text" class="form-control" id="create-post-title" name="title" required>
          </div>
          <div class="form-group">
            <label for="create-form-content">תוכן הפוסט:</label>
            <label class="error" id="create-post-content-error">* לא הוכנס תוכן</label>
            <textarea class="form-control" id="create-post-content" name="content" rows="3" required></textarea>
          </div>
          <?php
            if ($parent == 'f' && ($current_user->get_status() == 2 || $current_user->is_manager($link, $parent_id))) {
          ?>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="create-post-pin" name="pin">
                <label class="form-check-label" for="create-post-pin" style="padding-right: 30px">נעץ את הנושא</label>
              </div>
          <?php
            }
          ?>
          <div class="form-group">
            <label for="create-post-preview">תצוגה מקדימה</label>
            <div class="bbcode-preview" id="create-bbcode-preview"></div>
          </div>
          <input type="hidden" name="Submit" value="Submit">
          <input type="hidden" name="parent" value="<?= $parent ?>">
          <input type="hidden" name="parent_id" value="<?= $parent_id ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" form>סגור</button>
        <button type="button" class="btn btn-primary" id="create-post-submit">פרסם</button>
        <button type="button" class="btn btn-danger" id="create-post-reset">נקה את הטופס</button>
      </div>
    </div>
  </div>
</div>