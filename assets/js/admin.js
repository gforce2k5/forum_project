(function ($) {

  var categories;

  function addError(elementId, msg) {
    $(`#${elementId}`).after(`<label class="error">* ${msg}</label>`);
  }

  function renderData(data) {
    console.log(data);
    var html = '<ul class="list-group" id="cat-list">';
    for (let i = 0; i < data.length; i++) {
      let cat = data[i];
      html += `
        <li class="list-group-item drop" id="cat-${cat.id}" data-index="${i}">
          <div class="row">
            <div class="col-8">
              ${cat.name}
            </div>
            <div class="col-4">
              <button class="btn btn-warning cat-edit-btn">ערוך</button>
            </div>
          </div>
          <ul class="list-group mt-3" id="cat-${cat.id}-list">
      `;
      for (let j = 0; j < cat.forums.length; j++) {
        let forum = cat.forums[j];
        html += `
          <li class="list-group-item drag" id="forum-${forum.id}" draggable="true" data-index="${j}">
            <div class="row">
              <div class="col-7">
                ${forum.name}
              </div>
              <div class="col-5">
                <button class="btn btn-warning forum-edit-btn">ערוך</button>
                <button data-toggle="modal" data-target="#delete-forum-modal" class="btn btn-danger forum-delete">מחק</button>
              </div>
            </div>
          </li>
        `;
      }
      html += '</ul></li>';
    }

    html += '</ul>';

    $('#category-view').html(html);

    $('.forum-edit-btn').on('click', function(e) {
      let cat_index = $(this).parent().parent().parent().parent().parent().data('index');
      let forum_index = $(this).parent().parent().parent().data('index');
      renderForumForm(categories[cat_index].forums[forum_index]);
    });

    $('.cat-edit-btn').on('click', function(e) {
      renderCategoryForm(categories[$(this).parent().parent().parent().data('index')]);
    });

    $('.drag').on('dragstart', function(ev) {
      ev.originalEvent.dataTransfer.setData('text', ev.target.id);
    });

    $('.drop').on('dragover', function(ev) {
      ev.preventDefault();
      ev.stopPropagation();
    }).on('drop', function (ev) {
      ev.preventDefault();
      ev.stopPropagation();
      var data = ev.originalEvent.dataTransfer.getData('text');
      var target = $(ev.target);
      while (!target.hasClass('drop')) {
        target = target.parent();
      }
      
      var dataElement = $(`#${data}`);
      
      var oldCatIndex = dataElement.parent().parent().data('index');
      var newCatIndex = target.data('index');
      var forumIndex = dataElement.data('f-index');
      
      if (oldCatIndex != newCatIndex) {
        $(`#${target.attr('id')} > ul`).append(dataElement);
        categories[newCatIndex].forums.push(categories[oldCatIndex].forums.splice(forumIndex, 1)[0]);
        dataElement.data('index', categories[newCatIndex].forums.length - 1);
        if ($('#buttons').length == 0) {
          $('#cat-list').append('<li class="list-group-item" id="buttons"><button class="btn btn-primary" id="save-changes">שמור</button><button class="btn btn-secondary" id="cancel-changes">בטל שינויים</button></li>');

          $('#cancel-changes').on('click', function(e) {
            getData();
          })
        }
      }
    });
  }

  function getData() { 
    $.get("admin/get_forums.php?all=1", (data) => {
      categories = data = JSON.parse(data);

      renderData(data);
    });
  }

  function renderCategoryForm(cat) {
    var html = `
      <div class="form-group">
        <label for="category-name" id="category-name-label">שם: </label>
        <input type="text" class="form-control" id="category-name" value="${cat.name}">
      </div>
      <button id="submit-cat" class="btn btn-primary">ערוך</button>
      <button id="close" class="btn btn-secondary">סגור</button>
    `
    $('#edit-form').html(html);

    $('#close').on('click', e => {
      $('#edit-form').html('');
    })

    $('#submit-cat').on('click', function(e) {
      $('.error').remove();
      let name = $('#category-name').val();
      if (name == cat.name.trim()) return;
      if (name == '') {
        addError('category-name-label', 'שם הקטגוריה לא יכול להישאר ריק');
        return;
      }

      for (let i = 0; i < categories.length; i++) {
        if (name == categories[i].name) {
          addError('category-name-label', 'שם זה כבר קיים');
          return;
        }
      }

      $('#edit-form').html('');

      $.post('admin/edit_category.php', {name: name, id: cat.id}, data => {
        getData();
        $('#edit-form').html('');
      });
    });
  }

  function renderForumForm(forum) {
    $.get(`admin/get_users.php?fid=${forum.id}`, function(data) {
      var html = `
        <div class="form-group">
          <label for="edit-forum-name" id="edit-forum-name-label">
            שם הפורום:
          </label>
          <input type="text" class="form-control" id="edit-forum-name" name="name" value="${forum.name}" required>
        </div>
        <div class="form-group">
          <label for="edit-forum-description" id="edit-forum-description-label">
            תיאור:
          </label>
          <input type="text" class="form-control" id="edit-forum-description" name="description" value="${forum.description}" required>
        </div>
        <div class="form-group">
          <label for="edit-forum-managers id="edit-forum-managers-label">בחר מנהל/ים</label>
          <select class="form-control" name="managers[]" id="edit-forum-managers" required multiple>
      `
      html += data;
      html += `
          </select>
        </div>
        <div class="form-group">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="edit-forum-lock" name="lock"${forum.active == 1 ? '' : ' checked'}>
            <label class="form-check-label" for="edit-forum-lock" style="padding-right: 30px">נעל את הפורום</label>
          </div>
        </div>
        <button id="submit-forum" class="btn btn-primary">עדכן</button>
        <button id="close" class="btn btn-secondary">סגור</button>
      `
      $('#edit-form').html(html);

      $('#submit-forum').on('click', function() {
        $('.error').remove();
        var name = $('#edit-forum-name').val().trim();
        if (name == '') {
          addError('edit-forum-name-label', 'שם הפורום לא יכול להישאר ריק');
          return;
        } 

        for (let i = 0; i < categories.length; i++) {
          var cat = categories[i];
          for (let j = 0; j < cat.forums.length; j++) {
            if (name == cat.forums[j].name && forum.id !== cat.forums[j].id) {
              addError('edit-forum-name-label', 'שם הפורום כבר קיים');
            }
          }
        }

        var description = $('#edit-forum-description').val().trim();
        if (description.length == 0) {
          addError('edit-forum-description-label', 'תיאור הפורום לא יכול להישאר ריק');
        }

        var managers = $('#edit-forum-managers').val();
        if (managers.length == 0) {
          addError('edit-forum-managers-label', 'לא נבחרו מנהלים');
        }

        var active = $('#edit-forum-lock').is(':checked') ? 0 : 1;

        if ($('.error').length == 0) {
          $.post(`admin/edit_forum.php?fid=${forum.id}`, {name: name, description: description, managers: JSON.stringify(managers), id: forum.id, active: active}, function(data) {
            console.log(data);
            getData();
            $('#edit-form').html('');
          });
        }
      });

      $('#close').on('click', function() {
        $('#edit-form').html('');
      });

      
    });
  }

  getData();

})(jQuery);