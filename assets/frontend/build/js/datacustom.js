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

$(document).on('ready', function () {
  var link = $('.dataselect').data('link');
  $.ajax({
    url: link,
    type: 'GET',
    dataType: 'json',
    success: function (select) {
      $('.dataselect').html(select.dataselcet);
    }
  })
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
      $('.simpan').text('loading...');
      $('.simpan').attr('disabled', true);
      $('.tutup').attr('disabled', true);
    },
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
      $('.simpan').text('Simpan');
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
            Swal.fire(
              'Hapus!',
              'Data Gagal dihapus!',
              'error'
            )
          } else {
            Swal.fire(
              'Hapus!',
              'Data berhasil dihapus!',
              'success'
            )
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
      $('.edtsimpan').text('loading...');
      $('.edtsimpan').attr('disabled', true);
      $('.tutup').attr('disabled', true);
    },
    success: function (data) {
      table.ajax.reload(function (json) {
        json.response;
      });
      $('.edtsimpan').text('Simpan');
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
      $('.edtsimpan').text('Simpan');
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
