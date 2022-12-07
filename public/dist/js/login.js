const url = window.location.origin+'/planilla';

function redireccionar(ruta){
    window.location.href = url+ruta;
}

$(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        var datos = new FormData($(auth_login)[0]);
        $.ajax({
            url: './login/auth',
            type: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
                if ( !response ) {
                    return $('#alert-login').html(`<div class="alert alert-danger text-center" role="alert">Datos ingresados incorrectos.</div>`);
                }

                $('#alert-login').html(`<div class="alert alert-success text-center" role="alert">Datos correctos. Redireccionando.</div>`);
                setTimeout("redireccionar('')", 2000);
            },
            error: function(err) {
                alert('Error', `${err}`);
            }
        })
      }
    });
    $('#auth_login').validate({
      rules: {
        user: {
          required: true
        },
        clave: {
          required: true
        }
      },
      messages: {
        user: {
          required: "Please enter a email address",
          email: "Please enter a valid email address"
        },
        clave: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });


//   Close Sessión

$(document).on('click', '#logger', function() {
    Swal.fire({
        title: "¿Seguro de cerrar sesión",
        // text: "You wont be able to revert this!",
        icon: "info",
        showCancelButton: true,
        confirmButtonText: "Si",
        cancelButtonText: "Cancelar",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
          $.ajax({
              url: './login/logout',
              type: "GET",
              dataType: "json",
              success: function(response) {
                if ( response ) {
                    redireccionar( "/login" );
                }
              },
              error: function(err) {
                  alert('Error', `${err}`);
              }
          })
        }
    });

})
