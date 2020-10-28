$(document).ready(function () {
  $('#error').html(" ");
  $('input').change(function () {
    $(this).removeClass('is-invalid').addClass('is-valid');
    $(this).parents('.form-group').find('.help-block').html(" ");
  });
  $('textarea').change(function () {
    $(this).removeClass('is-invalid').addClass('is-valid');
    $(this).parents('.form-group').find('.help-block').html(" ");
  });
  $('select').change(function () {
    $(this).removeClass('is-invalid').addClass('is-valid');
    $(this).parents('.form-group').find('.help-block').html(" ");
  });
})

$('.simpan').on('click', function (e) {
  e.preventDefault();
  $('.simpan').text('loading...');
  $('.simpan').attr('disabled', true);
  $('.tutup').attr('disabled', true);
  var dataform = new FormData(this.form);
  var action = $(this).attr('data-link');
  var method = $(this).attr('method');
  var serialize = $(this).serialize();
  $.ajax({
    contentType: false,
    processData: false,
    cache: false,
    url: action,
    type: 'POST',
    data: dataform,
    dataType: 'json',
    success: function (data) {
      $('.simpan').text('Simpan');
      $('.simpan').attr('disabled', false);
      $('.tutup').attr('disabled', false);
      $.each(data, function (key, value) {
        $('.input-' + key).addClass('is-invalid');
        $('.input-' + key).parents('.form-group').find('.help-block').html(value);
      })
    }
  })
})
