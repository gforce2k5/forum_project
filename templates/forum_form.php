<div class="modal fade" style="text-align: right;" id="<?= $action ?>-forum-modal" tabindex="-1" role="dialog" aria-labelledby="<?= $action ?>-forum-form" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?= $action ?>-forum-modal-title"><?= $action == 'create' ? 'יצירת ' : 'עריכת ' ?>פורום</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 10px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="functions/<?= $action ?>_forum.php" method="post" id="<?= $action ?>-forum-form">
          <div class="form-group">
            <label for="<?= $action ?>-forum-name" id="<?= $action ?>-forum-name-label">
              שם הפורום:
            </label>
            <label class="error" id="<?= $action ?>-forum-name-error">* לא הוכנס שם פורום</label>
            <input type="text" class="form-control" id="<?= $action ?>-forum-name" name="name" required>
          </div>
          <div class="form-group">
            <label for="<?= $action ?>-forum-description">
              תיאור:
            </label>
            <label class="error" id="<?= $action ?>-forum-description-error">* לא הוכנס תיאור</label>
            <input type="text" class="form-control" id="<?= $action ?>-forum-description" name="description" required>
          </div>
          <div class="form-group">
            <label for="<?= $action ?>-forum-category">בחר קטגוריה</label>
            <label class="error" id="<?= $action ?>-forum-category-error">* לא נבחרה קטגוריה</label>
            <select class="form-control" name="cat_id" id="<?= $action ?>-forum-category" required>
              <option value=''></option>
              <?= Category::show_category_list($link) ?>
              <option value="-1">אחר...</option>
            </select>
          </div>
          <div class="form-group" id="<?= $action ?>-forum-other-group">
            <label for="<?= $action ?>-forum-other">
              אחר:
            </label>
            <input type="text" class="form-control" id="<?= $action ?>-forum-other" name="other">
          </div>
          <div class="form-group">
            <label for="<?= $action ?>-forum-managers">בחר מנהל/ים</label>
            <label class="error" id="<?= $action ?>-forum-managers-error">* לא נבחרו מנהלים</label>
            <select class="form-control" name="managers[]" id="<?= $action ?>-forum-managers" required multiple>
              <?= User::get_active_users($link) ?>
            </select>
          </div>
          <input type="hidden" name="Submit" value="Submit">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" form><i class="fas fa-times"></i> סגור</button>
        <button type="button" class="btn btn-primary" id="<?= $action ?>-forum-submit"><i class="fas fa-plus-square"></i> הוסף פורום</button>
        <button type="button" class="btn btn-danger" id="<?= $action ?>-forum-reset"><i class="fas fa-ban"></i> נקה את הטופס</button>
      </div>
    </div>
  </div>
</div>