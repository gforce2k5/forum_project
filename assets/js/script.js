$('#cat_id').change(function () {
  if ($('#cat_id').val() == -1) {
    console.log($('#cat_id').val());
    $('#other').prop('disabled', false);
  } else {
    $('#other').prop('disabled', true);
    $('#other').val('');
  }
});