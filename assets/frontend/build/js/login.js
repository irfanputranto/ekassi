$(document).ready(function () {
    let timerInterval

    $('.signin').on('click',function(event) {
        event.preventDefault();
        var data = new FormData(this.form);
        var linkaction = $(this).attr('data-link');
        var linkhref = $(this).data('pagelink');
        $.ajax({
            contentType: false,
            processData: false,
            cache: false,
            url : linkaction,
            type:'POST',
            data:data,
            dataType:'JSON',
            beforeSend:function() {
              $('.signin').attr('disabled', true);
            },
            error:function(xhr) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Koneksi bermasalah!',
                    showConfirmButton: false,
                    timer: 1500
                  })
                $('.signin').attr('disabled', false);
            }
        }).done(function(data) {
            if (data.code == 505) {
                $.each(data, function (key, value) {
                  $('.input-' + key).addClass('is-invalid text-danger');
                  $('.input-' + key).parents('.form-group').find('.help-block').html(value);
                })
                $('.signin').attr('disabled', false);
              } else if(data.code == 500){
                Swal.fire({
                    title: 'Loading...',
                    html: 'Pleass Wait <b></b> ...',
                    timer: 2000,
                    showConfirmButton:false,
                    timerProgressBar: true,
                    willOpen: () => {
                      Swal.showLoading()
                      timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                          const b = content.querySelector('b')
                          if (b) {
                            b.textContent = Swal.getTimerLeft()
                          }
                        }
                      }, 100)
                    },
                    willClose: () => {
                      clearInterval(timerInterval)
                    }
                  }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                      $('.signin').attr('disabled', false);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: data.data,
                            showConfirmButton: false,
                            timer: 1500
                          })
                    }
                  })
              } else if (data.code == 501) {
                Swal.fire({
                    title: 'Loading...',
                    html: 'Pleass Wait <b></b> ...',
                    timer: 2000,
                    showConfirmButton:false,
                    timerProgressBar: true,
                    willOpen: () => {
                      Swal.showLoading()
                      timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                          const b = content.querySelector('b')
                          if (b) {
                            b.textContent = Swal.getTimerLeft()
                          }
                        }
                      }, 100)
                    },
                    willClose: () => {
                      clearInterval(timerInterval)
                    }
                  }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                      $('.signin').attr('disabled', false);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: data.data,
                            showConfirmButton: false,
                            timer: 1500
                          })
                    }
                  })
              } 
              else {
                Swal.fire({
                  title: 'Loading...',
                  html: 'Pleass Wait <b></b> ...',
                  timer: 2000,
                  showConfirmButton:false,
                  timerProgressBar: true,
                  willOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                      const content = Swal.getContent()
                      if (content) {
                        const b = content.querySelector('b')
                        if (b) {
                          b.textContent = Swal.getTimerLeft()
                        }
                      }
                    }, 100)
                  },
                  willClose: () => {
                    clearInterval(timerInterval)
                  }
                }).then((result) => {
                  if (result.dismiss === Swal.DismissReason.timer) {
                    $(location).attr('href', linkhref);
                    $.each(data, function (keyfield, keyvalue) {
                        $('.clear-' + keyvalue).val('');
                      })
                      $('.signin').attr('disabled', false);
                  }
                })
              }
        });
     
      })
})