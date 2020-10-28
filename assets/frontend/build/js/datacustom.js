$(document).ready(function () {
  $('#error').html(" ");
  $('input').keypress(function () {
    $(this).removeClass('is-invalid').addClass('is-valid');
    $(this).parents('.form-group').find('.help-block').html(" ");
  });
  $('textarea').keypress(function () {
    $(this).removeClass('is-invalid').addClass('is-valid');
    $(this).parents('.form-group').find('.help-block').html(" ");
  });
  $('select').change(function () {
    $(this).removeClass('is-invalid').addClass('is-valid');
    $(this).parents('.form-group').find('.help-block').html(" ");
  });

  
 

})

$(document).on('ready',function() {
  var link = $('.dataselect').data('link');
  $.ajax({
    url:link,
    type:'GET',
    dataType: 'json',
    success: function(select) {
      $('.dataselect').html(select.dataselcet);
    }
})
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
      table.ajax.reload(function (json) {
        json.response;
      });
      $('.simpan').text('Simpan');
      $('.simpan').attr('disabled', false);
      $('.tutup').attr('disabled', false);
     if (data.status == 0) {
      $.each(data, function (key, value) {
        $('.input-' + key).addClass('is-invalid');
        $('.input-' + key).parents('.form-group').find('.help-block').html(value);
      })
    }else{
      $('.modalbutton').modal('hide');
      $.each(data, function(keyfield) {
        $('.clear-' + keyfield).val('');
      })
    }
     
    }
  })
})
