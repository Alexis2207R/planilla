const personales = () => {

  var table_personales;

  table_personales = $('#tbl_personales').DataTable({
    ajax: {
      url: './personales/list_personales',
      dataSrc: '',
      type: 'POST',
    },
    columns: [
      { data: 'dni_personal' },
      { data: 'nombre_personal' },
      { data: 'apellido_personal' },
      { data: 'nombre_regimen' },
      { data: 'nivel' },
      { data: 'condicion' },
      { data: 'nombre_cargo' },
      { data: 'sexo_personal' },
      { data: 'estado_personal' },
      { data: 'acciones' }
    ],
    order: [0, 'desc'],
    columnDefs: [
      {
        targets: 8,

        render: function (data, type, full, meta) {
          if (data == 1) {
            return `<div class="text-center"><span class="badge badge-success">ACTIVO</span></div>`;
          } else {
            return `<div class="text-center"><span class="badge badge-danger">INACTIVO</span></div>`;
          }
        }
      },
      {
        targets: 9,
        render: function (data, type, full, meta) {
          const btn_accion = full.estado == 2 ? { active: 'fas fa-check', color: 'success' } : { active: 'fas fa-ban', color: 'warning' };
          return `<center>
                                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button type="button" id="edit_personal"   item="${full.id_personal}" class="btn btn-xs btn-primary   btn-icon"><i class="icon-nd fas fa-edit"></i></button>
                                        <button type="button" id="delete_personal" item="${full.id_personal}" class="btn btn-xs btn-danger    btn-icon"><i class="icon-nd fas fa-trash"></i></button>
                                        <button type="button" id="view_personal"   item="${full.id_personal}" class="btn btn-xs btn-secondary btn-icon"><i class="icon-nd fas fa-eye"></i></button>
                                        <button type="button" status="${full.estado_personal}" id="ban_personal" item="${full.id_personal}" class="btn btn-xs btn-${btn_accion.color} btn-icon"><i class="icon-nd ${btn_accion.active}"></i></button>
                                        </div>
                                </div>
                            </center>`;
        }
      }
    ],

    pagingType: "full_numbers",

    language: {
      url: './public/dist/js/spanish.json'
    }

  });

  // Buscar DNI API
  $(document).on('click', '#api_personal', function () {
    let dni = $('[name="dni_personal"]').val();
    if (dni.length != 8) {
      Swal.fire('Error 400', 'Ingrese un DNI válido', "error");
      return false;
    }
    $.ajax({
      url: `https://dniruc.apisperu.com/api/v1/dni/${dni}?token=${token}`,
      type: 'GET',
      success: function (str) {// Función de devolución de llamada exitosa
        if (str.success == false) {
          Swal.fire(`${str.message}`, '', "info");
          $('[name="nombre_personal"]').val('');
          $('[name="apellido_personal"]').val('');
          return false;
        }

        $('[name="nombre_personal"]').val(str.nombres);
        $('[name="apellido_personal"]').val(`${str.apellidoPaterno} ${str.apellidoMaterno}`);
      },
      error: function (err) {// Función de devolución de llamada fallida
        Swal.fire(`${err.status}`, `${err.statusText}`, "error");
        $('[name="nombre_personal"]').val('');
        $('[name="apellido_personal"]').val('');
      }
    })
  })

  // Add Descuento
  $(document).on('click', '#btnNew', function () {
    $('#modal-personal').modal('show');
  });


  // Register Personal
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        var datos = new FormData($(form_personal)[0]);
        $.ajax({
          url: './personales/form',
          type: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            // console.log( response );
            // return;
            if (response.status == 200) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: response.msg,
                showConfirmButton: false,
                timer: 1500
              });
              resetform();
              table_personales.ajax.reload();
              $('#modal-personal').modal('hide');
            } else {
              Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
            }


          },
          error: function (err) {
            Swal.fire('Error 500', `${err}`, "error");
          }
        })
      }
    });
    $('#form_personal').validate({

      rules: {
        dni_personal: {
          required: true
        },
        nombre_personal: {
          required: true
        },
        apellido_personal: {
          required: true
        },
        sexo_personal: {
          required: true
        },
        id_cargo: {
          required: true
        },
        id_regimen: {
          required: true
        },
        id_remuneracion: {
          required: true
        },
        id_condicion: {
          required: true
        }
      },
      messages: {

        dni_personal: {
          required: "Campor requerido"
        },
        nombre_personal: {
          required: "Campor requerido"
        },
        apellido_personal: {
          required: "Campor requerido"
        },
        sexo_personal: {
          required: "Campor requerido"
        },
        id_cargo: {
          required: "Campor requerido"
        },
        id_regimen: {
          required: "Campor requerido"
        },
        id_remuneracion: {
          required: "Campor requerido"
        },
        id_condicion: {
          required: "Campor requerido"
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

  // Edit Personal
  $(document).on('click', '#edit_personal', function () {
    const item = $(this).attr('item');
    resetform();
    $.ajax({
      url: './personales/edit_personal',
      type: "POST",
      data: { item },
      dataType: "json",
      success: function (response) {
        // console.log(response);
        if (response) {
          const Personal = response.Personal;
          // console.log( response );
          $("#modal-personal .form").append(`<input class="temp" type="hidden" value="${Personal.id_personal}" name="id_personal">`)
          $('#modal-personal [name=dni_personal]').val(Personal.dni_personal);
          $('#modal-personal [name=nombre_personal]').val(Personal.nombre_personal);
          $('#modal-personal [name=paterno_personal]').val(Personal.paterno_personal);
          $('#modal-personal [name=materno_personal]').val(Personal.materno_personal);
          $('#modal-personal [name=sexo_personal]').val(Personal.sexo_personal);
          $('#modal-personal [name=nivel_remuneracion]').val(Personal.nivel_remuneracion);
          $('#modal-personal [name=condicion_laboral]').val(Personal.condicion_laboral);
          $('#modal-personal [name=sueldo_personal]').val(Personal.sueldo_personal);
          $('#modal-personal [name=incentivo_personal]').val(Personal.incentivo_personal);
          $('#modal-personal [name=costo_dia]').val(Personal.costo_dia);
          $('#modal-personal [name=costo_hora]').val(Personal.costo_hora);
          $('#modal-personal [name=costo_minuto]').val(Personal.costo_minuto);
          $('#modal-personal [name=direccion_personal]').val(Personal.direccion_personal);
          $('#modal-personal [name=ubicacion_dpt]').val(Personal.ubicacion_dpt);
          $('#modal-personal [name=ubicacion_prov]').val(Personal.ubicacion_prov);
          $('#modal-personal [name=ubicacion_dist]').val(Personal.ubicacion_dist);


          $('#modal-personal').modal('show');
        }
      },
      error: function (err) {
        Swal.fire('Error 500', `${err.statusText}`, "error");
      }
    })
  })


  // Delete personal
  $(document).on('click', '#delete_personal', function () {
    const item = $(this).attr('item');
    Swal.fire({
      title: "¿Desea eliminar este personal?",
      text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './personales/delete_personal',
          type: "POST",
          data: { item },
          dataType: "json",
          success: function (response) {
            if (response.status == 200) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: response.msg,
                showConfirmButton: false,
                timer: 1500
              });
              table_personales.ajax.reload();
            } else {
              Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
            }
          },
          error: function (err) {
            Swal.fire('Error 500', `${err.statusText}`, "error");
          }
        })
      }
    });
  });

  // Deshabilitar Personal
  $(document).on('click', '#ban_personal', function () {
    const item = $(this).attr('item');
    const estado = $(this).attr('status');
    msgStatus = estado == 1 ? 'deshabilitar' : 'habilitar'
    Swal.fire({
      title: `¿Desea  ${msgStatus} este personal?`,
      //text: "Esta acción es irrevesible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: `Si, ${msgStatus}`,
      cancelButtonText: "Cancelar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: './personales/disabled_personal',
          type: "POST",
          data: { item },
          dataType: "json",
          success: function (response) {
            if (response.status == 200) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: response.msg,
                showConfirmButton: false,
                timer: 1500
              });
              table_personales.ajax.reload();
            } else {
              Swal.fire(`Error ${response.status}`, `${response.msg}`, "error");
            }
          },
          error: function (err) {
            Swal.fire('Error 500', `${err.statusText}`, "error");
          }
        })
      }
    });
  });



  // Esconder el modal
  $('#btnCancel, .close, #btnNew').on('click', function () {
    $('#modal-personal').modal('hide');
  })



}
