const inputError = function (inputId) {
  $(`#${inputId}`).css('border-color', '#FF0000');
  $(`#${inputId}-error`).show();
}

const validateForumForm = function (action) {
  resetForm(`${action}-forum-form`);
  var validated = true;

  var name = $(`#${action}-forum-name`).val().trim();
  if (name.length == 0) {
    inputError(`${action}-forum-name`);
    validated = false;
  }

  var description = $(`#${action}-forum-description`).val().trim();
  if (description.length == 0) {
    inputError(`${action}-forum-description`);
    validated = false;
  }

  var category = $(`#${action}-forum-category`).val();
  var other = $(`#${action}-forum-other`).val();
  if (category === '' || category === '-1' && other.trim().length == 0) {
    inputError(`${action}-forum-category`);
    inputError(`${action}-forum-other`);
    validated = false;
  } 

  var managers = $(`#${action}-forum-managers`).val();
  if (managers.length == 0) {
    inputError(`${action}-forum-managers`);
    validated = false;
  }

  return validated;
}

const validatePostFrom = function (action) {
  resetForm(`${action}-post-form`);
  var validated = true;

  var title = $(`#${action}-post-title`).val().trim();
  if (title.length == 0) {
    inputError(`${action}-post-title`);
    validated = false;
  }

  var content = $(`#${action}-post-content`).val();
  if (content.length == 0) {
    inputError(`${action}-post-content`);
    validated = false;
  }

  return validated;
}

// Category list select

$('#create-forum-other-group').hide();

$('#create-forum-category').change(e => {
  if ($('#create-forum-category').val() == -1) {
    $('#create-forum-other-group').show();
  } else {
    $('#create-forum-other-group').hide();
    $('#create-forum-other-group input').val('');
  }
});

// register form validation

function resetForm(formId) {
  $(`#${formId} label.error`).hide();
  $(`#${formId} input, #${formId} select`).css('border-color', '#ced4da');
}

resetForm('register-form');

$('#register-submit').click(e => {
  resetForm('register-form');
  var validated = true;
  var username = $('#register-username').val();
  if (!username.match(/^[A-Za-z0-9]{4,}$/)) {
    inputError('register-username');
    validated = false;
  }

  var firstName = $('#register-first-name').val().trim();
  if (firstName.length == 0) {
    inputError('register-first-name');
    validated = false;
  }

  var lastName = $('#register-last-name').val().trim();
  if (lastName.length == 0) {
    inputError('register-last-name');
    validated = false;
  }

  var email = $('#register-email').val().trim();
  if (!email.match(/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/)) {
    inputError('register-email');
    validated = false;
  }

  var password = $('#register-password').val();
  if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/)) {
    inputError('register-password');
    validated = false;
  }

  var confirmpwd = $('#register-confirmpwd').val();
  if (password !== confirmpwd) {
    inputError('register-confirmpwd');
    validated = false;
  }

  var divur = $('#register-divur').prop('checked');
  if (!divur)
  {
    inputError('register-divur');
    validated = false;
  }
  if (validated) $('#register-form').submit();
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
  if (validateForumForm('create'))
    $('#create-forum-form').submit();
})

$('#create-forum-reset').click(e => {
  resetForm('create-forum-form');
  document.querySelector('#create-forum-form').reset();
})

// create post form validation

resetForm('create-post-form');

$('#create-post-submit').click(e => {
  if (validatePostFrom('create'))
    $('#create-post-form').submit();
})

$('#create-post-reset').click(e => {
  resetForm('create-post-form');
  document.querySelector('#create-post-form').reset();
})

$(document).ready(() => {
  $('.bbcode').bbcode({
    tag_bold: true,
    tag_italic: true,
    tag_underline: true, 
    tag_link: true,
    tag_image: true,
    button_image: true,
    image_url: 'assets/imgs/bbimage/'
  });
  process();
});

var bbcode = '';
function process()
{
  if (bbcode != $('.bbcode').val())
    {
      bbcode = $('.bbcode').val();
      $.get('functions/bbParser.php',
        {
          bbcode: bbcode
        },
        txt => {
          $('.bbcode-preview').html(txt);
        }
      )
    }
  setTimeout(process, 2000);
}