function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}
  document.onkeypress = stopRKey;

  
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

  // $('.menuload .nav a').on('click', function (e) {
  //   e.preventDefault();
  //   var url = $(this).attr('href');
  //   $('.loadpage').load(url);
  //   return false;
  // });



  $('body').on('click', '.animsition-link', function() {
    var link = $(this).attr('href');
    // console.log('click '+link);
    $('.site-menu-item').removeClass('active open');

    $(this).parent().addClass('active open');
    $.ajax({
      url: link,
      type: 'POST',
      data: {
        ajax: 'active'
      },
      success: function(respond) {
        // console.log('sukses: '+respond);
        $('.page').html(respond);
        var baseclass = $('#datatables').attr('data-class');
        switch(baseclass){
          case 'user':
          call_datatable_user();
          break;
          case 'dbdregister':
          call_datatable_dbdregister();
          break;
          default:
          call_datatable();
          break;
        }
      },
      error: function(respond) {
        // console.log('gagal: '+respond);
      }
    });
    return false;
  });

})


$('.simpan').on('click', function (e) {
  e.preventDefault();
  var dataform = new FormData(this.form);
  var action = $(this).attr('data-link');
  $.ajax({
    contentType: false,
    processData: false,
    cache: false,
    url: action,
    type: 'POST',
    data: dataform,
    dataType: 'json',
    beforeSend: function () {
      $('.loading').show();
      $('.simpan').attr('disabled', true);
      $('.tutup').attr('disabled', true);
    },
    success: function (data) {
      console.log(dataform);
      table.ajax.reload(function (json) {
        json.response;
      });
      $('.loading').hide();
      $('.simpan').attr('disabled', false);
      $('.tutup').attr('disabled', false);
      if (data.status == 0) {
        $.each(data, function (key, value) {
          $('.input-' + key).addClass('is-invalid');
          $('.input-' + key).parents('.form-group').find('.help-block').html(value);
        })
      } else {
        $('.modalbutton').modal('hide');
        $.each(data, function (keyfield, keyvalue) {
          $('.clear-' + keyvalue).val('');
        })
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Berhasil disimpan',
          showConfirmButton: false,
          timer: 1500
        })
      }
    },
    error: function (xhr) { // if error occured
      $('.loading').hide();
      $('.simpan').attr('disabled', false);
      $('.tutup').attr('disabled', false);
      Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Koneksi bermasalah!',
        showConfirmButton: false,
        timer: 1500
      })
    },
  })
})


$(document).on('click', '.delete', function () {
  var link = $(this).data('link');
  Swal.fire({
    title: 'Hapus?',
    text: "Apakah anda yakin ingin menghapus data?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: link,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          table.ajax.reload(function (json) {
            json.response;
          });
          if (data.status == 0) {
            Swal.fire({
              position: 'top-end',
              icon: 'error',
              title: 'Data Gagal dihapus!',
              showConfirmButton: false,
              timer: 1500
            })
          } else {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Data berhasil dihapus!',
              showConfirmButton: false,
              timer: 1500
            })
          }
        },
        error: function (xhr) { // if error occured
          table.ajax.reload(function (json) {
            json.response;
          });
          Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Koneksi bermasalah!',
            showConfirmButton: false,
            timer: 1500
          })
        }
      })
    }
  })
})


$(document).on('click', '.ubah', function () {
  var link = $(this).data('link');
  $('.updatemodal').modal('show');
  $.ajax({
    url: link,
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      $.each(data, function (keyfield, keyvalue) {
        $('.edtinput-' + keyfield).val(keyvalue);
      })
    },
    error: function (xhr) { // if error occured
      table.ajax.reload(function (json) {
        json.response;
      });
      Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Koneksi bermasalah!',
        showConfirmButton: false,
        timer: 1500
      })
    }
  })
})

$(document).on('click', '.edtsimpan', function (e) {
  e.preventDefault();
  var dataform = new FormData(this.form);
  var action = $(this).attr('data-link');
  $.ajax({
    contentType: false,
    processData: false,
    cache: false,
    url: action,
    type: 'POST',
    data: dataform,
    dataType: 'json',
    beforeSend: function () {
      $('.loading').show();
      $('.edtsimpan').attr('disabled', true);
      $('.tutup').attr('disabled', true);
    },
    success: function (data) {
      table.ajax.reload(function (json) {
        json.response;
      });
      $('.loading').hide();
      $('.edtsimpan').attr('disabled', false);
      $('.tutup').attr('disabled', false);
      if (data.status == 0) {
        $.each(data, function (key, value) {
          $('.edtinput-' + key).addClass('is-invalid');
          $('.edtinput-' + key).parents('.form-group').find('.help-block').html(value);
        })
      } else {
        $('.updatemodal').modal('hide');
        $.each(data, function (keyfield, keyvalue) {
          $('.clear-' + keyvalue).val('');
        })
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Berhasil disimpan',
          showConfirmButton: false,
          timer: 1500
        })
      }
    },
    error: function (xhr) { // if error occured
      $('.loading').hide();
      $('.edtsimpan').attr('disabled', false);
      $('.tutup').attr('disabled', false);
      Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Koneksi bermasalah!',
        showConfirmButton: false,
        timer: 1500
      })
    },
  })
})


$(document).on('ready', function () {
  $("#moneyInput, #money_input, .currency_input, .money").maskMoney({ thousands:'.', decimal:',', affixesStay: false, precision: 0});

  var aydi = $('.dataselect').attr('id'),
  hitung = aydi.split('-');
for (let a = 0; a < hitung.length; a++) {
var link = $('#select-' + a).data('link');
$.ajax({
  url: link,
  type: 'GET',
  dataType: 'json',
  error: function () { // if error occured
    // Swal.fire({
    //   position: 'top-end',
    //   icon: 'error',
    //   title: 'Koneksi bermasalah!',
    //   showConfirmButton: false,
    //   timer: 1500
    // })
  },
  success: function (select) {
    var no = 1;
    $.each(select, function(keyselect, valueselect) {
      $('#select-' + keyselect).html(valueselect);
    })
  }
})
}
})


