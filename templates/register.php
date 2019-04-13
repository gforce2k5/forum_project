<div class="modal fade" style="text-align: right;" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="register-form" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="register-modal-title">טופס הרשמה</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 10px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="functions/register.php" method="post" id="register-form">
          <div class="form-group">
            <label for="register-username" id="register-username-label">
              שם משתמש:
            </label>
            <label class="error" id="register-username-error">* שם המשתמש יכול להכיל אותיות גדולות וקטנות באנגלית ומספרים בלבד האורך המינימלי הוא 4 תווים</label>
            <input type="text" class="form-control" id="register-username" name="username" required>
          </div>
          <div class="form-group">
            <label for="register-first-name">
              שם פרטי:
            </label>
            <label class="error" id="register-first-name-error">* לא הוכנס שם פרטי</label>
            <input type="text" class="form-control" id="register-first-name" name="first-name" required>
          </div>
          <div class="form-group">
            <label for="register-last-name">
              שם משפחה:
            </label>
            <label class="error" id="register-last-name-error">* לא הוכנס שם משפחה</label>
            <input type="text" class="form-control" id="register-last-name" name="last-name" required>
          </div>
          <div class="form-group">
            <label for="register-email">
              דואר אלקטרוני:
            </label>
            <label class="error" id="register-email-error">* כתובת הדואר האלקטרוני אינה חוקית</label>
            <input type="email" class="form-control" id="register-email" name="email" required>
          </div>
          <div class="form-group">
            <label for="register-password">
              סיסמא:
            </label>
            <label class="error" id="register-password-error">* הסיסמא חייבת להכיל לפחות אות גדולה, אות קטנה ומספר. הסיסמה חייבת להכיל לפחות 6 תווים</label>
            <input type="password" class="form-control" id="register-password" name="password" required>
          </div>
          <div class="form-group">
            <label for="register-confirmpwd">
              סיסמא בשנית:
            </label>
            <label class="error" id="register-confirmpwd-error">* הסיסמאות שהכונסו לא זהות</label>
            <input type="password" class="form-control" id="register-confirmpwd" name="confirmpwd" required>
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="register-divur" name="divur" checked required>
            <label class="form-check-label" for="register-divur" style="padding-right: 30px">קראתי את התקנון ואני מסכים</label>
            <label class="error" id="register-divur-error">* קרא את התקנון ואשר אותו</label>
          </div>
          <input type="hidden" name="Submit" value="Submit">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" form>Close</button>
        <button type="button" class="btn btn-primary" id="register-submit">הירשם</button>
        <button type="button" class="btn btn-danger" id="register-reset">נקה את הטופס</button>
      </div>
    </div>
  </div>
</div>