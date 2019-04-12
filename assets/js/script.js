// Category list select

$('#create-forum-other').hide();

$('.cat_id').change(e => {
  if ($(this).val() == -1) {
    $('#create-forum-other').show();
  } else {
    $('#create-forum-other').hide();
    $('#create-forum-other').val('');
  }
});

// register form validation

function resetForm(formId) {
  $('#' + formId + ' label.error').hide();
  $('#' + formId + ' input').css('border-color', '#ced4da');
}

resetForm('register-form');

$('#register-submit').click(e => {
  resetForm('register-form');
  var errorCounter = 0;
  var username = $('#register-username').val();
  if (!username.match(/^[A-Za-z0-9]{4,}$/)) {
    $('#register-username').css('border-color', '#FF0000');
    $('#register-username-error').show();
    errorCounter++;
  }

  var firstName = $('#first-name').val().trim();
  if (firstName.length == 0) {
    $('#first-name').css('border-color', '#FF0000');
    $('#register-first-name-error').show();
    errorCounter++;
  }

  var lastName = $('#last-name').val().trim();
  if (lastName.length == 0) {
    $('#last-name').css('border-color', '#FF0000');
    $('#register-last-name-error').show();
    errorCounter++;
  }

  var email = $('#email').val().trim();
  if (!email.match(/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/)) {
    $('#email').css('border-color', '#FF0000');
    $('#register-email-error').show();
    errorCounter++;
  }

  var password = $('#register-password').val();
  if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/)) {
    $('#register-password').css('border-color', '#FF0000');
    $('#register-password-error').show();
    errorCounter++;
  }

  var confirmpwd = $('#confirmpwd').val();
  if (password !== confirmpwd) {
    $('#confirmpwd').css('border-color', '#FF0000');
    $('#register-confirmpwd-error').show();
    errorCounter++;
  }

  var divur = $('#divur').prop('checked');
  if (!divur)
  {
    $('#register-divur-error').show();
    errorCounter++;
  }
  if (errorCounter == 0) $('#register-form').submit();
});

$('#register-reset').click(e => {
  resetForm('register-form');
  document.querySelector('#register-form').reset();
});

// login form

$('#login-submit').click(e => {
  $('#login-form').submit();
})

$('#login-reset').click(e => {
  document.querySelector('#login-form').reset();
})

// create forum form validation

resetForm('create-forum-form');

$('#create-forum-submit').click(e => {
  $('#create-forum-form').submit();
})