$(document).ready(function() {
  $('input').change(function () {
    $(this).parent().removeClass('has-error');
    $(this).next().empty();
  })
  $('textarea').change(function () {
    $(this).parent().removeClass('has-error');
    $(this).next().empty();
  })
  $('select').change(function () {
    $(this).parent().removeClass('has-error');
    $(this).next().empty();
  })
})

$('.simpan').on('click',function() {
  $('.simpan').text('loading...');
  $('.simpan').attr('disabled', true);
  $('.tutup').attr('disabled', true);
    var dataform = new FormData(this.form);
    var action   = $(this).attr('data-link');
    var method   = $(this).attr('method');
    var serialize  = $(this).serialize();
    $.ajax({
        // contentType: false,
        // processData: false,
        // cache: false,
        url: action,
        type: 'POST',
        data: serialize,
        dataType: 'json',
        success:function (data) {
            console.log(data);
        }
    })
})
