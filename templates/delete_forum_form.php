<div class="modal fade" style="text-align: right;" id="delete-forum-modal" tabindex="-1" role="dialog" aria-labelledby="delete-category-form" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="create-form-modal-title">אישור מחיקת פורום</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 10px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="admin/delete_category.php" method="post" id="delete-post-form">
          <label>האם אתה בטוח שאתה רוצה למחוק את הקטגוריה? שים לב שמחיקת הפורום הוא בלתי הפיך והפוסטים תחת הפורום הזה יימחקו</label>
          <input type="hidden" name="c" id="delete-category-id" value="">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" form><i class="fas fa-check"></i> לא</button>
        <button type="button" class="btn btn-danger" id="delete-forum-submit"><i class="fas fa-trash-alt"></i> כן</button>
      </div>
    </div>
  </div>
</div>