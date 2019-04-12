<div class="modal fade" style="text-align: right;" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-form" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="login-modal-title">טופס התחברות</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 10px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="functions/login.php" method="post" id="login-form">
          <div class="form-group">
            <label for="login-username" id="login-username-label">
              שם משתמש:
            </label>
            <input type="text" class="form-control" id="login-username" name="username" required>
          </div>
          <div class="form-group">
            <label for="login-password">
              סיסמא:
            </label>
            <input type="password" class="form-control" id="login-password" name="password" required>
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember" style="padding-right: 30px">זכור אותי ל-30 יום</label>
          </div>
          <input type="hidden" name="Submit" value="Submit">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" form>Close</button>
        <button type="button" class="btn btn-primary" id="login-submit">התחבר</button>
        <button type="button" class="btn btn-danger" id="login-reset">נקה את הטופס</button>
      </div>
    </div>
  </div>
</div>