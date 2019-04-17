<div class="modal fade" style="text-align: right;" id="delete-post-modal" tabindex="-1" role="dialog" aria-labelledby="delete-post-form" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="create-form-modal-title">אישור מחיקת נושא\תגובה</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 10px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="functions/delete_post.php" method="post" id="delete-post-form">
          <label>האם אתה בטוח שאתה רוצה למחוק את הפוסט?</label>
          <input type="hidden" name="p" id="delete-post-id" value="">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" form>לא</button>
        <button type="button" class="btn btn-danger" id="delete-post-submit">כן</button>
      </div>
    </div>
  </div>
</div>